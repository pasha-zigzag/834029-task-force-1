<?php

require './classes/Task.php';

$task = new Task(1, 2);

if($task->getNextStatus('approve') == Task::STATUS_IN_WORK) {
    echo 'Следующий статус: ' . $task->getNextStatus('approve');
}

echo '<hr/>';

echo 'Доступные действия для заказчика:';
echo '<pre>';
var_dump($task->getAvailableCustomerActions(Task::STATUS_NEW));
echo '</pre>';