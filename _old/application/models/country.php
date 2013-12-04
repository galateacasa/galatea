<?

/**
 * DataMapper ORM class to describe the table
 */
class Country extends DataMapper
{
  /**
   * Table name
   * @var string
   */
  public $table = 'countries';

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

/* End of file country.php */
/* Location: ./application/models/country.php */