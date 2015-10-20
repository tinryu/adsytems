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
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>SY</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>System</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=$dir_image?>/ava.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $nameU ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?=$dir_image?>/ava.jpg" class="img-circle" alt="User Image">
                                <p>
                                    <small><?= $nameU ?> - Webdeveloper</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <?= anchor('user/logout', 'Sign out', array('class'=>'btn btn-default btn-flat')); ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

