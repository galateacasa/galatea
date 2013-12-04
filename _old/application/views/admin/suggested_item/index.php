<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Ítens Sugeridos</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/suggested_items/create')?>">Criar ítem sugerido</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Data</th>
            <th>Criado por</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($suggested_items as $suggested_item) {
            ?>
            <tr>
              <td><?php echo $suggested_item->id?></td>
              <td>
                <?
                if ($suggested_item->suggested_item_image->get()->exists()) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/suggested_items/'.$suggested_item->suggested_item_image->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo $suggested_item->name?></td>
              <td><?php echo $suggested_item->create_date?></td>
              <td><?php echo $suggested_item->user->name?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/suggested_items/edit/'.$suggested_item->id)?>">
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
