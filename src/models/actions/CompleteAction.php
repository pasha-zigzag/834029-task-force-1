<?php


namespace taskforce\models\actions;


use taskforce\models\Task;

class CompleteAction extends AbstractAction
{
    public static function getValue(): string
    {
        return 'complete';
    }

    public static function getName(): string
    {
        return 'Завершить';
    }

    public function checkPermission(Task $task, int $customer_id, int $worker_id): bool
    {
        // TODO: Implement checkPermission() method.
    }
}
