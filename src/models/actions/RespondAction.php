<?php


namespace taskforce\models\actions;


use taskforce\models\Task;

class RespondAction extends AbstractAction
{

    public static function getValue() :string
    {
        return 'respond';
    }

    public static function getName() :string
    {
        return 'Откликнуться';
    }

    public function checkPermission(Task $task, int $customer_id, int $worker_id) :bool
    {
        // TODO: Implement checkPermission() method.
    }
}
