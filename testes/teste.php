<?php

namespace teste;

require_once '../vendor/autoload.php';

use Notification;

class Teste extends Notification\NFCation {
    public $a;
    public $b;
    public $c;

    public function __construct(){
        $this->a = 10;
        $this->b = 'asd';

        parent::__construct($this);

        parent::GetVar()
            ->IsNumeric($this->a)
            ->IsNumeric($this->b)
            ->IsNull($this->c);
    }
}

$a = new Teste();
echo "<pre>";

print_r($a);