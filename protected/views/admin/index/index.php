<?php $baseurl = Yii::app()->baseUrl; ?>
<a class="btn btn-default" href="<?=$baseurl.'/admin/scope/';?>" >Scope</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/branch/';?>" >Branch</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/product/';?>" >Product</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/course/';?>" >Course</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/video/';?>" >Video</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/article/';?>" >Article</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/user/';?>" >User</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/seo/';?>" >Seo</a>
<a class="btn btn-default" href="<?=$baseurl.'/admin/settings/';?>" >Settings</a>

<div class="clearfix"></div>
<br>
<div>User IP: <?=Yii::app()->request->userHostAddress;?> Server IP: <?=$_SERVER['SERVER_ADDR'];?></div> 
