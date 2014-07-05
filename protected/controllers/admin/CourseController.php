<?php

class CourseController extends AdminController
{
    public $modelName = 'Course';
    
    protected function initRelData($model) {
        $currProd = Product::model()->findByPk($model->product_id);
        $scope_id = $currProd ? $currProd->scope_id : null;
        
        //scope
        $scopesObjects = Scope::model()->findAll();
        $scopes = array();
        $fscope_id = null;
        foreach ($scopesObjects as $obj){
            $scopes[$obj->id] = $obj->title;
            if (empty($fscope_id)) $fscope_id = $obj->id;
        }         
        $model->scope_id = ($scope_id ? $scope_id : $fscope_id);
        //product
        $pcrit = new CDbCriteria();
        $pcrit->condition = 'scope_id = "'.$model->scope_id.'"';
        $productsObjects = Product::model()->findAll( $pcrit );
   
        $products = array();
        foreach ($productsObjects as $obj){
            $products[$obj->id] = $obj->title;
        }
  
        return array(
            'scopes' => $scopes,
            'products' => $products
        );
    }
}
