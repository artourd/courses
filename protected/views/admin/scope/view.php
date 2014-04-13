<?php
/* @var $this ScopeController */
/* @var $model Scope */

$this->breadcrumbs=array(
	'Scopes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Scope', 'url'=>array('index')),
	array('label'=>'Create Scope', 'url'=>array('create')),
	array('label'=>'Update Scope', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Scope', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Scope', 'url'=>array('admin')),
);
?>

<h1>View Scope #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'alias',
		'title',
		'created',
		'updated',
        'active',
	),
)); ?>
