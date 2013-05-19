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
            if(is_null(Project::model()->findByPk($project->id))) {
                $linkRemove = '';
            }

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


        public static function parseMarkdown($text)
        {
            $mdp = new CMarkdownParser();
            $html = $mdp->transform($text);
            return $html;
        }

        public static function activeMarkdownTextArea($model, $field, $htmlOptions = array(), $preview = true)
        {
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/Markdown.Style.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/Markdown.Converter.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/Markdown.Sanitizer.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/Markdown.Editor.js');

            $htmlOptions['id'] = 'wmd-input';
            $html = '<div id="wmd-button-bar"></div>';
            $html .= CHtml::activeTextArea($model, $field, $htmlOptions);
            $html .= $preview ? '<div id="wmd-preview" class="float-right wmd-panel wmd-preview"></div>' : '';
            $html .= "
            <script type='text/javascript'>
                $(document).ready(function() {
                    var converter = Markdown.getSanitizingConverter();
                    var editor = new Markdown.Editor(converter);
                    editor.run();
                });
            </script>
            ";
            return $html;
        }

        public static function dropDownUserList($fieldName, $selected = '', $htmlOptions = array())
        {
            $users = User::model()->findAll();
            $userSelect = array();
            foreach($users as $user) {
                $userSelect[$user->id] = $user->signature . ' [ ' . $user->mail . ' ]';
            }

            return CHtml::dropDownList('user-mockup', $selected, $userSelect, $htmlOptions);
        }
    }
