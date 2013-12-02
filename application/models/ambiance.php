<?php

class Ambiance extends DataMapper {

  public $table = 'ambiances';
  public $id;
  public $user_id;
  public $title;
  public $image;
  public $description;
  public $category_id;
  public $status;
  public $has_one = array("user", "category");
  public $has_many = array(
    'ambiance_vote',
    'user_balance',
    'item' => array(
      'class'         => 'item',
      'other_field'   => 'ambiance',
      'join_self_as'  => 'ambiance',
      'join_other_as' => 'item',
      'join_table'    => 'ambiances_items'),
    'home_layout' => array(
      'class'         => 'home_layout',
      'other_field'   => 'ambiance',
      'join_self_as'  => 'ambiance',
      'join_other_as' => 'home_layout',
      'join_table'    => 'home_ambiance_items'
    )
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

    $vote_class = "";
    $ambiance_vote = new Ambiance_Vote();
    $ambiance_vote->where('ambiance_id', $this->id);
    $ambiance_vote->where('user_id', $sessionUser['id']);
    $ambiance_vote->get();

    # Check if the vote have been done
    if( $ambiance_vote->exists() ) $vote_class = "active";

    # HTML markup
    $html = <<<BTN
      <span class="star padd-top">
        <a
          id="item_vote_{$this->id}"
          href="#"
          class="item_vote {$vote_class}"
          data-vote-type="ambiances"
          data-vote-id="{$this->id}"
        >star</a>
      </span>
BTN;

    return $html;
  }

  /**
   * Create a HTML markup for denounce button
   * @return string HTML Markup
   */
  public function denounceBtn()
  {
    # Create HTML markup
    $html = <<<BTN
      <span class='denounce hotspot'>
        <a
          id="item_denounce_{$this->id}"
          class="item_denounce"
          data-denounce-type="disponibilities"
          data-denounce-id="{$this->id}"
        >denounce</a>
      </span>
BTN;

    return $html;
  }

  /**
   * Return horizontal slider HTML markup
   * @param  string  $icon_type     Name of icon type "star" or "close"
   * @param  boolean $icon_activate Define if the icon needs to be activated or not (available only for "star")
   * @return string                 HTML markup
   */
  public function show($icon_type = "star", $icon_activate = FALSE)
  {
    # Load ambiance slider markup library
    $this->load->library('ambiance_slider');
    $markup = new Ambiance_slider();
    return $markup->get($this, $icon_type, $icon_activate);
  }

}

?>
