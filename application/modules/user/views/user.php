<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=$dir_vendor ?>/tempadmin/bootstrap/css/bootstrap.min.css">
<title> <?= $title_page ?> </title>
<style>
    body{
        background: #fafafa;
    }
    #login_form{

        height: 200px;
        left: 50%;
        margin-left: -185px;
        margin-top: -149px;
        position: absolute;
        top: 50%;
        width: 400px;
    }
    #sign_in{
        border: 4px solid rgba(255,255,255,0.7);
        background: #3c8dbc;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 15px;
    }
    label[for="username"],label[for="password"]{
        color: #fafafa;
        font-size: 35px;
        font-weight: bold;
        width: 50px;
        float: left;
        display: block;
    }
    input[type=text], input[type=password] {
        float: left;
        margin: 0 0 1em 0;
        width: 85%;
        color: #000;
        padding: 0.5em;
        border: 1px solid #fafafa;
        background: rgba(255,255,255,0.8);
        height: auto;
    }
    button[type=submit], form a {
        width: 100%;
        border: 1px solid #fff0f0;
        border-radius: 0;
    }
    button[type=submit]:hover, form a:hover {
        border: 1px solid #fff0f0;
        cursor: pointer;
    }
    #login_form h3{ text-align: center; padding: 0; margin: 0; color: #000066}
    .firstcharacter { color: #f00000; font-size: 45px; line-height: 60px; padding-top: 4px; font-family: Georgia; }

</style>
<div id="login_form">
    <h3><span class="firstcharacter">A</span>dsytems</h3>
    <form id="sign_in" action="<?php echo base_url()?>user/check_login" method="post">
        <div class="form-group">
            <label for="username"><i class="fa fa-user"></i></label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password"><i class="fa fa-keyboard-o"></i></label>
            <input type="password" class="form-control" id="Password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div><!-- end login_form-->