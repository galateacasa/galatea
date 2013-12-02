<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Disponibilidades</h2>

    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Preço de Produção</th>
            <th>Status</th>
            <th>Produção Semanal</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($disponibilities as $disponibility) {
            ?>
            <tr>
              <td><?php echo $disponibility->id?></td>
              <td>
                <?
                if ($disponibility->item->item_image->get()->exists()) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/items/'.$disponibility->item->item_image->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo $disponibility->item->name?></td>
              <td><?php echo $disponibility->production_price?></td>
              <td><?php echo $disponibility->status?></td>
              <td><?php echo $disponibility->weekly_production?></td>
              <td><?php echo $disponibility->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/disponibilities/edit/'.$disponibility->id)?>">
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
