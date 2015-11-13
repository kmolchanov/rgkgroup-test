<?php

use yii\db\Schema;
use yii\db\Migration;

class m151113_163200_create_book_table extends Migration
{
    private $tableName = '{{%book}}';
    private $authorTableName = '{{%author}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image' => $this->string(),
            'released_at' => $this->integer(),
            'author_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('FK_author_id', $this->tableName, 'author_id', $this->authorTableName, 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_author_id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
