<?php

class VideoController extends AdminController
{
    public $modelName = 'Video';
    public $usePhotoProcess = false;
    
    protected function initRelData($model) {    
        $currCurse = Course::model()->findByPk($model->course_id);
        $currProd = $currCurse ? Product::model()->findByPk($currCurse->product_id) : null;
        
        $course_id = $model->course_id;
        $product_id = $currCurse ? $currCurse->product_id : null;
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
   
        $fproduct_id = null;
        $products = array();
        foreach ($productsObjects as $obj){
            $products[$obj->id] = $obj->title;
            if (empty($fproduct_id)) $fproduct_id = $obj->id;
        }
        $model->product_id = ($product_id ? $product_id : $fproduct_id);
                
        //courses
        $ccrit = new CDbCriteria();
        $ccrit->condition = 'product_id = "'.$model->product_id.'"';
        $coursesObjects = Course::model()->findAll( $ccrit );
        
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
