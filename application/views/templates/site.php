<?php

# Any user is logged in?
if( $this->session->userdata('id') ) $user = new User($this->session->userdata('id'));

$carroussels = new Carroussel();
$carroussels->order_by('id', 'desc')->get();

//Categories
$categories = new Category();
$categories->where('parent_id', '');
$categories->or_where('parent_id', 0);
$categories->or_where('parent_id', null);
$categories->order_by('id', 'asc');
$categories->get();

?>
<!DOCTYPE HTML>
<html lang="pt-br">

  <head>
    <meta charset="utf-8">
    <title><?php echo  $title ?></title>
    <?php echo  $metas ?>

    <link rel="stylesheet" type="text/css" href="<?php echo  assets_url('css/site/main.css') . '?v=' . VERSION ?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo  assets_url('css/site/mess.css') . '?v=' . VERSION ?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo  assets_url('css/site/pages.css') . '?v=' . VERSION ?>" >
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo  assets_url('images/favicon.ico')?>">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,700italic,200,300,600italic,400italic,300italic,200italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo  assets_url('js/lib/jquery-1.8.2.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  assets_url('js/plugins/jquery.filedrop.js') ?>"></script>
    <?php echo  $styles ?>

    <!--[if lt IE 9]>
      <script type="text/javascript" src="assets/js/html5shiv.js"></script>
    <![endif]-->
    <?php
    // Canonical tag
    $completeUrl = 'http' . (($_SERVER['SERVER_PORT'] === 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $regexResult = array();
    preg_match("/^.*?(?=\?)/", $completeUrl, $regexResult);

    if (!empty($regexResult)) {
      $strippedUrl = $regexResult[0];
    ?>
    <link href="<?php echo  $strippedUrl ?>" rel="canonical" />
    <?
    }
    ?>

  </head>

  <body class="product-page">

    <!-- overlay -->
    <div class="overlay upload-page-popup"></div>

    <?php echo  form_open('#', 'id="ambiance-form"') ?>
        <section id="ambiance-add-form" class="pop-block">

          <!-- main informations -->
          <div class="blocks">

            <!-- page title -->
            <h2 class="pop-title">
              Enviar Ambiente

              <!-- close button -->
              <a href="javascript:void(0)" class="close-btn">&nbsp;</a>

            </h2> <!-- /page title -->


            <div class="wrap-content">

              <!-- left column -->
              <section class="pop-small-block">

                <!-- file upload title from computer -->
                <?php echo  heading('Arraste uma imagem para o quadrado ou...', 3) ?>

                <!-- custom file input -->
                <input type="file" name="file" id="ambiance-image" class="file-upload-styled" />

                <!-- image preview -->
                <section class="msg-box">

                  <!-- title -->
                  <?php echo  heading('Pr&#233;-visualiza&#231;&#227;o da imagem:', 3) ?>

                  <!-- drop image area -->
                  <div id="upload-response" class="grid_12">
                    <span id="ambiance_dropbox" class="ambiance_dropbox" >
                      Arraste a imagem para esta &#225;rea
                      <?php echo  br(1) ?>
                      (Tamanho m&#225;ximo 2mb)
                    </span>

                    <!-- upload message -->
                    <span id="ambiance-upload-message"></span>

                  </div> <!-- /drop image area -->

                </section> <!-- /image preview -->

              </section> <!-- /left column -->

              <!-- right column -->
              <section class="pop-small-block omega last">

                <!-- file upload title from web -->
                <?php echo  heading('insira o endere&#231;o da web:', 3) ?>

                <!-- image from web -->
                <div class="inpt-out">
                  <input id="ambiance-image-url" type="text" class="search-area" placeholder="http://sitedaimage.com.br/nome-da-image.jpg">
                  <input id="ambiance-save-image-url" type="button" value="OK" class="submit-btn">
                </div>

                <!-- aditional informations -->
                <ul class="long-forms">

                  <!-- title -->
                  <li>
                    <div class="legend">T&#237;tulo:</div>
                    <input id="ambiance-title" type="text" class="search-area">
                  </li>

                  <!-- categories -->
                  <li>
                    <div class="legend">Categoria:</div>
                    <div class="report-box">
                      <select id="ambiance-category-main" class="ambiance-styled">
                      </select>
                    </div>
                  </li> <!-- /categories -->

                  <!-- submit + add products -->
                  <li>
                    <!-- submit ambiance -->
                    <button id="ambiance-save" type="submit" class="button float-r">publicar</button>

                    <!-- add products to this ambiance -->
                    <button type="button" id="add-products-btn" class="button button-gray float-r">anexar produtos</button>
                    <p class="ambiance-terms">
                      Clicando em PUBLICAR, voc&#234; estar&#225; concordando <br> com os <?php echo  anchor('institucional/termos-e-condicoes', 'termos do site', 'target="_blank"') ?> e com nossa pol&#237;tica de <?php echo  anchor('institucional/condicoes-de-upload#direitos-autorais', 'direito de imagem', 'target="_blank"') ?>
                    </p>
                  </li> <!-- /submit + add products -->

                </ul> <!-- /aditional informations -->

              </section> <!-- /right column -->

            </div>

          </div> <!-- /main informations -->

          <!-- add products -->
          <div id="products-add" class="blocks hide">

            <!-- title + search fild + filter -->
            <header class="pop-header">

              <!-- title -->
              <h2 class="pop-title">Anexar Produtos</h2>

              <!-- title description -->
              <h3 class="extra-lt-space">Anexe produtos do site relacionados a esse ambiente</h3>

              <!-- search area -->
              <section class="pro-search">
                <span class="long-forms">
                  <input
                    id="search-ambiance"
                    type="text"
                    class="search-area"
                    placeholder="Palavra-chave do produto buscado"
                  >
                </span>

                <!-- filter -->
                <!--<div class="sort-list" style="display: none;">-->
                  <!--<ul id="filter">-->

                    <!-- filter label -->
                    <!--<li>Exibir: </li>-->

                    <!-- all -->
                    <!--<li class="border">-->
                      <!--<a href="#" data-filter="all" class="current-sel">todos </a>-->
                    <!--</li>-->

                    <!-- favorites -->
                    <!--<li>-->
                      <!--<a href="#" data-filter="favorites">meus favoritos</a>-->
                    <!--</li>-->
                  <!--</ul>-->
                <!--</div>-->
                <!-- /filter -->

              </section> <!-- /search area -->

            </header> <!-- /title + search fild + filter -->

            <!-- search result -->
            <section class="slider">

              <div id="ambiance-slider-search" class="horizontal-slider-container">

                <!-- content -->
                <div id="search-result" class="horizontal-slider-content">
                  <ul class="horizontal-slider add-ambiance">
                    &nbsp;
                  </ul>
                </div>

                <div class="arrows">
                  <!-- left arrow -->
                  <a href="#" class="previous">&nbsp;</a>

                  <!-- right arrow -->
                  <a href="#" class="next">&nbsp;</a>
                </div>

              </div>

            </section> <!-- /search result -->

            <!-- added products title -->
            <h2 class="pop-title">produtos anexados</h2>

            <!-- added products title -->
            <section class="slider">

              <div id="ambiance-slider-attached" class="horizontal-slider-container">

                <!-- content -->
                <div id="ambiance-attached-products" class="horizontal-slider-content">
                  <ul id="products-added" class="horizontal-slider add-ambiance">&nbsp;</ul>
                </div>

                <div class="arrows">
                  <!-- left arrow -->
                  <a href="#" class="previous">&nbsp;</a>

                  <!-- right arrow -->
                  <a href="#" class="next">&nbsp;</a>
                </div>

              </div>

            </section> <!-- /added products title -->

          </div> <!-- /add products -->

        </section>
    <?php echo  form_close() ?>

    <!--header start here-->
    <section class="header-main">
      <header class="container_12">
        <?
          // Define icons properties
          $icons = array(
            'first'  => 'designer|designer',
            'second' => 'supplier|fornecedor',
            'third'  => 'decorator|decorador',
            'fourth' => 'client|cliente',
          );

          // Create icons addresses
          foreach($icons as $key => $value) {
            $name = explode('|', $value);
            $icon_li[] = anchor("site/about/index/{$name[0]}", strtoupper("Sou {$name[1]}"), "class=\"{$key}-icon\"" );
          }

          // Create <ul> mark-up
          echo ul($icon_li, 'class="four-icons"');
        ?>
        <!-- top navigation -->
        <section class="grid_12">

          <nav class="grid_6 prefix_6">

            <!-- static pages -->
            <ul>
              <li>
                <?php echo  anchor('institucional/sobre', 'Sobre a Galatea') ?>
              </li>
              <!-- <li><a href="#">Ajuda</a></li> -->
              <li>
                <?php echo  anchor('atendimento', 'Atendimento') ?>
              </li>
              <li>
                (19) 3112-0316
              </li>
            </ul>

            <?php $this->session; ?>

            <!-- ambiances -->
            <small class="inspire-me">
              <a href="<?php echo  site_url('inspire-me') ?>">inspire-me</a>
            </small>

          </nav>

        </section> <!-- /top navigation -->

        <section class="grid_12 header-mid">

          <!-- logo -->
          <section class="grid_6 alpha">
            <h1 class="logo">
              <a href="<?php echo site_url()?>" title="P&#225;gina inicial">
                <img
                src="<?php echo  assets_url('images/logo.jpg') ?>"
                width="461"
                height="41"
                alt="Galatea"
                >
              </a>
            </h1>
          </section> <!-- /logo -->

          <section class="grid_6 omega">

            <!-- send things + login -->
            <ul>

              <!-- login -->
              <?php if( $this->session->userdata('id') ): $menu_user_name = explode(" ", $this->session->userdata('name') ) ?>

                <li>

                  <a href="" class="padd-new">Ol&#225; <?php echo  $menu_user_name[0] ?></a>

                  <div class="drop-down">
                    <ul>
                      <li>
                        <?php echo  anchor('perfil/' . $this->session->userdata('username'), 'Meu Perfil') ?>
                      </li>
                      <li>
                        <?php echo  anchor('minha-conta', 'Minha Conta') ?>
                      </li>
                      <li>
                        <?php echo  anchor('meus-creditos', 'Meus Cr&#233;ditos') ?>
                      </li>
                      <li>
                        <?php echo  anchor('meus-pedidos', 'Meus Pedidos') ?>
                      </li>
                        <?php if($this->session->userdata('role') == 2): /* The logged in user is a supplier? */ ?>
                          <li>
                            <?php echo  anchor('quero-produzir', 'Quero produzi') ?>
                          </li>
                        <?php endif ?>
                      <li>
                        <?php echo  anchor('sair', 'Logout') ?>
                      </li>

                    </ul>
                  </div>

                </li>

              <?php else: ?>
                <li>
                  <a href="<?php echo  site_url('login'); ?>" class="padd-new">Entrar</a>
                </li>
              <?php endif ?>

              <?php if( $this->session->userdata('id') ): /* Check if the logged user is a designer */ ?>
                <!-- send -->
                <li>

                  <!-- dropdown title -->
                  <a href="#"><span>Enviar</span></a>

                  <!-- dropdown -->
                  <div class="drop-down">
                    <ul>

                      <!-- ambiance -->
                      <li>
                        <a href="javascript:void(0)" id="ambiance-add-image">Enviar Ambiente</a>
                      </li>

                      <!-- project -->
                      <li>
                        <?php echo  anchor('criar-projeto', 'Enviar Projeto') ?>
                      </li>

                    </ul>
                  </div> <!-- /dropdown -->

                </li> <!-- /send -->
              <?php endif ?>
            </ul> <!-- /send things + login -->

            <!-- cart -->
            <div class="compras">

              <dfn>COMPRAS</dfn> <span><?php echo  $this->cart->total_items() ?></span>

              <?php if($this->cart->total_items() > 0): /* Check if have any items into the cart */ ?>
                <div class="drop-down-cart">

                  <ul>
                    <?php foreach ($this->cart->contents() as $row_id => $product): ?>
                      <li>
                        <figure>
                          <?php echo  img($product['options']['image']) ?>
                        </figure>

                        <small class="desc">
                          <?php echo  "(x{$product['qty']}) {$product['name']}" ?>
                        </small>

                        <small class="price">
                          R$ <?php echo  number_format($product['subtotal'], 2, ',','.') ?>
                        </small>
                      </li>
                    <?php endforeach ?>
                  </ul>

                  <a class="button float-r" href="<?php echo site_url('carrinho-de-compras')?>">Ver Carrinho</a>
                  <a class="button button-red float-r" href="<?php echo site_url('site/cart/destroy')?>">Limpar Carrinho</a>

                </div>
              <?php endif ?>

            </div> <!-- /cart -->
          </section>
        </section>

      </header>
    </section>

    <!--header start here-->
    <div class="container_12 <?php if( !isset($ambiance_menu) ) echo 'content' ?>">

      <?php if(isset($carroussel)): ?>
        <section class="container_12">
          <section class="grid_12">
            <div class="banner-area"  id="slides">
              <div class="slides_container">

                <?php foreach ($carroussels as $carroussel): ?>
                  <div class="slide-content">
                    <a href="<?php echo $carroussel->link?>" target="_blank">
                      <img src="<?php echo amazon_url('images/carroussels/'.$carroussel->image, 940)?>" alt="">
                    </a>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </section>
        </section>
      <?php endif; ?>

      <!--categories section-->
      <section class="container_12">
        <nav class="grid_12 <?php if( !isset($ambiance_menu) ) echo "nav-main"?>">
          <?php

            if( isset($ambiance_menu) ) {
              echo $ambiance_menu;
            }else{

              // New menu
              $lis[] = anchor('categoria/novidades', 'Novidades', 'class="padd-first category_novidades"');

              // Create all categories markup
              foreach ($categories as $category) {

                // Skip projects category
                if ($category->slug == 'projetos') continue;

                $lis[] = anchor("categoria/{$category->slug}", $category->name, 'class="padd-first ' . "category_{$category->id}" . '"');
              }

              // Vote button mark up
              $lis[] = anchor('categoria/vote', 'Vote', 'class="padd-first category_vote"');

              // Print the main menu
              echo ul($lis);
            }

          ?>
          <!-- search area -->
          <?php echo  form_open('site/home/search') ?>
            <input type="text" name="search" id="search"  placeholder="Buscar">
          <?php echo  form_close() ?>

        </nav>
      </section>

      <?php echo $contents?>
    </div>

    <!--footer start here-->
    <footer class="footer-main">
      <section class="container_12">
        <section class="grid_12">

          <!-- tips -->
          <nav>
            <ul>
              <?
                // Define links informations
                $footer_links = array(

                  'tips' => array(
                    'href'  => 'institucional/cuidados-com-a-mobilia',
                    'label' => 'Cuidados com a mobília',
                  ),

                  'returns' => array(
                    'href'  => 'institucional/trocas-e-devolucoes',
                    'label' => 'Trocas e Devoluções',
                  ),

                  'terms' => array(
                    'href'  => 'institucional/termos-e-condicoes',
                    'label' => 'Termos e Condições',
                  ),

                  'payments' => array(
                    'href'  => 'institucional/formas-de-pagamento',
                    'label' => 'Pagamento e Entrega',
                  ),

                  'privacity' => array(
                    'href'  => 'institucional/termos-e-condicoes#privacidade',
                    'label' => 'Política de Privacidade',
                  ),

                );

                # Print all links addresses
                foreach($footer_links as $link)
                  printf("<li><a href=\"%s\">%s</a></li>", base_url($link['href']), $link['label']);
              ?>
            </ul>
          </nav> <!-- /tips -->

          <!-- social network -->
          <section class="footer-mid">
            <h4>Siga em outras redes:</h4>
            <ul>
              <li><a href="http://pinterest.com/galateacasa/" target="_blank">pinterst</a></li>
              <li><a href="https://www.facebook.com/GalateaCasa" class="facebook" target="_blank">facebook</a></li>
            </ul>
          </section> <!-- /social network -->

          <!-- newsletter + copyright + back to top -->
          <aside>

            <!-- title -->
            <h4>NewsLetter</h4>

            <!-- newsletter + back to top -->
            <div class="inpt-out">

              <!-- newsletter -->
              <?php echo  form_open('site/home/newsletter') ?>
                <input class="button-newsletter float-l" type="text" placeholder="e-mail" name="email" >
                <input type="submit" class="button float-r" value="OK">
              <?php echo  form_close() ?>

              <!-- back to top -->
              <a href="#top" class="back-top-top" onmouseover="tooltip.show('voltar ao topo');" onmouseout="tooltip.hide();">&nbsp;</a>

            </div>

            <!-- copyright -->

            <em>Galatea Casa &#169; Todos os direitos reservados.</em>
          </aside> <!-- /newsletter + copyright + back to top -->
        </section>
      </section>
    </footer> <!--footer ends here-->


    <?

      # Define default scripts that need to be included into document
      $defaultScripts = array(
        'plugins/jquery.ae.image.resize.min',
        'plugins/slides.min.jquery',
        'plugins/mCustomScrollbar',
        'plugins/jquery.validate',
        'plugins/jquery.maskMoney',

        'plugins/noty/jquery.noty',
        'plugins/noty/layouts/bottom',
        'plugins/noty/layouts/bottomCenter',
        'plugins/noty/layouts/bottomRight',
        'plugins/noty/layouts/center',
        'plugins/noty/layouts/centerLeft',
        'plugins/noty/layouts/centerRight',
        'plugins/noty/layouts/inline',
        'plugins/noty/layouts/top',
        'plugins/noty/layouts/topLeft',
        'plugins/noty/layouts/topRight',
        'plugins/noty/layouts/topCenter',
        'plugins/noty/themes/default',

        'plugins/customSelect.jquery',
        'plugins/customInput.jquery',
        'plugins/jquery.fileinput',
        // 'plugins/jquery.bxslider/jquery.bxslider',
        'site/upload_box',
        'site/Modernizr.custom.min',
        'site/Vote',
        'site/Denounce',
        'site/Dropdown',
        'site/Message',
        'site/Placeholder',
        'site/sticky-float',
        'site/tooltip',
        'site/util',
        'site/header',
        'site/navigation',
        'site/VerticalSlider',
        'site/HorizontalSlider'
      );

      # Include all default scripts
      foreach($defaultScripts as $defaultScript) echo '<script src="' . assets_url("js/$defaultScript.js") . '?v=' . VERSION . '"></script>';

    ?>

    <script>
      $(document).ready(function() {

        // Create a new Vote instance
        new Vote();

        // Create a new Denounce instance
        new Denounce("<?php echo  $this->session->userdata('id') ?>");

        // Message and reviews areas
        new Message("<?php echo  $this->session->userdata('id') ?>");

        // Create a new Placeholder instance
        new Placeholder();

        $("#slides div img").aeImageResize({ height: 203, width: 940 });

        $("#slides").slides({
          fadeSpeed: 350,
          play: 5000,
          effect:'fade'
        });

        $('.back-top-top').click(function(){
          $("html,body").animate({scrollTop:0},500)
        });

        $('.four-icons').stickyfloat();

        $('.social-icon li a').click(function(e){
          e.preventDefault();
          var specs = 'width=600,height=400';
          var url   = $(this).attr('data-url');
          var img = $(this).parent().parent().prev().children().children().attr('src');
          if($(this).attr('data-alert') == "true"){
            alert(url);
          }else{
            window.open(url,'',specs);
          }
        });

        //Money fields mask
        $('.money').maskMoney({
          symbol:'R$ ',
          thousands:'.',
          decimal:',',
          symbolStay: true
        });

        //Notifications
        function generate_noty(type, msg, layout, timeout) {
          var n = noty({
            text: msg,
            type: type,
            dismissQueue: true,
            layout: layout,
            timeout: timeout
          });
        }
        <?
        if($this->session->flashdata('error') || $this->session->flashdata('success')){
          $type = ($this->session->flashdata('error')) ? "error" : "success";

          $msg = str_replace(array("\r\n", "\r", "\n"), "", $this->session->flashdata($type));
          ?>
          generate_noty("<?php echo $type?>", "<?php echo  $msg ?>", 'topLeft', 9000);
          <?
        }
        ?>

      });
    </script>

    <?php echo  $scripts ?>

    <!-- marca&#231;&#227;o necess&#225;ria para o funcionamento do plugin do Facebook -->
    <div id="fb-root"></div>

    <?php if(ENVIRONMENT == 'production' ): /* We are at production server? */ ?>
      <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-25122440-2']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>
    <?php endif ?>

  </body>

</html>
