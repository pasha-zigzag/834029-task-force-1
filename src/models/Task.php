<?php

namespace taskforce\models;

use taskforce\models\actions\AbstractAction;
use taskforce\models\actions\ApproveAction;
use taskforce\models\actions\CancelAction;
use taskforce\models\actions\CompleteAction;
use taskforce\models\actions\RefuseAction;
use taskforce\models\actions\RespondAction;

class Task {
    private int $worker_id;
    private int $customer_id;

    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_WORK = 'in_work';
    public const STATUS_PERFORMED = 'performed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_COMPLETED = 'completed';

    private string $current_status = self::STATUS_NEW;

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
            'respond' => null,
            'refuse' => null,
            'cancel' => self::STATUS_CANCELED,
            'approve' => self::STATUS_IN_WORK
        ],
        self::STATUS_IN_WORK => [
            'refuse' => self::STATUS_FAILED,
            'complete' => self::STATUS_COMPLETED
        ],
        self::STATUS_CANCELED => [],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    public static function getAvailableActionsForStatus($status) {
        switch ($status) {
            case self::STATUS_NEW:
                return [
                    new RespondAction(),
                    new RefuseAction(),
                    new CancelAction(),
                    new ApproveAction()
                ];
            case self::STATUS_IN_WORK:
                return [
                    new RefuseAction(),
                    new CompleteAction()
                ];
            case self::STATUS_CANCELED:
            case self::STATUS_PERFORMED:
            case self::STATUS_FAILED:
                return [];
        }
    }

    public function __construct(int $customer_id, int $worker_id = 0)
    {
        $this->worker_id = $worker_id;
        $this->customer_id = $customer_id;
    }

    public function getAvailableActions(string $status, int $user_id): array
    {
        $actionsArray = self::getAvailableActionsForStatus($status);
        $result = [];
        if(!empty($actionsArray)) {
            foreach($actionsArray as $action) {
                if($action->checkPermission($this->worker_id, $this->customer_id, $user_id)) {
                    $result[] = $action;
                }
            }
        }
        return $result;
    }

    public function getNextStatus(AbstractAction $action): ?string
    {
        return self::$status_action_map[$this->current_status][$action->getValue()] ?? null;
    }

    public static function getStatusMap(string $status): ?array
    {
        if(isset(self::$status_map[$status])) {
            return self::$status_action_map[$status];
        }
    }

    public function getCurrentStatus(): string
    {
        return $this->current_status;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getWorkerId(): int
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
