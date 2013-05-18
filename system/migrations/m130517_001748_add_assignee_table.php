<?php

    class m130517_001748_add_assignee_table extends CDbMigration
    {
        public function safeUp()
        {
            $this->createTable('{{assignee}}', array(
                'id' => 'pk',
                'task_id' => 'int', 
                'user_id' => 'int', 
            ));
            $this->addForeignKey('fk_assignee_user_user_id', 'assignee', 'user_id', 'user', 'id', 'cascade'); 
            $this->addForeignKey('fk_assignee_task_task_id', 'assignee', 'task_id', 'task', 'id', 'cascade'); 

            $this->createTable('{{history}}', array(
                'id' => 'pk', 
                'type' => 'varchar(64)',
                'change' => 'text',
                'date' => 'datetime',
                'user_id' => 'int',
                'ref_id' => 'int',
            ));
            $this->addForeignKey('fk_history_user_user_id', 'history', 'user_id', 'user', 'id', 'set null'); 
        }

        public function safeDown()
        {
            $this->dropForeignKey('fk_assignee_user_user_id', 'assignee');
            $this->dropForeignKey('fk_assignee_task_task_id', 'assignee');
            $this->dropForeignKey('fk_history_user_user_id', 'history');
            $this->dropTable('{{assignee}}');
            $this->dropTable('{{history}}');
        }
    }
