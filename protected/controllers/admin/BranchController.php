<?php

class BranchController extends AdminController
{
    public $modelName = 'Branch';
    public $usePhotoProcess = true;    
    
    protected function initRelData($model) {
        return array('scopes' => Scope::getForDropDown());
    }    
}