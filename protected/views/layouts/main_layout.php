<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
<?php  $this->renderPartial('//layouts/_header'); ?>
	<?php echo $content; ?>

	<div class="clear"></div>

<?php $this->renderPartial('//layouts/_footer'); ?>

</div><!-- page -->

</body>
</html>