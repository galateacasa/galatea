<div class="container_12">
  <section class="grid_12">
    <nav class="brydcrumb">
      <ul>

        <?php foreach($breadcrumbs as $key => $breadcrumb): /* Create the breadcrumbs */ ?>
          <?
            # Set current class to be applyed
            $current = '';

            # Set class for last item
            $last = '';

            # Check if the actual key is the last key into the breadcrumbs
            if( $key == end( array_keys($breadcrumbs)) ){
              $current = 'class="current"';
              $last = 'class="last"';
            };
          ?>
          <li <?php echo  $last ?>>
            <?php
              if ($last) {
                echo $breadcrumb['name'];
              }else{
                echo anchor($breadcrumb['href'], $breadcrumb['name'], $current);
              }
            ?>
          </li>
        <?php endforeach ?>

      </ul>
    </nav>
  </section>
</div>
