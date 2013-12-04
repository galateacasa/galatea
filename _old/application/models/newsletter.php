<?php

class Newsletter extends DataMapper {

    public $table = 'newsletters';
    public $id;
    public $email;
    public $create_date;


    function __construct($id = NULL) {
        parent::__construct($id);
    }
}

?>
