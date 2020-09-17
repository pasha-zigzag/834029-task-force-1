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

    private $executor_id;
    private $customer_id;
    private $map = [
        'new' => 'Новое',
        'canceled' => 'Завершено',
        'in_work' => 'В работе',
        'performed' => 'Выполнено',
        'failed' => 'Провалено',
        'cancel' => 'Завершить',
        'respond' => 'Откликнуться',
        'approve' => 'Утвердить',
        'refuse' => 'Отказаться'
    ];

    public function __construct($executor_id, $customer_id) {
        $this->executor_id = $executor_id;
        $this->customer_id = $customer_id;
    }

    public function get_map($action) {

    }

    public function get_available_actions($status) {

    }

    public function get_next_status($action) {

    }
}