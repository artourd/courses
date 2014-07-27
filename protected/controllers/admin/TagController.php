<?php

class TagController extends AdminController
{
    public $modelName = 'Tag';
    public $usePhotoProcess = false;
    
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'add', 'getItems'),
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
    
    public function actionAdd(){
        //проверить наличие, если нет то создать
        $object = Yii::app()->request->getParam('object');
        $id = Yii::app()->request->getParam('id');
        
        $tagName = Yii::app()->request->getParam('tag');
        $tagAlias = Helper::transliterate($tagName);
        
        $tag = Tag::model()->findAllByAttributes(array('alias' => $tagAlias));
        
        if (!$tag){
            $tag = new Tag();
            $tag->alias = $tagAlias;
            $tag->name = $tagName;
            $tag->save();
        }
        
        //добавить связь
        $command = Yii::app()->db
            ->createCommand('INSERT INTO article_tags (article_id,tag_id) VALUES(:article_id,:tag_id)')
            ->bindParam(':article_id', $id, PDO::PARAM_INT)
            ->bindParam(':tag_id', $tag->id, PDO::PARAM_INT);             
        return $command->execute();
    }
    
    public function actionDelItem($tag_id, $article_id){
        $command = Yii::app()->db
            ->createCommand('DELETE FROM article_tags WHERE article_id = :article_id AND tag_id = :tag_id')
            ->bindParam(':article_id', $id, PDO::PARAM_INT)
            ->bindParam(':tag_id', $tag->id, PDO::PARAM_INT);
        return $command->execute();
    }
   
    
}