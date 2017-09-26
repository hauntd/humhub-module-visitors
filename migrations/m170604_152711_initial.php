<?php

use yii\db\Migration;

class m170604_152711_initial extends Migration
{
    public function up()
    {
        $this->createTable('visit', [
            'id' => $this->primaryKey(),
            'target_user_id' => $this->integer()->notNull(),
            'visitor_user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('visit_idx', 'visit', ['target_user_id', 'visitor_user_id'], true);
        $this->createIndex('visit_target_user_idx', 'visit', ['target_user_id']);
        $this->createIndex('visit_visitor_user_idx', 'visit', ['visitor_user_id']);

        $this->addForeignKey('fk_visitor_user', 'visit', 'visitor_user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_target_user', 'visit', 'target_user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        echo "m131023_165214_initial does not support migration down.\n";
        return false;
    }
}
