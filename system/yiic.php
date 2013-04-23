<?php
    function mergeArray($a,$b)
    {
        foreach($b as $k=>$v)
        {
            if(is_integer($k))
            isset($a[$k]) ? $a[]=$v : $a[$k]=$v;
            else if(is_array($v) && isset($a[$k]) && is_array($a[$k]))
            $a[$k]=self::mergeArray($a[$k],$v);
            else
            $a[$k]=$v;
        }
        return $a;
    }
    // change the following paths if necessary
    $yiic = '/home/alkagar/repos/libraries/yii/framework/yiic.php';

    $console = require_once(dirname(__FILE__).'/config/console.php');
    $local = require_once(dirname(__FILE__).'/config/taurus.php');

    $config = mergeArray( $console, $local );

    require_once($yiic);
