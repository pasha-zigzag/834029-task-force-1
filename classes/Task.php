<?php

class Task {
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_WORK = 'in_work';
    public const STATUS_PERFORMED = 'performed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_COMPLETED = 'completed';

    private const ACTION_CANCEL = 'cancel';
    private const ACTION_RESPOND = 'respond';
    private const ACTION_APPROVE = 'approve';
    private const ACTION_REFUSE = 'refuse';
    private const ACTION_COMPLETE = 'complete';

    private string $current_status = self::STATUS_NEW;
    private int $executor_id;
    private int $customer_id;

    public static array $status_map = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Завершено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::STATUS_COMPLETED => 'Выполнено'
    ];

    public static array $action_map = [
        self::ACTION_CANCEL => 'Завершить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_APPROVE => 'Утвердить',
        self::ACTION_REFUSE => 'Отказаться',
        self::ACTION_COMPLETE => 'Завершить'
    ];

    public static array $status_action_map = [
        self::STATUS_NEW => [
            'executor' => [
                self::ACTION_RESPOND => null,
                self::ACTION_REFUSE => null
            ],
            'customer' => [
                self::ACTION_CANCEL => self::STATUS_CANCELED,
                self::ACTION_APPROVE => self::STATUS_IN_WORK
            ]
        ],
        self::STATUS_CANCELED => [
            'executor' => [],
            'customer' => []
        ],
        self::STATUS_IN_WORK => [
            'executor' => [
                self::ACTION_REFUSE => self::STATUS_FAILED
            ],
            'customer' => [
                self::ACTION_COMPLETE => self::STATUS_COMPLETED
            ]
        ],
        self::STATUS_PERFORMED => [
            'executor' => [],
            'customer' => []
        ],
        self::STATUS_FAILED => [
            'executor' => [],
            'customer' => []
        ]
    ];

    public function __construct(int $customer_id, int $executor_id = null) {
        if($executor_id) {
            $this->executor_id = $executor_id;
        }
        $this->customer_id = $customer_id;
    }

    public function getCurrentStatus(): string {
        return self::$status_map[$this->current_status];
    }

    public function getStatusMap(string $status): array {
        return self::$status_action_map[$status];
    }

    private function getAvailableActions(string $status, string $role): array {
        $actionsArray = self::$status_action_map[$status][$role];
        $result = [];
        if(!empty($actionsArray)) {
            foreach($actionsArray as $action => $status) {
                $result[$action] = self::$action_map[$action];
            }
        }
        return $result;
    }

    public function getAvailableExecutorActions(string $status): array {
        return $this->getAvailableActions($status, 'executor');
    }

    public function getAvailableCustomerActions(string $status): array {
        return $this->getAvailableActions($status, 'customer');
    }

    public function getNextStatus(string $action, string $role): string {
        return self::$status_action_map[$this->current_status][$role][$action] ?? '';
    }

    public function setStatus(string $newStatus): void {
        $this->current_status = $newStatus;
    }
}
