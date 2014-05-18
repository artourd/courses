<?php

class Picture
{
    /**
     * get base path of all uploaded images
     * @return type
     */
    static function getBasePath(){
        return str_replace('protected', '', Yii::app()->basePath).'images';
    }
    
    /**
     * Make dir
     * @param type $path
     */
    static function makeDir($path){
        (!is_dir($path)) && mkdir($path, 0775, true);
    }
    
    /**
     * Return full image path
     * @param sting $modelName
     * @param sting $type - pic or thumb
     * @param int $id
     * @param sting $name - filename
     * @return string - full path to image
     */
    static function getImagePath($modelName, $modelId, $type, $name){
        return Yii::app()->request->baseUrl."\\images" . '\\'.$modelName.'\\'.$modelId.'\\'.$type.'\\'.$name;
    }
    
    static function getImage($modelName, $modelId, $type, $name){
        if ($name){
            return "<img src='".self::getImagePath($modelName, $modelId, $type, $name)."' width='40' height='40' id='img{$type}' />";
        } else {
            return "";
        }
    }
    
    /**
     * Get cross for delete image
     * @param type $type
     * @return type
     */
    static function getCross($type, $mname){
        return "<a href='#' onclick='deleteImg(\"{$type}\", \"{$mname}\"); return false;' id='a{$type}'>[X]</a>"
        . "<input type='hidden' id='del{$type}' name='del{$type}' value='0'>";
    }
    
    /**
     * Move Uploaded Images
     * @param int $id - model id
     */
    static function moveUploadedImages($id){
        $path = Picture::getBasePath();
                
        if ($_FILES['Scope']) {
            self::makeDir($path.'\\scope\\');
            self::makeDir($path.'\\scope\\'.$id.'\\');

            if ($_FILES['Scope']['name']['picture']) {
                self::makeDir($path.'\\scope\\'.$id.'\\pic\\');

                move_uploaded_file(
                        $_FILES['Scope']['tmp_name']['picture'], 
                        $path . '\\scope\\'.$id.'\\pic\\' . $_FILES['Scope']['name']['picture']);
            }
            if ($_FILES['Scope']['name']['thumb']) {

                self::makeDir($path.'\\scope\\'.$id.'\\thumb\\');

                move_uploaded_file(
                        $_FILES['Scope']['tmp_name']['thumb'], 
                        $path . '\\scope\\'.$id.'\\thumb\\' . $_FILES['Scope']['name']['thumb']);

            }
        }
    }
    
    /**
     * Delete image file
     * @param type $modelName
     * @param type $modelId
     * @param type $type
     * @param type $name
     */
    static function deleteImageFile($modelName, $modelId, $type, $name){
        $path = Picture::getBasePath();
        $filepath = $path.'\\'.$modelName.'\\'.$modelId.'\\'.$type.'\\'.$name;
        if (is_file($filepath)) {
            unlink($filepath);
        }
    }
    
    //
    static function removeImages(&$model){
        if (isset($_POST['delpic']) && $_POST['delpic']){
            Picture::deleteImageFile(get_class($model), $model->id, 'pic', $model->picture);
            $model->picture = '';
        }
        if (isset($_POST['delthumb']) && $_POST['delthumb']){
            Picture::deleteImageFile(get_class($model), $model->id, 'thumb', $model->thumb);
            $model->thumb = '';
        }        
    }
}