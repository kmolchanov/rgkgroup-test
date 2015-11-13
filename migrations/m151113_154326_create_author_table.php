<?php

use yii\db\Schema;
use yii\db\Migration;

class m151113_154326_create_author_table extends Migration
{
    public function up()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('author');
    }
}
