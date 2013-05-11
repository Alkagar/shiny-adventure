<?php

    class m130426_193819_add_auth_items extends CDbMigration
    {
        public function up()
        {
            // auth item types #  0: operation, 1: task, 2: role)

            $this->insert('auth_item', array(
                'name'                        => 'project_owner',
                'type'                        => 2,
                'description'                 => 'can manage his own projects',
                'bizrule'                     => '',
                'data'                        => ''
            ));

            $this->insert('auth_item', array(
                'name'                        => 'project_editor',
                'type'                        => 2,
                'description'                 => 'can edit his own project',
                'bizrule'                     => '',
                'data'                        => ''
            ));

            $this->insert('auth_item', array(
                'name'                        => 'project_member',
                'type'                        => 2,
                'description'                 => 'can see his own projects',
                'bizrule'                     => '',
                'data'                        => ''
            ));

            $this->insert('auth_item_child', array(
                'parent' => 'project_owner',
                'child' => 'project_editor',
            ));
            $this->insert('auth_item_child', array(
                'parent' => 'project_editor',
                'child' => 'project_member',
            ));
        }

        public function down()
        {
            $this->delete('auth_item', array('name="project_member"'));
            $this->delete('auth_item', array('name="project_editor"'));
            $this->delete('auth_item', array('name="project_owner"'));
        }
    }
