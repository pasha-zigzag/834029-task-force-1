<?php

use taskforce\models\Task;

require_once 'vendor/autoload.php';

$task = new Task(1, 2);

if($task->getNextStatus(Task::ACTION_APPROVE, Task::CUSTOMER_ROLE) == Task::STATUS_IN_WORK) {
    echo 'Следующий статус: ' . $task->getNextStatus(Task::ACTION_APPROVE, Task::CUSTOMER_ROLE);
}

echo '<hr/>';

echo 'Доступные действия для заказчика:';
echo '<pre>';
var_dump($task->getAvailableCustomerActions(Task::STATUS_NEW));
echo '</pre>';
