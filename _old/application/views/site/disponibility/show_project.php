<section class="container_12">
  <!-- banner -->
  <section class="grid_12">
    <!-- main image -->
    <div class="add-large-img extra-btm-space">
      <ul id="large_images">
<?php
foreach ($project->item_image->get() as $image) {
?>
          <li class="" id="img0">
            <figure>
              <!-- title -->
              <figcaption>
                <h3>
<?php
  echo $project->name;
  echo br(1);
  echo anchor("perfil/{$project->user->username}", "Por: {$project->user->name} {$project->user->surname}");
?>
                  <!-- total votes -->
                  <span class="vote-count">
<?php
  // Define total votes for the project
  $votes = $project->item_vote->where('item_id', $project->id)->count();

  // Define the text pattern
  $pattern = '%s <span>voto%s</span>';

  // Check if has only 1 vote
  if ($votes == 1) {
    printf($pattern, $votes, '');
  } else {
    printf($pattern, $votes, 's');
  }
?>
                  </span>
                  <!-- /total votes -->
                </h3>
              </figcaption>
              <!-- /title -->
              <!-- image -->
              <img src="<?php echo  amazon_url('images/items/' . $image->image, 940, 460); ?>" alt="<?php echo  $project->name; ?>" />
              <!-- /image -->
<?php
  if ($user->role == 2) {
?>
                <!-- call to vote -->
                <span class="vote vote-banner">
                  <?php echo  anchor( base_url('site/items/build/' . $project->id), 'QUERO PRODUZIR ESTE PROJETO', 'class="no-bg-img"') ?>
                </span>
<?php
  } else {
?>
                <!-- social icons -->
<?php
  //echo $socialLinks;
?>
                <!-- call to vote -->
                <span class="vote vote-banner">
                  <a id="<?php echo  'item_vote_' . $project->id; ?>" href="#" class="item_vote" data-vote-type="items" data-vote-id="<?php echo  $project->id; ?>" />VOTE</a>
                </span>
<?php
  }
?>
            </figure>
          </li>
<?php
}
?>
      </ul>
    </div>
    <!-- /main image -->


    <!-- thumbnails -->
    <div class="add-img-small extra-btm-space">
        <ul id="thumb_holder">
<?php
$index = 1;
foreach ($project->item_image->get() as $thumbnail) {
?>
          <li class="grid_2 alpha" style="<?php echo  ($index == 5) ? "margin:0;" : "" ?>">
            <a href="javascript:ovid(0);">
              <img src="<?php echo  amazon_url('images/items/' . $thumbnail->image, 140, 70); ?>" alt="<?php echo  $project->name; ?>" />
            </a>
          </li>
<?php
$index++;
}
?>
        </ul>
    </div>
    <!-- /thumbnails -->
  </section>
  <!-- /banner -->
</section>

<!-- about item + about design + technical details -->
<section class="container_12 extra-btm-space">
  <!-- about item -->
  <section class="grid_6">
    <!-- title -->
    <h2 class="extra-btm-space extra-top-space">Sobre o produto</h2>
<?php
$paragraphs = explode("\n", $project->description);
foreach($paragraphs as $paragraph) {
?>
      <p class="extra-btm-space">
        <?php echo  $paragraph; ?>
      </p>
<?php
}
?>
  </section>
  <!-- /about item -->
  <!-- about design + technical details -->
  <section class="grid_6 omega extra-top-space">
    <!-- about the designer -->
    <section class="grid_6 omega alpha extra-btm-space">
<?php
if($project->user->image) {
?>
      <img src="<?php echo  amazon_url('images/users/' . $project->user->image); ?>" alt="<?php echo  $project->user->name; ?>" width="80" height="85" style="float: left;" />
<?php
} else {
?>
      <figure class="profile-img">&nbsp;</figure>
<?php
}
?>
      <!-- designer description -->
      <article class="profile-des">
          <h2>
            Designer
            <small>
              <a href="<?php echo  site_url("perfil/{$project->user->username}"); ?>">
                <?php echo  "{$project->user->name} {$project->user->surname}"; ?>
              </a>
            </small>
          </h2>
          <p><?php echo  $project->user->description; ?></p>
      </article>
    </section>
    <!-- /about the designer -->
    <!-- technical information -->
    <section class="grid_6 omega alpha no-under-l">
      <!-- title -->
      <h2 class="extra-btm-space">Informações técnicas</h2>
      <h3>Medidas</h3>
<?php
foreach ($project->Item_Variation_Measurement->get() as $measure) {
?>
        <!-- width -->
        <p><?php echo  'Largura: ' . $measure->width . 'cm'; ?></p>
        <!-- height -->
        <p><?php echo  'Altura: ' . $measure->height . 'cm'; ?></p>
        <!-- depth -->
        <p><?php echo  'Profundidade: ' . $measure->depth . 'cm'; ?></p>
        <br>
<?php
}
?>
      <h3>Acabamentos</h3>
<?php
foreach ($project->Item_Variation_Material->get() as $material) {
?>
        <p><?php echo  $material->material; ?></p>
        <br>
<?php
}
?>
    </section>
    <!-- /technical information -->
  </section>
  <!-- /about design + technical details -->
</section>
<!-- /about item + about design + technical details -->
<!-- message reviews -->
<section class="container_12">
  <section class="grid_12 extra-btm-space">
    <?php echo  $message->get(); ?>
  </section>
</section>
<!-- /message reviews -->
<!-- vote History -->
<!-- <section class="container_12">
  <div class="grid_12 extra-btm-space vote-chart">
    <h2>histórico de votos</h2> -->
    <!-- div that will have the chart inside -->
    <!-- <div id="chart_div"></div> -->
  <!-- </div> -->
<!-- </section> -->
<!-- /vote History -->
