<?php

use yii\db\Migration;

/**
 * Class m210429_121049_add_attach_id
 */
class m210429_121049_add_attach_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('file_fk0', 'file');
        $this->dropColumn('file', 'task_id');

        $this->addColumn('task', 'attach_id', 'INT(10)');
        $this->addColumn('file', 'attach_id', 'INT(10) NOT NULL');

        $this->createIndex('task_attach_id', 'task', 'attach_id', true);
        $this->createIndex('file_attach_id', 'file', 'attach_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('file', 'task_id', 'INT(10) UNSIGNED');
        $this->addForeignKey('file_fk0', 'file', 'task_id', 'task', 'id', 'CASCADE');

        $this->dropColumn('task', 'attach_id');
        $this->dropColumn('file', 'attach_id');
    }
}
