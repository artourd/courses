<?php

class CourseController extends AdminController
{
    public $modelName = 'Course';
    
    protected function initRelData($model) {
        $scopesObjects = Scope::model()->findAll();

        $scopes = array();
        foreach ($scopesObjects as $obj){
          $scopes[$obj->id] = $obj->title;
        }  
        
        //product
        $productsObjects = Product::model()->findAll();
        
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
