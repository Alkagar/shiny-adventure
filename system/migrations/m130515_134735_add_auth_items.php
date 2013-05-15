<?php

class m130515_134735_add_auth_items extends CDbMigration
{
        public function up()
        {
            // auth item types #  0: operation, 1: task, 2: role)

            $this->insert('auth_item', array(
                'name'                        => 'admin',
                'type'                        => 3,
                'description'                 => 'can do everything',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'view_tasks',
                'type'                        => 1,
                'description'                 => 'can view all tasks in project',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'add_task',
                'type'                        => 1,
                'description'                 => 'can add task to his project',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'edit_own_tasks',
                'type'                        => 1,
                'description'                 => 'can edit his own task in his project',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'edit_all_tasks',
                'type'                        => 1,
                'description'                 => 'can edit all tasks regardless of ownership',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'remove_own_tasks',
                'type'                        => 1,
                'description'                 => 'can remove his own tasks',
                'bizrule'                     => '', 'data'                        => ''));
            $this->insert('auth_item', array(
                'name'                        => 'remove_all_tasks',
                'type'                        => 1,
                'description'                 => 'can remove all tasks regardless of ownership',
                'bizrule'                     => '', 'data'                        => ''));

            $this->insert('auth_item', array(
                'name'                        => 'remove_project',
                'type'                        => 1,
                'description'                 => '',
                'bizrule' => '', 'data' => ''));
            $this->insert('auth_item', array(
                'name'                        => 'manage_users_in_project',
                'type'                        => 1,
                'description'                 => '',
                'bizrule' => '', 'data' => ''));
            $this->insert('auth_item', array(
                'name'                        => 'edit_project',
                'type'                        => 1,
                'description'                 => '',
                'bizrule' => '', 'data' => ''));

            $this->insert('auth_item_child', array( 'parent' => 'admin', 'child' => 'project_owner',));
            $this->insert('auth_item_child', array( 'parent' => 'project_editor', 'child' => 'edit_all_tasks',));
            $this->insert('auth_item_child', array( 'parent' => 'project_member', 'child' => 'edit_own_tasks',));
            $this->insert('auth_item_child', array( 'parent' => 'project_editor', 'child' => 'remove_all_tasks',));
            $this->insert('auth_item_child', array( 'parent' => 'project_member', 'child' => 'remove_own_tasks',));
            $this->insert('auth_item_child', array( 'parent' => 'project_member', 'child' => 'add_task',));
            $this->insert('auth_item_child', array( 'parent' => 'project_member', 'child' => 'view_tasks',));
            $this->insert('auth_item_child', array( 'parent' => 'project_owner', 'child' => 'remove_project',));
            $this->insert('auth_item_child', array( 'parent' => 'project_owner', 'child' => 'manage_users_in_project',));
            $this->insert('auth_item_child', array( 'parent' => 'project_editor', 'child' => 'edit_project',));
        }

        public function down()
        {
            $this->delete('auth_item', array('name="admin"'));
            $this->delete('auth_item', array('name="edit_all_tasks"'));
            $this->delete('auth_item', array('name="edit_own_tasks"'));
            $this->delete('auth_item', array('name="remove_all_tasks"'));
            $this->delete('auth_item', array('name="remove_own_tasks"'));
            $this->delete('auth_item', array('name="add_task"'));
            $this->delete('auth_item', array('name="view_tasks"'));
            $this->delete('auth_item', array('name="remove_project"'));
            $this->delete('auth_item', array('name="manage_users_in_project"'));
            $this->delete('auth_item', array('name="edit_project"'));
        }
}
