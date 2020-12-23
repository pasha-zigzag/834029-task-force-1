<?php


namespace taskforce\models\actions;


use taskforce\models\Task;

class ApproveAction extends AbstractAction
{
    public static function getValue() :string
    {
        return 'approve';
    }

    public static function getName() :string
    {
        return 'Утвердить';
    }

    public function checkPermission(Task $task, int $customer_id, int $worker_id) :bool
    {
        // TODO: Implement checkPermission() method.
    }
}
