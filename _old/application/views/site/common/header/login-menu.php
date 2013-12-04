<ul>

  <!-- login -->
  <?php if( $this->session->userdata('id') ): $menu_user_name = explode(" ", $this->session->userdata('name') ) ?>

    <li>

      <a href="" class="padd-new">Ol&#225; <?php echo  $menu_user_name[0] ?></a>

      <div class="drop-down">
        <ul>
          <li>
            <?php echo  anchor('perfil/' . $this->session->userdata('username'), 'Meu Perfil') ?>
          </li>
          <li>
            <?php echo  anchor('minha-conta', 'Minha Conta') ?>
          </li>
          <li>
            <?php echo  anchor('meus-creditos', 'Meus Cr&#233;ditos') ?>
          </li>
          <li>
            <?php echo  anchor('meus-pedidos', 'Meus Pedidos') ?>
          </li>
            <?php if($this->session->userdata('role') == 2): /* The logged in user is a supplier? */ ?>
              <li>
                <?php echo  anchor('quero-produzir', 'Quero produzi') ?>
              </li>
            <?php endif ?>
          <li>
            <?php echo  anchor('sair', 'Logout') ?>
          </li>

        </ul>
      </div>

    </li>

  <?php else: ?>
    <li>
      <a href="<?php echo  site_url('login'); ?>" class="padd-new">Entrar</a>
    </li>
  <?php endif ?>

  <?php if( $this->session->userdata('id') ): /* Check if the logged user is a designer */ ?>
    <!-- send -->
    <li>

      <!-- dropdown title -->
      <a href="#"><span>Enviar</span></a>

      <!-- dropdown -->
      <div class="drop-down">
        <ul>

          <!-- ambiance -->
          <li>
            <a href="javascript:void(0)" id="ambiance-add-image">Enviar Ambiente</a>
          </li>

          <!-- project -->
          <li>
            <?php echo  anchor('criar-projeto', 'Enviar Projeto') ?>
          </li>

        </ul>
      </div> <!-- /dropdown -->

    </li> <!-- /send -->
  <?php endif ?>
</ul>
