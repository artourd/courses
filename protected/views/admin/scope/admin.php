<?php
/* @var $this ScopeController */
/* @var $model Scope */

$this->breadcrumbs=array(
	'Scopes'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Scope', 'url'=>array('index')),
	array('label'=>'Create Scope', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#scope-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Scopes</h1>

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
	'id'=>'scope-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'alias',
		'title',
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
