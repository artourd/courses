<?php

abstract class MainController extends Controller {
    public function init() {
        $baseUrl = Yii::app()->baseUrl;
		$pos = CClientScript::POS_END;
        
		$cs = Yii::app()->clientScript;
        $cs->registerScript("baseVars", "var _baseUrl = '".Yii::app()->baseUrl."'; ", $pos);
        
		$cs->registerScriptFile($baseUrl . '/js/jquery-2.1.1.min.js', $pos);
        $cs->registerScriptFile($baseUrl . '/js/main.js', $pos);
        
        $cs->registerCssFile($baseUrl . '/css/bootstrap.css');
        $cs->registerCssFile($baseUrl . '/css/bootstrap-dos.css');
        //$cs->registerCssFile($baseUrl . '/css/bootstrap-theme.css');
		$cs->registerCssFile($baseUrl . '/css/main.css');
        
        parent::init();
    }
}

