<?php

namespace Notification;

require_once __DIR__ . '/../vendor/autoload.php';

use Interfaces;

class OBNotification  /* extends CLASS */  implements  Interfaces\IOBNotification
{

    private $_NOTIFICATIONS = array();
    private $_ISVALID = true;
    private $_ISINVALID = false;
    private $_VARS = array();
    private $_LISTVARS = array("_NOTIFICATIONS" => 1, "_ISVALID" => 1, "_ISINVALID" => 1, "_VARS" => 1, "_LISTVARS" => 1);

    public function __construct($ob){
        $this->GetVar($ob);
    }

    /**
     * @return bool
     */
    public function  IsValid() : bool
    {
        return $this->_ISVALID;
    }

    /**
     * @return bool
     */
    public function IsInValid() : bool
    {
        return $this->_ISINVALID;
    }

    /**
     * @return $this
     */
    protected function GetVar(){
        $var = array_keys(get_object_vars($this));

        foreach ($var as $item)
        {
            if(!array_key_exists( $item , $this->_LISTVARS))
                $this->_VARS[$item] = $item;
        }
        return $this;
    }

    /**
     * @param string $var : nome da variavel
     * @param string $mes : menssagem
     */
    private function SetNotification(string $varName , string  $mes) : void
    {
        $this->_NOTIFICATIONS[$varName] = $mes;
    }

    /**
     * @param bool $valid : se o objeto e valido
     */
    private function SetIsValid(bool $valid = false) : void
    {
        if($this->_ISINVALID )
            return;

        $this->_ISVALID   = $valid;
        $this->_ISINVALID = !$this->_ISVALID;
    }

    /**
     * @param $var
     * @return string
     */
    private function GetNomeVar($var) : string
    {
        foreach ($this as $key => $value)
        {
            if($value == $var && array_key_exists( $key , $this->_VARS) )
                return $this->_VARS[$key];
        }


        return "Default :: $var";
    }

    /**
     * @param int / float $num : verificar se a var eh um numero
     * @return object
     */
    protected function IsNumeric( $num )
    {
        if(is_numeric($num))
            return $this;

        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($num);
        $this->SetNotification( $vName , "$vName não é um número");

        return $this;
    }

    /**
     * @param $list
     * @return $this
     */
    protected function IsArray( $list )
    {
        if(is_array( $list ))
            return $this;

        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($list );
        $this->SetNotification( $vName , "$vName não é um array");
        return $this;
    }

    /**
     * @param $list
     * @return $this
     */
    protected function IsArrayEmpty( $list )
    {
        $this->IsArray($list);
        if($this->IsInValid())
            return $this;

        if(count($list) == 0)
        {
            $this->SetIsValid(false);
            $vName = $this->GetNomeVar($list);
            $this->SetNotification( $vName , "$vName não pode ser vazio");
        }
        return $this;
    }

    /**
     * @param $object
     * @return $this
     */
    protected function IsObjectEmpty( $object )
    {
        if(!is_object($object))
        {
            $this->SetErroObject($object, "Não é um objeto");
            return $this;
        }

        if (empty((array) $object))
        {
            $this->SetErroObject($object, "Objeto não pode ser nulo");
        }
        return $this;
    }

    /**
     * @param $string
     * @return $this
     */
    protected function IsString( $string )
    {
        if(is_string($string))
            return $this;

        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($string);
        $this->SetNotification( $vName , "Não é do tipo string");
    }

    /**
     * @param $string
     * @return $this
     */
    protected function IsStringEmpty($string)
    {
        if ($this->IsString($string) && $this->IsValid() )
           return $this;

        if(empty($string))
        {
            $vName = $this->GetNomeVar($string);
            $this->SetNotification( $vName , "Não pode ser vazia");
            return $this;
        }
    }

    /**
     * @param $email
     * @return $this
     */
    protected function IsEmail( $email )
    {
        if( is_string($email) && preg_match("/@/" , $email ) &&  preg_match("/./" , $email ))
            return $this;

        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($email);
        $this->SetNotification( $vName , "Email inválido");

        return $this;
    }

    /**
     * @param $object
     * @param string $mes
     */
    protected final function SetErroObject( $object , $mes = "Objeto vazio")
    {
        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($object);
        $this->SetNotification( $vName , $mes);
    }

    /**
     * @param $var
     * @return $this
     * @throws \Exception
     */
    protected function IsNull( &$var )
    {
        if(!is_null($var))
            return $this;

        $num = random_int(0 , 1000000);
        $var =  $num ;

        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($num );
        $this->SetNotification( $vName , "$vName não pode ser nulo");

        $var = null;
        return $this;
    }

    /**
     * @param string $cpf
     * @return $this
     */
    protected function IsCpf(string  $cpf){

        $default = $cpf;

        if(empty($cpf))
        {
            $this->SetErroCPF($default , "CPF : variavel não pode ser nula");
            return $this;
        }

        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $digitoUm = 0;
        $digitoDois = 0;

        if( strlen($cpf) < 11)
        {
            $this->SetErroCPF($default , "CPF menor que 11 digitos.");
            return $this;
        }

        for($i = 0, $x = 10; $i <= 8; $i++, $x--){
             $digitoUm += $cpf[$i] * $x;
        }

        for($i = 0, $x = 11; $i <= 9; $i++, $x--){

            if(str_repeat($i, 11) == $cpf){
                $this->SetErroCPF($default);
                return $this;
            }
            $digitoDois += $cpf[$i] * $x;
        }

        $calculoUm  = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
        $calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);

        if($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10]){
            $this->SetErroCPF($default);
            return $this;
        }

        return $this;
    }

    /**
     * funcao auxiliar para o cpf
     * @param string $cpf
     * @param string $mes
     */
    protected final function SetErroCPF(string $cpf, string $mes = "CPF inválido")
    {
        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($cpf);
        $this->SetNotification( $vName , $mes);
    }

    /**
     * @param string $cnpj
     * @return $this
     */
    protected function IsCnpj(string $cnpj)
    {
        $default = $cnpj;

        if(empty($cnpj)) {
            $this->SetErroCnpj($cnpj , "CNPJ não pode ser nulo");
            return $this;
        }

        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14) {
            $this->SetErroCnpj($default , "CNPJ menor que 14 digitos");
            return $this;
        }

        else if ($cnpj == '00000000000000' || $cnpj == '11111111111111' || $cnpj == '22222222222222' || $cnpj == '33333333333333' || $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' || $cnpj == '66666666666666' || $cnpj == '77777777777777' || $cnpj == '88888888888888' || $cnpj == '99999999999999') {

            $this->SetErroCnpj($default);
            return $this;
        } else {

            $j = 5;
            $k = 6;
            $soma1 = "";
            $soma2 = "";

            for ($i = 0; $i < 13; $i++) {

                $j = $j == 1 ? 9 : $j;
                $k = $k == 1 ? 9 : $k;

                $soma2 += ($cnpj{$i} * $k);

                if ($i < 12) {
                    $soma1 += ($cnpj{$i} * $j);
                }
                $k--;
                $j--;
            }

            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

            if((($cnpj{12} == $digito1) and ($cnpj{13} == $digito2)))
                return $this;

            $this->SetErroCnpj($default);
            return $this;

        }
    }

    /**
     * @param string $cnpj
     * @param string $mes
     */
    protected final function SetErroCnpj(string $cnpj ,string $mes = "CNPJ inválido")
    {
        $this->SetIsValid(false);
        $vName = $this->GetNomeVar($cnpj);
        $this->SetNotification( $vName , $mes);
    }
}