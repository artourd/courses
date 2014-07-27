<?php

class ArticleController extends AdminController
{
    public $modelName = 'Article';
    public $usePhotoProcess = false;
    
    protected function initRelData($model) {
        $product = Product::model()->findByPk($model->product_id);
        $scope_id = $product ? $product->scope_id : null;
                
        //scope
        $scopes = Scope::getForDropDown();        
        $model->scope_id = ($scope_id ? $scope_id : key($scopes));
                
        //product
        $products = Product::getForDropDown($model->scope_id);
        
        //tags
        $tags = Tag::findByArticle($model->id);
  
        return array(
            'scopes' => $scopes,
            'products' => $products,
            'tags' => $tags,
        );
    }    
    
    protected function updateRelData($model) {
        $tagStr = '';
        if (isset($_POST['tags'])) {
            $tagStr = $_POST['tags'];
        }
        
        $tags = explode(';', $tagStr);
        
        Tag::deleteAllRelations($model->id);
        if ($tags) foreach ($tags as $tagName){
            $tag = Tag::get($tagName);
            $tag->addRelation($model->id);
        }
        return true;
    }
    
    protected function processData($data) {
        if (isset($data['published'])){
            //19 07 2014 - 10:30 => 2014-07-19 10:30:00
            $publ = explode(' ', $data['published']);
            $data['published'] = $publ[2].'-'.$publ[1].'-'.$publ[0].' '.$publ[4].':00';
        }
        return $data;
    }
}
