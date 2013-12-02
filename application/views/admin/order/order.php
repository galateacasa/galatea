<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Visualizar Pedido: <?php echo  $order->id ?></h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Status</legend>
          <?php if (count($order->order_status->order_by('create_date', 'desc')->get()) > 0) { ?>
          <table class="table table-bordered table-striped ">
            <thead>
              <tr >
                <th>Data</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order->order_status as $st) { ?>
              <tr>
                <td><?php echo  $st->create_date ?></td>
                <td><?php echo  status_to_literal_pagseguro($st->status) ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php } ?>
        </fieldset>
        <fieldset>
          <legend>Detalhes</legend>
          <div class="row-fluid">
            <address>
              <strong>Método de pagamento</strong><br>
              <?php echo  payment_to_literal_pagseguro($order->payment_method) ?>
            </address>
          </div>

          <div class="row-fluid">
            <address>
              <strong>Endereço de entrega</strong><br>
              <?
              $delivery_address = $order->delivery_address;
              $delivery_address->street ?>, <?php echo  $delivery_address->number ?>, <?php echo  $delivery_address->complement ?>, <?php echo  $delivery_address->district ?><br>
              <?php echo  $delivery_address->city ?> - <?php echo  $delivery_address->state ?>, <?php echo  $delivery_address->zip ?><br>
              Tel: <?php echo  $delivery_address->phone ?>
            </address>

          </div>
        </fieldset>
        <fieldset>
          <legend>Produtos</legend>
          <table class="table table-bordered table-striped ">
            <thead>
              <tr >
                <th>Id</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Variações</th>
              </tr>
            </thead>
            <tbody>
              <?
              $order_items = $order->order_item->get();
              foreach ($order_items as $order_item) { ?>
              <tr>
                <td><?php echo  $order_item->id ?></td>
                <td><?php echo  $order_item->item->name ?></td>
                <td><?php echo  $order_item->price ?></td>
                <td><?php echo  $order_item->qty ?></td>
                <td><?php echo  $order_item->variations ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </fieldset>
      </form>
    </div>
  </div>
</div>
