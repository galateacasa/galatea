<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Saldo dos Usuários</h2>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Tipo</th>
            <th>Pedido</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($user_balances as $user_balance) {
            ?>
            <tr>
              <td><?php echo $user_balance->id?></td>
              <td><?php echo $user_balance->user->name?></td>
              <td><?php echo transaction_to_literal($user_balance->transaction_type)?></td>
              <td><?php echo $user_balance->order->id?></td>
              <td><?php echo $user_balance->create_date?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/user_balances/transaction/'.$user_balance->id)?>">
                  <i class="icon-zoom-in icon-white"></i>
                  Visualizar
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
