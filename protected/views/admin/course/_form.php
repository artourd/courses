<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'scope_id'); ?>
		<?php echo $form->dropDownList($model,'scope_id', $scopes); ?>
		<?php echo $form->error($model,'scope_id'); ?>
	</div>    
    
	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->dropDownList($model,'product_id', $products); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->checkBox($model,'active',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'active'); ?>
	</div> 

	<div class="row">
		<?php echo $form->labelEx($model,'picture'); ?>
		<?php echo $form->fileField($model,'picture',array('size'=>50,'maxlength'=>50, 'class'=>($model->picture ? 'none': '') )); ?>
		<?php echo $form->error($model,'picture'); ?>
        <?=  Picture::getImage('course', $model->id, 'picture', $model->picture)?>
        <?= $model->picture ? Picture::getCross('picture', get_class($model)) : ''; ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'thumb'); ?>
		<?php echo $form->fileField($model,'thumb',array('size'=>50,'maxlength'=>50, 'class'=>($model->thumb ? 'none': ''))); ?>
		<?php echo $form->error($model,'thumb'); ?>
        <?=  Picture::getImage('course', $model->id, 'thumb', $model->thumb);?>
        <?= $model->thumb ? Picture::getCross('thumb', get_class($model)) : ''; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ico'); ?>
		<?php echo $form->fileField($model,'ico',array('size'=>50,'maxlength'=>50, 'class'=>($model->ico ? 'none': ''))); ?>
		<?php echo $form->error($model,'ico'); ?>
        <?=  Picture::getImage('course', $model->id, 'ico', $model->ico);?>
        <?= $model->ico ? Picture::getCross('ico', get_class($model)) : ''; ?>
	</div>      
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->