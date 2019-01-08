<?php

namespace Interfaces ;

require_once __DIR__ . '/../vendor/autoload.php';

interface IOBNotification
{
    function IsValid() : bool;
    function IsInValid() : bool;
}