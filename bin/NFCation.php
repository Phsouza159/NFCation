<?php
/**
 *
 */
namespace Notification;

require_once '../vendor/autoload.php';

use Notification;

class NFCation extends Notification\OBNotification {
    /**
     * NFCation constructor.
     * @param $ob
     */
    public function __construct($ob){
       parent::__construct($ob);

    }
}