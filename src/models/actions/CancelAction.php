<?php


namespace taskforce\models\actions;


use taskforce\models\Task;

class CancelAction extends AbstractAction
{

    public static function getValue() :string
    {
        return 'cancel';
    }

    public static function getName() :string
    {
        return 'Завершить';
    }

    public function checkPermission(Task $task, int $customer_id, int $worker_id): bool
    {
        if($task->getCurrentStatus() === 'new' && $task->getCustomerId() === $customer_id) {
            return true;
        }
        return false;
    }
}
