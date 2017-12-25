<?php

namespace common\cmyii\text\migrations;

use yii\db\Migration;

class m150516_131138_cmyii_text extends Migration
{
    public function safeUp()
    {
        // text table
        $this->createTable('{{%cmyii_text}}', [
            'id'          => $this->primaryKey(),
            'block_id'    => $this->integer(),
            'page_id'     => $this->integer(),
            'content'     => $this->text(),
            'sort'        => $this->integer()->notNull()->defaultValue(0),
            'is_disabled' => $this->boolean()->notNull()->defaultValue(false),
        ]);
        $this->createIndex('cmyii_text_block_id_page_id_idx', '{{%cmyii_text}}', ['block_id', 'page_id']);
        $this->createIndex('cmyii_text_page_id_idx',          '{{%cmyii_text}}', ['page_id']);
        $this->addForeignKey('cmyii_text_block_id_cmyii_block_id_fkey', '{{%cmyii_text}}', 'block_id', '{{%cmyii_block}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cmyii_text_page_id_cmyii_page_id_fkey',   '{{%cmyii_text}}', 'page_id',  '{{%cmyii_page}}',  'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%cmyii_text}}');
    }
}
