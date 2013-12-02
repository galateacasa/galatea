<?

/**
 * Create and array from objects and data to be displayed in some emails
 * @since 18/07/2013
 */
if( !function_exists('address_to_array') )
{
  function address_to_array($addressObject, $nameFirst = '', $nameLast = '')
  {
    # Create array with shared data
    $userAddress = array(
      'street'       => $addressObject->street,
      'number'       => $addressObject->number,
      'complement'   => $addressObject->complement,
      'district'     => $addressObject->district,
      'state'        => $addressObject->state->acronym,
      'city'         => $addressObject->city->name,
      'zipCode'      => $addressObject->zip
    );

    # Check if the object has the atributeproperties
    if( property_exists($addressObject, 'name') and property_exists($addressObject, 'surname') ):
      $userAddress['userFullName'] = "{$addressObject->name} {$addressObject->surname}";
    else:
      $userAddress['userFullName'] = "{$nameFirst} {$nameLast}";
    endif;

    # Return complete array
    return $userAddress;
  }
}

/* End of address_to_array helper */
/* Location: ./application/helpers/user_address_helper.php */