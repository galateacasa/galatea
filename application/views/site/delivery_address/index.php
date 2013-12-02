<div class="row-fluid">
  <h3>Endereços de entrega</h3>
  <p>
    <a class="btn btn-primary btn-mini" href="<?php echo  site_url('site/delivery_addresses/create') ?>">Cadastrar</a>
  </p>
  <table class="table table-bordered table-striped ">
    <thead>
      <tr >
        <th>id</th>
        <th>Endereço</th>
        <th>Numero</th>
        <th>Complemento</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($delivery_address as $da) { ?>
        <tr>
          <td><?php echo  $da->id ?></td>
          <td><?php echo  $da->street ?></td>
          <td><?php echo  $da->number ?></td>
          <td><?php echo  $da->complement ?></td>
          <td>
            <div class="btn-group">
              <a class="btn btn-primary btn-mini" href="<?php echo  site_url('site/delivery_addresses/edit/' . $da->id) ?>">Editar</a>
              <a class="btn btn-danger btn-mini delete" onclick="return confirm('Tem Certeza?')" href="<?php echo  site_url('site/delivery_addresses/delete/' . $da->id) ?>">Excluir</a>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
