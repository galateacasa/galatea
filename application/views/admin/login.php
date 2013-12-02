<!DOCTYPE html>
<html lang="en">
<head>
  <!--
    Charisma v1.0.0

    Copyright 2012 Muhammad Usman
    Licensed under the Apache License v2.0
    http://www.apache.org/licenses/LICENSE-2.0

    http://usman.it
    http://twitter.com/halalit_usman
  -->
  <meta charset="utf-8">
  <title>Galatea Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- The styles -->
  <link id="bs-css" href="<?php echo assets_url('bootstrap/css/bootstrap-cerulean.css')?>" rel="stylesheet">
  <style type="text/css">
  body {
    padding-bottom: 40px;
  }
  .sidebar-nav {
    padding: 9px 0;
  }
  </style>
  <link href="<?php echo assets_url('bootstrap/css/bootstrap-responsive.css')?>" rel="stylesheet">
  <link href="<?php echo assets_url('css/admin/charisma-app.css')?>" rel="stylesheet">

  <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

  </head>

  <body>
    <div class="container-fluid">
      <div class="row-fluid">

        <div class="row-fluid">
          <div class="span12 center login-header">
            <h2>Admin Galatea</h2>
          </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid">
          <div class="well span5 center login-box">
            <div class="alert alert-info">
              <?
              if (validation_errors() || $this->session->flashdata('error')) { ?>
              <?php echo  validation_errors(); ?>
              <?php echo  $this->session->flashdata('error'); ?>
              <?php }else{ ?>
              Faça o login com seu email e senha.
              <?php } ?>
            </div>
            <form class="form-horizontal" action="" method="post">
              <fieldset>
                <div class="input-prepend" title="Username" data-rel="tooltip">
                  <span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="email" id="email" type="text" value="" />
                </div>
                <div class="clearfix"></div>

                <div class="input-prepend" title="Password" data-rel="tooltip">
                  <span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password" id="password" type="password" value="" />
                </div>
                <div class="clearfix"></div>

                <p class="center span5">
                  <button type="submit" class="btn btn-primary">Login</button>
                </p>
              </fieldset>
            </form>
          </div><!--/span-->
        </div><!--/row-->
      </div><!--/fluid-row-->

    </div><!--/.fluid-container-->
  </body>
  </html>
