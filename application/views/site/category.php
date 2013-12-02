<?php
$filter = $this->input->get('filter');
$order  = $this->input->get('order');

echo $breadcrumbs;
?>

<!-- banner area -->
<section class="container_12">
  <section class="grid_12">
    <div class="banner-area c-banner">
      <a href="<?php echo $category['href']; ?>"><?php echo img( amazon_url("images/categories/{$category['image']}", 940, 164) ); ?></a>
    </div>
  </section>
</section>
<!-- /banner area -->

<!-- Category content -->
<section class="container_12">
  <!-- Category menu -->
  <nav class="grid_12 category-nav">
    <?php if ($category_sub) { ?>
    <h2><?php echo $category_sub->name; ?></h2>
    <?php } ?>
    <input type="hidden" id="category-main-actual" value="<?php echo $category_main_actual; ?>">
    <ul>
      <?php
      if ($category_sub) {
        foreach ($sub_categories as $sub_category) {
          if ($sub_category->name !== $category_sub->name) {
      ?>
          <?php echo anchor("categoria/{$category_main->slug}/{$sub_category->slug}", $sub_category->name); ?>
      <?php
          }
        }
      } else {
        foreach ($sub_categories as $sub_category) {
      ?>
          <?php echo anchor("categoria/{$category_main->slug}/{$sub_category->slug}", $sub_category->name); ?>
      <?php
        }
      }
      ?>
    </ul>
  </nav>

  <!-- Category main content -->
  <section class="grid_12 main-content">

    <!-- sort menu -->
    <section class="filtros">
      <div class="sort-list">
        <ul>
          <li class="filter-name">organizar por:</li>
          <li class="border"><a <?php echo $this->input->get('order') === 'price_asc' ? 'class="current-sel"' : ''  ?> href="<?php echo base_url("$category_url/?filter=$filter&order=price_asc"); ?>">menor preço</a></li>
          <li><a <?php echo $this->input->get('order') === 'price_desc' ? 'class="current-sel"' : ''  ?> href="<?php echo base_url("$category_url/?filter=$filter&order=price_desc"); ?>">maior preço</a></li>
        </ul>
      </div>
      <div class="sort-list">
        <ul>
          <li class="filter-name">filtrar por:</li>
          <li class="border"><a <?php echo $this->input->get('filter') === 'news' ? 'class="current-sel"' : ''  ?> href="<?php echo site_url("$category_url/?filter=news&order=$order"); ?>">novidades</a></li>
          <?php if ($this->session->userdata('id')) { ?>
            <li><a <?php echo $this->input->get('filter') === 'favorites' ? 'class="current-sel"' : ''  ?> href="<?php echo site_url("$category_url/?filter=favorites&order=$order"); ?>">preferidos</a></li>
          <?php } ?>
          <li><a <?php if (($this->input->get('filter') !== 'news') && ($this->input->get('filter') !== 'favorites')) echo 'class="current-sel"'; ?> href="<?php echo site_url($category_url); ?>">tudo</a></li>
        </ul>
      </div>
    </section>

    <!-- products list -->
    <section class="category-container">
      <ul class="category">
        <?php foreach ($products as $product) echo $product->show('product', 'star'); ?>
      </ul>
    </section>
</section>

<?php
printf('<script src="%s?v=%s"></script>', base_url("/assets/js/plugins/jquery.jcarousel.min.js"), VERSION);
?>
<style type="text/css">
/*
This is the visible area of you carousel.
Set a width here to define how much items are visible.
The width can be either fixed in px or flexible in %.
Position must be relative!
*/
.jcarousel {
    position: relative;
    overflow: hidden;
}

/*
This is the container of the carousel items.
You must ensure that the position is relative or absolute and
that the width is big enough to contain all items.
*/
.jcarousel ul {
    width: 20000em;
    position: relative;

    /* Optional, required in this case since it's a <ul> element */
    list-style: none;
    margin: 0;
    padding: 0;
}

/*
These are the item elements. jCarousel works best, if the items
have a fixed width and height (but it's not required).
*/
.jcarousel li {
    /* Required only for block elements like <li>'s */
    float: left;
}
</style>
<script>
$(function() {
  // $('.jcarousel').jcarousel();

  // $('.seta_r').click(function(event) {
  //   event.preventDefault();

  //   $(this).parent().parent().find('.jcarousel').jcarousel('scroll', '+=1');
  // });

  // $('.seta_l').click(function(event) {
  //   event.preventDefault();

  //   $(this).parent().parent().find('.jcarousel').jcarousel('scroll', '-=1');
  // });
});
</script>
