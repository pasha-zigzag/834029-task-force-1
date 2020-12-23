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

    public const ACTION_CANCEL = CancelAction::class;
    public const ACTION_RESPOND = RespondAction::class;
    public const ACTION_APPROVE = ApproveAction::class;
    public const ACTION_REFUSE = RefuseAction::class;
    public const ACTION_COMPLETE = CompleteAction::class;

    public const CUSTOMER_ROLE = 'customer';
    public const WORKER_ROLE = 'worker';

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
            self::WORKER_ROLE => [
                self::ACTION_RESPOND => null,
                self::ACTION_REFUSE => null
            ],
            self::CUSTOMER_ROLE => [
                self::ACTION_CANCEL => self::STATUS_CANCELED,
                self::ACTION_APPROVE => self::STATUS_IN_WORK
            ]
        ],
        self::STATUS_CANCELED => [
            self::WORKER_ROLE => [],
            self::CUSTOMER_ROLE => []
        ],
        self::STATUS_IN_WORK => [
            self::WORKER_ROLE => [
                self::ACTION_REFUSE => self::STATUS_FAILED
            ],
            self::CUSTOMER_ROLE => [
                self::ACTION_COMPLETE => self::STATUS_COMPLETED
            ]
        ],
        self::STATUS_PERFORMED => [
            self::WORKER_ROLE => [],
            self::CUSTOMER_ROLE => []
        ],
        self::STATUS_FAILED => [
            self::WORKER_ROLE => [],
            self::CUSTOMER_ROLE => []
        ]
    ];

    public static $role_map = [
        self::CUSTOMER_ROLE => 'Заказчик',
        self::WORKER_ROLE => 'Исполнитель'
    ];

    public function __construct(int $customer_id, int $worker_id = 0)
    {
        $this->worker_id = $worker_id;
        $this->customer_id = $customer_id;
    }

    public function getCurrentStatus(): string {
        return $this->current_status;
    }

    public static function getStatusMap(string $status): ?array
    {
        if(isset(self::$status_map[$status])) {
            return self::$status_action_map[$status];
        }
    }

    private function getAvailableActions(string $status, string $role): array
    {
        $actionsArray = self::$status_action_map[$status][$role];
        $result = [];
        if(!empty($actionsArray)) {
            foreach($actionsArray as $action => $status) {
                $result[] = new $action();
            }
        }
        return $result;
    }


    public function getAvailableWorkerActions(string $status): ?array
    {
        if(isset(self::$status_map[$status])) {
            return $this->getAvailableActions($status, self::WORKER_ROLE);
        }
    }

    public function getAvailableCustomerActions(string $status): ?array
    {
        if(isset(self::$status_map[$status])) {
            return $this->getAvailableActions($status, self::CUSTOMER_ROLE);
        }
    }

    public function getNextStatus(AbstractAction $action, string $role): string
    {
        if(isset(self::$role_map[$role])) {
            return self::$status_action_map[$this->current_status][$role][get_class($action)] ?? '';
        }
    }

    public function setStatus(string $newStatus): bool
    {
        if(isset(self::$status_map[$newStatus])) {
            $this->current_status = $newStatus;
            return true;
        }
        return false;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getWorkerId()
    {
        return $this->worker_id;
    }
}
