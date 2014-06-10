<?php

class ProductController extends AdminController
{
    public $modelName = 'Product';
    
    protected function initRelData($model) {
        $scopesObjects = Scope::model()->findAll();
        
        $scopes = array();
        foreach ($scopesObjects as $obj){
          $scopes[$obj->id] = $obj->title;
        }  
        
        return array('scopes' => $scopes);
    }

}
