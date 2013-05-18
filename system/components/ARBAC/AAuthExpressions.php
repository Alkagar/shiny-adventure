<?php
    class AAuthExpressions {
        public static function isTaskAuthor($user, $rule) 
        {
            $availableKeys = array('remove_own_tasks', 'edit_own_tasks');
            $taskId = null;
            foreach($availableKeys as $key) {
                if(isset($rule->roles[$key])) {
                    $taskId = $rule->roles[$key]['task_id'];
                }
            }
            if(!is_null($taskId)) {
                $task = Task::model()->findByPk($taskId);
                return $task->author_id == $user->id;
            }
            return false;
        }

        public static function canRemoveTask($task) 
        {
            $params = array('project_id' => $task->project_id);
            $canRemoveTask = Yii::app()->user->checkAccess('remove_own_tasks', $params) && $task->author_id == Yii::app()->user->id;
            $canRemoveTask = $canRemoveTask || Yii::app()->user->checkAccess('remove_all_tasks', $params);
            return $canRemoveTask;
        }
    }
