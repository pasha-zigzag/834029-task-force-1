<?php


namespace taskforce\models\actions;


use taskforce\models\Task;

class RefuseAction extends AbstractAction
{

    public static function getValue(): string
    {
        return 'refuse';
    }

    public static function getName(): string
    {
        return 'Отказаться';
    }

    public function checkPermission(Task $task, int $customer_id, int $worker_id): bool
    {
        // TODO: Implement checkPermission() method.
    }
}
