<section class="grid_12">
  <nav class="grid_6 prefix_6">

    <!-- static pages -->
    <ul>
      <li>
        <?php echo  anchor('institucional/sobre', 'Sobre a Galatea') ?>
      </li>
      <!-- <li><a href="#">Ajuda</a></li> -->
      <li>
        <?php echo  anchor('atendimento', 'Atendimento') ?>
      </li>
      <li>
        (19) 3112-0316
      </li>
    </ul>

    <?php $this->session; ?>

    <!-- ambiances -->
    <small class="inspire-me">
      <a href="<?php echo  site_url('inspire-me') ?>">inspire-me</a>
    </small>

  </nav>
</section>
