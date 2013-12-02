<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product
{
  protected $ci;
  public $product_obj     = false;
  public $product_url     = false;
  public $product_images  = array();
  public $designer_url    = false;
  public $designer_image  = false;
  public $social_links    = false;
  public $denounce_button = false;

  public function __construct(){
    $this->ci =& get_instance();
  }

  function get($product_obj, $type = 'star', $activate = FALSE)
  {
    # The product is able to be shown?
    if($product_obj->status > 0)
    {
      # Define activation
      $activation = $activate == TRUE ? 'activate' : '';

      # Load social_links, vote_button and denounce_button libraries
      $this->ci->load->library( array('social_links', 'vote_button', 'denounce_button') );

      # Instanciate Social Links
      $this->social_links = new Social_Links();

      # Instanciate vote button
      $vote_button = new Vote_Button();

      # Instanciate denounce button
      $this->denounce_button = new Denounce_button();

      //product data
      $this->product_obj = $product_obj;
      $this->product_url = base_url("produto/{$product_obj->slug}");

      if ($this->product_obj->item_image->where('principal', 1)->get()->exists())  {
        $this->product_images[] = amazon_url("images/items/{$this->product_obj->item_image->where('principal', 1)->get()->image}", 380, 167);

        // if ($this->product_obj->item_image->where('principal', 0)->get()->exists()) {
        //   foreach ($this->product_obj->item_image->where('principal', 0)->get() as $itemImage) {
        //     $this->product_images[] = amazon_url("images/items/{$itemImage->image}", 380, 167);
        //   }
        // }
      }

      //Product price
      //price is the sum of the cheapest measure with the cheapest material
      //Material
      $cheapest_material = "";
      foreach ($product_obj->item_variation_material->get() as $material) {
        if($cheapest_material == "" || $cheapest_material > $material->additional_amount)
          $cheapest_material = $material->additional_amount;
      }

      //measure
      $cheapest_measure = "";
      foreach ($product_obj->item_variation_measurement->get() as $measure) {
        if($cheapest_measure == "" || $cheapest_measure > $measure->additional_amount)
          $cheapest_measure = $measure->additional_amount;
      }
      $item_price = $cheapest_measure + $cheapest_material + $product_obj->production_price;

      //Calculate the delivery_price
      $delivery_cost = $product_obj->delivery_cost;
      $delivery_price = $item_price * $delivery_cost / 100;

      //Add to the price
      $item_price += $delivery_price;

      //instalments
      $instalment = $item_price / 10;

      # Format prices
      $item_price = number_format($item_price, 2, ',', '.');
      $instalment = number_format($instalment, 2, ',', '.');

      //Designer data
      $this->designer_url = site_url('site/users/profile/'.$product_obj->user->id);

      $html = <<<HTML
        <!-- product -->
        <li class="product" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
          <div class="product-image">
            <figure>
              <a href="/produto/{$this->product_obj->slug}">
                <div class="jcarousel">
                  <ul>
HTML;
      foreach ($this->product_images as $images) {
      $html .= <<<HTML
      <li><img src="{$images}" alt="{$this->product_obj->name}" itemprop="image" style="height:100%; width:100%;" /></li>
HTML;
      }

      $html .= <<<HTML
                  </ul>
                </div>
              </a>
            </figure>
            <!--
            <div id="slider">
              <a class="seta_r" href="#proxima">&rsaquo;</a>
              <a class="seta_l" href="#anterior">&lsaquo;</a>
            </div>
            -->
          </div>
          <a href="/produto/{$this->product_obj->slug}">
            <h3><span itemprop="name" style="word-wrap: break-word;">{$this->product_obj->name}</span></h3>
            <div class="white-box">
              <div class="rate-new-container">
                <span class="rate-new">R$ {$item_price}</span>
              </div>
              <span class="rate" itemprop="price">10 x R$ {$instalment}</span>
            </div>
          </a>
        </li>
HTML;

      return $html;
    }else{
      return '';
    }
  }
}
