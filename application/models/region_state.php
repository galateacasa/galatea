<?php

class Region_State extends DataMapper {

  public $table = 'regions_states';
  public $id;
  public $region_id;
  public $state_id;
  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
