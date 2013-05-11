<?php

class m130511_010909_add_other_user extends CDbMigration
{
        public function up()
        {
            $this->insert('user', array(
                'mail' => 'jakub@mrowiec.org',
                'password' => sha1('pharazon'),
                'signature' => 'jakub',
                'status_id' => 1, 
            ));
        }

        public function down()
        {
            $this->delete('user', 'mail="jakub@mrowiec.org"');
        }
}
