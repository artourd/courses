<?php
/* @var $this VideoController */
/* @var $model Video */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'video-form',
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
		<?php echo $form->labelEx($model,'course_id'); ?>
		<?php echo $form->dropDownList($model,'course_id', $courses); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>  
    
    <div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
    <input type="button" onclick="loadVideoData();" value="Load from Youtube" />

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?php echo $form->textField($model,'desc',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'desc'); ?>
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
        <?=  Picture::getImage('video', $model->id, 'picture', $model->picture)?>
        <?= $model->picture ? Picture::getCross('picture', get_class($model)) : ''; ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'thumb'); ?>
		<?php echo $form->fileField($model,'thumb',array('size'=>50,'maxlength'=>50, 'class'=>($model->thumb ? 'none': ''))); ?>
		<?php echo $form->error($model,'thumb'); ?>
        <?=  Picture::getImage('video', $model->id, 'thumb', $model->thumb);?>
        <?= $model->thumb ? Picture::getCross('thumb', get_class($model)) : ''; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ico'); ?>
		<?php echo $form->fileField($model,'ico',array('size'=>50,'maxlength'=>50, 'class'=>($model->ico ? 'none': ''))); ?>
		<?php echo $form->error($model,'ico'); ?>
        <?=  Picture::getImage('video', $model->id, 'ico', $model->ico);?>
        <?= $model->ico ? Picture::getCross('ico', get_class($model)) : ''; ?>
	</div>      
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
function loadVideoData(){    
    $.ajax({
        type: "POST",
        url: '<?=Yii::app()->baseUrl;?>/index.php/admin/video/getVideoData/',
        dataType: 'json',
        data: {'source':'youtube', 'link': $('#Video_link').val()},
        success: function(response){
            if (response.success){
                alert(response.data.channelTitle);
            } else {
                alert(response.error);
            }
        },
        error: function(){
            alert('Error loadVideoData');
        },
    });
}    
</script>    