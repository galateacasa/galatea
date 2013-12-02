<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Pedidos</h2>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Pedido</th>
            <th>Cliente</th>
            <th>Status</th>
            <th>Valor</th>
            <th>Fornecedor</th>
            <th>Data da compra</th>
            <th>Prazo de entrega</th>
            <th>Farol</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($orders as $order) {
            ?>
            <tr>
              <td><?php echo $order->id?></td>
              <td><?php echo $order->user->name?></td>
              <td><?php echo $order->status?></td>
              <td><?php echo $order->value?></td>
              <td><?php foreach ($order->items as $item) { foreach ($item->suppliers as $supplier) { echo $supplier->name . '<br>'; } }?></td>
              <td><?php echo $order->create_date?></td>
              <td><?php echo $order->estimated_delivery_date?></td>
              <td><?php echo $order->traffic_light?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/orders/order/'.$order->id)?>">
                  <i class="icon-zoom-in icon-white"></i>
                  Ver
                </a>
              </td>
            </tr>
            <?
          }

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
