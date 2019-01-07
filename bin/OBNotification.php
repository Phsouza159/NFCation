<?php
namespace Notification;

require_once '../vendor/autoload.php';

use Interfaces;

class OBNotification implements  Interfaces\IOBNotification{

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
            if($value == $var)
                return $this->_VARS[$key];

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
}