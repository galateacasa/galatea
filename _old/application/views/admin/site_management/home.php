<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Gerenciamento de Sites - HOME</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/site_management_home/create')?>">Adicionar Novo</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
        <tr>
          <th>ID</th>
          <th>Imagem</th>
          <th>Nome</th>
          <th>Ambiente</th>
          <th>Produtos</th>
          <th>Ações</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($layouts as $layout): ?>
            <tr>
              <td><?php echo  $layout->id; ?></td>
              <td><img width="100" height="100" src="<?php echo amazon_url('images/ambiances/'.$layout->ambiance->get()->image)?>" alt=""></td>
              <td><?php echo  $layout->name; ?></td>
              <td><?php echo  $layout->ambiance->get()->title; ?></td>
              <td>
                <?php foreach($layout->item->get() as $items): ?>
                  <?php echo  $items->name.'<br />'; ?>
                <?php endforeach ?>
              </td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/site_management_home/edit/'.$layout->id) ?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/site_management_home/remove/'.$layout->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Remover
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
