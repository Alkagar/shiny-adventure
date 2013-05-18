<?php 
    class ATaskHelper {

        public static function taskListAssigneesHtml($task) 
        {
            $html = '';
            foreach($task->assignees as $assignee) {
                $htmlOptions = array(
                    'class' => 'attachment clear-both', 
                );
                $value = $assignee->user->signature . ' [ ' . $assignee->user->mail . ' ] ';
                $html .= CHtml::tag( 'div', $htmlOptions, $value);
            }
            return $html;
        }

        public static function taskShowAssigneesHtml($task) 
        {
            $html = '';
            foreach($task->assignees as $assignee) {
                $htmlOptions = array(
                    'class' => 'attachment clear-both cursor remove-assignee', 
                    'id' => 'remove-assignee_' . $assignee->user_id
                );
                $value = $assignee->user->signature . ' [ ' . $assignee->user->mail . ' ] ';
                $html .= CHtml::tag( 'div', $htmlOptions, $value);
            }
            return $html;
        }
    }
