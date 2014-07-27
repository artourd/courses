<link rel="stylesheet" type="text/css" href="<?=(IS_PROD ? '' : '/courses')?>/css/file-browser.css" />
<script type="text/javascript" src="<?=(IS_PROD ? '' : '/courses')?>/js/jquery-2.1.1.min.js" ></script>
<script type="text/javascript" src="<?=(IS_PROD ? '' : '/courses')?>/js/file-browser.js" ></script>

<div class="buttons">
    <input id="newfolder" type="text" value="" />
    <a href="#" onclick="addfolder('<?=$q?>'); return false;" ><img src="<?=(IS_PROD ? '' : '/courses')?>/css/img/folderadd.gif" alt="new folder" title="new folder"></a>
    <a href="#" onclick="delfolder('<?=$q?>'); return false;" ><img src="<?=(IS_PROD ? '' : '/courses')?>/css/img/folderdel.gif" alt="delete folder" title="delete folder"></a>
    <a href="" onclick="refresh('<?=$q?>')"><img src="<?=(IS_PROD ? '' : '/courses')?>/css/img/refresh.gif" alt="refresh" title="refresh"></a>  
    <form method="post" action="<?=(IS_PROD ? '' : '/courses')?>/admin/file/" id="frmAddImage" enctype="multipart/form-data" style="float: right">
        <input type="file" name="newimage" id="newimage" value="" />
        <input type="hidden" name="q" value="<?=$q;?>" />
        <a href="" onclick="upload('<?=$q;?>'); return false;">
            <img src="<?=(IS_PROD ? '' : '/courses')?>/css/img/add.gif" alt="upload" title="upload">
        </a>
    </form>
</div>
<div class="clear"></div>

<div class="path">path: <?=$q; ?></div>
<div class="clear"></div>

<div class="folders">
    <?php foreach ($dirs as $dir): ?>
    <? if ($dir == '.'): ?>
    <a href="#" class="home" onclick="getLinkHome()">&uArr;</a>
    <? elseif ($dir == '..'): ?>
    <a href="#" class="up" onclick="getLinkUp('<?=$parent?>')">&lsh; </a>
    <? else: ?>
    <a href="#" class="dir" onclick="getLink('<?=$dir?>', '<?=$q?>')"><?=$dir?></a>
    <? endif; ?>
    <?php endforeach; ?>
</div>
<div >
    <div class="files">
        <?php foreach ($images as $image ): ?>
        <a href="" onclick="setInput('<?=(IS_PROD ? '' : '/courses'). '/images/'.$q.'/'.$image?>');">
            <img height="100" width="100" src="<?=(IS_PROD ? '' : '/courses').'/images/'.$q.'/'.$image?>" title="<?=$image?>" alt="<?=$image?>"/>
        </a>
        <?php endforeach; ?>
    </div>
    <div>
        <?php foreach ($files as $file ): ?>
        <a href="" onclick="setInput('<?=(IS_PROD ? '' : '/courses').'/images/'.$q.'/'.$file?>');"><?=$file?></a>
        <?php endforeach; ?>        
    </div>    
</div>
