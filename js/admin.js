$(document).ready(function(){
    $('#'+_model+'_scope_id').on('change', function(){
        if ($('#'+_model+'_product_id').length) {
            $('#'+_model+'_product_id').html('');
            if ($('#'+_model+'_scope_id').val()){            
                $.ajax({
                    type: "POST",
                    url: _baseUrl + '/admin/scope/getProducts/',
                    dataType: 'json',
                    data: {'scope_id': $('#'+_model+'_scope_id').val()},
                    success: function(data) {
                        var opt = '';
                        if (data) {
                            $.each(data, function(elem, ind) {
                                opt += '<option value="' + elem + '" >' + ind + '</option>';
                            })
                        } else {
                            console.log('No products');
                        }
                        $('#'+_model+'_product_id').html(opt);
                        $('#'+_model+'_product_id').change();                    
                    },
                    error: function() {
                        alert('Error change product');
                    },
                });
            }    
        }
    });   

    $('#'+_model+'_product_id').on('change', function(){
        if ($('#'+_model+'_article_id').length) {
            $('#'+_model+'_article_id').html('');
            if ($('#'+_model+'_product_id').val()){
                $.ajax({
                    type: "POST",
                    url: _baseUrl + '/admin/scope/getCourses/',
                    dataType: 'json',
                    data: {'product_id': $('#'+_model+'_product_id').val()},
                    success: function(data) {
                        var opt = '';
                        if (data) {                        
                            $.each(data, function(elem, ind) {
                                opt += '<option value="' + elem + '" >' + ind + '</option>';
                            })
                        } else {
                            console.log('No articles');
                        }
                        $('#'+_model+'_article_id').html(opt);
                    },
                    error: function() {
                        alert('Error change product');
                    },
                });
            }
        }
    });     
    
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1,
        format: 'yyyy-mm-dd hh:ii:ss',
    });    
    
    $('#Video_picture').on('change', function(){
        $('#Video_picture_img').attr('src', $('#Video_picture').val() );
    });
    $('#Video_thumb').on('change', function(){
        $('#Video_thumb_img').attr('src', $('#Video_thumb').val() );
    });
    $('#Video_ico').on('change', function(){
        $('#Video_ico_img').attr('src', $('#Video_ico').val() );
    });   
    $('#Video_link').on('change', function(){
        loadVideoData();
    });

    if (_model == 'Article'){
        /*CKEDITOR.replace( 'Article_content', {
            filebrowserBrowseUrl: '/browser/browse.php',
            filebrowserUploadUrl: '/uploader/upload.php'
        });*/

        tinymce.init({
            selector: "#Article_content",
            theme: "modern",
            height: 300,
            plugins: [
                 "advlist autolink link image lists charmap hr anchor pagebreak ",
                 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                 "save table contextmenu directionality emoticons template paste textcolor code sh4tinymce preview"
           ],

           toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | "+
                "bullist numlist outdent indent | link image media fullpage | forecolor backcolor emoticons | sh4tinymce preview", 
           style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            content_css: _baseUrl + '/css/bootstrap.css, ' + _baseUrl + '/css/bootstrap-theme.css ',
            file_browser_callback : function(field_name, url, type, win) { 
                //win.document.getElementById(field_name).value = 'my browser value'; 
                myFileBrowser (field_name, url, type, win);
            }

        });        
        
        $('.mce-ico.mce-i-preview').on('click', function(e) {
            SyntaxHighlighter.highlight();
        });        
    }
    
    //TAGS
    var tags = getTagData();
    if (tags){
        $.each(tags, function( index, tag ) {
            createTagElem(tag);
        });
    }
    
    $('#tags .add').on('click', function(){
        var tag = $('#tags .new').val();
        $('#tags .new').val('');
        if (tag && !findTagCopy(tag)){
            createTagElem(tag);                        
            addTagData(tag);
        }
    });
    
    $('#tags .new').on('keydown', function(e){
        if (e.keyCode == 13){
            $('#tags .add').click();
            return false;
        }
    });
    
    $('#tags').on('click', '.del', function(){
        var delTag = $(this).prev().html();
        delTagData(delTag);
        $(this).parent().remove();
    });
    
}); //end document ready 
/////////////

//TAGS
function createTagElem(tag){
    if (tag){
        $('#tags .new').before("<span><span>"+tag+ "</span>"+
                " <a href='#' class='del' onclick='return false'>[x]</a></span>&nbsp; ");                
    }
}

function getTagData(){
    var tagStr = $('#tags .tag_data').val();
    return tags = tagStr ? tagStr.split(';') : new Array();
}

function findTagCopy(tag){
    var tags = getTagData();
    var pos = tags.indexOf(tag); 
    return (pos > -1);
}

function addTagData(newTag){
    var tags = getTagData();
    tags.push(newTag);
    var tagStr = tags.join(';');
    $('#tags .tag_data').val(tagStr);
    $('#tags .tag_dirty').val(1);
}

function delTagData(delTag){
    var tags = getTagData();
    var pos = tags.indexOf(delTag);    
    if (pos > -1){
        tags.splice(pos, 1);
    }
    var tagStr = tags.join(';');
    $('#tags .tag_data').val(tagStr);   
    $('#tags .tag_dirty').val(1);
}
// end TAGS


function deleteImg(imgtype, model){
    $("#del"+imgtype).val(1);
    $("#img"+imgtype).hide();
    $("#a"+imgtype).hide();
    $('#'+model+"_"+imgtype).show();
}

function loadVideosData(){
    $.ajax({
        type: "POST",
        url: _baseUrl + '/index.php/admin/video/loadVideosData/',
        dataType: 'json',
        data: {'source':'youtube', 'links': $('#loadVideos').val(), 'article_id': '<?=$model->id?>' },
        success: function(data){
            if (data.success){
                $('#loadVideos').val('Loaded!');
            } else {
                alert(data.error);
            }
        },
        error: function(){
            alert('Error loadVideoData');
        },
    });
}

function myFileBrowser (field_name, url, type, win) {

    //alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

    var cmsURL = _baseUrl + '/admin/file';

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

function uploadVideoData(){
    $('#uploadVideoResult').html('Uploading...');
    $.ajax({
        type: "POST",
        url: _baseUrl + '/admin/video/uploadVideoData/',
        dataType: 'json',
        data: {'source':'youtube', 'article_id': $('#article_id').val(), 'links': $('#videoLinks').val(), 'source': 'youtube'},
        success: function(data){
            if (data.success == true){
                $('#uploadVideoResult').html('Success, uploaded: '+data.count);
            } else {
                $('#uploadVideoResult').html('Error: '+data.error);
            }
        },
        error: function(){
            $('#uploadVideoResult').html('Error in request');
        },
    });
}  

function loadVideoData(){    
    $.ajax({
        type: "POST",
        url: _baseUrl + '/admin/video/getVideoData/',
        dataType: 'json',
        data: {'source':'youtube', 'link': $('#Video_link').val()},
        success: function(data){
            if (data.success){
                $('#Video_title').val(data.title);
                $('#Video_desc').val(data.desc);
                $('#Video_alias').val(data.alias);
                $('#Video_picture').val(data.picture).change();
                $('#Video_thumb').val(data.thumb).change();
                $('#Video_ico').val(data.ico).change();
            } else {
                alert(data.error);
            }
        },
        error: function(){
            alert('Error loadVideoData');
        },
    });
}  
