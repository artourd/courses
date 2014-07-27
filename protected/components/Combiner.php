<?php

class Combiner extends CComponent {

    public static function processJs(Array $scripts = null){
        $jsName = 'application-' . sha1(implode('', $scripts)) . '.js';
        $jsPath = str_replace('protected', '', Yii::app()->basePath) . DIRECTORY_SEPARATOR . 
                'js' . DIRECTORY_SEPARATOR . $jsName;

        if (!file_exists($jsPath)) {
            $buffer = '';
            foreach ($scripts as $file) {
                $buffer .= file_get_contents('.' . $file) . "\n";
            }
            file_put_contents($jsPath, $buffer);//JSMin::minify($buffer));
        }

		return Yii::app()->baseUrl . '/js/' . $jsName;
    }
    
    public static function processCss(Array $styles = null){
        $cssName = 'application-' . sha1(implode('', $styles)) . '.css';
        $cssPath = str_replace('protected', '', Yii::app()->basePath) . DIRECTORY_SEPARATOR . 
                'css' . DIRECTORY_SEPARATOR . $cssName;

        if (!file_exists($cssPath)) {
            $buffer = '';
            foreach ($styles as $file) {
                if ($file){
                    $buffer .= file_get_contents('.' . $file) . "\n";
                }
            }
            file_put_contents($cssPath, $buffer);//CssMin::minify($buffer));
        }

        return Yii::app()->baseUrl . '/css/' . $cssName;
    }
}
