function deleteImg(imgtype, model){
    $("#del"+imgtype).val(1);
    $("#img"+imgtype).hide();
    $("#a"+imgtype).hide();
    $('#'+model+"_"+imgtype).show();
}

$(document).ready(function(){
    //
    
    
});


