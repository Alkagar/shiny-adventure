<?php

    class m130424_005827_add_default_users extends CDbMigration
    {
        public function up()
        {
            $this->insert('user', array(
                'mail' => 'alkagar@gmail.com',
                'password' => sha1('pharazon'),
                'signature' => 'alkagar',
                'status_id' => 1, 
            ));
        }

        public function down()
        {
            $this->delete('user', array('mail' => 'alkagar@gmail.com'));
        }

    }
