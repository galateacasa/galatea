<section class="grid_9 omega product-top alpha omega">

  <h2 class="extra-btm-space border-btm">quero produzir</h2>

  <section class="product-top grid_9 alpha omega">

    <h2 class="small-text extra-btm-space">
      projetos:<span> projetos postados por designers no site com interesse de clientes votantes</span>
    </h2>

    <?php if( $projects_most_voted->exists() ): ?>
      <!-- content -->
      <div class="horizontal-slider-content">
        <ul class="horizontal-slider category">
          <?php foreach ($projects_most_voted as $most_voted) echo $most_voted->show('project', 'produce'); ?>
        </ul>
      </div>
    <?php else: ?>
      <p>Nenhum projeto disponível no no momento.</p>
    <?php endif ?>

    <?php if(FALSE): ?>
      <!-- product list -->
      <div class="block">

        <h2 class="small-text extra-btm-space">
          produtos:<span> produtos do site com interesse comercial, porém sem fornecedor na sua região</span>
        </h2>

        <!-- carousel -->
        <div class="horizontal-slider-container">

          <!-- content -->
          <div class="horizontal-slider-content">
            <ul class="horizontal-slider category">
              <?php foreach ($products_most_voted as $product_most_voted) echo $product_most_voted->show('project', 'produce'); ?>
            </ul>
          </div>

        </div>

      </div> <!-- /product list -->
    <?php endif ?>

  </section>

</section>
<!-- end maincontent -->
