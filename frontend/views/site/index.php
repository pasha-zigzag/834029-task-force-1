<?php
$task = \app\models\Task::findOne(1);
var_dump($task->title);
var_dump($task->category->title);