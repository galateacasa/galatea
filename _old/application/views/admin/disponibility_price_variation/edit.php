<script type="text/javascript">
$(document).ready(function(){

});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar variaçoes de preço de disponibilidade</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $disponibility_variation_value->disponibility_variation_disponibility_item_name ?> - <?php echo  $disponibility_variation_value->disponibility_variation_name ?> - <?php echo $disponibility_variation_value->name?></legend>
          <form class="form-inline" method="post">
            <input type="hidden" name="disponibility_variation_value_id" id="disponibility_variation_value_id" value="<?php echo $disponibility_variation_value->id?>" />
            <select name="state" id="state"><option>Estado</option></select>
            <select name="city" id="city"><option>Cidade</option></select>
            <input type="text" name="price" id="price" placeholder="Preço" class="input-mini" />
            <button class="btn btn-primary" type="submit">Salvar</button>
          </form>
        </fieldset>
      </form>
      <fieldset>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Estado</th>
              <th>Cidade</th>
              <th>Preço</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?
            foreach ($disponibility_price_variations as $disponibility_price_variation) {
              ?>
              <tr>
                <td><?php echo $disponibility_price_variation->id?></td>
                <td><?php echo $disponibility_price_variation->state_name?></td>
                <td><?php echo $disponibility_price_variation->city_name?></td>
                <td>R$<?php echo number_format($disponibility_price_variation->price, 2, ',', '.')?></td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-danger btn-mini delete" onclick="return confirm('Tem Certeza?')" href="<?php echo  site_url('admin/disponibility_price_variations/delete/'.$disponibility_price_variation->id.'/'.$disponibility_variation_value->id) ?>">Excluir</a>
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
