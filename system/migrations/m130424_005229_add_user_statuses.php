<?php

    class m130424_005229_add_user_statuses extends CDbMigration
    {
        public function up()
        {
            $this->insert('status', array(
                'name' => 'active',
                'type' => 'user',
                'description' => 'User have this when is active: can login and operate normally.',
                ));
            $this->insert('status', array(
                'name' => 'archive',
                'type' => 'user',
                'description' => 'User have this when is in archive: user can no longer logon.',
                ));
        }

        public function down()
        {
            $this->delete('status', array('name' => 'active', 'type' => 'user'));
            $this->delete('status', array('name' => 'archive', 'type' => 'user'));
            return false;
        }

    }
