<section class="container_12">
  <section class="grid_12">
    <div class="error-msg prefix_1">
      <h2>Deu certo!</h2>
      <p>
        <strong><?php echo  $user->name ?></strong>, obrigado pelo seu cadastro, deu tudo certo. Em função da sua região e da sua área de produção,
        gostaríamos de pedir ao sr/sra que envie proposta para os ítens abaixo, que interessarem:
      </p>
    </div>
  </section>
</section>

<?php if( $projects->exists() ): /* Check if have any project to show */ ?>
  <section class="product-top grid_12">

    <h2 class="small-text extra-btm-space">
      <!-- projetos:<span> projetos postados por designers no site com interesse de clientes votantes</span> -->
    </h2>

    <div class="horizontal-slider-container">

      <!-- content -->
      <div class="horizontal-slider-content">
        <ul class="horizontal-slider search">
          <?php foreach ($projects as $project) echo $project->show('project', 'produce'); ?>
        </ul>
      </div> <!-- /content -->

    </div>
  </section>
<?php endif ?>
