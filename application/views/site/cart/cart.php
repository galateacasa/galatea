<!-- delivery address -->
<section class="container_12" id="delivery_address">
  <section class="grid_12 mycart border-hrz">
    <h2 class="float-l">Meu Carrinho</h2>

    <?php if( $this->session->userdata('id') ): /* The user is logged in? */ ?>
      <div class="delivery_address_select">

        <label id="select-address" for="">selecione um endereço de entrega</label>

        <div>
          <select class="styled" name="delivery_address">
            <option value="">
              <?php echo  $delivery_addresses ? '-- Selecione --' : 'Você não possui endereços cadastrados' ?>
            </option>

            <?php if( $delivery_addresses ): /* Check if the user have any delivery address */ ?>

               <?php foreach($delivery_addresses as $delivery): ?>

                <?php
                  $pattern = '%s, %s %s - %s/%s CEP.: %s';

                  $opt = sprintf(
                    $pattern,
                    $delivery['street'],
                    $delivery['number'],
                    $delivery['complement'],
                    $delivery['city'],
                    $delivery['state'],
                    $delivery['zip']
                  );
                ?>

                <?php if( $this->session->userdata('delivery_address_id') ): ?>
                  <option value="<?php echo  $delivery['id'] ?>" <?php echo  $this->session->userdata('delivery_address_id') == $delivery['id'] ? 'selected' : '' ?> >
                    <?php echo  $opt ?>
                  </option>
                <?php else: ?>
                  <option value="<?php echo  $delivery['id'] ?>" <?php echo  $delivery['default'] ? '' : 'selected' ?> >
                    <?php echo  $opt ?>
                  </option>
                <?php endif ?>

              <?php endforeach ?>

            <?php endif ?>

          </select>

          <a class="button" href="<?php echo  base_url('minha-conta');?>">Novo endereço</a>

        </div>

        <?php if( $this->session->userdata('id') ): /* The user is logged in? */ ?>
          <div style="margin-top: 40px;">

            <?php if( $this->session->userdata('delivery_address_id') and $this->session->userdata('delivery_address_valid') ): ?>
              <label id="success_msg" style="display: block; color: #33bef2">
                finalize a compra! seu endereço é coberto pela nossa logística
              </label>
              <label id="error_msg" style="display: none; color: #ef0011;">
                sentimos muito, mas ainda não entregamos no seu endereço
              </label>
            <?php else: ?>
              <label id="success_msg" style="display: none; color: #33bef2">
                finalize a compra! seu endereço é coberto pela nossa logística
              </label>
              <label id="error_msg" style="display: block; color: #ef0011;">
                sentimos muito, mas ainda não entregamos no seu endereço
              </label>
            <?php endif ?>

          </div>
        <?php endif ?>

      </div>
    <?php endif ?>

  </section>
</section> <!-- /delivery address -->

