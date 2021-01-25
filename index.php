<?php

use taskforce\models\actions\ApproveAction;
use taskforce\models\exceptions\FileNotExistException;
use taskforce\models\exceptions\CantWriteFileException;
use taskforce\models\CsvToSqlConverter;
use taskforce\models\Task;

require_once 'vendor/autoload.php';

function dd($data) {
    echo '<pre>' . print_r($data, 1) . '</pre><hr/>';
}
//
//$task = new Task(1, 2);
//
//$approveAction = new ApproveAction();
//
//if($task->getNextStatus($approveAction) == Task::STATUS_IN_WORK) {
//    echo 'Следующий статус: ' . $task->getNextStatus($approveAction);
//}
//
//echo '<hr/>';
//
//echo 'Доступные действия для заказчика (STATUS_NEW):';
//dd($task->getAvailableActions(Task::STATUS_NEW, 1)); // CancelAction Object | ApproveAction Object
//echo 'Доступные действия для исполнителя (STATUS_NEW):';
//dd($task->getAvailableActions(Task::STATUS_NEW, 2)); // RespondAction Object | RefuseAction Object
//
//echo 'Доступные действия для заказчика (STATUS_IN_WORK):';
//dd($task->getAvailableActions(Task::STATUS_IN_WORK, 1)); //CompleteAction Object
//echo 'Доступные действия для исполнителя (STATUS_IN_WORK):';
//dd($task->getAvailableActions(Task::STATUS_IN_WORK, 2)); // RefuseAction Object
//
//echo 'Доступные действия для исполнителя (STATUS_CANCELED):';
//dd($task->getAvailableActions(Task::STATUS_CANCELED, 2)); // []





try {
    $converter = new CsvToSqlConverter('data/categories.csv', 'category');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/cities.csv', 'city');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/opinions.csv', 'review');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/replies.csv', 'response');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/tasks.csv', 'task');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/user-category.csv', 'user_category');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/users.csv', 'user');
    $converter->createInsertSql();
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}

try {
    $converter = new CsvToSqlConverter('data/profiles.csv', 'user');
    $converter->createUpdateSql(1);
} catch (FileNotExistException | CantWriteFileException $e) {
    echo $e->getMessage();
}
