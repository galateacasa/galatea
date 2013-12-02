<?php

class Item extends DataMapper {

  public $table = 'items';
  public $id;
  public $user_id;
  public $name;
  public $description;
  public $status;
  public $suggested_item_id;
  public $category_id;
  public $type;
  public $parent_project_id;
  public $production_price;
  public $production_amount;
  public $start_sell_date;
  public $end_sell_date;
  public $delivery_time;
  public $delivery_cost;
  public $create_date;
  public $update_date;
  public $delete_date;

  public $has_one = array(
    // 'category',
    'style',
    'suggested_item',
    'user',
  );

  public $has_many = array(

    'item_variation_material'    => array(),
    'item_variation_measurement' => array(),
    'item_image'                 => array(),
    'item_message'               => array(),
    'item_vote'                  => array(),
    'order_item'                 => array(),
    'category' => array(
      'class'         => 'category',
      'other_field'   => 'item',
      'join_self_as'  => 'item',
      'join_other_as' => 'category',
      'join_table'    => 'categories_items'
    ),

    'orders' => array(
        'class' => 'order',
        'other_field' => 'item',
        'join_self_as' => 'item',
        'join_other_as' => 'order',
        'join_table' => 'order_items'),

    'ambiance' => array(
      'class'         => 'ambiance',
      'other_field'   => 'item',
      'join_self_as'  => 'item',
      'join_other_as' => 'ambiance',
      'join_table'    => 'ambiances_items'),

    'supplier'       => array(
      'class'         => 'user',
      'other_field'   => 'item',
      'join_self_as'  => 'item',
      'join_other_as' => 'user',
      'join_table'    => 'items_suppliers'),

    'home_layout' => array(
      'class'         => 'home_layout',
      'other_field'   => 'item',
      'join_self_as'  => 'item',
      'join_other_as' => 'home_layout',
      'join_table'    => 'home_layout_items'
    )
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

  function voteBtn($type = ""){
    $ci = & get_instance();
    $sessionUser = $ci->session->userdata('user');
    if ($this->id == $sessionUser['id']) {
      return;
    }

    $vote_class = "";
    $item_vote = new Item_Vote();
    $item_vote->where('item_id', $this->id);
    $item_vote->where('user_id', $sessionUser['id']);
    $item_vote->get();

    if( $item_vote->exists() ) $vote_class = "active";

    switch($type)
    {
      # Project
      case 'project':
        $html = <<<BTN
        <span class="vote">
          <a
            id="item_vote_{$this->id}"
            href="#"
            class="item_vote {$vote_class}"
            data-vote-type="items"
            data-vote-id="{$this->id}"
          >Vote</a>
        </span>
BTN;


        break;

      # Product
      case 'product':

        $html = <<<BTN
        <span class="star padd-top">
          <a
            id="item_vote_{$this->id}"
            href="#"
            class="item_vote {$vote_class}"
            data-vote-type="disponibilities"
            data-vote-id="{$this->id}"
          >star</a>
        </span>
BTN;
      break;

    }

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
          data-denounce-type="items"
          data-denounce-id="{$this->id}"
        >denounce</a>
      </span>
BTN;

    return $html;
  }

  public function show($type = "", $icon_type = "star", $icon_activate = FALSE)
  {
    $designer    = $this->user->name." ".$this->user->surname;
    $designerUrl = site_url('/site/users/profile/' . $this->user->id);
    $image       = amazon_url('images/items/'.$this->item_image->where('principal',1)->get()->image);
    $url         = site_url('site/items/show/'.$this->id);
    $item_name   = substr($this->name, 0, 24);

    # Get denounce button HTML markup
    $denounceBtn = $this->denounceBtn();

    # Get Social Links HTML markup
    $this->load->library('social_links');
    $social_links = new Social_Links();
    $socialLinks = $social_links->get($this->name, $this->description, $image, $url);

    //logged user
    $ci = & get_instance();
    $usr = $ci->session->userdata('user');
    $user = new User($usr['id']);

    if($type == 'product')
    {
      //Item price
      //Item price is the sum of the cheapest measure with the cheapest material
      //Material
      $cheapest_material = "";
      foreach ($this->item_variation_material->get() as $material) {
        if($cheapest_material == ""){
          $cheapest_material = $material->additional_amount;
        }

        if($cheapest_material > $material->additional_amount){
          $cheapest_material = $material->additional_amount;
        }
      }

      //measure
      $cheapest_measure = "";
      foreach ($this->item_variation_measurement->get() as $measure) {
        if($cheapest_measure == ""){
          $cheapest_measure = $measure->additional_amount;
        }

        if($cheapest_measure > $measure->additional_amount){
          $cheapest_measure = $measure->additional_amount;
        }
      }
      $item_price = $cheapest_measure + $cheapest_material;

      //Calculate the delivery_price
      $delivery_cost = $this->delivery_cost;
      $delivery_price = $item_price * $delivery_cost/100;
      //Add to the price
      $item_price += $delivery_price;
      $item_price_format = number_format($item_price, 2, ',', '.');

      //instalments
      $instalment = $item_price/10;
      $instalment = number_format($instalment, 2, ',', '.');
    }

    $html = "";

    switch ($type)
    {
      case 'credits':

        # Get vote button HTML markup
        $voteBtn = $this->voteBtn('product');

        //product url
        $productUrl = site_url('site/disponibilities/show/'.$this->id);

        //Credits discount
        $user_credits = $user->getUserCredits();
        if($user_credits >= $item_price){
          $credits_discount = $user_credits - ($user_credits - $item_price);
          $credits_discount = $item_price - $credits_discount;
        }else{
          $credits_discount = $item_price - $user_credits;
        }
        $credits_discount = number_format($credits_discount, 2, ',', '.');

        if($this->item_image->where('principal',1)->get()->exists()){
          $img = amazon_url('images/items/'.$this->item_image->image, 206,147);
        }else{
          $img = assets_url("images/fig-new.jpg");
        }

        $html = <<<html
          <li>
            <div class="block">

              $denounceBtn
              $voteBtn

              <h3>
                <a href="$productUrl">{$item_name}</a>
                <i><a href="#">Por {$designer}</a></i>
                <span></span>
              </h3>

              <figure class="padd-second">
                <a href="$productUrl">
                  <img width="206" height="147" alt="{$this->name}" src="$img">
                </a>
              </figure>

              {$socialLinks}

              <div class="price">
                <span class="rate-new">10 x R$ $instalment</span>
                <span class="rate">R$ $item_price_format</span>
              </div>

            </div>
            <div class="credits">
              <span class="credit-title">utilizando seus créditos</span>
              <span class="credit-rate rate">R$ $credits_discount</span>
            </div>
          </li>
html;
      break;

      case 'produce':
        $userUrl = site_url('site/users/profile/'.$this->user_id);
        $productUrl = site_url('site/items/show/'.$this->id);
        $produceUrl = site_url('site/disponibilities/create/'.$this->id);

        if($this->item_image->where('principal',1)->get()->exists()){
          $img = amazon_url('images/items/'.$this->item_image->image);
        }else{
          $img = assets_url("images/fig-new.jpg");
        }
        $html = <<<html
        <li>
          <h3><a href="{$productUrl}">{$item_name}</a> <i><a href="{$userUrl}">Por Designer {$designer}</a></i></h3>
          <p>{$this->description}</p>
          <figure class="padd-second">
            <a href="{$productUrl}">
              <img width="206" height="147" alt="{$this->name}"  src="{$img}">
            </a>
          </figure>
          <span class="vote vote-banner small-title"><a class="no-bg-img" href="{$produceUrl}">quero produzir</a></span>
        </li>
html;
      break;

      case 'project':

        $this->load->library('project');
        $project = new Project();
        return $project->get($this, $icon_type, $icon_activate);

      break;

      case 'product':
      default:
      #Product

        $this->load->library('product');
        $product = new Product();
        return $product->get($this, $icon_type, $icon_activate);

      break;

    }

    return $html;
  }

}

?>
