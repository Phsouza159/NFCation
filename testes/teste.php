<?php

namespace teste;

require_once __DIR__ . '/../vendor/autoload.php';

use Notification;

/**
 * Class Teste
 * @package teste
 */
class Teste extends Notification\NFCation {
    public $a;
    public $b;
    public $c;
    public $cpf = "064.111.661-64";
    public $cnpj = "78.132.679/0001-61";

    public function __construct(){
        $this->a = 10;
        $this->b = 'asd';

        parent::__construct($this);

        parent::GetVar()
            ->IsNumeric($this->a)
            ->IsNumeric($this->b)
            ->IsNotNull($this->c)
            ->IsCpf($this->cpf)
            ->IsCnpj($this->cnpj);
    }
}

class Teste2 extends Notification\NFCation
{

    /**
     * Teste2 constructor.
     */
    public function __construct()
    {
    }
}


$a = new Teste();
$b = new Teste2();

$b->AddNotificationObject( $a );

echo "<pre>";

print_r($a);

print_r($b);