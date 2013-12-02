<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Projetos</h2>

    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">

        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?php echo  $item->id?></td>
              <td>
                <?php echo  img( amazon_url("images/items/{$item->item_image->get()->image}", 100, 100) )?>
              </td>
              <td><?php echo  $item->name ?></td>
              <td><?php echo  disponibility_status_to_literal($item->status) ?></td>
              <td><?php echo  $item->create_date ?></td>
              <td>
                <a class="btn btn-info" href="<?php echo  base_url("admin/curadoria/item/{$item->id}") ?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>

      </table>
    </div>
  </div>
</div>
