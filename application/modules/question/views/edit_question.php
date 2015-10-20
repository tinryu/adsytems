
<form id="edit_ques" action="<?= base_url();?>question/edit" method="post">
    <div class="row">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="col-md-6">
            <div class="form-group">
                <label for="group_id">ID_Group</label>
                <?=$categoris?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="group_id">Related</label>
                <?=$related?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?=$title;?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="picture">Picture</label>
                <div class="user-img" id="container1">
                    <div class="row">
                        <div class="col-md-12">
                            <a id="pickfiles" class="btn btn-default fileinput-button" href="javascript:;"><i class="fa fa-plus"></i>  Chọn file</a>
                            <div id="showImg" style="text-align: left; margin: 5px 0 0 0">
                                <img width="128" height="128" class="img-circle" src="<?=base_url('uploads/quesImg/'.$picture)?>" alt="">
                                <input type="hidden" name="picture" value="<?=$picture?>"/>
                            </div>
                            <div id="filelist"></div>
                            <div id="console"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="short">Short</label>
                <textarea name="short" id="short"><?=$short;?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content"><?=$content;?></textarea>
            </div>
        </div>
    </div>

    <div class="row fixed_screen">
        <div style="text-align: center; padding: 10px 0 0">
            <button type="submit" name="save" class="btn btn-default">Save</button>
        </div>
    </div>

</form>
<script type="text/javascript">
    // Custom example logic
    var current_filename = '';
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container1'), // ... or DOM Element itself
        url : url_server+'upload/do_upload_ques',
        filters : {
            max_file_size : '10mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"}
            ]
        },

        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = "";
            },

            FilesAdded: function(up, files) {
                while( up.files.length > 1 ) {
                    up.removeFile( up.files[0] );
                }
                plupload.each(files, function(file) {
                    if( file != undefined ) {
                        var namepic = file.name.split('.')[0];
                        var ext = file.name.split( '.' ).pop();
                        current_file = file.name = namepic+'_'+randomKey(5)+"."+ext;
                        document.getElementById('filelist').innerHTML = '<div id="' + file.id + '"><label>' + file.name  + '</label> <b></b></div> <input type="hidden" name="picture" value="'+current_file+'">';
                        current_filename = current_file;
                        uploader.start();
                    }
                });
            },

            UploadProgress: function(up, file) {
                var html_pro = '<div class="progress">';
                html_pro += '<div class="progress-bar" role="progressbar" aria-valuenow="'+file.percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+file.percent+'%">';
                html_pro += ' '+ file.percent +'%';
                html_pro += '</div>';
                html_pro += '</div>';
                //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = html_pro;
            },

            Error: function(up, err) {
                document.getElementById('console').innerHTML = "\nError #" + err.code + ": " + err.message;
            }
        }
    });
    uploader.bind('FileUploaded', function(up, files,info) {
        info = info.response;
        console.log(info);
        $('#showImg' ).empty().append('<img width="128" height="128" class="img-circle" alt="star" src="data:image/gif;base64,'+info+'" />');
    });
    uploader.init();

</script>