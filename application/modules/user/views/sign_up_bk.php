<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= $dir_vendor ?>/plupload/css/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="<?= $dir_vendor ?>/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
<!--fancybox-->
<link rel="stylesheet" href="<?= $dir_vendor ?>/fancyBox-v2.1.5/jquery.fancybox.css">
</head>
<title> LOGIN </title>
<form id="sign_in" action="login/create_member" method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="Password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="re_password">Re_password</label>
        <input type="password" class="form-control" id="re_password" name="re_password" placeholder="re password">
    </div>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="full name">
    </div>
    <div class="form-group">
        <label for="picture">Picture</label>
        <a href="http://news.zing.vn/" class="iframe-btn">click</a>
        <div id="uploader" style="display: none"></div>
        <input type="text" class="form-control" id="picture" name="picture">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="email">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
<script src="<?= $dir_vendor ?>/jquery-1.10.2.js"></script>
<script src="<?= $dir_vendor ?>/fancyBox-v2.1.5/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?= $dir_vendor ?>/plupload/js/jquery-ui.min.js"></script>
<!-- production -->
<script type="text/javascript" src="<?= $dir_vendor ?>/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?= $dir_vendor ?>/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript">
    $(".iframe-btn").fancybox({
        "width"	: 880,
        "height"	: 570,
        "type"	: "iframe",
        "autoScale"   : false
    });
    // Initialize the widget when the DOM is ready
    $(function() {
        $("#uploader").plupload({
            // General settings
            runtimes : 'html5,flash,silverlight,html4',
            url : 'examples/upload.php',

            // User can upload no more then 20 files in one go (sets multiple_queues to false)
            max_file_count: 20,

            chunk_size: '1mb',

            // Resize images on clientside if we can
            resize : {
                width : 900,
                height : 500,
                quality : 90,
                crop: true // crop to exact dimensions
            },

            filters : {
                // Maximum file size
                max_file_size : '1000mb',
                // Specify what files to browse for
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },

            // Rename files by clicking on their titles
            rename: true,

            // Sort files
            sortable: true,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,

            // Views to activate
            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },

            // Flash settings
            flash_swf_url : 'js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : 'js/Moxie.xap'
        });


        // Handle the case when form was submitted before uploading has finished
        $('#form').submit(function(e) {
            // Files in queue upload them first
            if ($('#uploader').plupload('getFiles').length > 0) {

                // When all files are uploaded submit form
                $('#uploader').on('complete', function() {
                    $('#form')[0].submit();
                });

                $('#uploader').plupload('start');
            } else {
                alert("You must have at least one file in the queue.");
            }
            return false; // Keep the form from submitting
        });
    });
</script>


