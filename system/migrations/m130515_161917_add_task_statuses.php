<?php

    class m130515_161917_add_task_statuses extends CDbMigration
    {
        public function up()
        {
            $this->insert('status', array(
                'name' => 'new',
                'type' => 'task',
                'description' => 'New task, created but not picked up by anyone',
            ));
            $this->insert('status', array(
                'name' => 'in-progress',
                'type' => 'task',
                'description' => 'Task was picked up by someone.',
            ));
            $this->insert('status', array(
                'name' => 'closed',
                'type' => 'task',
                'description' => 'Task finised.',
            ));
            $this->insert('status', array(
                'name' => 'on-hold',
                'type' => 'task',
                'description' => 'Task is on hold - waiting for something.',
            ));
        }

        public function down()
        {
            $this->delete('status', array('name' => 'new', 'type' => 'task'));
            $this->delete('status', array('name' => 'in-progress', 'type' => 'task'));
            $this->delete('status', array('name' => 'closed', 'type' => 'task'));
            $this->delete('status', array('name' => 'on-hold', 'type' => 'task'));
            return false;
        }

    }
