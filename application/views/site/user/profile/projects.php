<div class="grid_12">

  <!-- title -->
  <h2 id="project" class="profile-tab">

    <a
      class="filter activate"
      data-hide="carousel-project-mine"
      data-show="carousel-project-starred"
      data-section="project"
      href="#carousel-project-starred"
    >Projetos Preferidos</a>

    <a
      class="filter border"
      data-hide="carousel-project-starred"
      data-show="carousel-project-mine"
      data-section="project"
      href="#carousel-project-mine"
    ><?php echo  $user->id == $this->session->userdata('id') ? 'Meus projetos' : "Projetos propostos" ?></a>

  </h2> <!-- /title -->

  <!-- starred projects -->
  <section id="carousel-project-starred">
    <div class="horizontal-slider-container">

      <!-- content -->
      <div class="horizontal-slider-content">
        <ul id="carousel-project-star" class="horizontal-slider">

          <?php if( !$user_projects_starred->exists() ): ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner */ ?>
              <?php $lis-- ?>

              <!-- default project -->
              <li class="no-data project">
                <?php echo  heading('você ainda não votou <br> em nenhum projeto', 2) ?>
                <div class="msg">os mais votados viram produtos <br> e você ganha 5% de desconto!</div>
                <?php echo  anchor('site/categories/show_projects', 'vote') ?>
              </li>

            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              # Lista all projects
              foreach( $user_projects_starred as $project ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $project->show('project', $action);
              }

              if ( $user_projects_starred->result_count() < 4)
                echo str_repeat( '<li class="empty"></li>', 4 - $user_projects_starred->result_count() );
            ?>

          <?php endif ?>

        </ul>
      </div> <!-- /content -->

      <?php if( $user_projects_starred->result_count() > 4): /* Check if the arrows are necessary */ ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div>
  </section> <!-- /starred projects -->

  <!-- user projects -->
  <section id="carousel-project-mine" class="hide">
    <div class="horizontal-slider-container">

      <!-- carousel -->
      <div class="horizontal-slider-content">
        <ul id="carousel-project-my" class="horizontal-slider">

          <?php if( !$user_projects->exists() ): /* Check if the user have any project */  ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner */ ?>

              <?php $lis-- ?>

              <!-- default project -->
              <li class="no-data project">
                <?php echo  heading('Você não possui projetos', 2) ?>
                <div class="msg">Poste e divulgue seus projetos <br> para eles virarem produtos</div>
                <?php echo  anchor('#', 'Saiba mais') ?>
              </li> <!-- /default project -->

            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              /* Lista all projects */
              foreach( $user_projects as $user_project ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $user_project->show('project', $action);
              }

              if ( $user_projects->result_count() < 4 )
                echo str_repeat( '<li class="empty"></li>', 4 - $user_projects->result_count() );
            ?>

          <?php endif ?>

        </ul>
      </div> <!-- /carousel -->

      <?php if( $user_projects->result_count() > 4): /* Check if the arrows are necessary */ ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div>
  </section> <!-- /user projects -->

</div>
