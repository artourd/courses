<?php

class CourseController extends AdminController
{
    public $modelName = 'Course';
    public $usePhotoProcess = true;      
    
    protected function initRelData($model) {
        $product = Product::model()->findByPk($model->product_id);
        $scope_id = $product ? $product->scope_id : null;
                
        //scope
        $scopes = Scope::getForDropDown();        
        $model->scope_id = ($scope_id ? $scope_id : key($scopes));
                
        //product
        $products = Product::getForDropDown($model->scope_id);
  
        return array(
            'scopes' => $scopes,
            'products' => $products
        );
    }
}
