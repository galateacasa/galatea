<div class="row-fluid">
  <h3>Meus Pedidos</h3>

  <form class="form-horizontal" method="get" action="">
    <legend>Filtros</legend>
    <div class="control-group">
      <label class="control-label" for="search">Busca</label>
      <div class="controls">
        <input type="text" name="search" id="search" placeholder="N do pedido" value="<?php echo  $search ?>" />
      </div>
    </div>
    <div class="form-inline" style="margin-left: 100px;">
      <input type="text" class="input-medium datepicker" placeholder="Data Início" id="date_start" name="date_start" value="<?php echo  $date_start ?>" />
      <input type="text" class="input-medium datepicker" placeholder="Data Fim" id="date_end" name="date_end" value="<?php echo  $date_end ?>" />
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
  </form>

  <table class="table table-bordered table-striped ">
    <thead>
      <tr >
        <th>#</th>
        <th>Data</th>
        <th>Método de Pagamento</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($orders as $order) { ?>
        <tr>
          <td><?php echo  $order->id ?></td>
          <td><?php echo  $order->create_date ?></td>
          <td><?php echo  payment_to_literal_pagseguro($order->payment_method) ?></td>
          <td>
            <div class="btn-group">
              <a class="btn btn-primary btn-mini" href="<?php echo  site_url('meus-pedidos/order/' . $order->id) ?>">Visualizar</a>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="span9" style="text-align: center;" >
    <?php echo  $paginate ?>
  </div>
</div>
