
<section class="container_12 extra-top-space">
  <section class="grid_12">
    <!-- sidebar -->
    <aside class="grid_3 alpha">

      <?php if ( $this->session->userdata('id') ): ?>
        <nav class="sidebar-nav">
          <ul class="text-big">

            <li>
              <?php echo  anchor("perfil/{$user->username}", 'meu perfil') ?>
            </li>

            <li class="<?php echo  $current_menu == 'orders' ? 'current' : ''?>">
              <?php echo  anchor('meus-pedidos', 'meus pedidos') ?>
            </li>

            <li class="<?php echo $current_menu == 'user_balance' ? 'current' : ''?>">
              <?php echo  anchor('meus-creditos', 'meus créditos') ?>
            </li>

            <li class="<?php echo $current_menu == 'edit_user' ? 'current' : ''?>">
              <?php echo  anchor('minha-conta', 'editar dados') ?>
            </li>

            <?php if($user->role == 2): /* The user is a supplier? */ ?>
              <li class="<?php echo $current_menu == 'produce' ? 'current' : ''?>">
                <?php echo  anchor('site/items/produce', 'quero produzir') ?>
              </li>
            <?php endif ?>

          </ul>
        </nav>
      <?php endif ?>

      <nav class="sidebar-nav extra-top-space">
        <ul class="text-big">
          <li class="<?php echo  $current_menu == 'about_galatea' ? 'current' : ''?> ">

            <?php echo  anchor('institucional/sobre','sobre a galatea') ?>

            <ul class="sub-menu">
              <li class="<?php echo $current_menu == 'client' ? 'current' : ''?>">
                <?php anchor('institucional/cliente', 'cliente') ?>
              </li>
              <li class="<?php echo $current_menu == 'decorator' ? 'current' : ''?>">
                <?php echo  anchor('institucional/decorador','decorador') ?>
              </li>
              <li class="<?php echo $current_menu == 'designer' ? 'current' : ''?>">
                <?php echo  anchor('institucional/designer','designer') ?>
              </li>
              <li class="<?php echo $current_menu == 'supplier' ? 'current' : ''?>">
                <?php echo  anchor('institucional/fornecedor', 'fornecedor') ?>
              </li>
              <li class="<?php echo $current_menu == 'be_galatea' ? 'current' : ''?>">
                <?php echo  anchor('institucional/manual-de-boas-praticas', 'Manual de boas práticas') ?>
              </li>
            </ul>
          </li>

          <?
            $menus = array(
              array('item' => 'contact', 'url' => 'atendimento', 'label' => 'atendimento', 'institutional' => 1),
              array('item' => 'faq', 'url' => 'duvidas-frequentes', 'label' => 'dúvidas frequentes', 'institutional' => 0),
              array('item' => 'tips', 'url' => 'cuidados-com-a-mobilia', 'label' => 'cuidados com a mobília', 'institutional' => 0),
              array('item' => 'returns', 'url' => 'trocas-e-devolucoes', 'label' => 'trocas e devoluções', 'institutional' => 0),
              array('item' => 'warranty', 'url' => 'garantia', 'label' => 'garantia', 'institutional' => 0),
              array('item' => 'payments', 'url' => 'formas-de-pagamento', 'label' => 'formas de pagamento', 'institutional' => 0),
              array('item' => 'credits', 'url' => 'ganhe-creditos', 'label' => 'ganhe créditos', 'institutional' => 0),
              array('item' => 'delivery-policy', 'url' => 'politica-de-entrega', 'label' => 'política de entrega', 'institutional' => 0),
              array('item' => 'terms', 'url' => 'termos-e-condicoes', 'label' => 'termos e condições', 'institutional' => 0),
              array('item' => 'upload_projects', 'url' => 'condicoes-de-upload', 'label' => 'condições de upload', 'institutional' => 0),
              array('item' => 'sitemap', 'url' => 'mapa-do-site', 'label' => 'mapa do site', 'institutional' => 1)
            );
          ?>

          <?php foreach($menus as $menu): ?>
            <li class="<?php echo  $current_menu == $menu['item'] ? 'current' : ''?>">
              <?
                if($menu['institutional']):
                  echo anchor($menu['url'], $menu['label']);
                else:
                  echo anchor("institucional/{$menu['url']}", $menu['label']);
                endif;
              ?>
            </li>
          <?php endforeach ?>

        </ul>
      </nav>

    </aside>
    <!-- end Sidebar -->

    <!-- main content -->
    <section class="grid_8 omega product-top">
      <div class="block space-container">
        <?php echo  $this->load->view($content) ?>
      </section>
    </div>
</section>
