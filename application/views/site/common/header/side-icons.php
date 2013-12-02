<?
  // Define icons properties
  $icons = array(
    'first'  => 'designer|designer',
    'second' => 'supplier|fornecedor',
    'third'  => 'decorator|decorador',
    'fourth' => 'client|cliente',
  );

  // Create icons addresses
  foreach($icons as $key => $value) {
    $name = explode('|', $value);
    $icon_li[] = anchor("site/about/index/{$name[0]}", strtoupper("Sou {$name[1]}"), "class=\"{$key}-icon\"" );
  }

  // Create <ul> mark-up
  echo ul($icon_li, 'class="four-icons"');
?>