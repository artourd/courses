<?php
/* @var $this ScopeController */
/* @var $model Scope */

$this->breadcrumbs=array(
	'Scopes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Scope', 'url'=>array('index')),
	array('label'=>'Create Scope', 'url'=>array('create')),
	array('label'=>'View Scope', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Scope', 'url'=>array('admin')),
);
?>

<h1>Update Scope <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>