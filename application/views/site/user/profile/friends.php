<section class="grid_6 alpha">

  <!-- title -->
  <h2 id="follow" class="profile-tab">

    <a class="filter activate" data-show="following" data-hide="followers" href="#">Seguindo</a>
    <a class="filter border" data-show="followers" data-hide="following" href="#">Seguidores</a>

  </h2>

  <!-- following -->
  <article id="following" class="post-block comments blog-box">
    <ul id="content_2" class="comments">

      <?php if( $user_following->result_count() > 0 ): /* Check if the user follow someone */ ?>

        <?php foreach( $user_following as $following ): /* list all following */ ?>
          <li>
            <a href="<?php echo  base_url("perfil/{$following->user->username}") ?>">
              <figure>

                <?php echo  img( amazon_url("images/users/{$following->user->image}", 80, 80) ) ?>

                <?php if( $user->id == $this->session->userdata('id') ): /* check if profile owner is logged in */ ?>
                  <figcaption class="close_following">
                    Desconectar
                    <a id="<?php echo  "following_vote_{$following->user->id}" ?>" href="#" class="item_vote close-btn" data-vote-type="users" data-vote-id="<?php echo  $following->user->id ?>">&nbsp;</a>
                  </figcaption>
                <?php endif ?>

              </figure>
            </a>
          </li>
        <?php endforeach ?>

      <?php else: ?>
        <?php $pattern = '%s não segue ninguém.' ?>
        <?php echo  $user->id == $this->session->userdata('id') ? sprintf($pattern, 'Você') : sprintf($pattern, $user->name) ?>
      <?php endif ?>
    </ul>
  </article> <!-- /following -->

  <!-- followers -->
  <article id="followers" class="post-block comments blog-box hide">
    <ul id="content_2" class="comments">

      <?php if( $user_followers->result_count() > 0 ): /* Check if someone follow the user */ ?>

        <?php foreach( $user_followers as $follower ): /* list all followers */ ?>
          <li>
            <a href="<?php echo  base_url("perfil/{$follower->user->username}") ?>">
              <figure>

                <?php echo  img( amazon_url("images/users/{$follower->user->image}", 80, 80) ) ?>

                <?php if( $user->id == $this->session->userdata('id') ): /* check if profile owner is logged in */ ?>
                <!--
                  <figcaption>
                    Desconectar <a class="close-btn" href="#">&nbsp;</a>
                  </figcaption>
                -->
                <?php endif ?>

              </figure>
            </a>
          </li>
        <?php endforeach ?>

      <?php else: ?>
        Nenhum seguidor.
      <?php endif ?>
    </ul>
  </article> <!-- /followers -->

  <?php echo  br(2) ?>

</section>
