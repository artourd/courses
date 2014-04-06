<?php
/* @var $this ScopeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Scopes',
);

$this->menu=array(
	array('label'=>'Create Scope', 'url'=>array('create')),
	array('label'=>'Manage Scope', 'url'=>array('admin')),
);
?>

<h1>Scopes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
