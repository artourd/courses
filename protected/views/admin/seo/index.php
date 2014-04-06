<?php
/* @var $this SeoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seos',
);

$this->menu=array(
	array('label'=>'Create Seo', 'url'=>array('create')),
	array('label'=>'Manage Seo', 'url'=>array('admin')),
);
?>

<h1>Seos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
