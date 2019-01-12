<?php
/*
|-----------------------------------------------------------------------------------------
|
| NFCation Lib
| Autor: Paulo Henrique Ribeiro de Souza
|
| Biblioteca Baseada na prmToolkit.NotificationPattern para C# :
|       git url https://github.com/pauloanalista/prmToolkit.NotificationPattern
|-----------------------------------------------------------------------------------------
|  NFCation
|    \->
|        \->bin
|            \->Idioma
|                |-> pt-BR.json
|            |->NFCationConfig.php
|            |->NFCationIdioma.php
|            |->OBNotification.php
|        \->Interfaces
|            |->IOBnotification.php
|        |->log.ini
|        |->NFCation.php
|-----------------------------------------------------------------------------------------
| NFCation
 |*
 |* IsValid() retorno se o objeto e válido
 |*
 |* IsInvalid(0 retorna se o objeto e invalido
 |*
 |* GetNotifications() retorna array de notificações (caso exista)
 |*
 |* AddNotificationObject() adicionar notificação apartir de outro objeto que herda de NFCation
 |*
 |* AddNotification() adiciona notificação
 |*
 |* Log() gera um Log.ini com todoas as notificações
 |*
 |* IsNumeric() verifica se é um número
 |*
 |* IsArray() verifica se [e um array
 |*
 |* IsArrayEmpty() verifica se é um array ou é um array vazio
 |*
 |* IsObjectElementsEmpty() verifica se o objeto contém elementos vazios
 |*
 |* IsObjectEmpty() verifica se o objeto está vazio
 |*
 |* IsString() verifica se é uma string
 |*
 |* IsStringEmpty() verifica se é uma string e está vazia
 |*
 |* IsNotNull() verifica se é vazio
 |*
 |* IsCpf() verifica se é um CPF válido
 |*
 |* IsCnpj() verifica se é um CNPJ
 |*
 |* IsContem() verifica se uma frase contem em outra frase
 |*
 |* IsEmail() verifica se é um email válido
 |*
 |* IsMinLenght() verifica se a frase contem o minimo de caracteres informado
 |*
 |* IsMaxLenght() verifica se a frase contem o máximo de caracteres informado
 |*
 |*
*/

require_once __DIR__ . '/bin/OBNotification.php';
require_once __DIR__ . '/bin/NFCationConfig.php';
require_once __DIR__ . '/bin/NFCationIdioma.php';

use Notification\bin as bin;

/**
 * Class NFCation
 */
class NFCation extends  bin\OBNotification
{
    public function AddNotificatio( $_Object )
    {
         parent::__construct( $_Object );
         return $this;
    }
}

