<?
  # Create random ID as a form Key and for city and state (it's necessary to be used with JavaScript).
  $uniqueID    = sha1(uniqid( rand(), true));
  $uniqueState = "state_{$uniqueID}";
  $uniqueCity  = "city_{$uniqueID}";
?>

<section>

  <!-- remove button -->
  <a class="delivery-address-delete">Remover</a>

  <!-- zip code -->
  <div class="zip">
    <input
      class="zip"
      data-name="zip"
      name="delivery_address[new][<?php echo  $uniqueID ?>][zip]"
      placeholder="cep"
      type="text"
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
      name="delivery_address[new][<?php echo  $uniqueID ?>][areaCode]"
      placeholder="ddd"
      type="text"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- phone -->
  <div class="phone">
    <input
      class="phone"
      data-name="phone"
      name="delivery_address[new][<?php echo  $uniqueID ?>][phone]"
      placeholder="telefone"
      type="text"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- address -->
  <div class="address">
    <input
      class="street"
      data-name="street"
      name="delivery_address[new][<?php echo  $uniqueID ?>][street]"
      placeholder="rua/avenida"
      type="text"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- number -->
  <div class="number">
    <input
      class="number"
      data-name="number"
      name="delivery_address[new][<?php echo  $uniqueID ?>][number]"
      placeholder="número"
      type="text"
    >
    <em class="imp">&nbsp;</em>
  </div>

  <!-- complement -->
  <div class="complement">
    <input
      class="complement"
      data-name="complement"
      name="delivery_address[new][<?php echo  $uniqueID ?>][complement]"
      placeholder="complemento"
      type="text"
    >
  </div>

  <!-- country -->
  <div class="country-container">
    <?php echo  form_dropdown("delivery_address[new][$uniqueID][country_id]", $countries['all'], $countries['user'], 'class="country styled_new"') ?>
    <em class="imp">&nbsp;</em>
  </div>

  <!-- state -->
  <div class="state-container">
    <select class="styled_new state" id="<?php echo  $uniqueState ?>" name="delivery_address[new][<?php echo  $uniqueID ?>][state_id]" data-name="state_id"></select>
    <em class="imp">&nbsp;</em>
  </div>

  <!-- city -->
  <div class="city-container">
    <select class="styled_new city" id="<?php echo  $uniqueCity ?>" name="delivery_address[new][<?php echo  $uniqueID ?>][city_id]" data-name="city_id"></select>
    <em class="imp">&nbsp;</em>
  </div>

  <script type="text/javascript">

    //State and city dropdown for each address added
    $(document).ready(function() {

      new Dropdown(
        '<?php echo  $uniqueState ?>',
        '<?php echo  $uniqueCity ?>',
        '<?php echo  base_url("ajax/states/get")?>'
      );

      // Activate all custom selects
      $('select.styled_new').customSelect();

      // Apply input mask
      $('.zip').mask('99999-999');
      $('.phone').mask('9999-9999?9');
      $('.areaCode').mask('99');

    });

  </script>

</section>
