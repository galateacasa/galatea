<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Produtos</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/products/create')?>">Criar produto</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Sub-Categoria</th>
            <th>Designer</th>
            <th>Fornecedores</th>
            <th>Preço (A partir de)</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($products as $product) {
            ?>
            <tr>
              <td><?php echo $product->name?></td>
              <td><?php echo $product->category->name?></td>
              <td><?php echo $product->subcategory->name?></td>
              <td><?php echo $product->designer->name?></td>
              <td><?php
                foreach ($product->suppliers as $supplier) {
                  echo $supplier->name . '<br>';
                }
              ?></td>
              <td><?php echo $product->minimum_price?></td>
              <td><?php echo  (($product->status == 1)? 'Publicado' : 'Não publicado') ?></td>
              <td>
                <a class="btn btn-success" href="<?php echo site_url('admin/products/edit/'.$product->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a onclick="return(confirm('Tem certeza?'));" class="btn btn-danger" href="<?php echo  site_url('admin/products/remove/'.$product->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Excluir
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
