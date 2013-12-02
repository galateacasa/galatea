<nav>
  <ul>
    <?php
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

      // Print all links addresses
      foreach($footer_links as $link)
        printf('<li><a href="%s">%s</a></li>', base_url($link['href']), $link['label']);
    ?>
  </ul>
</nav>