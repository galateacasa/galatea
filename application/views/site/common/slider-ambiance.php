<!-- common ambiance -->
<li class="ambiance">

  <!-- title -->
  <h3>
    <a ambiance-id="<?php echo $ambiance->id; ?>" href="<?php echo base_url('inspire-me/' . $ambiance->id); ?>" class="ambiance-info">
      <?php echo  $ambiance->title ?>
    </a>
  </h3> <!-- /title -->

  <!-- icon -->
  <span class="<?php echo  $icon . $activation ?>"><?php echo  $icon == 'star' ? '&nbsp;' : 'X' ?></span>

  <!-- image -->
  <figure>
    <a ambiance-id="<?php echo $ambiance->id; ?>" href="<?php echo base_url('inspire-me/' . $ambiance->id); ?>" class="ambiance-info">
      <?php echo  img( amazon_url("images/ambiances/{$ambiance->image}", 218, 137) ) ?>
    </a>
  </figure> <!-- /image -->

  <?php echo  $social_links->get( $ambiance->title, $ambiance->title, amazon_url("images/ambiances{$ambiance->image}"), site_url("ambiances") ); ?>
  <?php echo  $vote_button->get($ambiance->id, 'ambiances', $icon); ?>

  <div class="white-box">
    <figure>

      <!-- user information -->
      <figcaption>
        <!-- username -->
        <?php echo  anchor("perfil/{$ambiance->user->username}", "Por {$ambiance->user->name}") ?>

        <!-- category -->
        <mark>
          <?php echo  anchor("site/categories/show/{$ambiance->category_id}", $ambiance->category->name) ?>
        </mark>
      </figcaption> <!-- /user information -->

      <!-- user image -->
      <?php if($ambiance->user->image): /* Check if have any image */ ?>
        <?php echo  anchor("perfil/{$ambiance->user->username}", img( amazon_url("images/users/{$ambiance->user->image}", 40, 40) ) ) ?>
      <?php endif ?>

    </figure>
  </div>

</li> <!-- /common ambiance -->
