<?php

use yii\db\Migration;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 */
class uninstall extends Migration
{

    public function up()
    {
        $this->dropForeignKey('fk_visitor_user', 'visit');
        $this->dropForeignKey('fk_target_user', 'visit');
        $this->dropTable('visit');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }
}
