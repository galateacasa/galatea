<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Home</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/home_layouts/create')?>">Adicionar layout</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Ambiente</th>
            <th>Produtos</th>
            <th>A&ccedil;&otilde;es</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($home_layouts as $home_layout) {
            ?>
            <tr>
              <td><?php echo  $home_layout->ambiance->title; ?></td>
              <td><?php
              foreach ($home_layout->item->get() as $item) {
                echo $item->name . '<br>';
                } ?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/home_layouts/edit/'.$home_layout->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/home_layouts/remove/'.$home_layout->id)?>">
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
