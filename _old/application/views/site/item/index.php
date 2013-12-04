<div class="row-fluid">
  <h3>Meus Projetos</h3>

  <p>
    <a class="btn btn-primary btn-mini" href="<?php echo  site_url('criar-projeto') ?>">Cadastrar</a>
  </p>

  <form class="form-horizontal" method="get" action="">
    <legend>Filtros</legend>
    <div class="control-group">
      <label class="control-label" for="search">Busca</label>
      <div class="controls">
        <input type="text" name="search" id="search" placeholder="" value="<?php echo  $search ?>" />
      </div>
    </div>
    <div class="form-inline" style="margin-left: 100px;">
      <input type="text" class="input-medium datepicker" placeholder="Data Início" id="date_start" name="date_start" value="<?php echo  $date_start ?>" />
      <input type="text" class="input-medium datepicker" placeholder="Data Fim" id="date_end" name="date_end" value="<?php echo  $date_end ?>" />
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
        <th>Altura</th>
        <th>Largura</th>
        <th>Profundidade</th>
        <th>Descrição</th>
        <th>Data</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($items as $item) { ?>
        <tr>
          <td><?php echo  $item->id ?></td>
          <td>
            <?php if ($item->item_image->get()->exists()) { ?>
              <img width="100" height="100" src="<?php echo  amazon_url('images/items/' . $item->item_image->image) ?>">
            <?php } ?>
          </td>
          <td><?php echo  $item->name ?></td>
          <td><?php echo  $item->height ?></td>
          <td><?php echo  $item->width ?></td>
          <td><?php echo  $item->depth ?></td>
          <td><?php echo substr($item->description, 0, 20)?></td>
          <td><?php echo  $item->create_date ?></td>
          <td>
            <div class="btn-group">
              <a class="btn btn-primary btn-mini" href="<?php echo  site_url('site/items/edit/' . $item->id) ?>">Editar</a>
              <a class="btn btn-danger btn-mini" href="<?php echo  site_url('site/items/delete/' . $item->id) ?>">Excluir</a>
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
