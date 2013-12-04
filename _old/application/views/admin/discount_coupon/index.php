<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Cupons de Desconto</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/discount_coupons/create')?>">Criar cupom de desconto</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Hash</th>
            <th>Tipo de desconto</th>
            <th>Valor</th>
            <th>Valor Mínimo</th>
            <th>Utilizações Máximas</th>
            <th>Data de Início</th>
            <th>Data de Fim</th>
            <th>Criado</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($discount_coupons as $discount_coupon) {
            ?>
            <tr>
              <td><?php echo $discount_coupon->id?></td>
              <td><?php echo $discount_coupon->hash?></td>
              <td><?php echo $discount_coupon->type == 1 ? "Valor" : "Percentual" ?></td>
              <td><?php echo $discount_coupon->value?></td>
              <td><?php echo $discount_coupon->min_sell_value?></td>
              <td><?php echo $discount_coupon->max_utilizations?></td>
              <td><?php echo $discount_coupon->start_date?></td>
              <td><?php echo $discount_coupon->end_date?></td>
              <td><?php echo $discount_coupon->create_date?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/discount_coupons/edit/'.$discount_coupon->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
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
