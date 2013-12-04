<?php

function get_statuses_pagseguro() {
  $status_array = array(
      '1' => 'Aguardando pagamento',
      '2' => 'Em análise',
      '3' => 'Paga',
      '4' => 'Disponível',
      '5' => 'Em disputa',
      '6' => 'Devolvida',
      '7' => 'Cancelada',
      '8' => 'Tentativa de Fraude',
  );

  return $status_array;
}

function status_to_literal_pagseguro($status) {
  $status_array = get_statuses_pagseguro();

  if (isset($status_array[$status])) {
    return $status_array[$status];
  } else {
    return $status;
  }
}

function get_payments_pagseguro() {
  $payments_array = array(
      '1' => 'Cartão de Crédito',
      '2' => 'Boleto',
      '3' => 'Débito online (TEF)',
      '4' => 'Saldo PagSeguro',
      '5' => 'Oi Paggo',
  );

  return $payments_array;
}

function payment_to_literal_pagseguro($payment) {
  $payments_array = get_payments_pagseguro();

  if (isset($payments_array[$payment])) {
    return $payments_array[$payment];
  } else {
    return $payment;
  }
}

?>
