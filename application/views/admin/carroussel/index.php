<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Carroussel</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/carroussels/create')?>">Inserir imagem</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Títuloe</th>
            <th>Descrição</th>
            <th>Link</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($carroussels as $carroussel) {
            ?>
            <tr>
              <td><?php echo $carroussel->id?></td>
              <td>
                <?
                if (!empty($carroussel->image)) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/carroussels/'.$carroussel->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo $carroussel->title?></td>
              <td><?php echo  $carroussel->description; ?></td>
              <td><?php echo  $carroussel->link; ?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/carroussels/edit/'.$carroussel->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/carroussels/remove/'.$carroussel->id)?>">
                                    <i class="icon-edit icon-white"></i>
                                    Remover
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
