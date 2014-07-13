function getLink(dir, q){
    if (q != '') q += '/';
    window.location.href = 'http://'+ window.location.hostname + window.location.pathname + '?q='+ q + dir;
}
function getLinkUp(parent){
    window.location.href = 'http://'+window.location.hostname + window.location.pathname + '?q='+ parent;
}
function getLinkHome(){
    window.location.href = 'http://'+window.location.hostname + window.location.pathname;
}
function refresh(q){
    window.location.href = 'http://'+window.location.hostname + window.location.pathname + '?q='+ q;
}
function setInput(link){
    var args = top.tinymce.activeEditor.windowManager.getParams();
    args.window.document.getElementById(args.input).value = link;
    top.tinymce.activeEditor.windowManager.close();
}
function upload(q){
    document.getElementById('frmAddImage').submit();
    //refresh(q);
}

function addfolder(q){
    var f = $('#newfolder').val();
    if (f == null || f == ''){
        alert('Empty folder');
    } else {
        $.ajax({
            url: 'admin/file/addfolder/?folder=' + q + '/' + $('#newfolder').val(),
            success: function() {
                refresh(q);
            },
            error: function() {
                alert('Error add folder');
            }
        });
    }
}
function delfolder(q){
    if (confirm('Delete current folder?')){
        $.ajax({
            url: 'admin/file/delfolder/?folder=' + q,
            success: function() {
                refresh(q);
            },
            error: function() {
                alert('Error del folder');
            }
        });
    }
}