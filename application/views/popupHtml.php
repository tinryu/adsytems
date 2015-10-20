<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?= $title_page ?> </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?=$dir_vendor ?>/plupload/css/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?=$dir_vendor ?>/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/plugins/morris/morris.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!--fancybox-->
    <link rel="stylesheet" href="<?= $dir_vendor ?>/fancyBox-v2.1.5/jquery.fancybox.css">

    <link rel="stylesheet" href="<?= $dir_vendor ?>/bootstrap-chosen-master/bootstrap-chosen.css">

    <link rel="stylesheet" href="<?= $dir_vendor ?>/global/layout.css">

    <!--Script-->
    <script src="<?= $dir_vendor ?>/jquery-1.10.2.js"></script>

    <script src="<?= $dir_vendor ?>/angular.min.js"></script>
    <script src="<?= $dir_vendor ?>/angular-route.js"></script>
    <script src="<?= $dir_vendor ?>/angular-animate.js"></script>
    <script src="<?= $dir_vendor ?>/app.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="<?= $dir_vendor ?>/jquery-ui.min.js"></script>
    <script src="<?= $dir_vendor ?>/bootstrap3/js/bootstrap.js"></script>
    <script src="<?= $dir_vendor ?>/bootstrap3/js/bootstrap-formhelpers.min.js"></script>

    <script src="<?= $dir_vendor ?>/bootstrap-chosen-master/chosen.jquery.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.chosen-select').chosen();
            $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        });
    </script>
    <script type="text/javascript" src="<?= $dir_vendor ?>/ScrollToFixed-master/jquery-scrolltofixed.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fixed_screen').scrollToFixed({
                bottom: 0,
                //limit: $('.fixed_screen').offset().top,
                preFixed: function() { $(this).css('background', '#3C8DBC');},
                postFixed: function() { $(this).css('background', '');}
            });
        });
    </script>

    <script src="<?= $dir_vendor ?>/fancyBox-v2.1.5/jquery.fancybox.pack.js"></script>
    <script src="<?=$dir_vendor ?>/plupload/plupload.full.min.js"></script>
    <script src="<?=$dir_vendor ?>/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>
    <script src="<?=$dir_vendor ?>/tinymce/tinymce.min.js"></script>
    <script src="<?=$dir_vendor ?>/tinymce/config.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var url_server = "<?= $dir_sever; ?>"
        var url_templace = "<?= $dir_templace; ?>"
        var url_dir_image = "<?= $dir_image; ?>"
        var url_dir_vendor = "<?= $dir_vendor ?>"
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini" ng-app="angularApp">
<div class="wrapper">
    <header class="main-header">

    </header>
    <!-- Main content -->
    <section class="content">
        <?= $main_content ?>
    </section><!-- /.content -->
    <footer class="main-footer">

    </footer>
</div>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button);</script>

<!-- Morris.js charts -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/morris/raphael-min.js"></script>
<script src="<?=$dir_vendor ?>/tempadmin/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=$dir_vendor ?>/tempadmin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/knob/jquery.knob.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=$dir_vendor ?>/tempadmin/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$dir_vendor ?>/tempadmin/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=$dir_vendor ?>/tempadmin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=$dir_vendor ?>/tempadmin/dist/js/demo.js"></script>
<script>
    $('.date_form').datepicker({ });
</script>
<script src="<?= $dir_vendor ?>/lib.js"></script>
</body>
</html>
