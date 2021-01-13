<?php

namespace taskforce\models;

use taskforce\models\actions\AbstractAction;
use taskforce\models\actions\ApproveAction;
use taskforce\models\actions\CancelAction;
use taskforce\models\actions\CompleteAction;
use taskforce\models\actions\RefuseAction;
use taskforce\models\actions\RespondAction;

class Task {
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_WORK = 'in_work';
    public const STATUS_PERFORMED = 'performed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_COMPLETED = 'completed';

    public CancelAction $action_cancel;
    public RespondAction $action_respond;
    public ApproveAction $action_approve;
    public RefuseAction $action_refuse;
    public CompleteAction $action_complete;

    private string $current_status = self::STATUS_NEW;
    private int $worker_id;
    private int $customer_id;

    public static array $status_map = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Завершено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::STATUS_COMPLETED => 'Выполнено'
    ];

    public static array $status_action_map = [
        self::STATUS_NEW => [
            'action_respond' => null,
            'action_refuse' => null,
            'action_cancel' => self::STATUS_CANCELED,
            'action_approve' => self::STATUS_IN_WORK
        ],
        self::STATUS_IN_WORK => [
            'action_refuse' => self::STATUS_FAILED,
            'action_complete' => self::STATUS_COMPLETED
        ],
        self::STATUS_CANCELED => [],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    public function __construct(int $customer_id, int $worker_id = 0)
    {
        $this->worker_id = $worker_id;
        $this->customer_id = $customer_id;
        $this->action_cancel = new CancelAction();
        $this->action_respond = new RespondAction();
        $this->action_approve = new ApproveAction();
        $this->action_refuse = new RefuseAction();
        $this->action_complete = new CompleteAction();
    }

    public function getAvailableActions(string $status, int $user_id): array
    {
        $actionsArray = self::$status_action_map[$status];
        $result = [];
        if(!empty($actionsArray)) {
            foreach($actionsArray as $action => $status) {
                if($this->$action->checkPermission($this->worker_id, $this->customer_id, $user_id)) {
                    $result[] = $this->$action;
                }
            }
        }
        return $result;
    }

    public function getNextStatus(AbstractAction $action): string
    {
        return self::$status_action_map[$this->current_status]['action_'.$action->getValue()] ?? '';
    }

    public static function getStatusMap(string $status): ?array
    {
        if(isset(self::$status_map[$status])) {
            return self::$status_action_map[$status];
        }
    }

    public function getCurrentStatus(): string {
        return $this->current_status;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getWorkerId()
    {
        return $this->worker_id;
    }

    public function setStatus(string $newStatus): bool
    {
        if(isset(self::$status_map[$newStatus])) {
            $this->current_status = $newStatus;
            return true;
        }
        return false;
    }
}
