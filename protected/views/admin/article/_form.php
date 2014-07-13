<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'short'); ?>
		<?php echo $form->textField($model,'short',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'short'); ?>
	</div>

    <div class="form-group" style="width: 350px;">
        <?php echo $form->labelEx($model,'published'); ?>
        <div data-link-field="dtp_input1" data-date-format="dd mm yyyy - HH:ii" data-date="<?=$model->published?>" class="input-group date form_datetime">
            <?php echo $form->textField($model,'published',array('size'=>20,'maxlength'=>20,)); ?>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>        
        <input type="hidden" value="" id="dtp_input2"><br>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>47)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>    
    
	<div class="form-group">
		<?php echo $form->labelEx($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'author_id'); ?>
	</div>
    
	<div class="form-group">
		<?php echo $form->labelEx($model,'scope_id'); ?>
		<?php echo $form->dropDownList($model,'scope_id', $scopes); ?>
		<?php echo $form->error($model,'scope_id'); ?>
	</div>    
    
	<div class="form-group">
		<?php echo $form->labelEx($model,'branch_id'); ?>
		<?php echo $form->dropDownList($model,'branch_id', $branches); ?>
		<?php echo $form->error($model,'branch_id'); ?>
	</div>    
    
	<div class="form-group">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->dropDownList($model,'product_id', $products); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>    

	<div class="form-group">
		<?php echo $form->labelEx($model,'meta_desc'); ?>
		<?php echo $form->textField($model,'meta_desc',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'meta_desc'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'meta_keys'); ?>
		<?php echo $form->textField($model,'meta_keys',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'meta_keys'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
    
/*CKEDITOR.replace( 'Article_content', {
    filebrowserBrowseUrl: '/browser/browse.php',
    filebrowserUploadUrl: '/uploader/upload.php'
});*/
    
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 300,
        plugins: [
             "advlist autolink link image lists charmap hr anchor pagebreak spellchecker",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],

       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media fullpage | forecolor backcolor emoticons", 
       style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        file_browser_callback : function(field_name, url, type, win) { 
            //win.document.getElementById(field_name).value = 'my browser value'; 
            myFileBrowser (field_name, url, type, win);
        }

    });
    
function myFileBrowser (field_name, url, type, win) {

    //alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

    var cmsURL = '<?=Yii::app()->baseUrl;?>/admin/file';

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'My File Browser',
        width : 560,  // Your dimensions may differ - toy around with them!
        height : 420,
        resizable : "yes",
        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }
</script>    
    
</div><!-- form -->