<!-- product list and buttons -->
<section class="container_12">

  <!-- product list -->
  <section class="grid_12 border-btm ">
    <?php echo  form_open('site/cart/update_cart') ?>
      <table class="chart shopping-cart" >

        <!-- title -->
        <tr class="chart-title">
          <th>Item</th>
          <th>Imagem</th>
          <th>Descrição</th>
          <th>Valor Unitário</th>
          <th>Quantidade</th>
          <th>Total</th>
          <th>&nbsp;</th>
        </tr> <!-- /title -->

        <?php if( $this->cart->contents() ): /* Check if have any products */ ?>
          <?php foreach ($this->cart->contents() as $row_id => $product): /* List all products */ ?>
            <tr>

              <!-- name -->
              <td><?php echo  anchor("produto/{$product['slug']}", $product['name']) ?></td>

              <!-- image -->
              <td><?php echo  anchor("produto/{$product['slug']}", img($product['options']['image']) ) ?></td>

              <!-- material + measurement -->
              <td>
                <p>
                  <strong>Material:</strong> <?php echo  $product['options']['material'] ?><br/>
                  <strong>Medida:</strong> <?php echo  $product['options']['measurement'] ?><br/>
                </p>
              </td> <!-- /material + measurement -->

              <!-- price -->
              <td><?php echo  to_money($product['price']) ?></td>

              <!-- quantity -->
              <td>
                <input type="text" name="qty[<?php echo   $row_id ?>]" value="<?php echo   $product['qty'] ?>" class="quantity-pro" >
                <input type="submit" class="link-btn blue float-r bold-text" style="padding: 4px 10px"  value="ok">
              </td>

              <!-- subtotal -->
              <td><?php echo  to_money($product['subtotal']) ?></td>

              <!-- delete -->
              <td>
                <a onclick="javascript:return confirm('tem certeza que deseja excluir?');" href="<?php echo   base_url("site/cart/remove_item/{$row_id}")?>" class="remove-link">excluir</a>
              </td>

            </tr>
          <?php endforeach ?>
        <?php endif ?>

        <!-- cart total -->
        <tr class="subtotal">
          <td colspan="5">&nbsp;</td>
          <td>
            <?php echo  to_money( $this->cart->total() ) ?>
          </td>
          <td>&nbsp;</td>
        </tr> <!-- /cart total -->

        <!-- user credits + user counpom -->
        <tr>
          <td colspan="7">

            <?php if( $user->getUserCredits() > 0 ): /* Check if the user have any credit */ ?>
              <div class="credit-block extra-top-space">
                <input type="submit" class="link-btn blue float-r bold-text" style="padding: 7px 10px; margin: 0px 0px 0px 5px;"  value="ok">
                <span class="subtotal-input">
                  <input type="text" value="<?php echo   $user_credit ?>" id="user_credits" name="user_credits" class="search-area no-bg money" />
                </span>
                <label>Você tem <span><?php echo  to_money( $user->getUserCredits() ) ?></span>Insira os créditos que deseja usar</label>
              </div>
            <?php endif ?>

            <!-- coupon -->
            <div class="credit-block extra-top-space extra-btm-space">
              <input type="submit" class="link-btn blue float-r bold-text" style="padding: 7px 10px; margin: 0px 0px 0px 5px;"  value="ok">
              <span class="subtotal-input">
                <input type="text" id="discount_coupon_value"  value="R$ <?php echo  is_numeric($discount_coupon['value']) ? number_format($discount_coupon['value'], 2, ',','.') : ''?>" readonly class="search-area no-bg money" />
              </span>
              <input type="text" class="d-coupon" name="discount_coupon"  value="<?php echo  $discount_coupon['hash']?>" />
              <label>insira o número do seu cupom de desconto se tiver um</label>
            </div> <!-- /coupon -->

          </td>
        </tr> <!-- /user credits + user counpom -->

        <!-- total -->
        <tr class="grand-amount chart-title cap-caps">
          <td colspan="5" style="text-align: right;">total</td>
          <td colspan="2"><?php echo  to_money($total_cart) ?></td>
        </tr>
      </table>
    <?php echo  form_close() ?>
  </section> <!-- /product list -->

  <!-- bottom of cart -->
  <section class="grid_6 extra-top-space text-big float-r ">

    <!-- delivery date -->
    <span class="credit-amount ext-bold grey-text right-text ">
      a data de entrega estimada para essa compra é <em class="omega"><?php echo  $delivery_time ?></em>
    </span>

    <!-- terms -->
    <h3 class="extra-top-space right-text grey-text ext-bold extra-btm-space">
      CLICANDO EM “FINALIZAR” VOCÊ SERÁ DIRECIONADO AO SITE DO PAGSEGURO PARA SELECIONAR O MEIO DE PAGAMENTO, NÚMERO DE PARCELAS E FINALIZAR A COMPRA DE FORMA SEGURA.
    </h3>

    <!-- bottom butons -->
    <div class="shopping-cart-buttons">

      <?php if( $this->session->userdata('id') ): /* The user is logged in and the delivery address was set up? */ ?>

        <?php if( $this->session->userdata('delivery_address_id') and $this->session->userdata('delivery_address_valid') ): ?>
          <a class="button float-r push-left" href="<?php echo  base_url('site/cart/finalize') ?>" id="finalize" style="display: block;">
            Finalizar
          </a>
          <a class="button float-r push-left" href="#select-address" id="change-address" style="display: none;">
            troque o endereço
          </a>
        <?php else: ?>
          <a class="button float-r push-left" href="<?php echo  base_url('site/cart/finalize') ?>" id="finalize" style="display: none;">
            Finalizar
          </a>
          <a class="button float-r push-left" href="#select-address" id="change-address" style="display: block;">
            troque o endereço
          </a>
        <?php endif ?>

      <?php else: ?>
        <?php $this->session->set_userdata('return_path', base_url('carrinho-de-compras')); ?>
        <a class="button button-gray float-r push-left" href="<?php echo  base_url('login') ?>">Entre para finalizar a compra</a>
      <?php endif ?>

      <a class="button button-gray float-r" href="<?php echo  base_url() ?>">Seguir comprando</a>
    </div> <!-- /bottom butons -->

  </section> <!-- /bottom of cart -->

</section> <!-- /product list and buttons -->
