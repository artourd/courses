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
                    'getProducts', 'getCourses'),
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
        $article = Course::model()->findByPk($model->article_id);
        $product_id = $article ? $article->product_id : null;
        $product = Product::model()->findByPk($product_id);
        $scope_id = $product ? $product->scope_id : null;
                
        //scope
        $scopes = Scope::getForDropDown();        
        $model->scope_id = ($scope_id ? $scope_id : key($scopes));
                
        //product
        $products = Product::getForDropDown($model->scope_id);
        $model->product_id = ($product_id ? $product_id : key($products));
  
        $articles = Article::getForDropDown($model->product_id);
        
        return array(
            'scopes' => $scopes,
            'products' => $products,
            'articles' => $articles,
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
        $article_id = Yii::app()->request->getParam('article_id');
        $linkStr = Yii::app()->request->getParam('links');
        $source = Yii::app()->request->getParam('source');
        
        if (!$article_id){
            echo CJSON::encode(array('success' => false, 'error' => 'No article_id'));
            return false;            
        }
        if (!$linkStr){
            echo CJSON::encode(array('success' => false, 'error' => 'No links'));
            return false;            
        }        

        $links = explode("\n", $linkStr);
        
        $maxOrd = Video::getMaxOrder($article_id);
        $i = 0;
        foreach($links as $link){
            $linkId = VideoAdapter::linkToId($link);
            if (!Video::existByAlias($linkId, $article_id)){
                $result = VideoAdapter::link2data($source, $link);
                if ($result['success']){
                    $model = new Video();
                    $model->article_id = $article_id;
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
