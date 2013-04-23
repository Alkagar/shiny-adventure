<?php

    return array(
        'commandMap'=>array(
            'migrate'=>array(
                'class'=>'system.cli.commands.MigrateCommand',
                'migrationPath'=>'application.migrations',
                'migrationTable'=>'{{migration_history}}',
                'connectionID'=>'db',
                'templateFile'=>'application.migrations.template',
            ),
        ),

        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Console Shiny Adventure',
    );

