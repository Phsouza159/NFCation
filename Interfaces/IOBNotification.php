<?php

namespace Interfaces ;

require_once '../vendor/autoload.php';

interface IOBNotification
{
    function IsValid() : bool;
    function IsInValid() : bool;
}