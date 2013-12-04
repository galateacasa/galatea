<div class="container_12 content">

  <section class="grid_11 float-r">
    <section class="login-fields">
      <form method="post" action="<?php echo  site_url('login'); ?>">
        <div class="block" style="display: block;">
          <h2>Login</h2>
          <input type="text" class="search-area email" placeholder="email" name="email" value="" >
        </div>
        <div class="block" style="display: block;">
          <input type="password" class="search-area pwd float-l" placeholder="senha" name="password" value="" >
          <input class="button float-r" type="submit" value="login">
        </div>

        <div class="grid_4">
          <!-- forgot password -->
          <a href="<?php echo  site_url('esqueci-minha-senha') ?>">esqueceu sua senha?</a>

          <div class="custom-checkbox">
            <input type="checkbox" name="keep_logged" id="check-1" value="1">
            <label for="check-1" class="">manter logado</label>
          </div>
        </div>
      </form>
    </section>

    <div class="grid_4 connect-fb">
      <h2>Login via Facebook</h2>
      <a href="<?php echo  site_url('login/facebook_login'); ?>"><img src="<?php echo  assets_url('images/icon-fb.jpg'); ?>"  title="fb-login"></a>
    </div>
  </section>
</div>

<!-- Login Fields -->
<div class="login-division">
  <section class="container_12">

    <!-- Tabbing -->
    <section class="grid_11 tabbing float-r">
      <?php echo  $this->input->get('supplier') ? '<input id="from-supplier" type="hidden" value="true">' : '' ?>
      <?php echo  $this->input->get('designer') ? '<input id="from-designer" type="hidden" value="true">' : '' ?>
      <?php echo  $this->input->get('decorator') ? '<input id="from-decorator" type="hidden" value="true">' : '' ?>
      <nav>
        <ul id="click">
          <li><h2><a>Ou Cadastre-se!</a></h2></li>
          <li><a href="javascript:void(0)" class="s-designer active" id="tab-a">SOU DESIGNER</a></li>
          <li><a href="javascript:void(0)" class="s-client"  id="tab-b">SOU CLIENTE</a></li>
          <li><a href="javascript:void(0)" class="s-supplier"  id="tab-c">SOU FORNECEDOR</a></li>
          <li><a href="javascript:void(0)" class="s-decorator"  id="tab-d">SOU DECORADOR</a></li>
        </ul>
      </nav>

      <form name="frm_new_user" id="frm_new_user" method="post" action="<?php echo  site_url('site/users/create'); ?>" autocomplete="off">

        <input type="hidden" name="role" id="role" value="3" />
        <!-- tabbing first -->
        <div class="tabbing-content" id="tabbin-a">

          <div class="up-image-box">

            <figure class="upload-frame">
              <figcaption>foto</figcaption>
              <span id="user_drop_image" class="frame">
                Arraste a imagem para esta área
              </span>
              <small id="user_drop_image_response">&nbsp;</small>
            </figure>

            <div class="file-submit file-upload-inline">
              <input type="file" name="file" id="user_image" class="file-upload-styled" />
            </div>

          </div>

          <div class=" login-forms grid_6 omega">
            <div class="blocks">
              <span>
                <em class="imp">&nbsp;</em>
                <input type="text" class="search-area float-l no-bg-img name-text" placeholder="nome" value="" id="name" name="name"></span>
                <span  class=" omega">
                  <em class="imp">&nbsp;</em>
                  <input type="text" class="search-area float-l no-bg-img sur-name" placeholder="sobrenome" value=""  name="surname" id="surname"></span>
                </div>
                <div class="blocks">
                  <span>
                    <em class="imp">&nbsp;</em>
                    <input type="text" class="search-area float-l no-bg-img equal-text" placeholder="email" value="" id="email" name="email"></span>
                    <span  class=" omega">
                      <em class="imp">&nbsp;</em>
                      <input type="text" class="search-area float-l no-bg-img equal-text" placeholder="confirmar email" id="confirm_email" value=""  name="confirm_email"></span>
                    </div>

                    <div class="blocks">
                      <span>
                        <em class="imp">&nbsp;</em>
                        <input type="password" class="search-area float-l no-bg-img equal-text" placeholder="senha" value="" id="pass" name="pass"></span>
                        <span class=" omega">
                          <em class="imp">&nbsp;</em>
                          <input type="password" class="search-area float-l no-bg-img equal-text" placeholder="confirmar senha" id="confirm_pass" value="" name="confirm_pass"></span>
                        </div>
                      </div>

                      <div class="msg-box" style="display: none;">
                        <textarea rows="5" name="description" placeholder="escreva algums palavras sobre você (esse texto aparecerá no seu perfil público)"  class="msg"></textarea>
                      </div>

                      <div id="enterprise" class="ignore" style="display: none;">
                        <section class="grid_10 alpha login-forms border-hrz">
                          <h2>Dados da empresa</h2>

                          <div class="blocks no-pad-left">
                            <span class=" omega">
                              <em class="imp">&nbsp;</em>
                              <input type="text" placeholder="razão social" value="" id="company_name" name="company_name" class="search-area float-l no-bg-img sur-name grid_6 alpha">
                            </span>
                          </div>

                          <div class="blocks no-pad-left">
                            <span class=" omega">
                              <em class="imp">&nbsp;</em>
                              <input type="text" placeholder="cnpj" name="cnpj" id="cnpj" value="" class="search-area float-l no-bg-img sur-name grid_3 alpha cnpj">
                            </span>
                          </div>
                        </section>
                        <!-- company data -->
                        <section class="grid_10 alpha login-forms extra-btm-space ">

                          <div class="blocks no-pad-left">

                            <label class="chose">Dados da empresa</label>

                            <div class="report-box custom-select no-margin">
                              <select class="styled" id="selector" name="selector">
                                <option value="">Selecione a sua área de atuação</option>
                                <?php foreach($expertises as $expertise): ?>
                                  <option value="<?php echo  $expertise->id; ?>"><?php echo  $expertise->name; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                          </div>

                          <div class="blocks no-pad slector-con"  id="toshow" style="display:none;">
                            <span class="note float-l extra-top-space extra-btm-space">Clique uma vez para selecionar e outra para cancelar a seleção das funções que você desempenha</span>
                            <ul class="field-links" id="field-links"></ul>
                          </div>

                        </section>

                      <section class="grid_10 alpha login-forms border-top extra-top-space addr">
                        <h2>endereço</h2>
                        <div class="blocks no-pad-left">
                          <span class=" omega">
                            <em class="imp">&nbsp;</em>
                            <input type="text" name="zip" id="zip" class="search-area float-l no-bg-img grid_3 omega alpha cep" placeholder="cep" value="">
                          </span>

                          <span class=" omega">
                            <label class="float-l">
                              <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do">Não sabe seu CEP?</a>
                            </label>
                            <input type="text" class="search-area name-text float-l no-bg-img  grid_2 omega areaCode" name="areaCode" id="areaCode" placeholder="DDD" value="">
                            <em class="imp">&nbsp;</em>
                            <input type="text" class="search-area float-l no-bg-img  grid_2 omega phone" name="phone" id="phone" placeholder="telefone" value="">
                          </span>
                        </div>

                        <div class="blocks no-pad-left">
                          <span class="">
                            <em class="imp">&nbsp;</em>
                            <input type="text" name="street" id="street" value="" placeholder="rua/avenida" class="search-area float-l no-bg-img grid_4 alpha">
                          </span>

                          <span class="">
                            <em class="imp">&nbsp;</em>
                            <input type="text" class="search-area float-l no-bg-img  name-text" id="number" name="number" placeholder="número" value="">
                          </span>

                          <span class="">
                            <input type="text" class="search-area float-l no-bg-img  name-text alpha" name="complement" placeholder="complemento" value="">
                          </span>
                        </div>

                        <div class="blocks no-pad-left">
                          <span class="omega">
                            <select class="styled" id="state" name="state"></select>
                          </span>

                          <span class="omega">
                            <select class="styled" id="city" name="city"></select>
                          </span>
                        </div>

                        <div class="blocks no-pad-left">
                          <span class="">
                            <input type="text" class="search-area float-l no-bg-img  name-text alpha" name="country" placeholder="país" value="">
                          </span>
                        </div>
                      </section>
                    </div>

                  </div>
                  <!-- end tabbing first -->

                </section>
                <!-- End Tabbing -->

                <section class="grid_7 float-r accept-terms omega" style="margin-right:40px;">
                  <!--<a href="#" class="link-btn blue float-r ">CADASTRAR</a>-->
                  <button type="submit" class="button float-r">CADASTRAR</button>
                  <span class="grid_4 terms-con alpha float-r">
                    Clicando em CADASTRAR, você estará concordando com os <?php echo  anchor('institucional/termos-e-condicoes', 'Termos do site', 'target="_blank"') ?> e que você leu nossa <?php echo  anchor('institucional/termos-e-condicoes#privacidade', 'política de uso de informações', 'target="_blank"') ?>, incluindo o relacionado a Cookies.
                  </span>
                </section>
              </form>
            </section>
          </div>
          <!-- LOgin Fields -->

          <!--footer start here-->
          <footer class="footer-main">
            <section class="container_12">
              <section class="grid_12">

                <!-- tips -->
                <nav>
                  <ul>
                    <?
                      // Define links informations
                      $footer_links = array(

                        'tips' => array(
                          'href'  => 'institucional/cuidados-com-a-mobilia',
                          'label' => 'Cuidados com a mobília',
                        ),

                        'returns' => array(
                          'href'  => 'institucional/trocas-e-devolucoes',
                          'label' => 'Trocas e Devoluções',
                        ),

                        'terms' => array(
                          'href'  => 'institucional/termos-e-condicoes',
                          'label' => 'Termos e Condições',
                        ),

                        'payments' => array(
                          'href'  => 'institucional/formas-de-pagamento',
                          'label' => 'Pagamento e Entrega',
                        ),

                        'privacity' => array(
                          'href'  => 'institucional/termos-e-condicoes#privacidade',
                          'label' => 'Política de Privacidade',
                        ),

                      );

                      # Print all links addresses
                      foreach($footer_links as $link)
                        printf("<li><a href=\"%s\">%s</a></li>", base_url($link['href']), $link['label']);
                    ?>
                  </ul>
                </nav> <!-- /tips -->

                <!-- social network -->
                <section class="footer-mid">
                  <h4>Siga em outras redes:</h4>
                  <ul>
                    <li><a href="http://pinterest.com/galateacasa/" target="_blank">pinterst</a></li>
                    <li><a href="https://www.facebook.com/GalateaCasa" class="facebook" target="_blank">facebook</a></li>
                  </ul>
                </section> <!-- /social network -->

                <!-- newsletter + copyright + back to top -->
                <aside>

                  <!-- title -->
                  <h4>NewsLetter</h4>

                  <!-- newsletter + back to top -->
                  <div class="inpt-out">

                    <!-- newsletter -->
                    <?php echo  form_open('site/home/newsletter') ?>
                      <input class="button-newsletter float-l" type="text" placeholder="e-mail" name="email" >
                      <input type="submit" class="button float-r" value="OK">
                    <?php echo  form_close() ?>

                    <!-- back to top -->
                    <a href="#top" class="back-top-top" onmouseover="tooltip.show('voltar ao topo');" onmouseout="tooltip.hide();">&nbsp;</a>

                  </div>

                  <!-- copyright -->

                  <em>Galatea Casa © Todos os direitos reservados.</em>
                </aside> <!-- /newsletter + copyright + back to top -->

              </section>
            </section>
          </footer>
          <!--footer ends here-->


          <?

            # Scripts to be included
            $scripts = array(
              'lib/jquery-ui-1.9.2.custom.min',
              'plugins/jquery.fileinput',
              'plugins/customSelect.jquery',
              'plugins/jquery.jqEasyCharCounter',
              'plugins/jquery.filedrop',
              'plugins/jquery.ae.image.resize.min',
              'plugins/jquery.maskedinput',
              'plugins/jquery.validate',
              'plugins/customInput.jquery',
              'site/address_search',
              'site/Dropdown',
              'site/upload_box',
              'site/login/login',
              'plugins/noty/jquery.noty',
              'plugins/noty/layouts/bottom',
              'plugins/noty/layouts/bottomCenter',
              'plugins/noty/layouts/bottomRight',
              'plugins/noty/layouts/center',
              'plugins/noty/layouts/centerLeft',
              'plugins/noty/layouts/centerRight',
              'plugins/noty/layouts/inline',
              'plugins/noty/layouts/top',
              'plugins/noty/layouts/topLeft',
              'plugins/noty/layouts/topRight',
              'plugins/noty/layouts/topCenter',
              'plugins/noty/themes/default'
            );

            # Script tag pattern
            $pattern = "<script type=\"text/javascript\" src=\"%s\"></script>";

            # Include all scripts
            foreach($scripts as $script) printf($pattern, assets_url("js/$script.js") );


          ?>

          <script type="text/javascript">
            $(document).ready(function() {

              // Get Amazon URL
              var url = window.location.protocol + '//' + window.location.hostname + '/';
              $.getJSON( url + 'ajax/common/get_amazon_url', function(urls) {
                // User image
                new upload_box('user_drop_image', 'user_drop_image_response', 'images/users', urls.user, 1, '', '', 160, '', 'user_image');
              });

              <?
              if($this->session->flashdata('error') || $this->session->flashdata('success')){
                $type = ($this->session->flashdata('error')) ? "error" : "success";

                $msg = str_replace(array("\r\n", "\r", "\n"), "", $this->session->flashdata($type));
                ?>
                noty({
                  type: "<?php echo  $type?>",
                  text: "<?php echo  $msg ?>",
                  layout: 'topLeft',
                  timeout: 10000
                });
                <?
              }
              ?>
            });
          </script>

  </body>

</html>
