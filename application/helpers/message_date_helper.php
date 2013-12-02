<?
  # Check if the function already exists
  if( !function_exists('message_date') )
  {
    /**
     * Convert database datetime into chat date format
     * @param  string $datetime Database datetime
     * @return string           Date at the chat format
     */
    function message_date($datetime)
    {
      # Separate date and time
      list($date, $time) = explode(' ', $datetime);

      # Convert date to the brasilian format
      $date = implode('/', array_reverse( explode('-', $date) ) );

      # Remove seconds
      $time = substr($time, 0, -3);

      # return the date and time at the correct format
      return $date . ' às ' . $time;
    }
  }

?>