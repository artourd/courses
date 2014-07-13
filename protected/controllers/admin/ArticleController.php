<?php

class ArticleController extends AdminController
{
    public $modelName = 'Article';
    public $usePhotoProcess = false;
    
    protected function initRelData($model) {
        $product = Product::model()->findByPk($model->product_id);
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
  
        return array(
            'scopes' => $scopes,
            'branches' => $branches,
            'products' => $products
        );
    }    
}
