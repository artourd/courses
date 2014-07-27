<?php

abstract class AdminController extends Controller {
    public $modelName = 'admin';
    public $layout='//layouts/column2';
    public $usePhotoProcess = false;
    
    private $_scripts = array(
        '/js/jquery-2.1.1.min.js',
        '/js/bootstrap.min.js',
        '/js/bootstrap-datetimepicker.min.js',
        '/js/jquery.ba-bbq.js',
        '/js/jquery.yiiactiveform.js',
        '/js/jquery-ui.min.js',
        '/js/sh/shCore.js',
        '/js/sh/shBrushXml.js',
        '/js/sh/shBrushJScript.js',
        '/js/sh/shBrushPhp.js',
    );
    private $_styles = array(
        '/css/bootstrap.css',
        '/css/bootstrap-theme.css',
        '/css/bootstrap-datetimepicker.css',
        '/css/jquery-ui.min.css',
        '/css/sh/shCore.css',
        '/css/sh/shCoreDefault.css',
        '/css/sh/shThemeDefault.css',
    );        
    
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'getProducts', 'getArticles'),
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

    public function init() {
        $this->registerScripts();
        $this->registerStyles();
        
        parent::init();
    }
    
    private function registerScripts(){
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->clientScript;
        $pos = CClientScript::POS_END;
        
        $cs->registerScript("baseVars", 
                " var _baseUrl = '".Yii::app()->baseUrl."'; ".
                " var _model = '".$this->modelName."'; ", $pos);
        
        $scripts = $this->_scripts;
        $scripts[] = '/js/admin.js';
        if (IS_PROD){
            $jspath = Combiner::processJs($scripts);
            $cs->registerScriptFile($jspath, $pos);
        } else {     
            foreach ($scripts as $value) {
                $cs->registerScriptFile($baseUrl . $value, $pos);
            }
        }
        if ($this->modelName == 'Article'){
            $cs->registerScriptFile($baseUrl . '/js/tinymce/tinymce.min.js', $pos);
        }
    }
    
    private function registerStyles(){
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->clientScript;
        
        $styles = $this->_styles;
        $styles[] = '/css/admin.css';
        
        if (IS_PROD){
            $csspath = Combiner::processCss($styles);
            $cs->registerCssFile($csspath);            
        } else {
            foreach ($styles as $value) {
                $cs->registerCssFile($baseUrl.$value);
            }
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new $this->modelName;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST[$this->modelName])) {
            $model->attributes = $this->processData($_POST[$this->modelName]);

            if ($model->save()){

                if ($this->usePhotoProcess){
                    Picture::writeImageFilenames($model);
                    $model->save();

                    Picture::moveUploadedImages($model->id, $this->modelName);
                }
                if ($this->updateRelData($model)){
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        
        $data = array_merge(array('model' => $model), $this->initRelData($model));        
        $this->render('create', $data);
    }
    
    protected function initRelData($model){
        return array();
    }

    protected function updateRelData($model){
        return true;
    }
    
    protected function processData($data){
        return $data;
    }

        /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
       // print_r($_FILES); exit;
        
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST[$this->modelName])) {
            if ($this->usePhotoProcess){
                $_POST[$this->modelName]['picture'] = $model->picture;
                $_POST[$this->modelName]['thumb'] = $model->thumb;
                $_POST[$this->modelName]['ico'] = $model->ico;
            }
            
            $model->attributes = $this->processData($_POST[$this->modelName]);

            if ($this->usePhotoProcess){
                Picture::processImages($model);
            }
         
            if ($model->save()){
                if ($this->updateRelData($model)){
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $data = array_merge(array('model' => $model), $this->initRelData($model));
        
        $this->render('update', $data);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        
        if ($this->usePhotoProcess){
            Picture::clearImageFiles($model);        
        }
        
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider($this->modelName);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new $this->modelName('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Scope the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $modelObj = new $this->modelName;
        $model = $modelObj->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Scope $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->modelName).'-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function gridPicture($data){
        return Picture::getImage(get_class($data), $data->id, 'picture', $data['picture']);
    }
    
    public function gridThumb($data){
        return Picture::getImage(get_class($data), $data->id, 'thumb', $data['thumb']);
    }    
    
    
    public function gridIco($data){
        return Picture::getImage(get_class($data), $data->id, 'ico', $data['ico']);
    }
    
    public function gridImgIco($data){
        return $this->gridImg($data['ico']);
    }
    
    public function gridImg($src){
        return Picture::getImg($src);
    }    

    public function gridCheckbox($data) {
        return ($data["active"] ? "<b>+</b>" : "");
    }
    
    function actionGetProducts(){
        $scope_id = Yii::app()->request->getParam('scope_id');
        
        $crit = null;
        if ($scope_id){
            $crit = new CDbCriteria();
            $crit->condition = 'scope_id = "'.$scope_id.'"';
        }
        $objects = Product::model()->findAll( $crit );

        $items = array();
        foreach ($objects as $obj){
            $items[$obj->id] = $obj->title;
        }
        
        echo CJSON::encode($items);
    }
    
    function actionGetArticles(){
        $product_id = Yii::app()->request->getParam('product_id');
        
        $crit = null;
        if ($product_id){
            $crit = new CDbCriteria();
            $crit->condition = 'product_id = "'.$product_id.'"';
        }
        $objects = Article::model()->findAll( $crit );

        $items = array();
        foreach ($objects as $obj){
            $items[$obj->id] = $obj->title;
        }
        
        echo CJSON::encode($items);
    }
    
}
