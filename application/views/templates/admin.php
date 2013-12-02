<?
$user = $this->session->userdata('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Galatea Admin</title>
  <?php echo  $metas ?>

  <!-- The styles -->
  <link href="<?php echo  assets_url('bootstrap/css/bootstrap.css') ?>" rel="stylesheet">
  <link id="bs-css" href="<?php echo assets_url('bootstrap/css/bootstrap-cerulean.css');?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo  assets_url('css/admin/charisma-app.css') ?>">
  <link rel="stylesheet" href="<?php echo  assets_url('bootstrap/css/bootstrap-responsive.css') ?>">
  <link rel="stylesheet" href="<?php echo  assets_url('css/plugins/datepicker/datepicker.css') ?>">

  <script src="<?php echo  assets_url('js/lib/jquery.min.js') ?>"></script>
  <script src="<?php echo  assets_url('bootstrap/js/bootstrap.js') ?>"></script>
  <script src="<?php echo assets_url('js/plugins/datepicker/bootstrap-datepicker.js')?>"></script>
  <script src="<?php echo assets_url('js/plugins/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo assets_url('js/plugins/jquery.history.js')?>"></script>
  <script src="<?php echo assets_url('js/admin/admin.js')?>"></script>
  <script src="<?php echo assets_url('js/site/util.js')?>"></script>
  <script src="<?php echo assets_url('js/plugins/jquery.maskMoney.js')?>"></script>
  <script>
    $(document).ready(function() {
      //Money fields mask
      $('.money').maskMoney({
        symbol:'R$ ',
        thousands:'.',
        decimal:',',
        symbolStay: true
      });

      $('.decimal').maskMoney({
        symbol:'',
        thousands:'.',
        decimal:',',
        symbolStay: false
      });
    });
  </script>
  <style type="text/css">
  body {
    padding-bottom: 40px;
  }
  .sidebar-nav {
    padding: 9px 0;
  }
  </style>

  <?php echo  $scripts ?>
  <?php echo  $styles ?>
</head>
<body>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="#">
          <span>Galatea</span>
        </a>
        <!-- user dropdown starts -->
        <div class="btn-group pull-right" >
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="icon-user"></i><span class="hidden-phone"> <?php echo $user['name']?></span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('admin/users/edit/'.$user['id'])?>">Profile</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('admin/login/logout')?>">Logout</a></li>
          </ul>
        </div>
        <!-- user dropdown ends -->
      </div>
    </div>
  </div>
  <!-- topbar ends -->

  <!-- ALERTS -->
  <?php if ($this->session->flashdata('error')) {
    ?>
    <div class="alert alert-error">
      <button class="close" data-dismiss="alert" type="button"> x </button>
      <strong>Atenção</strong>
      <?php echo $this->session->flashdata('error');?>
    </div>
    <?
  }?>

  <?php if ($this->session->flashdata('success')) {
    ?>
    <div class="alert alert-success">
      <button class="close" data-dismiss="alert" type="button"> x </button>
      <?php echo $this->session->flashdata('success');?>
    </div>
    <?
  }?>

  <div class="container-fluid">
    <div class="row-fluid">
      <!-- left menu starts -->
      <div class="span2 main-menu-span">
        <div class="well nav-collapse sidebar-nav">
          <ul class="nav nav-tabs nav-stacked main-menu">
            <li class="nav-header hidden-tablet">Main</li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin')?>">
                <i class="icon-home"></i>
                <span class="hidden-tablet"> Dashboard</span>
              </a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" >
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Gerenciamento do Site</span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/home_layouts')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Home</span>
                  </a>
                </li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/categories/')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Categorias</span>
                  </a>
                </li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/products')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Produtos</span>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/carroussels/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Carroussel</span>
              </a>
            </li>
            <li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" >
                  <i class="icon-list-alt"></i>
                  <span class="hidden-tablet"> Curadoria</span>
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="ajax-link" href="<?php echo site_url('admin/curadoria/items')?>">
                      <i class="icon-list-alt"></i>
                      <span class="hidden-tablet"> Projetos</span>
                    </a>
                  </li>
                  <li>
                    <a class="ajax-link" href="<?php echo site_url('admin/curadoria/approved')?>">
                      <i class="icon-list-alt"></i>
                      <span class="hidden-tablet"> Histórico de Projetos Aprovados</span>
                    </a>
                  </li>
                  <li>
                    <a class="ajax-link" href="<?php echo site_url('admin/curadoria/disapproved')?>">
                      <i class="icon-list-alt"></i>
                      <span class="hidden-tablet"> Histórico de Projetos Reprovados</span>
                    </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a class="ajax-link" href="<?php echo site_url('admin/curadoria/avaliation_texts')?>">
                      <i class="icon-list-alt"></i>
                      <span class="hidden-tablet"> Textos de avaliação</span>
                    </a>
                  </li>
                </ul>
              </li>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" >
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Pedidos</span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/orders/')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Painel de Controle</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/orders/net')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Vendas líquidas</span>
                  </a>
                </li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/orders/gross')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Vendas brutas</span>
                  </a>
                </li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/orders/products')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Vendas por produto</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a class="ajax-link" href="<?php echo site_url('admin/orders/cancellations')?>">
                    <i class="icon-list-alt"></i>
                    <span class="hidden-tablet"> Cancelamentos</span>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/regions/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Regiões</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/expertises/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Expertises</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/styles/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Estilos</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/users/')?>">
                <i class="icon-user"></i>
                <span class="hidden-tablet"> Usuários</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/items/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Projetos</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/ambiances/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Inspire-me</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/discount_coupons/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Cupons de desconto</span>
              </a>
            </li>
            <li>
              <a class="ajax-link" href="<?php echo site_url('admin/user_balances/')?>">
                <i class="icon-list-alt"></i>
                <span class="hidden-tablet"> Saldo dos usuários</span>
              </a>
            </li>

          </ul>
        </div><!--/.well -->
      </div><!--/span-->
      <!-- left menu ends -->

      <noscript>
        <div class="alert alert-block span10">
          <h4 class="alert-heading">Warning!</h4>
          <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
      </noscript>




      <div id="content" class="span10">
        <!-- breadcrumb -->
        <?php echo  $breadcrumb ?>
        <!-- content starts -->
        <?php echo  $contents ?>
      </div>

    </div>
  </div>
</body>
</html>
