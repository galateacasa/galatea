<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Inspire-se</h2>

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
          <?
          foreach ($ambiances as $ambiance) {
            ?>
            <tr>
              <td><?php echo $ambiance->id?></td>
              <td>
                <?
                if (!empty($ambiance->image)) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/ambiances/'.$ambiance->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo $ambiance->name?></td>
              <td><?php echo disponibility_status_to_literal($ambiance->status)?></td>
              <td><?php echo $ambiance->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/curadoria/ambiance/'.$ambiance->id)?>">
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
