<?
@$category->image = "";
$category->name = "Novidades";
$filter = $this->input->get('filter');
$order = $this->input->get('order');

echo $breadcrumbs;
?>
<!-- banner area -->
<section class="container_12">
  <section class="grid_12">
    <div class="banner-area c-banner">
      <?php echo  img( amazon_url("images/categories/cat_nov_vote.jpg", 940, 164) ) ?>
    </div>
  </section>
</section>
<!-- End banner area -->

<section class="container_12 category-page">
  <section class="grid_12">
    <!-- sidebar -->
    <section class="grid_3 alpha">
      <nav class="sidebar-nav">
        <h2><?php echo  $category->name ?></h2>
        <ul>

        </ul>
      </nav>
    </section>
    <!-- end Sidebar -->

    <!-- main content -->
    <section class="grid_9 omega ">

      <!-- order -->
      <div class="sort-list">
        <ul>
          <li class="filter-name">organizar por:</li>
          <li class="border">
            <a <?php echo  $this->input->get('order') == 'price_asc' ? 'class="current-sel"' : '' ?> href="<?php echo  base_url('categoria/novidades/?order=price_asc')?>">menor preço</a>
          </li>
          <li>
            <a <?php echo  $this->input->get('order') == 'price_desc' ? 'class="current-sel"' : '' ?> href="<?php echo  base_url('categoria/novidades/?order=price_desc')?>">maior preço</a>
          </li>
        </ul>
      </div> <!-- /order -->

      <?php if( $this->session->userdata('id') ): /* The user is logged in? */ ?>
        <!-- filter -->
        <div class="sort-list omega">
          <ul>
            <li class="filter-name">filtrar por:</li>

            <li class="border">
              <a <?php echo  $this->input->get('filter') == 'favorites' ? 'class="current-sel"' : '' ?> href="<?php echo  base_url('categoria/novidades/?filter=favorites')?>">preferidos</a>
            </li>

            <li>
              <a <?php echo  $this->input->get('filter') != 'favorites' ? 'class="current-sel"' : '' ?> href="<?php echo  base_url('categoria/novidades/')?>">tudo</a>
            </li>

          </ul>
        </div> <!-- /filter -->
      <?php endif ?>

    </section>

    <section class="horizontal-slider-container">
      <ul class="horizontal-slider category">
        <?php foreach ($products as $product) echo $product->show('product', 'star'); ?>
      </ul>
    </section>
    <!-- end maincontent -->
  </section>
</section>
