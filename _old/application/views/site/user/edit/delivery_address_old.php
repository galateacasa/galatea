<?
  # Define city and state unique IDs (it's necessary to be used with JavaScript).
  $uniqueState = "state_{$data['id']}";
  $uniqueCity  = "city_{$data['id']}";
?>

<section>
  <input type="hidden" name="delivery_address[old][<?php echo  $data['id'] ?>][id]" value="<?php echo  $data['id'] ?>">

  <!-- remove button -->
  <a class="delivery-address-delete">Remover</a>

  <!-- zip code -->
  <div class="zip">
    <input
      class="zip"
      data-name="zip"
      name="delivery_address[old][<?php echo  $data['id'] ?>][zip]"
      placeholder="cep"
      type="text"
      value="<?php echo  $data['zip'] ?>"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- zip code search -->
  <a class="zip-search" href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank">
    não sabe o seu CEP?
  </a>

  <!-- code area -->
  <div class="area-code">
    <input
      class="areaCode"
      data-name="areaCode"
      name="delivery_address[old][<?php echo  $data['id'] ?>][areaCode]"
      placeholder="ddd"
      type="text"
      value="<?php echo  $data['areaCode'] ?>"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- phone -->
  <div class="phone">
    <input
      class="phone"
      data-name="phone"
      name="delivery_address[old][<?php echo  $data['id'] ?>][phone]"
      placeholder="telefone"
      type="text"
      value="<?php echo  $data['phone'] ?>"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- address -->
  <div class="address">
    <input
      class="street"
      data-name="street"
      name="delivery_address[old][<?php echo  $data['id'] ?>][street]"
      placeholder="rua/avenida"
      type="text"
      value="<?php echo  $data['street'] ?>"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- number -->
  <div class="number">
    <input
      class="number"
      data-name="number"
      name="delivery_address[old][<?php echo  $data['id'] ?>][number]"
      placeholder="número"
      type="text"
      value="<?php echo  $data['number'] ?>"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- complement -->
  <div class="complement">
    <input
      class="complement"
      data-name="complement"
      name="delivery_address[old][<?php echo  $data['id'] ?>][complement]"
      placeholder="complemento"
      type="text"
      value="<?php echo  $data['complement'] ?>"
    >
  </div>

  <!-- country -->
  <div class="country-container">
    <?php echo  form_dropdown("delivery_address[old][{$data['id']}][country_id]", $countries, $data['country_id'], 'class="styled country"') ?>
    <em class="imp">&nbsp;</em>
  </div>

  <!-- state -->
  <div class="state-container" style="display: <?php echo  $data['country_id'] == 36 ? 'inline-block' : 'none' ?>;">
    <select class="styled state" id="<?php echo  $uniqueState ?>" name="delivery_address[old][<?php echo  $data['id'] ?>][state_id]" data-name="state_id"></select>
    <em class="imp">&nbsp;</em>
  </div>

  <!-- city -->
  <div class="city-container" style="display: <?php echo  $data['country_id'] == 36 ? 'inline-block' : 'none' ?>;">
    <select class="styled city" id="<?php echo  $uniqueCity ?>" name="delivery_address[old][<?php echo  $data['id'] ?>][city_id]" data-name="city_id"></select>
    <em class="imp">&nbsp;</em>
  </div>

  <script type="text/javascript">

    //State and city dropdown for each address added
    $(document).ready(function() {

      // Populate city and state dropdowns
      new Dropdown(
        "<?php echo  $uniqueState ?>",
        "<?php echo  $uniqueCity ?>",
        "<?php echo  base_url('ajax/states/get')?>",
        "<?php echo  $data['state_id'] ?>",
        "<?php echo  $data['city_id'] ?>"
      );

    });

  </script>

</section>
