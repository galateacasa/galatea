<?

if ( ! function_exists('clear_number'))
{
  function clear_number($string){

    # Allowed numbers
    $numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

    # Remove the numbers
    foreach($numbers as $number) $string = str_replace($number, '', $string);

    # Return cleared string
    return trim($string);
  }
}

/* End of clear_number helper */
/* Location: ./application/helpers/clear_number_helper.php */