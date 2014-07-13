<?php

class VideoController extends AdminController
{
    public $modelName = 'Video';
    public $usePhotoProcess = false;
    
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'getVideoData', 'UploadVideoData', 
                    'getProducts', 'getBranches', 'getCourses'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }    
    
    protected function initRelData($model) {    
        $course = Course::model()->findByPk($model->course_id);
        $product_id = $course ? $course->product_id : null;
        $product = Product::model()->findByPk($product_id);
        $branch_id = $product ? $product->branch_id : null;
        $branch = Branch::model()->findByPk($branch_id);
        $scope_id = $branch ? $branch->scope_id : null;
                
        //scope
        $scopes = Scope::getForDropDown();        
        $model->scope_id = ($scope_id ? $scope_id : key($scopes));
                
        //branch
        $branches = Branch::getForDropDown($model->scope_id);
        $model->branch_id = ($branch_id ? $branch_id : key($branches));
        
        //product
        $products = Product::getForDropDown($model->branch_id);
        $model->product_id = ($product_id ? $product_id : key($products));
  
        $courses = Course::getForDropDown($model->product_id);
        
        return array(
            'scopes' => $scopes,
            'branches' => $branches,
            'products' => $products,
            'courses' => $courses,
        );
    }   
    
    public function actionGetVideoData() {
        $source = Yii::app()->request->getParam('source', 'youtube');
        $link = Yii::app()->request->getParam('link');

        if (empty($link)){
            return CJSON::encode(array('success' => false, 'error' => 'Empty link'));
        }
        if (empty($source)){
            return CJSON::encode(array('success' => false, 'error' => 'Empty source'));
        }
            
        $result = VideoAdapter::link2data($source, $link);

        echo CJSON::encode($result);
    }
    
    function actionUploadVideoData(){
        $course_id = Yii::app()->request->getParam('course_id');
        $linkStr = Yii::app()->request->getParam('links');
        $source = Yii::app()->request->getParam('source');
        
        if (!$course_id){
            echo CJSON::encode(array('success' => false, 'error' => 'No course_id'));
            return false;            
        }
        if (!$linkStr){
            echo CJSON::encode(array('success' => false, 'error' => 'No links'));
            return false;            
        }        

        $links = explode("\n", $linkStr);
        
        $maxOrd = Video::getMaxOrder($course_id);
        $i = 0;
        foreach($links as $link){
            $linkId = VideoAdapter::linkToId($link);
            if (!Video::existByAlias($linkId, $course_id)){
                $result = VideoAdapter::link2data($source, $link);
                if ($result['success']){
                    $model = new Video();
                    $model->course_id = $course_id;
                    $model->link = $link;
                    $model->alias = $linkId;
                    $model->title = $result['title'];
                    $model->desc = $result['desc'];                
                    $model->picture = $result['picture'];
                    $model->thumb = $result['thumb'];
                    $model->ico = $result['ico'];
                    $model->ord = ++$maxOrd;
                    $model->save();
                    $i++;
                } else {
                    echo CJSON::encode(array('success' => false, 'error' => $result['error']));
                    return false;
                }
            }
        }
        echo CJSON::encode(array('success' => true, 'count' => $i));
    }    
}
