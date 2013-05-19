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
        public static function taskShowNotes($task) 
        {
            $html = '';
            foreach($task->taskNotes as $taskNote) {
                $content = AViewHelper::parseMarkdown($taskNote->content);
                $taskContent = CHtml::tag('div', array('class' => 'task-note'), $content);
                $taskDate = CHtml::tag('time', array('class' => 'task-note-date'), $taskNote->created_at);
                $html = $taskDate . $taskContent . $html;
            }
            return $html;
        }

        public static function generateMenuButtonsForTask($task)
        {
            $params = array('project_id' => $task->project_id);

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-trash',), '');
            $linkRemove = CHtml::link($icon, array('task/remove', 'projectId' => $task->project_id, 'id' => $task->id), array(
                'class' => 'float-right title-buttons', 
                'confirm' => Yii::t('site', 'messages.really-remove'), 
                'title' => Yii::t('site', 'link-title.remove-task'),
            ));
            if(is_null(Task::model()->findByPk($task->id))) {
                $linkRemove = '';
            }

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-plus',), '');
            $linkAddTask = CHtml::link($icon, array('task/add', 'projectId' => $task->project_id), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.add-task'),
            ));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-back',), '');
            $linkGoBack = CHtml::link($icon, array('project/show', 'id' => $task->project_id), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.go-back-to-project'),
            ));

            $html = '';
            $html .= AAuthExpressions::canRemoveTask($task) ? $linkRemove : '';
            $html .= $linkGoBack;
            $html .= Yii::app()->user->checkAccess('add_task', $params) ? $linkAddTask : '';
            return $html;
        }
    }
