<div class="row-fluid">
  <h3>Minhas Disponibilidades</h3>

  <form class="form-horizontal" method="get" action="">
    <legend>Filtros</legend>
    <div class="control-group">
      <label class="control-label" for="search">Busca</label>
      <div class="controls">
        <input type="text" name="search" id="search" placeholder="" value="<?php echo  $search ?>">
      </div>
    </div>
    <div class="form-inline" style="margin-left: 100px;">
      <input type="text" class="input-medium datepicker" placeholder="Data Início" id="date_start" name="date_start" value="<?php echo  $date_start ?>">
      <input type="text" class="input-medium datepicker" placeholder="Data Fim" id="date_end" name="date_end" value="<?php echo  $date_end ?>">
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
  </form>

  <table class="table table-bordered table-striped ">
    <thead>
      <tr >
        <th>#</th>
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

      <?php foreach ($disponibilities as $disponibility) {  ?>
        <tr>
          <td><?php echo  $disponibility->id ?></td>
          <td>
            <?php if ($disponibility->item->item_image) { ?>
              <img width="100" height="100" src="<?php echo  amazon_url('images/items/' . $disponibility->item->item_image->get()->image) ?>">
            <?php } ?>
          </td>
          <td><?php echo  $disponibility->item->name ?></td>
          <td>R$ <?php echo  number_format($disponibility->production_price ,2 ,',' ,'.')?></td>
          <td><?php echo  disponibility_status_to_literal($disponibility->status) ?></td>
          <td><?php echo  $disponibility->weekly_production ?></td>
          <td><?php echo  $disponibility->create_date ?></td>
          <td>
            <div class="btn-group">
              <a class="btn btn-primary btn-mini" href="<?php echo  site_url('site/disponibilities/edit/' . $disponibility->id) ?>">Editar</a>
              <a class="btn btn-danger btn-mini" href="<?php echo  site_url('site/disponibilities/delete/' . $disponibility->id) ?>">Excluir</a>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="span9" style="text-align: center;" >
    <?php echo  $paginate ?>
  </div>
</div>
