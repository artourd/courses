$(document).ready(function(){
    $('#'+_model+'_scope_id').on('change', function() {
        if ($('#'+_model+'_branch_id').length) {
            $('#'+_model+'_branch_id').html('');
            if ($('#'+_model+'_scope_id').val()){
                $.ajax({
                    type: "POST",
                    url: _baseUrl + '/admin/scope/getBranches/',
                    dataType: 'json',
                    data: {'scope_id': $('#'+_model+'_scope_id').val()},
                    success: function(data) {
                        var opt = '';
                        if (data) {                        
                            $.each(data, function(elem, ind) {
                                opt += '<option value="' + elem + '" >' + ind + '</option>';
                            })
                        } else {
                            console.log('No branches');
                        }
                        $('#'+_model+'_branch_id').html(opt);
                        $('#'+_model+'_branch_id').change();                    
                    },
                    error: function() {
                        alert('Error change scope');
                    },
                });
            }
        }
    });
    
    
    $('#'+_model+'_branch_id').on('change', function(){
        if ($('#'+_model+'_product_id').length) {
            $('#'+_model+'_product_id').html('');
            if ($('#'+_model+'_branch_id').val()){            
                $.ajax({
                    type: "POST",
                    url: _baseUrl + '/admin/scope/getProducts/',
                    dataType: 'json',
                    data: {'branch_id': $('#'+_model+'_branch_id').val()},
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
        if ($('#'+_model+'_course_id').length) {
            $('#'+_model+'_course_id').html('');
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
                            console.log('No courses');
                        }
                        $('#'+_model+'_course_id').html(opt);
                    },
                    error: function() {
                        alert('Error change product');
                    },
                });
            }
        }
    });     
    
}); //end document ready   

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
        data: {'source':'youtube', 'links': $('#loadVideos').val(), 'course_id': '<?=$model->id?>' },
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


