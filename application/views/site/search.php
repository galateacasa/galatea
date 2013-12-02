<section class="container_12">

  <?php if( !$products->exists() ): ?>

      <section class="grid_12">
        <div class="error-msg prefix_2">

          <h3>resultados da busca</h3>

          <p class="extra-btm-space">
            Infelizmente não encontramos nenhum resultado para a sua busca. Por favor tente novamente ou navegue pelas nossas categorias. Você também pode voltar para a home.
          </p>

        </div>
      </section>

  <?php else: ?>

    <section class="product-top grid_12">

      <h3>Exibindo resultados para “<?php echo  $search ?>”:</h3>

      <section class="horizontal-slider-container">
        <ul class="horizontal-slider search">
          <?php foreach ($products as $product) echo $product->show('product', 'star'); ?>
        </ul>
      </section>

    </section>

  <?php endif ?>

</section>
<?php echo  br(10) ?>
