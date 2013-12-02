<?php

if (!function_exists('pt_to_mysql_date')) {

  function pt_to_mysql_date($date, $separator = "/") {
    $date = explode("/", $date);
    return $date[2] . "-" . $date[1] . "-" . $date[0];
  }

}

if (!function_exists('transaction_to_literal')) {

  function transaction_to_literal($transaction) {

    return $transaction == 1?"Crédito":"Débito";
  }

}

if (!function_exists('role_to_literal')) {

  function role_to_literal($role) {
    $literal = "";
    switch ($role) {
      case '1':
        $literal = "Admin";
        break;

      case '2':
        $literal = "Fornecedor";
        break;
      case '3':
        $literal = "Designer";
        break;
      case '4':
        $literal = "Decorador";
        break;
      case '5':
        $literal = "Cliente";
        break;
    }
    return $literal;
  }
}

if (!function_exists('disponibility_status_to_literal')) {

  function disponibility_status_to_literal($role) {
    $literal = "";
    switch ($role) {
      case '0':
        $literal = "Novo";
        break;

      case '1':
        $literal = "Aprovado";
        break;
      case '2':
        $literal = "Rejeitado";
        break;
      default:
        $literal = "Novo";
        break;
    }
    return $literal;
  }
}

if(!function_exists('validate_CNPJ')){
  function validate_CNPJ($cnpj){
    if (strlen($cnpj) != 18) return 0;
    $soma1 = ($cnpj[0] * 5) +
      ($cnpj[1] * 4) +
      ($cnpj[3] * 3) +
      ($cnpj[4] * 2) +
      ($cnpj[5] * 9) +
      ($cnpj[7] * 8) +
      ($cnpj[8] * 7) +
      ($cnpj[9] * 6) +
      ($cnpj[11] * 5) +
      ($cnpj[12] * 4) +
      ($cnpj[13] * 3) +
      ($cnpj[14] * 2);
    $resto = $soma1 % 11;
    $digito1 = $resto < 2 ? 0 : 11 - $resto;
    $soma2 = ($cnpj[0] * 6) +

      ($cnpj[1] * 5) +
      ($cnpj[3] * 4) +
      ($cnpj[4] * 3) +
      ($cnpj[5] * 2) +
      ($cnpj[7] * 9) +
      ($cnpj[8] * 8) +
      ($cnpj[9] * 7) +
      ($cnpj[11] * 6) +
      ($cnpj[12] * 5) +
      ($cnpj[13] * 4) +
      ($cnpj[14] * 3) +
      ($cnpj[16] * 2);
    $resto = $soma2 % 11;
    $digito2 = $resto < 2 ? 0 : 11 - $resto;
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));

  }
}
if(!function_exists('remove_mask')){
  function remove_mask($string){
    $sinais = array('(',')','-',' ','+','.','/');
    return str_replace($sinais, '', $string);
  }
}


?>
