<?
@$category->image = "";
$category->name = "Vote";

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
        <?php echo  heading($category->name, 2) ?>
        <!-- <h3>categorias:</h3> -->
        <ul>

        </ul>
      </nav>
    </section> <!-- end Sidebar -->

    <!-- main content -->
    <section class="grid_9 omega ">

      <div class="sort-list omega">
        <ul>
          <li class="filter-name">filtrar por:</li>

          <li class="border<?php echo  $this->input->get('filter') == 'news' ? ' current-sel' : '' ?>">
            <a href="<?php echo  site_url('categoria/vote/?filter=news') ?>">novidades</a>
          </li>

          <?php if( $this->session->userdata('id') ): /* The user is logged in? */ ?>
            <li class="border<?php echo  $this->input->get('filter') == 'favorites' ? ' current-sel' : '' ?>">
              <a href="<?php echo site_url('categoria/vote/?filter=favorites')?>">preferidos</a>
            </li>
          <?php endif ?>

          <li <?php echo  $this->input->get('filter') == '' ? 'class="current-sel"' : '' ?>>
            <a href="<?php echo  site_url('categoria/vote/?filter=') ?>">tudo</a>
          </li>

        </ul>
      </div>

    </section>

    <section class="horizontal-slider-container">
      <ul class="horizontal-slider category">
        <?php foreach ($projects as $project) echo $project->show('project', 'vote'); ?>
      </ul>
    </section>

    <!-- end maincontent -->
  </section>
</section>

