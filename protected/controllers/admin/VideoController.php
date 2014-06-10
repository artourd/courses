<?php

class VideoController extends AdminController
{
    public $modelName = 'Video';
    
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
        
        //courses
        $coursesObjects = Course::model()->findAll();
        
        $courses = array();
        foreach ($coursesObjects as $obj){
          $courses[$obj->id] = $obj->title;
        }        
        
        return array(
            'scopes' => $scopes,
            'products' => $products,
            'courses' => $courses,
        );
    }    
}
