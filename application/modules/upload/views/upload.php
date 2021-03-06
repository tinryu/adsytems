<head>
    <link rel="stylesheet" href="<?=$dir_vendor ?>/plupload/css/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?=$dir_vendor ?>/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
    <script type="text/javascript">
        var url_server = "<?= $dir_sever; ?>"
        var url_dir_vendor = "<?= $dir_vendor ?>"
    </script>
    <!--Script-->
    <script src="<?= $dir_vendor ?>/jquery-1.10.2.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="<?=$dir_vendor ?>/plupload/plupload.full.min.js"></script>
    <script src="<?=$dir_vendor ?>/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>
</head>
<div id="uploader"></div>
<script type="text/javascript">
    $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : url_server+'upload/do_upload_user',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: 20,

        chunk_size: '1mb',

        // Resize images on clientside if we can
        resize : {
            width : 200,
            height : 200,
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
</script>