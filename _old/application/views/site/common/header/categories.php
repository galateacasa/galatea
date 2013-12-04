<div class="container_12">
  <nav class="grid_12 nav-main">

    <?php

      // New menu
      $lis[] = anchor('categoria/novidades', 'Novidades', 'class="padd-first category_novidades"');

      // Create all categories markup
      foreach ($categories as $category) {

        // Skip projects category
        if ($category->slug == 'projetos') continue;

        $lis[] = anchor(
          "categoria/{$category->slug}",
          $category->name,
          "class=\"padd-first category_{$category->id}\""
        );

      }

      // Vote button mark up
      $lis[] = anchor('categoria/vote', 'Vote', 'class="padd-first category_vote"');

      // Print the main menu
      echo ul($lis);

    ?>

    <!-- search area -->
    <?php echo  form_open('site/home/search') ?>
      <input type="text" name="search" id="search"  placeholder="Buscar">
    <?php echo  form_close() ?>

  </nav>
</div>
