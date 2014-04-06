<?php
/* @var $this SeoController */
/* @var $model Seo */

$this->breadcrumbs=array(
	'Seos'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Seo', 'url'=>array('index')),
	array('label'=>'Create Seo', 'url'=>array('create')),
	array('label'=>'View Seo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Seo', 'url'=>array('admin')),
);
?>

<h1>Update Seo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>