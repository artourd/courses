<?php

class ProductController extends AdminController
{
    public $modelName = 'Product';
    public $usePhotoProcess = true;      
    
    protected function initRelData($model) {
        $branch = Product::model()->findByPk($model->branch_id);
        $scope_id = $branch ? $branch->scope_id : null;
        
        //scope
        $scopes = Scope::getForDropDown();        
        $model->scope_id = ($scope_id ? $scope_id : key($scopes));
                
        //branch
        $branches = Branch::getForDropDown($model->scope_id);

        return array(
            'scopes' => $scopes,
            'branches' => $branches
        );
    }    

}
