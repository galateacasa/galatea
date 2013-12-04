<?

/**
 * Convert common number to the brazilian money format
 */
if( !function_exists('to_money') )
{
  function to_money($amount)
  {
    return 'R$' . number_format($amount, 2, ',', '.');
  }
}

/* End of to_money helper */
/* Location: ./application/helpers/to_money_helper.php */