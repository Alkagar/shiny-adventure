<?php 
    class AViewHelper {
        public static function generateMenuButtonsForProject($project) 
        {
            $params = array('project_id' => $project->id);

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-trash',), '');
            $linkRemove = CHtml::link($icon, array('project/remove', 'id' => $project->id), array(
                'class' => 'float-right title-buttons', 
                'confirm' => Yii::t('site', 'messages.really-remove'), 
                'title' => Yii::t('site', 'link-title.remove-project'),
            ));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-plus',), '');
            $linkAddTask = CHtml::link($icon, array('task/add', 'projectId' => $project->id), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.add-task'),
            ));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-back',), '');
            $linkGoDashboard = CHtml::link($icon, array('user/dashboard'), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.go-back-to-dashboard'),
            ));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-users',), '');
            $linkManageUsers = CHtml::link($icon, array('project/manageUsers', 'id' => $project->id), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.manage-users-in-project')
            ));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-edit',), '');
            $linkChange = CHtml::link($icon, array('project/change', 'id' => $project->id), array(
                'class' => 'float-right title-buttons', 
                'title' => Yii::t('site', 'link-title.edit-project')
            ));

            $html = '';
            $html .= Yii::app()->user->checkAccess('remove_project', $params) ? $linkRemove : '';
            $html .= Yii::app()->user->checkAccess('manage_users_in_project', $params) ? $linkManageUsers : '';
            $html .= Yii::app()->user->checkAccess('add_task', $params) ? $linkAddTask : '';
            $html .= Yii::app()->user->checkAccess('edit_project', $params) ? $linkChange : '';
            $html .= $linkGoDashboard;
            return $html;
        }
    }
