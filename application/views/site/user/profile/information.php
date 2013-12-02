<section class="post-info">

  <?php if($user->image): /* Check if have any image */ ?>
    <img
      src="<?php echo  amazon_url("images/users/{$user->image}", 110, 110) ?>"
      alt="<?php echo  $user->name ?>"
      width="110"
      style="float: left;"
    >
  <?php else: ?>
    <figure class="profile-img">&nbsp;</figure>
  <?php endif ?>

  <!-- summary -->
  <article class="post-by-detail">

    <!-- name -->
    <h3>
      <?php echo  $user->name ?>
      <?
        # Pattern fo user description
        $pattern = '<small>%s</small>';

        # Check if the user is a suplier
        if($user->role == 2) printf($pattern, 'Fornecedor');

        # Check if the user is a designer
        if($user->role == 3) printf($pattern, 'Designer');
      ?>

      <?php if( $user->id != $this->session->userdata('id') ): /* Check if the logged user is who is into the page */ ?>
        <span class="star">
          <a
            id="<?php echo  "item_vote_{$user->id}" ?>"
            href="#"
            class="item_vote <?php if($user->user_vote->where('user_voted_id', $this->session->userdata('id') )->get()->exists() ) echo 'active' ?>"
            data-vote-type="users"
            data-vote-id="<?php echo  $user->id ?>">star</a>
        </span>
      <?php endif ?>
    </h3> <!-- /name -->

    <!-- statistics -->
    <ul>

      <?php if( $user->id == 2 or $user->id == 3 ): /* Check if the user is a designer or a supplier */ ?>
        <!-- projects -->
        <li>
          <?php if($user->role == 2): /* Check if the user is a supplier */ ?>
            <span>Produtos produzidos</span>
            <?php echo  $user_products->result_count() ?>
          <?php else: ?>
            <span>Projetos propostos</span>
            <?php echo  $user_projects->result_count() ?>
          <?php endif ?>
        </li>
      <?php endif ?>

      <!-- ambiances -->
      <li>
        <span>Ambientes Postados</span>
        <?php echo  $user_ambiances->result_count() ?>
      </li>

      <!-- users -->
      <li>
        <span>Seguidores</span>
        <?php echo  $user_followers->result_count() ?>
      </li>

      <?
        # Check if this profile is from logged user
        if($user->id == $this->session->userdata('id') )
          echo anchor( site_url('minha-conta'), 'Editar', 'class="edit"');
      ?>

    </ul> <!-- /statistics -->

  </article> <!-- /summary -->

  <!-- description -->
  <article class="grid_7 float-r omega">

    <!-- description text -->
    <p class="extra-btm-space">
      <?php echo  $user->description ?>
    </p>

    <?
      # Check if the logged user is the profile owner
      if($user->id == $this->session->userdata('id') )
        echo anchor( site_url('minha-conta'), 'Editar', 'class="edit"');
    ?>

  </article> <!-- /description -->

</section>
