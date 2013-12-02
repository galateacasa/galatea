<div class="row-fluid">
  <form action="<?php echo  site_url('site/cart/finalize') ?>" method="POST" >

    <h3>Confirmar endereço</h3>

    <label><?php echo  $user->name ?></label>

    <div class="span6">
      <h4>Endereço de cobrança</h4>
      <hr>
      <address>
        <i class="icon-home"></i><?php echo  $user->street ?>, <?php echo  $user->number ?>, <?php echo  $user->complement ?> <br>
        <i class="icon-map-marker"></i><?php echo  $user->city->get()->name ?> - <?php echo  $user->state->get()->acronym ?> <?php echo  $user->district ?>, <?php echo  $user->zip ?> <br>
        <i class="icon-signal"></i> <?php echo  $user->phone ?> <br>
        <i class="icon-envelope"></i> <?php echo  $user->email ?> <br>
      </address>
      <hr>

      <h4>Endereço de entrega</h4>
      <?
      if (!$user->delivery_address->get()->exists()) {
        ?>
        <input type="checkbox" name="same_as_charge"> Usar mesmo endereço de cobrança
        <?
      }else{
        foreach ($user->delivery_address as $delivery_address) {
          ?>
          <input type="radio" name="delivery_address" value="<?php echo  $delivery_address->id ?>">
          <address>
            <i class="icon-home"></i><?php echo  $delivery_address->street ?>, <?php echo  $delivery_address->number ?>, <?php echo  $delivery_address->complement ?> <br>
            <i class="icon-map-marker"></i><?php echo  $delivery_address->city->get()->name ?> - <?php echo  $delivery_address->state->get()->acronym ?> <?php echo  $delivery_address->district ?>, <?php echo  $delivery_address->zip ?> <br>
            <i class="icon-signal"></i> <?php echo  $delivery_address->phone ?> <br>
            <i class="icon-envelope"></i> <?php echo  $delivery_address->email ?> <br>
          </address>
          <?
        }
      }
      ?>
    </div>
    <div class="span4" style="text-align:center;">
      <a href="<?php echo  site_url('site/delivery_addresses/create') ?>" class="btn btn-primary" >Cadastrar novo endereço de entrega</a>
      <br/>
      <br/>
      <input type="submit" class="btn btn-primary" value="Prosseguir">
    </div>
  </form>
</div>
