<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project
{
  protected   $ci;
  public $project_obj     = false;
  public $project_url     = false;
  public $project_image   = false;
  public $designer_url    = false;
  public $designer_image  = false;
  public $social_links    = false;
  public $denounce_button = false;

  public function __construct(){
    $this->ci =& get_instance();
  }

  function get($project_obj, $type = 'star', $activate = FALSE)
  {
    # Define activation
    $activation = $activate == TRUE ? 'activate' : '';

    #Load social_links, vote_button and denounce_button libraries
    $this->ci->load->library( array('social_links', 'vote_button', 'denounce_button') );

    # Instanciate Social Links
    $this->social_links = new Social_Links();

    # Instanciate vote button
    $vote_button = new Vote_Button();

    # Instanciate denounce button
    $this->denounce_button = new Denounce_button();

    if ($type == 'produce') {
      $button = "<span class=\"produce\">" . anchor("site/items/build/{$project_obj->id}", 'Quero produzir') . "</span>";
    } else {
      $button = $vote_button->get($project_obj->id, 'items', $type);
    }

    //Project data
    $this->project_obj = $project_obj;
    $this->project_url = site_url('projeto/'.$project_obj->slug);

    # Define image
    if( $this->project_obj->item_image->get()->exists() ) {
      $this->project_image = amazon_url("images/items/{$this->project_obj->item_image->image}", 380, 167);
    }else{
      $this->project_image = assets_url('images/nopic.jpg');
    }

    //Designer data
    $this->project_url = site_url('projeto/'.$project_obj->slug);
    $this->designer_url = site_url('site/users/profile/'.$project_obj->user->slug);

    $html = <<<HTML
    <li class="project">

      <!-- title -->
      <h3>
        <!-- project name -->
        <a href="{$this->project_url}">
          {$this->project_obj->name}
        </a>

        <!-- designer name -->
        <i>
          <a href="{$this->designer_url}">
            Por {$this->project_obj->user->name}
          </a>
        </i>

      </h3>

      <!-- image -->
      <figure>
        <a href="{$this->project_url}">
          <img src="{$this->project_image}" alt="{$this->project_obj->name}">
        </a>
      </figure>

      <!-- denounce button -->

      <!-- social links -->
      {$this->social_links->get( $this->project_obj->title, $this->project_obj->description, $this->project_image, $this->project_url )}

      <div class="white-box"></div>

      $button

    </li>
HTML;
    // {$this->denounce_button->define('project', $this->project_obj->id)->get()}
    return $html;
  }
}
