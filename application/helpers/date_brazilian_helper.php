<?
  # Check if the function already exists
  if( !function_exists('date_brazilian') )
  {
    /**
     * Convert database date or datetime into brazilian date format
     *
     * @param  (string) $datetime = Database datetime
     * @return (string) Brazilian date format
     * @since  2013-07-19
     */
    function date_brazilian($date)
    {
      # The date have a time? Remove it!
      if( strlen($date) > 10 ) $date = substr($date, 0, -9);

      # Convert date to the brasilian format
      return implode('/', array_reverse( explode('-', $date) ) );
    }
  }

?>