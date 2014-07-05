<?php

class Picture
{
    public static $imgParams = array(
        'pic' => array('width' => 400, 'height' => 400),
        'thumb' => array('width' => 160, 'height' => 160, 'crop' => true),
        'ico' => array('width' => 40, 'height' => 40, 'crop' => true)
    );    
    
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
     * Remove folder
     * @param type $path
     */
    static function remDir($path){
        (is_dir($path)) && rmdir($path);
    }
    
    /**
     * 
     * @param type $modelName
     * @param type $modelId
     * @param string $type
     * @param type $name
     * @return type
     */
    static function getImagePath($modelName, $modelId, $type, $name){
        if ($type == 'picture') $type = 'pic';
        return Yii::app()->request->baseUrl."/images" . '/'.$modelName.'/'.$modelId.'/'.$type.'/'.$name;
    }
    
    /**
     * 
     * @param type $modelName
     * @param type $modelId
     * @param type $type
     * @param type $name
     * @return string
     */
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

    static function getClear($type, $mname){
        return "<a href='#' onclick='clearImg(\"{$type}\", \"{$mname}\"); return false;' id='ac{$type}'>[X]</a>";
    }

    static function getUrl($mname, $type, $value){
        return "<input name='{$mname}_{$type}_url' type='text' value='{$value}' class='form-control' size='50' placeholder='{$type} url'/>";
    }    

    /**
     * Move Uploaded Images
     * @param int $id - model id
     */
    static function moveUploadedImages($id, $modelName){
        $path = self::getBasePath();
        $mname = strtolower($modelName);
           
        if ($_FILES[$modelName]) {
            self::makeDir($path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR);
            self::makeDir($path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR);

            Yii::import('application.vendors.*');
            require_once 'uploadPhoto.php';
            
            if ($_FILES[$modelName]['name']['picture']) {
                self::makeDir($path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.'pic'.DIRECTORY_SEPARATOR);
                
                self::cropProcess('pic', 
                        $path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR, 
                        $_FILES[$modelName]['tmp_name']['picture'], 
                        $id.'.'.pathinfo($_FILES[$modelName]['name']['picture'], PATHINFO_EXTENSION));
            }
            if ($_FILES[$modelName]['name']['thumb']) {

                self::makeDir($path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR);
                
                self::cropProcess('thumb', 
                        $path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR, 
                        $_FILES[$modelName]['tmp_name']['thumb'], 
                        $id.'.'.pathinfo($_FILES[$modelName]['name']['thumb'], PATHINFO_EXTENSION));
            }
            if ($_FILES[$modelName]['name']['ico']) {

                self::makeDir($path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.'ico'.DIRECTORY_SEPARATOR);
                
                self::cropProcess('ico', 
                        $path.DIRECTORY_SEPARATOR.$mname.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR, 
                        $_FILES[$modelName]['tmp_name']['ico'], 
                        $id.'.'.pathinfo($_FILES[$modelName]['name']['ico'], PATHINFO_EXTENSION));
            }            
        }
    }
    
    /*
     * Main process of creating/updating image
     */
    static function processImages(&$model){
        self::removeImages($model);

        self::writeImageFilenames($model);

        self::moveUploadedImages($model->id, get_class($model));
    }
    
    /*
     * Write to modl image names
     */
    static function writeImageFilenames(&$model){
        $modelName = get_class($model);
        
        if ($_FILES[$modelName]['name']['picture']){
            $model->picture = $model->id.'.'.pathinfo($_FILES[$modelName]['name']['picture'], PATHINFO_EXTENSION);
        }

        if ($_FILES[$modelName]['name']['thumb']){
            $model->thumb = $model->id.'.'.pathinfo($_FILES[$modelName]['name']['thumb'], PATHINFO_EXTENSION);
        }     
        
        if ($_FILES[$modelName]['name']['ico']){
            $model->ico = $model->id.'.'.pathinfo($_FILES[$modelName]['name']['ico'], PATHINFO_EXTENSION);
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
        $path = self::getBasePath();
        $filedir = $path.DIRECTORY_SEPARATOR.strtolower($modelName).DIRECTORY_SEPARATOR.$modelId.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR;
        if (is_file($filedir.$name)) {
            unlink($filedir.$name);
        }
        self::remDir($filedir);
    }
    
    /**
     * 
     * @param type $model
     */
    static function removeImages(&$model){
        if (isset($_POST['delpicture']) && $_POST['delpicture']){
            self::deleteImageFile(get_class($model), $model->id, 'pic', $model->picture);
            $model->picture = '';
        }
        if (isset($_POST['delthumb']) && $_POST['delthumb']){
            self::deleteImageFile(get_class($model), $model->id, 'thumb', $model->thumb);
            $model->thumb = '';
        }  
        if (isset($_POST['delico']) && $_POST['delico']){
            self::deleteImageFile(get_class($model), $model->id, 'ico', $model->ico);
            $model->ico = '';
        }         
    }
    
    /**
     * 
     * @param type $model
     */    
    static function clearImageFiles(&$model){
        $modelName = get_class($model);
        self::deleteImageFile($modelName, $model->id, 'pic', $model->picture);
        self::deleteImageFile($modelName, $model->id, 'thumb', $model->thumb);
        self::deleteImageFile($modelName, $model->id, 'ico', $model->ico);        
        self::remDir(self::getBasePath().DIRECTORY_SEPARATOR.$modelName.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR);
    }  
    
    /**
     * Crop
     * @param type $imgType
     * @param type $path
     * @param type $tmpfname
     * @param type $fname
     * @throws CException
     */
    function cropProcess($imgType, $path, $tmpfname, $fname){
        $imgData = self::$imgParams[$imgType];
        $handle = new uploadPhoto($tmpfname);

        if ($handle->uploaded) {
            $handle->file_new_name_body = $fname;
            $handle->file_new_name_ext = '';
            $handle->image_resize = true;
            $handle->image_y = $imgData['height'];
            $handle->image_x = $imgData['width'];
            $handle->jpeg_quality = 85;
            $handle->image_ratio_fill = 'C';
            $handle->image_ratio_crop = (empty($imgData['crop']) ? false : $imgData['crop']);

            //маленькие фото не увеличиваются, а заполняются бекграундом
            if (($handle->image_dst_x < $imgData['width']) && ($handle->image_dst_y < $imgData['height'])) {
                $imgx = floor(($imgData['width'] - $handle->image_dst_x) / 2);
                $imgy = floor(($imgData['height'] - $handle->image_dst_y) / 2);

                $handle->image_resize = false;
                $handle->image_crop = '-' . $imgy . 'px -' . $imgx . 'px';
            }
            $handle->process($path.$imgType.DIRECTORY_SEPARATOR);
            if(!$handle->processed) {
                throw new CException('image uploader process error: '.$handle->error);
            }
        }  else {
            throw new CException('image uploader error: '.$handle->error);
        }      
    }
}