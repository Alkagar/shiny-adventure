<!doctype html>
<html>
    <head>
        <title></title>
        <meta name="description" content="<?php echo Yii::t('site', 'head.description');?>" />
        <meta name="keywords" content="<?php echo Yii::t('site', 'head.keywords');?>" />
        <meta name="author" content="Jakub Alkagar Mrowiec - jakub@mrowiec.org" />
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.6.0/build/cssreset/cssreset-min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/default.css" />
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/scripts/default.js"></script>
    </head>
    <body>
        <div class='page'>
            <?php $this->renderPartial('//partials/menu'); ?>
            <div class='content'>
                <?php echo $content; ?>
            </div>
            <?php $this->renderPartial('//partials/footer'); ?>
        </div>

    </body>
</html>
