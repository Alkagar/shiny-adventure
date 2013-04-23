<?php

    class m130423_050812_initial_structure extends CDbMigration
    {
        public function safeUp()
        {
            $tables = $this->_getStructure();
            foreach($tables as $table => $structure) {
                $this->createTable('{{' . $table . '}}', $structure);
            }

            $this->createIndex('uq_user_mail', '{{user}}', 'mail', 'true');

            $this->addForeignKey('fk_user_status_status', 'user', 'status', 'status', 'id', 'restrict'); 

            $this->addForeignKey('fk_auth_item_child_auth_item_parent', 'auth_item_child', 'parent', 'auth_item', 'name', 'cascade', 'cascade'); 
            $this->addForeignKey('fk_auth_item_child_auth_item_child', 'auth_item_child', 'child', 'auth_item', 'name', 'cascade', 'cascade'); 
            $this->addForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment', 'itemname', 'auth_item', 'name', 'cascade', 'cascade'); 

            $this->addForeignKey('fk_project_user_author_id', 'project', 'author_id', 'user', 'id', 'restrict'); 

            $this->addForeignKey('fk_task_user_author_id', 'task', 'author_id', 'user', 'id', 'restrict'); 
            $this->addForeignKey('fk_task_project_project_id', 'task', 'project_id', 'project', 'id', 'restrict'); 
            $this->addForeignKey('fk_task_status_status', 'task', 'status', 'status', 'id', 'restrict'); 

            $this->addForeignKey('fk_attachment_user_author_id', 'attachment', 'author_id', 'user', 'id', 'restrict'); 
        }

        public function safeDown()
        {
            $this->dropForeignKey('fk_user_status_status', 'user');
            $this->dropForeignKey('fk_auth_item_child_auth_item_parent', 'auth_item_child'); 
            $this->dropForeignKey('fk_auth_item_child_auth_item_child', 'auth_item_child'); 
            $this->dropForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment'); 
            $this->dropForeignKey('fk_project_user_author_id', 'project');
            $this->dropForeignKey('fk_task_user_author_id', 'task');
            $this->dropForeignKey('fk_task_project_project_id', 'task');
            $this->dropForeignKey('fk_task_status_status', 'task');
            $this->dropForeignKey('fk_attachment_user_author_id', 'attachment');
            $this->dropIndex('uq_user_mail', '{{user}}');
            $tables = $this->_getStructure();
            foreach($tables as $table => $structure) {
                $this->dropTable('{{' . $table . '}}');
            }
        }

        private function _getStructure() 
        {
            return array(
                'status' => array(
                    'id' => 'pk',
                    'name' => 'varchar(64)',
                    'type' => 'varchar(64)',
                    'description' => 'varchar(255)',
                ),
                'user' => array(
                    'id' => 'pk',
                    'mail' => 'varchar(128) NOT NULL',
                    'password' => 'varchar(40) NOT NULL',
                    'signature' => 'varchar(64)',
                    'status' => 'int',
                ),
                'project' => array(
                    'id' => 'pk',
                    'name' => 'varchar(128) NOT NULL',
                    'description' => 'text',
                    'author_id' => 'int',
                    'created_at' => 'datetime',
                    'modified_at' => 'datetime',
                ),
                'task' => array(
                    'id' => 'pk',
                    'name' => 'varchar(255)',
                    'description' => 'text',
                    'project_id' => 'int',
                    'time_spent' => 'int',
                    'author_id' => 'int',
                    'created_at' => 'datetime',
                    'modified_at' => 'datetime',
                    'status' => 'int',
                ),
                'attachment' => array(
                    'id' => 'pk',
                    'belongs_to' => 'int',
                    'url' => 'varchar(255)',
                    'created_at' => 'datetime',
                    'modified_at' => 'datetime',
                    'author_id' => 'int',
                    'type' => 'varchar(64)',
                ),
                'auth_item' => array(
                    'name'                => 'varchar(64) NOT NULL',
                    'type'                => 'int not null',
                    'description'         => 'text',
                    'bizrule'             => 'text',
                    'data'                => 'text',
                    'primary key (name)',
                ),
                'auth_item_child' => array(
                    'parent'  =>             'varchar(64) not null',
                    'child'    =>            'varchar(64) not null',
                    'primary key (parent,child)',
                ),
                'auth_assignment' => array(
                    'itemname'        =>     'varchar(64) not null',
                    'userid'           =>    'varchar(64) not null',
                    'bizrule'          =>    'text',
                    'data'              =>   'text',
                    'primary key (itemname,userid)',
                ),
            );
        }
    }
