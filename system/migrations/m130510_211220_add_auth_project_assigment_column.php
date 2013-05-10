<?php

    class m130510_211220_add_auth_project_assigment_column extends CDbMigration
    {
        public function safeUp()
        {
            $this->dropForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment'); 
            $this->execute('ALTER TABLE auth_assignment DROP PRIMARY KEY');
            $this->addColumn('auth_assignment', 'project_id', 'int not null');
            $this->addPrimaryKey('pk_assignment', 'auth_assignment', 'itemname,userid,project_id');
            $this->addForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment', 'itemname', 'auth_item', 'name', 'cascade', 'cascade'); 
        }

        public function safeDown()
        {
            $this->dropForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment'); 
            $this->execute('ALTER TABLE auth_assignment DROP PRIMARY KEY');
            $this->dropColumn('auth_assignment', 'project_id');
            $this->addPrimaryKey('pk_assignment', 'auth_assignment', 'itemname,userid');
            $this->addForeignKey('fk_auth_assignment_auth_item_name', 'auth_assignment', 'itemname', 'auth_item', 'name', 'cascade', 'cascade'); 
        }
    }
