<?php

class User extends DataMapper {

  public $table = 'users';
  public $id;
  public $name;
  public $surname;
  public $company_name;
  public $description;
  public $email;
  public $password;
  public $role;
  public $phone;
  public $street;
  public $number;
  public $complement;
  public $district;
  public $country;
  public $state_id;
  public $city_id;
  public $zip;
  public $cpf;
  public $cnpj;
  public $rg;
  public $ie;
  public $email_confirmation_hash;
  public $email_confirmed;
  public $url;
  public $user_indication;
  public $image;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array("state", "city", "social_login");
  public $has_many = array(
    "delivery_address",
    "suggested_item",
    "order",
    "item",
    "ambiance",
    "disponibility",
    "user_balance",
    "item_vote",
    'user_vote',
    'user_message',
    'item_message',
    'ambiance_vote',

    'expertise' => array(
      'class'         => 'expertise',
      'other_field'   => 'user',
      'join_self_as'  => 'user',
      'join_other_as' => 'expertise',
      'join_table'    => 'users_expertises'
    ),

    'sender' => array(
      'class'       => 'user_message',
      'other_field' => 'sender'
    ),

    'user_voted' => array(
      'class'       => 'user_vote',
      'other_field' => 'user_voted'
    ),

    'sender_item_message' => array(
      'class'       => 'item_message',
      'other_field' => 'sender'
    ),

    'product' => array(
      'class'         => 'item',
      'other_field'   => 'user',
      'join_self_as'  => 'user',
      'join_other_as' => 'item',
      'join_table'    => 'items_suppliers'
    ),
 );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

  function voteBtn(){
    $ci = & get_instance();
    $sessionUser = $ci->session->userdata('user');
    if ($this->id == $sessionUser['id']) {
      return;
    }

    $txt_vote = "Votar";
    $user_vote = new User_Vote();
    $user_vote->where('user_voted_id', $this->id);
    $user_vote->where('user_id', $sessionUser['id']);
    $user_vote->get();
    if($user_vote->exists()){
      $txt_vote = "Votei";
    }
    $html = "<a class='btn btn-mini user_vote' id='user_vote_$this->id'  user_voted_id='$this->id'>$txt_vote</a>";

    return $html;
  }

  function countUserProjects(){
    $projects = new Item();
    $projects->where('status', 1);
    $projects->where('user_id', $this->id);
    $projects->where_related('disponibility', 'status !=', 1);
    return $projects->count();
  }

  function countUserAmbiances(){
    $ambiances = new Ambiance();
    $ambiances->where('user_id', $this->id);
    return $ambiances->count();
  }

  function countUserVotes(){
    $user_votes = new User_Vote();
    $user_votes->where('user_voted_id', $this->id);
    return $user_votes->count();
  }

  function getUserCredits(){
    //Credit
    $user_balance_credit = new User_Balance();
    $user_balance_credit->where(array('user_id' => $this->id, 'transaction_type' => 1, 'status' => 1));
    $user_balance_credit->select_sum('value');
    $user_balance_credit->get();
    $credit = $user_balance_credit->value;

    //Debit
    $user_balance_debit = new User_Balance();
    $user_balance_debit->where(array('user_id' => $this->id, 'transaction_type' => 2, 'status' => 1));
    $user_balance_debit->select_sum('value');
    $user_balance_debit->get();
    $debit = $user_balance_debit->value;

    return $credit - $debit;
  }

}

?>
