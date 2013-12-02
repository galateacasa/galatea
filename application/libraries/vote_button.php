<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  /**
   * Library to add the vote button for projects, products, etc in any place
   */
  class Vote_Button
  {
    /**
     * Gives access to the Code Igniter instances, so you could load libraries, helpers, etc
     * @var object
     */
    protected $ci;

    /**
     * Initial actions
     */
    public function __construct() {
      $this->ci = &get_instance();
    }

    /**
     * Get HTML markup for vote button
     * @param  integer  $item_id  Item ID
     * @param  boolean  $star     Define if the markup needs to return with the yello/gray start
     * @return HTML               Vote button HTML markup
     */
    public function get($item_id, $type, $star = 'star')
    {
      # Check if the vote needs to came as a star
      switch($star)
      {
        case 'vote':
          $icon_class  = 'vote';
          $button_text = 'vote';
        break;

        case 'close':
          $icon_class  = 'close';
          $button_text = 'X';
        break;

        case 'star':
        default:
          $icon_class  = 'star';
          $button_text = '&nbsp;';
        break;
      }

      $vote_class = '';

      # Check if the user is logged in
      if( $this->ci->session->userdata('id') )
      {
        # Check if the item is an ambiance
        if($type == 'ambiances')
        {
          # Create a new item vote instante
          $item_vote = new Ambiance_Vote();

          # Get all data
          $item_vote->where('ambiance_id', $item_id)
                    ->where('user_id', $this->ci->session->userdata('id') )
                    ->get();

          # Check if the user already voted at the item
          if( $item_vote->exists() ) $vote_class = 'active';
        }else{
          # Create a new item vote instante
          $item_vote = new Item_Vote();

          # Get all data
          $item_vote->where('item_id', $item_id)
                    ->where('user_id', $this->ci->session->userdata('id') )
                    ->get();

          # Check if the user already voted at the item
          if( $item_vote->exists() ) $vote_class = 'active';
        }

      }

      # Create HTML markup
      $html_markup = <<<HTML

        <span class="{$icon_class}">
          <a
            id="{$type}_vote_{$item_id}"
            href="#"
            class="item_vote {$vote_class}"
            data-vote-type="{$type}"
            data-vote-id="{$item_id}"
          >$button_text</a>
        </span>

HTML;

      # Return mounted HTML markup
      return $html_markup;
    }

  }
