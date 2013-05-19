<?php

    class m130519_155444_task_note_table extends CDbMigration
    {
        public function up()
        {
            $this->createTable('{{task_note}}', array(
                'id' => 'pk',
                'author_id' => 'int',
                'created_at' => 'datetime',
                'modified_at' => 'datetime',
                'content' => 'text',
                'task_id' => 'int', 
            ));
            $this->addForeignKey('fk_task_note_user_author_id', 'task_note', 'author_id', 'user', 'id', 'restrict'); 
            $this->addForeignKey('fk_task_note_task_task_id', 'task_note', 'task_id', 'task', 'id', 'cascade'); 
        }

        public function down()
        {
            $this->dropForeignKey('fk_task_note_user_author_id', 'task_note');
            $this->dropForeignKey('fk_task_note_task_task_id', 'task_note');
            $this->dropTable('{{task_note}}');
        }
    }
