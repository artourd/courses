<?php
/* @var $this VideoController */
/* @var $model Video */

$this->breadcrumbs=array(
	'Videos'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Video', 'url'=>array('index')),
	array('label'=>'Create Video', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#video-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Videos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'video-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'course.title',
		'link',
		'alias',
		'title',
		'desc',
        array(
            'name' => 'created',
            'type' => 'html',
            'value' => 'date("d.m.Y H:i:s", strtotime($data["created"]))',
        ),        
        array(
            'name' => 'updated',
            'type' => 'html',
            'value' => 'date("d.m.Y H:i:s", strtotime($data["updated"]))',
        ),        
        array(
            'name' => 'active',
            'type' => 'html',
            'value' => array($this, 'gridCheckbox'),
        ),        
        array(
            'name' => 'picture',
            'type' => 'html',
            'value' => array($this, 'gridPicture'),
        ),
        array(
            'name' => 'thumb',
            'type' => 'html',
            'value' => array($this, 'gridThumb'),
        ),
        array(
            'name' => 'ico',
            'type' => 'html',
            'value' => array($this, 'gridIco'),
            'cssClassExpression' => '"tx_c"',
        ),  
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
