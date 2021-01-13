<?php

namespace taskforce\models\actions;

use taskforce\models\Task;

abstract class AbstractAction
{
    abstract public static function getValue() :string;
    abstract public static function getName() :string;
    abstract public function checkPermission(int $worker_id, int $customer_id, int $user_id) :bool;
}
