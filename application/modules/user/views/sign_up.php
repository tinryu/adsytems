
<form id="sign_up" action="<?= base_url();?>user/create_member" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sex">Sex</label></br>
                        <input type="radio" name="sex" value="0" checked> Nam
                        <input type="radio" name="sex" value="1"> Nữ
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <div class="user-img" id="container1">
                            <div class="row">
                                <div class="col-md-12">
                                    <a id="pickfiles" class="btn btn-default fileinput-button" href="javascript:;"><i class="fa fa-plus"></i>  Chọn file</a>
                                    <div id="showImg" style="text-align: left; margin: 5px 0 0 0"></div>
                                    <div id="filelist"></div>
                                    <div id="console"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="Password" name="password" placeholder="Password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="re_password">Re_password</label>
                <input type="password" class="form-control" id="re_password" name="re_password" placeholder="re password">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="full_name">Full name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="full name">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birthday">Birthday</label>
                <span class="add-on"><i class="icon-calendar"></i></span>
                <input type="date" class="form-control date_form" id="birthday" name="birthday" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control bfh-phone" id="mobile" name="mobile" data-format="+0 (ddd) ddd-dddd">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="address">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ward">Ward</label>
                <?=$select_ward?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="district">District</label>
                <?=$select_ditrict?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="city">City</label>
                <?=$select_province?>
            </div>
        </div>
    </div>
    <div class="row fixed_screen">
        <div style="text-align: center; padding: 10px 0 0">
            <button type="submit" class="btn btn-default">Add</button>
        </div>
    </div>

</form>
<script>
    $('#date_form input').datepicker({ });
</script>
<script type="text/javascript">
    // Custom example logic
    var current_filename = '';
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container1'), // ... or DOM Element itself
        url : url_server+'upload/do_upload_user',
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



