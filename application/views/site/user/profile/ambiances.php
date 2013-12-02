<!-- black overlay -->
<div class="overlay upload-page-popup" ></div>

<!-- pop-up section to receive content -->
<section class="pop-block-extended"></section>

<div class="grid_12">

  <!-- title -->
  <h2 id="ambiance" class="profile-tab">

    <!-- user starred -->
    <a
      class="filter activate"
      data-hide="carousel-ambiance-mine"
      data-show="carousel-ambiance-starred"
      data-section="ambiance"
      href="#"
    >Ambientes Preferidos</a>

    <!-- from user -->
    <a
      class="filter border"
      data-hide="carousel-ambiance-starred"
      data-show="carousel-ambiance-mine"
      data-section="ambiance"
      href="#"
    ><?php echo  $user->id == $this->session->userdata('id') ? 'Meus ambientes' : "Ambientes enviados" ?></a>

  </h2> <!-- /title -->

  <!-- starred -->
  <section id="carousel-ambiance-starred">
    <div class="horizontal-slider-container">

      <!-- carousel -->
      <div class="horizontal-slider-content">
        <ul class="horizontal-slider">

          <?php if( !$user_ambiances_starred->exists() ): /* Check if the user have any ambiance */ ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner */ ?>

              <?php $lis-- ?>

              <!-- default ambiance -->
              <li class="no-data ambiance">
                <?php echo  heading('você ainda não possui <br> ambientes selecionados', 2) ?>
                <div>faça a <img src="/assets/images/rate.png" alt="Estrela"> brilhar nos <br> ambientes que mais gosta</div>
                <?php echo  anchor('inspire-me', 'Inspire-me') ?>
              </li>

            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              foreach( $user_ambiances_starred as $user_ambiance_starred ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $user_ambiance_starred->show($action);
              }

              if ( $user_ambiances_starred->result_count() < 4 )
                echo str_repeat( '<li class="empty"></li>', 4 - $user_ambiances_starred->result_count() );
            ?>


          <?php endif ?>

        </ul>
      </div> <!-- /carousel -->

      <?php if( $user_ambiances_starred->result_count() > 4): /* Check if the arrows are necessary */ ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div>
  </section> <!-- /starred -->

  <!-- from him -->
  <section id="carousel-ambiance-mine" class="hide">
    <div class="horizontal-slider-container">

      <!-- carousel -->
      <div class="horizontal-slider-content">
        <ul class="horizontal-slider">

          <?php if( !$user_ambiances->exists() ): /* Check if the user have any ambiance */ ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner */ ?>

              <?php $lis-- ?>

              <!-- default ambiance -->
              <li class="no-data ambiance">
                <?php echo  heading('Você ainda não possui <br> ambientes selecionados', 2) ?>
                <div class="msg">
                  Você ainda não enviou ambientes <br>
                  Envie suas imagens e ganhe 1% de comissão a cada venda que elas gerarem
                </div>
                <?php echo  anchor('institucional/ganhe-creditos', 'Saiba mais') ?>
              </li>

            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              foreach( $user_ambiances as $user_ambiance ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $user_ambiance->show($action);
              }

              if ( $user_ambiances->result_count() < 4 )
                echo str_repeat('<li class="empty"></li>', 4 - $user_ambiances->result_count() );
            ?>

          <?php endif ?>

        </ul>
      </div> <!-- /carousel -->

      <?php if( $user_ambiances->result_count() > 4): /* Check if the arrows are necessary */ ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div>
  </section> <!-- /from him -->

</div>
