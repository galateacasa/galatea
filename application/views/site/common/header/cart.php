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

</div>
