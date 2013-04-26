<?php

    class ProjectController extends AController
    {
        public function actionAdd()
        {
            $this->render('add');
        }

        public function actionChange()
        {
            $this->render('change');
        }

        public function actionList()
        {
            $this->render('list');
        }

        public function actionRemove()
        {
            $this->render('remove');
        }
    }
