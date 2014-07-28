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
        if (isset($_POST['tags_dirty']) && ($_POST['tags_dirty'] == 1) ){
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
        }
        return true;
    }
    
}
