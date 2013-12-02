<section class="grid_9 omega product-top alpha omega">
  <div class="block extra-btm-space">
    <h2 class="extra-btm-space extra-top-space">meus créditos</h2>
    <h3 class="small-caps accumulation">Você acumulou<em>R$ <?php echo number_format($user->getUserCredits(), 2, ',', '.')?></em></h3>
    <p>Confira abaixo os itens que geraram esses créditos e como resgat&aacute;-los</p>
  </div>


  <div class="block border-btm border-top extra-top-space">
    <h3 class="dark-clr">royalties provenientes da venda dos seus produtos</h3>
    <table class="chart">
      <tr class="chart-title">
        <td>Item</td>
        <td>Unid.<br> Vendidas</td>
        <td>Data</td>
        <td>Valor Unitário</td>
        <td>Valor Total</td>
        <td>Royalties (<?php echo PRODUCT_SELL_ROYALTIES?>%)<a class="help-sm" href="<?php echo  base_url('institucional/designer') ?>">&nbsp;</a></td>
        <td>Status</td>
      </tr>
      <?
      $total_product_credit = 0;
      foreach ($product_sells as $product_sell) {
        $item = $product_sell->order_item->item;
        $credit = $product_sell->value;
        $total_sell = $product_sell->order_item->price * $product_sell->order_item->qty;
        $total_product_credit += $credit;
        $price = number_format($product_sell->order_item->price, 2, ',','.');
        $credit = number_format($credit, 2, ',','.');
        $total_sell = number_format($total_sell, 2, ',','.');
        ?>
        <tr>
          <td>(<?php echo $item->id?>)<?php echo $item->name?></td>
          <td><?php echo $product_sell->order_item->qty?></td>
          <td><?php echo $product_sell->create_date?></td>
          <td>R$ <?php echo $price?></td>
          <td>R$ <?php echo $total_sell?></td>
          <td>R$ <?php echo $credit?></td>
          <td>
            <?
            switch ($product_sell->status) {
              case 0:
                echo "Pendente";
              break;

              case 1:
                echo "Aprovado";
              break;

              case 2:
                echo "Cancelado";
              break;
            }
            ?>
          </td>
        </tr>
        <?
      }
      ?>
      <tr class="last">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="dark-clr">R$ <?php echo number_format($total_product_credit, 2, ',','.');?></td>
      </tr>
    </table>
  </div>

  <div class="block border-btm extra-top-space">
    <h3 class="dark-clr">crédito gerado pelas decorações que você postou no site</h3>
    <table class="chart">
      <tr class="chart-title">
        <td>Imagem</td>
        <td>Produtos <br>Vendidos</td>
        <td>Data</td>
        <td>Valor da Venda</td>
        <td>Royalties (<?php echo AMBIANCE_SELL_ROYALTIES?>%)<a class="help-sm" href="<?php echo  base_url('institucional/ganhe-creditos') ?>">&nbsp;</a></td>
        <td>Status</td>
      </tr>
      <?
        $total_ambiance_credit = 0;

        foreach ($ambiance_sells as $ambiance_sell):
          $ambiance = $ambiance_sell->ambiance;
          $credit = $ambiance_sell->value;
          $total_ambiance_credit += $credit;
          $total_sell = $ambiance_sell->order_item->price * $ambiance_sell->order_item->qty;
          $price = number_format($ambiance_sell->order_item->price, 2, ',','.');
          $credit = number_format($credit, 2, ',','.');
          $total_sell = number_format($total_sell, 2, ',','.');
      ?>
        <tr>
          <td>(<?php echo  $ambiance->id ?>) <?php echo  $ambiance->title ?></td>
          <td><?php echo  $ambiance_sell->order_item->qty ?></td>
          <td><?php echo  $ambiance_sell->create_date ?></td>
          <td>R$ <?php echo  $total_sell ?></td>
          <td>R$ <?php echo  $credit ?></td>
          <td>
            <?
              switch ($ambiance_sell->status)
              {
                case 0:
                  echo "Pendente";
                break;

                case 1:
                  echo "Aprovado";
                break;

                case 2:
                  echo "Cancelado";
                break;
              }
            ?>
          </td>
        </tr>

      <?php endforeach ?>

      <tr class="last">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="dark-clr">R$ <?php echo number_format($total_ambiance_credit, 2, ',','.');?></td>
      </tr>
    </table>

    <?php if($total_ambiance_credit > 0): /* Does user have any credits? */ ?>

      <?php if ($user->cnpj != ""): /* Is a supplier? */ ?>
        <div  class="block center-text extra-btm-space">
          <p style="padding-right: 0px;" class="add-to-cart no-bg no-under-l">
            Resgate seus créditos no carrinho de compras ou na sua conta bancária <a href="<?php echo site_url('meus-creditos/credit_recovery')?>" title="register" class=" float-r link-btn blue small-link ">resgatar</a>
          </p>
        </div>
      <?php else: ?>
        <div class="block center-text extra-btm-space">
          <?php echo  anchor('site/cart', 'Resgate seus créditos no carrinho de compras', 'class="add-to-cart"') ?>
        </div>
      <?php endif ?>

    <?php endif ?>

  </div>
  <?
  if($user->getUserCredits() > 0){
    ?>
    <section class="product-top grid_9 alpha omega">
      <h3 class="small-text extra-btm-space dark-clr">confira alguns itens que separamos para você</h3>
      <!-- product list -->
      <ul class="product-list omega extra-btm-space reward-products">
        <?
        foreach ($products as $product) {
          echo $product->show('credits');
        }
        ?>
      </ul>
      <!-- product list -->
    </section>
    <?
  }
  ?>

</section>
<!-- end maincontent -->
