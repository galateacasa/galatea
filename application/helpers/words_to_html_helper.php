<?

if ( ! function_exists('words_to_html'))
{
  function words_to_html($data)
  {
    if( is_array($data) ):
      foreach($data as &$text) $text = htmlentities($text);
    else:
      $data = htmlentities($data);
    endif;

    return $data;
  }
}

/* End of clear_number helper */
/* Location: ./application/helpers/clear_number_helper.php */