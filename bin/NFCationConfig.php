<?php
/**
 * Created by PhpStorm.
 * User: paulo-pc
 * Date: 11/01/2019
 * Time: 01:25
 */

namespace Notification\bin;


class NFCationConfig
{
    /**
     * @var array
     */
    private static $_Config = [

      "IDIOMA" => "pt-BR",

      "Lang" => [
            "pt-BR" => "pt-BR.json" ,
            "eua" => "eua.json"
          ],

        "FileLog" => [
            "externo" => "" ,
            "interno" => "log.ini"
        ]

    ];

    /**
     * configurar idioma
     * @param string $idioma
     */
    public static function SetIdioma(string $idioma )
    {
        self::$_Config["IDIOMA"] = $idioma;
    }

    /**
     * @return string
     */
    public static function GetIdioma() : string
    {
        return empty(self::$_Config["IDIOMA"])
            ? "pt-BR.json"
                : (isset( self::$_Config["Lang"][self::$_Config["IDIOMA"]] )
                    ? self::$_Config["Lang"][self::$_Config["IDIOMA"]]
                        : "pt-BR.json");
    }

    /**
     * @param array $Notifications
     */
    public static function Log(array $Notifications ){

        if(is_null($Notifications))
            return ;

        $logInterno = self::$_Config["FileLog"]["interno"];
        $caminho = __DIR__ . "/../" . $logInterno;
        $index = 0;

        if( file_exists($caminho))
        {
           $index = parse_ini_file( $caminho , true);
           $index = count($index);
        }

        file_put_contents ( $caminho , self::FormtateLog($Notifications , $index) , FILE_APPEND);
    }

    /**
     * @param array $Notifications
     * @param $index
     * @return string
     */
    private static function FormtateLog( array $Notifications , $index)
    {
        $line = "\n;----------------------------------------------------------------------------------------------";
        $formt = $line;

        foreach ($Notifications as $val) {
            $formt .= "\nN_$index = \"". date("d/m/y h:m:s")." | $val\"";
            $index++;
        }

        $formt .= $line;
        return $formt;
    }

}
