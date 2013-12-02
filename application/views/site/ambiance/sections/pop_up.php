<!-- close button -->
<a href="javascript:void(0)" class="close-button">Fechar</a>

<h2>
  <?php echo  $ambiance->title ?>
  <?php echo  anchor("perfil/{$ambiance->user->username}", "{$ambiance->user->name} {$ambiance->user->surname}") ?>
</h2>
<?
  echo $vote_button->get($ambiance->id, 'ambiances', 'star');
  echo $denounce_button->define('ambiance', $ambiance->id)->get();
?>

<!-- main image -->
<figure class="main-image">
  <?php echo  img( amazon_url("images/ambiances/{$ambiance->image}") ) ?>
</figure> <!-- /main image -->

<?php //echo $social_links->get($ambiance->title, $ambiance->title, amazon_url("images/ambiances/{$ambiance->image}"), site_url("inspire-me/{$ambiance->id}") ) ?>

<?php $products = $ambiance->item->get() /* Get all products from this ambiance */ ?>
<?php if( $products->exists() ): /* Check if the ambiance have any product */ ?>
  <!-- attached products -->
  <section class="vertical-slider">

    <!-- title -->
    <h2>Produtos neste ambiente</h2>

    <div id="ambiance-vertical-slider">

      <!-- content -->
      <div class="content">
        <ul>

          <?php foreach($products as $product): /* List all products */ ?>
            <li>
              <?php echo  anchor("produto/{$product->slug}?ambiance_id={$ambiance->id}", img( amazon_url("images/items/{$product->item_image->get()->image}", 100, 100) ), 'target="_blank"' )  ?>
            </li>
          <?php endforeach ?>

        </ul>
      </div> <!-- /content -->

      <!-- arrows -->
      <?php if( $products->result_count() > 4 ): ?>
        <div class="arrows">
          <a class="previous" href="#">Anterior</a>
          <a class="next" href="#">Próximo</a>
        </div>
      <?php endif ?>

    </div>

  </section> <!-- /attached products -->
<?php endif ?>
