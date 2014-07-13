<?php

class VideoController extends AdminController
{
    public $modelName = 'Video';
    public $usePhotoProcess = false;
    
    protected function initRelData($model) {    
        $course = Course::model()->findByPk($model->course_id);
        $product_id = $course ? $course->product_id : null;
        $product = Product::model()->findByPk($product_id);
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
        $model->product_id = ($product_id ? $product_id : key($products));
  
        $courses = Course::getForDropDown($model->product_id);
        
        return array(
            'scopes' => $scopes,
            'branches' => $branches,
            'products' => $products,
            'courses' => $courses,
        );
    }    
}
