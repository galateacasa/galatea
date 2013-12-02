<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome to Galatea</title>
  <link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/site/location/style.css')?>">
  <link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/site/grid.css')?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url('images/favicon.ico')?>">
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,700italic,200,300,600italic,400italic,300italic,200italic' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body class="entry-page">
    <div class="entry-header">
      <div class="entry-container container_12">
        <section class="grid_6 alpha">
          <h1 class="logo"><a href="#"><img width="461" height="41" alt="Galatea" src="<?php echo assets_url('images/logo.jpg')?>"></a></h1>
        </section>
        <section class="grid_9 alpha">
          <div class="enter-search">
            <form id="zip-form" method="POST" action="">
              <input type="text" id="zip" name="zip" placeholder="informe seu cep" class="search-area information-search grid_6 alpha" />
              <a id="submit-zip-form" style="cursor:pointer;" class="enter-search-btn">entrar</a>
            </form>
          </div>
          <a href="#" class="help">&nbsp;</a>
          <section class="help-hint">
            <a href="#" >não sabe o seu CEP?</a>
            <div class="help-dropdown">
              <form id="state-form" method="POST" action="">
                <div class="report-box">
                  <select id="state" name="state" class="styled"></select>
                </div>
                <div class="report-box">
                  <select id="city" name="city" class="styled"></select>
                </div>
                <div class="report-box">
                  <a id="submit-state-form" style="cursor:pointer;" class="large-btn">entrar</a>
                </div>
              </form>
            </div>
          </section>
          <h2>A conexão entre quem cria, produz e deseja móveis</h2>
        </section>
      </div>
    </div>

    <script type="text/javascript" src="<?php echo assets_url('js/lib/jquery-1.8.2.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo assets_url('js/plugins/customSelect.jquery.js');?>" ></script>
    <script type="text/javascript" src="<?php echo assets_url('js/site/sticky-float.js')?>"></script>
    <script type="text/javascript" src="<?php echo assets_url('js/site/header.js');?>" ></script>
    <script type="text/javascript" src="<?php echo assets_url('js/plugins/slides.min.jquery.js');?>"></script>
    <script type="text/javascript" src="<?php echo assets_url('js/site/tooltip.js')?>"></script>
    <script src="<?php echo  assets_url('js/site/util.js') ?>"></script>
    <script type="text/javascript" src="<?php echo assets_url('js/plugins/jquery.maskedinput.js');?>" ></script>
    <script type="text/javascript" src="<?php echo assets_url('js/plugins/jquery.validate.js');?>" ></script>
    <script type="text/javascript">

    $(function(){
      $('#zip').mask('99999-999');

      $('#submit-zip-form').click(function(){
        $('#zip-form').submit();
      });

      $('#submit-state-form').click(function(){
        $('#state-form').submit();
      });

      $('select.styled').customSelect();

      set_combo_state(false);
      $('#state').change(function(){
        set_combo_city(false, $(this).val());
      });

});
</script>
</body>
</html>
