<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Variações de preços das disponibilidades</h2>

    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Disponibilidade</th>
            <th>Variaçao</th>
            <th>Valor da Variação</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($disponibility_variation_values as $disponibility_variation_value) {
          ?>
            <tr>
              <td><?php echo $disponibility_variation_value->id?></td>
              <td><?php echo $disponibility_variation_value->disponibility_variation_disponibility_item_name?></td>
              <td><?php echo $disponibility_variation_value->disponibility_variation_name?></td>
              <td><?php echo $disponibility_variation_value->name?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/disponibility_price_variations/edit/'.$disponibility_variation_value->id)?>">
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
