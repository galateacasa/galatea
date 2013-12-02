<section class="grid_12 product-page product-top">
  <div class="enter-pwd">

    <!-- title -->
    <h2 class="extra-btm-space"><?php echo  $title ?></h2>

    <!-- input area -->
    <form id="frm-change-password" method="post">
      <ul class="extra-btm-space">

        <?php if( isset($show_password_fields) ): /* Check if the password field need to be showed */ ?>
        <input type="hidden" name="user_id" value="<?php echo $user->id?>">

          <!-- new password -->
          <li>
            <input
              type="password"
              name="password"
              placeholder="nova senha"
              class="search-area"
              id="password"
              value="<?php $this->input->post('password') ?>"
            >
          </li> <!-- /new password -->

          <!-- repeat new password -->
          <li>
            <input
              type="password"
              name="password_repeat"
              placeholder="confirmar nova senha"
              class="search-area"
              id="password_again"
              value="<?php $this->input->post('password_repeat') ?>"
            >
          </li> <!-- /repeat new password -->

        <?php else: /* Show email field */ ?>
          <!-- user email -->
          <li>
            <input
              type="text"
              name="email"
              placeholder="email@provedor.com.br"
              class="search-area"
              id="password"
              value="<?php echo  @$email ?>"
            >
          </li>
        <?php endif; ?>

        <!-- submit button -->
        <li class="omega"><input type="submit" class="submit-btn big" id="pwd-enter" value="ok"></li>

      </ul> <!-- /input area -->
    </form>

    <article class="block extra-top-space" id="welcome-note">
      <span class="note">sua senha foi atualizada com sucesso, você já pode navegar!</span>
      <a href="#" title="link" class="link-btn blue small-link float-l">entrar</a>
    </article>

  </div>
</section>
