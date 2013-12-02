<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar região</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $region->name?></legend>
          <form class="form-inline" method="post">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" placeholder="Nome" value="<?php echo  set_value('name', $region->name) ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="role"> Estados </label>
              <div class="controls">
                <select name="states[]" id="state" multiple="multiple"></select>
              </div>
            </div>
            <div class="form-actions">
              <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
          </form>
        </fieldset>
      </form>
      <fieldset>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Estado</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?
            foreach ($region->state->get() as $region_state) {
              ?>
              <tr>
                <td><?php echo $region_state->id?></td>
                <td><?php echo $region_state->name?></td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-danger btn-mini delete" onclick="return confirm('Tem Certeza?')" href="<?php echo  site_url('admin/regions/delete/'.$region_state->id.'/'.$region->id) ?>">Excluir</a>
                  </div>
                </td>
              </tr>
              <?
            }
            ?>
          </tbody>
        </table>
      </fieldset>
    </div>
  </div>
</div>
