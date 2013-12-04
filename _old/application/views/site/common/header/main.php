<!DOCTYPE HTML>
<html lang="pt-br">

  <head>

    <meta charset="utf-8">

    <title>
      <?php echo  isset($title) ? $title : 'Galatea Casa' ?>
    </title>

    <?php

      // Any meta tag was set up? It's came as array? Print it!
      if ( isset($metas) ) echo is_array($metas) ? implode('', $metas) : $metas;

      // Default stylesheets
      $stylesheets = array('main', 'mess', 'pages');

      // Include all stylesheets
      foreach ($stylesheets as $stylesheet) {

        printf(
          '<link rel="stylesheet" type="text/css" href="%s?v=%s">',
          base_url("/assets/css/site/$stylesheet.css"),
          VERSION
        );

      }

      // Icon
      echo link_tag('assets/images/favicon.ico', 'shortcut icon', 'image/ico');

      // Canonical tag
      {
        $completeUrl = 'http' . (($_SERVER['SERVER_PORT'] === 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $regexResult = array();

        preg_match("/^.*?(?=\?)/", $completeUrl, $regexResult);

        if ( !empty($regexResult) ) printf('<link href="%s" rel="canonical" />', $regexResult[0]);
      }

    ?>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,700italic,200,300,600italic,400italic,300italic,200italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo  assets_url('js/lib/jquery-1.8.2.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  assets_url('js/plugins/jquery.filedrop.js') ?>"></script>

    <!--[if lt IE 9]>
      <script type="text/javascript" src="assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body class="product-page">

    <?php if ( $this->session->userdata('id') ) $this->load->view('site/ambiance/create') ?>
    <!--header start here-->
    <section class="header-main">
      <header class="container_12">

        <?php $this->load->view('site/common/header/top-navigation') ?>

        <section class="grid_12 header-mid">

          <?php $this->load->view('site/common/header/main-logo') ?>

          <div class="grid_6 omega">

            <?php $this->load->view('site/common/header/login-menu') ?>
            <?php $this->load->view('site/common/header/cart') ?>

          </div>

        </section>

      </header>
    </section>

