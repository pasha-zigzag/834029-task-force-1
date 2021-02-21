<?php

use yii\db\Migration;

/**
 * Class m210217_142455_add_last_active_time_column
 */
class m210217_142455_add_last_active_time_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'user', 'last_active_time', $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'last_active_time');
    }
}
