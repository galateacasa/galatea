<?php
    $subcat = array();
    foreach($subcategories as $sub){
        $subcat[] = $sub->parent_id;
    }

?>

<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Categorias</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/categories/create')?>">Criar categoria</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Pai</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($categories as $category) {
            ?>
            <tr>
              <td><?php echo $category->id?></td>
              <td>
                <?
                if (!empty($category->image)) {
                  ?>
                  <img width="100" height="100" src="<?php echo amazon_url('images/categories/'.$category->image)?>" alt="">
                  <?
                }
                ?>
              </td>
              <td><?php echo  $category->name?></td>
              <td><?php echo  $category->parent->name; ?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/categories/edit/'.$category->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>

                                <?php if(in_array($category->id, $subcat)): ?>
                                    <a onclick="return(confirm('A categoria tem subcategorias. Todas serao apagadas. Tem certeza que deseja continuar?'));" class="btn btn-danger" href="<?php echo  site_url('admin/categories/remove/'.$category->id)?>">
                                        <i class="icon-edit icon-white"></i>
                                        Remover
                                    </a>
                                <?php else: ?>
                                    <a onclick="return(confirm('Tem certeza?'));" class="btn btn-danger" href="<?php echo  site_url('admin/categories/remove/'.$category->id)?>">
                                        <i class="icon-edit icon-white"></i>
                                        Remover
                                    </a>
                                <?php endif; ?>
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
