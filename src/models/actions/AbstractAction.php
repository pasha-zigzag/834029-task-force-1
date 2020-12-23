<?php

namespace taskforce\models\actions;

use taskforce\models\Task;

abstract class AbstractAction
{
    abstract public static function getValue() :string;
    abstract public static function getName() :string;
    abstract public function checkPermission(Task $task, int $customer_id, int $worker_id) :bool;
}
