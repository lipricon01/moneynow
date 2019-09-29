<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wallet}}`.
 */
class m190929_121929_create_user_wallet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wallet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'summ' => $this->float()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wallet}}');
    }
}
