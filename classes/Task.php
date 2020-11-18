<?php

class Task {
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_APPROVE = 'approve';
    const ACTION_REFUSE = 'refuse';

    private $current_status;
    private $executor_id;
    private $customer_id;
    private $status_map = [
        self::STATUS_NEW => [
            'title' => 'Новое',
            'executor_actions' => [
                self::ACTION_RESPOND => ['next_status' => ''],
                self::ACTION_REFUSE => ['next_status' => '']
            ],
            'customer_actions' => [
                self::ACTION_CANCEL => ['next_status' => self::STATUS_CANCELED],
                self::ACTION_APPROVE => ['next_status' => self::STATUS_IN_WORK]
            ]
        ],
        self::STATUS_CANCELED => [
            'title' => 'Завершено',
            'executor_actions' => [],
            'customer_actions' => []
        ],
        self::STATUS_IN_WORK => [
            'title' => 'В работе',
            'executor_actions' => [
                self::ACTION_REFUSE => ['next_status' => self::STATUS_FAILED]
            ],
            'customer_actions' => [
                self::ACTION_CANCEL => ['next_status' => self::STATUS_PERFORMED]
            ]
        ],
        self::STATUS_PERFORMED => [
            'title' => 'Выполнено',
            'executor_actions' => [],
            'customer_actions' => []
        ],
        self::STATUS_FAILED => [
            'title' => 'Провалено',
            'executor_actions' => [],
            'customer_actions' => []
        ]
    ];
    
    private $action_map = [
        self::ACTION_CANCEL => 'Завершить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_APPROVE => 'Утвердить',
        self::ACTION_REFUSE => 'Отказаться'
    ];

    public function __construct($executor_id, $customer_id) {
        $this->executor_id = $executor_id; //когда создается задание, исполнитель еще не выбран
        $this->customer_id = $customer_id;
        $this->current_status = self::STATUS_NEW;
    }

    public function getCurrentStatusMap() {
        return $this->status_map[$this->current_status];
    }

    public function getStatusMap($status) {
        return $this->status_map[$status];
    }

    private function getAvailableActions($status, $role) {
        $actionsArray = $this->status_map[$status][$role];
        $result = [];
        if(!empty($actionsArray)) {
            foreach($actionsArray as $action => $info) {
                $result[$action] = $this->action_map[$action];
            }
        }
        return $result;
    }

    public function getAvailableExecutorActions($status) {
        return $this->getAvailableActions($status, 'executor_actions');
    }

    public function getAvailableCustomerActions($status) {
        return $this->getAvailableActions($status, 'customer_actions');
    }

    public function getNextStatus($action) {
        //get user role => customer_actions OR executor_actions
        return $this->status_map[$this->current_status]['customer_actions'][$action]['next_status'] ?? '';
    }

    public function setStatus($newStatus) {
        $this->current_status = $newStatus;
    }
}