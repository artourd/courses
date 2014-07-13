<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title>Admin Panel</title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
        <div id="logo">Admin Panel 
            <?php if (Yii::app()->user->isGuest): ?>
                <a href="/site/login" style="color: blue">login</a>
            <?php else: ?>
            <span style="color: #aaa; font-size: 12px">(<?=Yii::app()->user->name;?>      
                <a href="/site/logout" >logout</a>)
            </span>
            <?php endif; ?>
        </div>
	</div><!-- header -->
    
	<div id="mainmenu">

		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                array('label'=>'Scope', 'url'=>array('/admin/scope/admin/')),
                array('label'=>'Branch', 'url'=>array('/admin/branch/admin/')),
                array('label'=>'Product', 'url'=>array('/admin/product/admin/')),
                array('label'=>'Course', 'url'=>array('/admin/course/admin/')),
                array('label'=>'Video', 'url'=>array('/admin/video/admin/')),
                array('label'=>'Article', 'url'=>array('/admin/article/admin/')),                
                array('label'=>'User', 'url'=>array('/admin/user/admin/')),
                array('label'=>'Seo', 'url'=>array('/admin/seo/admin/')),
                array('label'=>'Settings', 'url'=>array('/admin/settings/admin/')),
			),
		)); ?>
	</div><!-- mainmenu -->

	<?php echo $content; ?>

	<div class="clearfix"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
