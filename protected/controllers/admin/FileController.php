<?php

class FileController extends AdminController
{
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('Catalog', 'Addfolder'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'Delfolder'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }    
    
    /**
     * ImageManager for Tiny MCE
     */
    public function actionIndex(){
        $q = Yii::app()->request->getParam('q');  
        $path = Picture::getBasePath();//.DIRECTORY_SEPARATOR.'article';
        if ($q) $path .= DIRECTORY_SEPARATOR.$q;
        
        if (isset($_FILES) && isset($_FILES['newimage'])){
            move_uploaded_file($_FILES['newimage']['tmp_name'], $path.DIRECTORY_SEPARATOR.$_FILES['newimage']['name']);
        }
        
        $parent = '';
        if ($q != ''){
            $qsplit = explode('/', $q);
            unset($qsplit[count($qsplit)-1]);
            $parent = implode('/', $qsplit);
        }
        
        $dirs = $files = $images = array();
        
        $objects = scandir($path);
        //print_r($objects); exit;

        foreach ($objects as $obj){
            $type = filetype($path.'/'.$obj);
            if ($type == 'dir'){
                $dirs[] = $obj;
            } elseif ($type == 'file') {
                $ext = strtolower(pathinfo($path.'/'.$obj, PATHINFO_EXTENSION));
                if (in_array($ext, array('jpeg', 'png', 'gif', 'jpg', 'bmp'))){
                    $images[] = $obj;
                } else {
                    $files[] = $obj;
                }
            }
        }
        
        $this->renderPartial('_catalog', array(
            'path' => $path,
            'dirs' => $dirs,
            'images' => $images,
            'files' => $files,
            'q' => $q,
            'parent' => $parent,
                ));
    }
    
    public function actionAddfolder(){
        $path = Picture::getBasePath().DIRECTORY_SEPARATOR.Yii::app()->request->getParam('folder');
        mkdir($path);        
    }
    
    public function actionDelfolder(){
        $path = Picture::getBasePath().DIRECTORY_SEPARATOR.Yii::app()->request->getParam('folder');
        //Helper::rrmdir($path);       
    }   
    
    public function actionDelfile(){
        $path = Picture::getBasePath().DIRECTORY_SEPARATOR.Yii::app()->request->getParam('file');
        unlink($path);
        //Helper::rrmdir($path);       
    }    
}
