<section class="about">

  <h2>MAPA DO SITE</h2>

  <p>Aqui você encontra um atalho para todas as seções do site.</p>

  <ul>
    <li><?php echo  anchor('categoria/vote', 'Vote!') ?></li>

    <h3>Por Ambiente</h3>

    <li><?php echo  anchor('categoria/novidades', 'Novidades') ?></li>
    <li><?php echo  anchor('categoria/sala-de-estar', 'Sala de Estar') ?></li>
    <li><?php echo  anchor('categoria/sala-de-jantar', 'Sala de Jantar') ?></li>
    <li><?php echo  anchor('categoria/quarto', 'Quarto') ?></li>
    <li><?php echo  anchor('categoria/home-office', 'Home Office') ?></li>
    <li><?php echo  anchor('categoria/exterior', 'Exterior') ?></li>
    <li><?php echo  anchor('categoria/iluminacao', 'Iluminação') ?></li>
    <li><?php echo  anchor('categoria/decoracao-e-acessorios', 'Decoração e Acessórios') ?></li>
  </ul>

  <ul>
    <h3>Por produto</h3>

    <?
      $categories_map = array(

        array(
          'main'  => 'quarto',
          'sub'   => 'abajur',
          'label' => 'Abajures'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'banco-e-banqueta',
          'label' => 'Bancos e banquetas'
        ),

        array(
          'main'  => 'sala-de-jantar',
          'sub'   => 'buffet',
          'label' => 'Buffets'
        ),

        array(
          'main'  => 'sala-de-jantar',
          'sub'   => 'cadeira',
          'label' => 'Cadeiras'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'carrinho-de-cha',
          'label' => 'Carrinhos de chá'
        ),

        array(
          'main'  => 'decoracao-e-acessorios',
          'sub'   => '',
          'label' => 'Decoração e acessórios'
        ),

        array(
          'main'  => 'iluminacao',
          'sub'   => 'luminaria-de-chao',
          'label' => 'Luminárias de chão'
        ),

        array(
          'main'  => 'iluminacao',
          'sub'   => 'luminaria-de-mesa',
          'label' => 'Luminárias de mesa'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'mesa-de-centro',
          'label' => 'Mesas de centro'
        ),

        array(
          'main'  => 'sala-de-jantar',
          'sub'   => 'mesa-de-jantar',
          'label' => 'Mesas de jantar'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'mesa-lateral',
          'label' => 'Mesa laterais'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'poltrona',
          'label' => 'Poltronas'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'pufe',
          'label' => 'Pufes'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'rack',
          'label' => 'sala-de-estar'
        ),

        array(
          'main'  => 'sala-de-estar',
          'sub'   => 'sofa',
          'label' => 'Sofás'
        )

      );

      foreach($categories_map as $category_map) {
        $url = anchor("categoria/{$category_map['main']}/{$category_map['sub']}", $category_map['label']);
        printf('<li>%s</li>', $url);
      }


    ?>
  </ul>

</section>
