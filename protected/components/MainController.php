<?php

abstract class MainController extends Controller {
    public $layout='//layouts/main_layout';    
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
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
                " var _baseUrl = '".Yii::app()->baseUrl."'; ", $pos);
        
        $scripts = array(
            '/js/jquery-2.1.1.min.js',
            '/js/jquery.yiiactiveform.js',
        );
        if (IS_PROD){
            $scripts[] = '/js/main.js';
        }        
        /*foreach ($scripts as $value) {
            $cs->registerScriptFile($baseUrl . $value, $pos);
        }*/
        $jspath = Combiner::processJs($scripts);
        $cs->registerScriptFile($jspath, $pos);
        
        if (!IS_PROD){
            $cs->registerScriptFile($baseUrl . '/js/main.js', $pos);
        }
    }
    
    private function registerStyles(){
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->clientScript;
        
        $styles = array(
            '/css/base.css',
            '/css/menu.css',
            '/css/menu_products.css',
            '/css/list.css',
        );
        if (IS_PROD){
            $styles[] = '/css/main.css';
        }
        foreach ($styles as $value) {
            $cs->registerCssFile($baseUrl.$value);
        }
        //$csspath = Combiner::processCss($styles);
        //$cs->registerCssFile($csspath);
        
        if (!IS_PROD){
            $cs->registerCssFile($baseUrl.'/css/main.css');
        }
    }    
}

