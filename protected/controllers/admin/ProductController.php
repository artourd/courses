<?php

class ProductController extends AdminController
{
    public $modelName = 'Product';
    public $usePhotoProcess = true;      
    
    protected function initRelData($model) {
        return array('scopes' => Scope::getForDropDown());
    }    

}
