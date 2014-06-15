<?php

class AdminController extends Controller {
    public $modelName = 'admin';
    public $layout='//layouts/column2';
    
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
                'actions' => array('create', 'update', 'GetVideoData'),
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
            $model->attributes = $_POST[$this->modelName];
            
            if ($model->save()){
                Picture::writeImageFilenames($model);
                $model->save();
                
                Picture::moveUploadedImages($model->id, $this->modelName);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        
        $data = array_merge(array('model' => $model), $this->initRelData($model));        
        $this->render('create', $data);
    }
    
    protected function initRelData($model){
        return array();
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
       // print_r($_FILES); exit;
        
        $cs = Yii::app()->clientScript;
        $cs->registerPackage('admin');
        
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST[$this->modelName])) {
            $_POST[$this->modelName]['picture'] = $model->picture;
            $_POST[$this->modelName]['thumb'] = $model->thumb;
            $_POST[$this->modelName]['ico'] = $model->ico;
            
            $model->attributes = $_POST[$this->modelName];

            Picture::processImages($model);
         
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $data = array_merge(array('model' => $model), $this->initRelData($model));
        
        $this->render('create', $data);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        Picture::clearImageFiles($model);        
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

    public function gridCheckbox($data) {
        return ($data["active"] ? "<b>+</b>" : "");
    }
    
    public function actionGetVideoData() {
        $source = Yii::app()->request->getParam('source', 'youtube');
        $linkf = Yii::app()->request->getParam('link');
        $link1 = explode('?', $linkf);
        $link2 = explode('=', $link1[1]); 
        $link = $link2[1];

        if (empty($link)){
            return CJSON::encode(array('success' => false, 'error' => 'Empty link'));
        }
        if (empty($source)){
            return CJSON::encode(array('success' => false, 'error' => 'Empty source'));
        }
        
        echo CJSON::encode(VideoAdapter::getData($source, $link));
    }
}
