<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Projetos</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/items/create')?>">Criar projeto</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Altura</th>
            <th>Largura</th>
            <th>Profundidade</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($items as $item) {
            ?>
            <tr>
              <td><?php echo $item->id?></td>
              <td>
                <?
                if ($item->item_image->get()->exists()) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/items/'.$item->item_image->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo $item->name?></td>
              <td><?php echo $item->height?></td>
              <td><?php echo $item->width?></td>
              <td><?php echo $item->depth?></td>
              <td><?php echo $item->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/items/edit/'.$item->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a class="btn btn-primary" href="<?php echo site_url('admin/disponibilities/create/'.$item->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Criar disponibilidade
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
