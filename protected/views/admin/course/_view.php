<?php
/* @var $this CourseController */
/* @var $data Course */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product')); ?>:</b>
	<?php echo CHtml::encode($data->product->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br /> 
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('picture')); ?>:</b>
	<?php echo CHtml::encode($data->picture); ?>
    <?=  Picture::getImage('course', $data->id, 'picture', $data->picture);?>
	<br /> 
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('thumb')); ?>:</b>
	<?php echo CHtml::encode($data->thumb); ?>
    <?=  Picture::getImage('course', $data->id, 'thumb', $data->thumb);?>
	<br /> 
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('ico')); ?>:</b>
	<?php echo CHtml::encode($data->ico); ?>
    <?=  Picture::getImage('course', $data->id, 'ico', $data->ico);?>
	<br />      


</div>