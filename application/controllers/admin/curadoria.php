<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curadoria extends CI_Controller
{
  public $path = "/images/items/";
  private $amazon_url;
  private $history_type;

  /**
   * Initial actions
   */
  function __construct()
  {
    parent::__construct();

    // The user is logged in?
    if ( !$this->session->userdata('loggedIn') ) redirect('admin/login');

    // Define amazon URL for images
    $this->amazon_url = amazon_url('images/items');

    $this->history_type = array(
      'approved'    => 1,
      'disapproved' => 0
    );

    $this->history_title = array(
      'approved'    => 'Aprovados',
      'disapproved' => 'Reprovados'
    );

  }

  /**
   * Responsible to list all projects
   */
  public function items()
  {
    $projects = new Item();
    $projects->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date')
          ->where(array('type' => 1, 'status' => 0))
          ->order_by('create_date', 'desc')
          ->get();

    $breadcrumb = array(
      'Home'      => site_url('admin'),
      'Curadoria' => "#",
      'Projetos'  => site_url('admin/curadoria/items')
    );

    $this->load->helper('html');

    $toview['items'] = $projects;

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/curadoria/items', $toview);
  }

  /**
   * Responsable to edit the project data
   *
   * @access public
   * @param  integer $item_id Project ID
   * @return void
   */
  public function item($project_id)
  {
    $project = new Item($project_id);

    // The project exists?
    if( $project->exists() )
    {
      // The form was submitted?
      if( $this->input->post() ) $this->save($project_id);

      $avaliation_texts = new Avaliation_Text();
      $avaliation_texts->order_by('avaliation')->get();

      $project_statuses = new Item_Status();
      $project_statuses->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date')
                       ->where('item_id', $project->id)
                       ->order_by('create_date', 'desc')
                       ->get();

      switch ($project->status)
      {
        case 1:
          $breadcrumb = array(
            'Home' => site_url('admin'),
            'Curadoria' => "#",
            'Projetos Aprovados' => site_url('admin/curadoria/approved')
          );
        break;

        case 2:
          $breadcrumb = array(
            'Home' => site_url('admin'),
            'Curadoria' => "#",
            'Projetos Reprovados' => site_url('admin/curadoria/disapproved')
          );
        break;

        default:
          $breadcrumb = array(
            'Home' => site_url('admin'),
            'Curadoria' => "#",
            'Projetos' => site_url('admin/curadoria/items')
          );
        break;
      }

      $images = array();

      foreach ($project->item_image->get() as $image) $images[] = $image->image;

      // Get Inline Scripts
      $inline = '';
      $inline = empty($images) ? $inline = $this->getScriptsInline() : $inline = $this->getScriptsInline($images);

      // Define template options
      {
        $this->template->set_breadcrumb($breadcrumb);
        $this->template->set_script( assets_url('js/admin/curadoria/item.js') );
        $this->template->set_script( assets_url('js/plugins/jquery.ae.image.resize.min.js') );
        $this->template->set_script( assets_url('js/plugins/jquery.filedrop.js') );
        $this->template->set_script( assets_url('js/site/upload_box.js') );
        $this->template->set_script('', $inline);
      }

      // Get all project categories
      {
        $categories = new Category();
        $categories->where('parent_id', 156)->get();

        // $toview['categories'] = '';

        foreach ($categories as $category) {
          $toview['categories'][$category->id] = $category->name;
        }
      }

      // View variables
      {
        $toview['item_statuses']    = $project_statuses;
        $toview['avaliation_texts'] = $avaliation_texts;
        $toview['item']             = $project;
        $toview['categoriesSub']    = $project->category->get();
      }

      // Load template
      $this->template->load('admin', 'admin/curadoria/item', $toview);
    }else{
      $this->session->flashdata('error', 'Projeto não encontrado.');
      redirect('admin/curadoria/items');
    }
  }

  /**
   * Save the project data into database
   *
   * @access private
   * @param  integer $id Project ID
   * @return void
   */
  private function save($project_id)
  {
    // Instanciate a new item object
    $project = new Item($project_id);

    // Set main definitions
    {
      $project->name        = $this->input->post('name');
      $project->description = $this->input->post('description');
      $project->category_id = $this->input->post('category');
    }

    // Is necessary to change status?
    if($this->input->post('is_status') == 1) {

      // item_status
      $project_status = new Item_Status();
      $project_status->status  = $this->input->post('status');
      $project_status->item_id = $project->id;
      $project_status->message = $this->input->post('message');

      // The status was saved?
      if( !$project_status->save() ) {
        $this->session->set_flashdata('error', $project_status->error->transaction);
        redirect("admin/curadoria/item/{$item->id}");
      }

      // Define the month
      $month = date('m') == 12 ? 1 : date('m') + 1;

      // Set item status
      $project->status = $this->input->post('status');

      // Define item delivery data
      $project->delivery_date = date("Y-$month-1");

    }

    // The item was saved?
    if( !$project->save() ) {
      $this->session->set_flashdata('error', $project->error->transaction);
      redirect("admin/curadoria/item/{$project->id}");
    }

    // Variations
    $post_variations = array(
      'materials'    => $this->input->post('materials'),
      'measurements' => $this->input->post('measurements')
    );
    $variations = array(
      'materials'    => array(),
      'measurements' => array()
    );

    // Remove all old variations
    {
      $old_materials = new Item_variation_material();
      $old_materials->where('item_id', $project->id)
                    ->get()
                    ->delete_all();
    }

    // Remove all old measurements
    {
      $old_measurements = new Item_variation_measurement();
      $old_measurements->where('item_id', $project->id)
                       ->get()
                       ->delete_all();
    }

    // Save all measurements
    foreach($this->input->post('measurements') as $key => $variation)
    {
      foreach ($variation as $id => $value)
        if ($value != '' && $value != '0') $variations['measurements'][$id][$key] = $value;
    }

    // Save all materials
    foreach($this->input->post('materials') as $variation_material)
    {
      // The material was sent?
      if( !empty($variation_material) ):
        $new_variation = new Item_variation_material();
        $new_variation->item_id  = $project->id;
        $new_variation->material = $variation_material;
        $new_variation->save();
      endif;
    }

    foreach ($variations['measurements'] as $id => $variation_measurement)
    {
      if ($variation_measurement['width'] != '' && $variation_measurement['width'] != 0 &&
          $variation_measurement['height'] != '' && $variation_measurement['height'] != 0 &&
          $variation_measurement['depth'] != '' && $variation_measurement['depth'] != 0) {

        $new_variation = new Item_variation_measurement();
        $new_variation->item_id = $project->id;
        $new_variation->width   = $variation_measurement['width'];
        $new_variation->height  = $variation_measurement['height'];
        $new_variation->depth   = $variation_measurement['depth'];

        // Sabe into database
        $new_variation->save();
      }
    }

    // Remove all old images
    {
      $old_images = new Item_image();
      $old_images->where(array('item_id' => $project->id))
                 ->get()
                 ->delete_all();
    }

    // Any image was submitted?
    if( $this->input->post('images') )
    {
      // Save all images into database
      foreach ($this->input->post('images') as $project_image):
        $project_images = new Item_Image();
        $project_images->item_id = $project->id;
        $project_images->image   = $project_image;
        $project_images->save();
      endforeach;
    }

    // Is necessary to send the email?
    if($this->input->post('sendmail') == 1)
      $this->sendMail( $project, $this->input->post('status'), $this->input->post('message') );

    $this->session->set_flashdata('success', 'Avaliação salva.');

    switch( $this->input->post('status') ) {
      case 1:
        redirect('admin/curadoria/approved');
        break;
      case 2:
        redirect('admin/curadoria/disapproved');
        break;
      default:
        redirect('admin/curadoria/items');
        break;
    }

  }

  /**
   * Send email to the project owner
   * @param  object  $project   Project informations
   * @param  integer $status    Project status: 1.Name, 2.Approved, 3.Disapproved
   * @param  string  $message   Message to be send
   * @return object             Email object
   */
  private function sendMail($project, $status, $message)
  {
    // Instanciate a new user
    $user = new User($project->user_id);

    switch($status)
    {
      // New
      case 1:
        $data['title'] = "Olá {$user->name}!";
        $data['text'] = array("Seu projeto \"{$project->name}\" foi aprovado!", $message,'Atenciosamente,', 'Equipe Galatea.');
        $body = $this->load->view('site/common/email/default', $data, TRUE);
        $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
        $this->email->to($user->email);
        $this->email->subject('Galatea - Seu projeto foi aprovado!');
        $this->email->message($body);
        $this->email->send();
      break;

      // Disapproved
      case 2:
        $data['title'] = "Olá {$user->name}!";
        $data['text'] = array("Seu projeto \"{$project->name}\" foi reprovado.", $message,'Atenciosamente,', 'Equipe Galatea.');
        $body = $this->load->view('site/email/default', $data, TRUE);
        $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
        $this->email->to($user->email);
        $this->email->subject('Projeto Reprovado');
        $this->email->message($body);
        $this->email->send();
      break;
    }

    return $this->email;
  }

  public function approved()
  {
    $items_list = new Item();
    $items_list->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date')
               ->where(array('type' => 1, 'status' => 1))
               ->order_by('create_date', 'desc')
               ->get();

    $items = array();

    foreach ($items_list as $item)
    {
      $item_status = new Item_Status();
      $item_status->where('item_id', $item->id)
                  ->order_by('create_date', 'DESC')
                  ->limit(1)
                  ->get();

      $item->item_status = $item_status;

      $items[] = $item;
    }

    $breadcrumb = array(
      'Home'      => site_url('admin'),
      'Curadoria' => "#",
      'Aprovados' => site_url('admin/curadoria/approved')
    );

    $toview['history_title'] = $this->history_title['approved'];
    $toview['history_type']  = $this->history_type['approved'];
    $toview['items'] = $items;

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/curadoria/history', $toview);
  }

  public function disapproved()
  {
    $items_list = new Item();
    $items_list->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $items_list->where(array('type' => 1, 'status' => 2));
    $items_list->order_by('create_date', 'desc');
    $items_list->get();
    $items = array();

    foreach ($items_list as $item) {
      $item_status = new Item_Status();
      $item_status->where(array('item_id' => $item->id));
      $item_status->order_by('create_date', 'DESC');
      $item_status->limit(1);
      $item_status->get();

      $item->item_status = $item_status;

      $items[] = $item;
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Curadoria' => "#",
      'Reprovados' => site_url('admin/curadoria/disapproved')
      );

    $toview['history_title'] = $this->history_title['disapproved'];
    $toview['history_type']  = $this->history_type['disapproved'];
    $toview['items'] = $items;

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/curadoria/history', $toview);
  }

  /**
   * Avaliation texts used to disapprove a project
   * @return void
   */
  public function avaliation_texts()
  {
    $avaliation_texts = new Avaliation_Text();
    $avaliation_texts->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date')
                     ->order_by('avaliation')
                     ->get();

    $breadcrumb = array(
      'Home'                => site_url('admin'),
      'Curadoria'           => '#',
      'Textos de avaliação' => site_url('admin/curadoria/avaliation_texts')
    );

    $toview['avaliation_texts'] = $avaliation_texts;

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/curadoria/avaliation_texts', $toview);
  }

  /**
   * Creates the avaliation text
   * @return void
   */
  public function create_avaliation_text()
  {

    # The form was submitted?
    if( $this->input->post() )
    {
      $avaliation_text = new Avaliation_Text();
      $avaliation_text->avaliation = $this->input->post('avaliation');
      $avaliation_text->text = $this->input->post('text');

      # The data was saved?
      if( $avaliation_text->save() )
      {
        $this->session->set_flashdata('success', 'Salvo com sucesso');
        redirect("admin/curadoria/edit_avaliation_text/{$avaliation_text->id}");
      }else{
        $this->session->set_flashdata('error', $avaliation_text->error->transaction);
        redirect(site_url('admin/curadoria/create_avaliation_text'));
      }
    }else{
      $breadcrumb = array(
        'Home'                => site_url('admin'),
        'Curadoria'           => '#',
        'Textos de avaliação' => site_url('admin/curadoria/avaliation_texts'),
        'Editar'              => '#'
      );

      $this->template->set_breadcrumb($breadcrumb);
      $this->template->load('admin', 'admin/curadoria/create_avaliation_text');
    }
  }

  /**
   * Edit avaliation text
   * @return void
   */
  public function edit_avaliation_text($avaliation_text_id)
  {
    $avaliation_text = new Avaliation_Text($avaliation_text_id);
    if(!$avaliation_text->exists()){
      $this->session->set_flashdata('error', 'Texto de avaliação não encontrado');
      redirect(site_url('admin/curadoria/avaliation_texts'));
    }

    if($this->input->post()){
      $avaliation_text->avaliation = $this->input->post('avaliation');
      $avaliation_text->text = $this->input->post('text');
      if(!$avaliation_text->save()){
        $this->session->set_flashdata('error', $avaliation_text->error->transaction);
        redirect(site_url('admin/curadoria/avaliation_texts'));
      }
      $this->session->set_flashdata('success', 'Salvo com sucesso');
      redirect(site_url('admin/curadoria/edit_avaliation_text/'.$avaliation_text->id));
    }

    $toview['avaliation_text'] = $avaliation_text;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Curadoria' => '#',
      'Textos de avaliação' => site_url('admin/curadoria/avaliation_texts'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/curadoria/edit_avaliation_text', $toview);
  }

  /**
   * Delete an avaliation text
   * @param  integer $avaliation_text_id The ID of avaliation text
   * @return void
   */
  public function remove_avaliation_text($avaliation_text_id)
  {
    $avaliation_text = new Avaliation_Text($avaliation_text_id);
    if(!$avaliation_text->exists()){
      $this->session->set_flashdata('error', 'Texto de avaliação não encontrado');
      redirect(site_url('admin/curadoria/avaliation_texts'));
    }
    $avaliation_text->delete();
    $this->session->set_flashdata('success', 'Removido com sucesso.');
    redirect(site_url('admin/curadoria/avaliation_texts'));
  }

  private function getScriptsInline($images = '') {
    if (is_array($images)) {
      $images = implode(';', $images);
    }
    $scripts_inline = <<<SCRIPTS
      $(document).ready(function() {

        // URL for perform AJAX requests
        var url = window.location.protocol + '//' + window.location.hostname;

        // Get Amazon URL
        $.getJSON( url + '/ajax/common/get_amazon_url', function(urls) {
          // Script to upload images on the fly
          new upload_box('dropbox', 'message', 'images/items', urls.item, '12', 'thumbnails', '{$images}', 520, 520);
        });


        // Script to add Measurements Boxes
        $('.measurements_default').hide();
        $('#measurements_add').click(
          function() {
            var measurements = $('.measurements_default').clone();
            measurements.removeClass('measurements_default');
            $('#measurements_template').append(measurements);
            measurements.show();
            addRemovable();
          }
        );

        // Add text to the <textarea> based by the <select>
        $('#avaliation_id').bind('change', function() {
          var text = $(this).find('option:selected').attr('data-text');
          $('#avaliation-message').text(text);
        });

        $('#category').bind('change', function() {
          var category_id = $(this).find('option:selected').val();

          $('#sub-categories').children().hide();

          $('#category_sub_' + category_id).show();

        });

        // Script to add Material Boxes
        $('.materials_default').hide();
        $('#materials_add').click(
          function() {
            var materials = $('.materials_default').clone();
            materials.removeClass('materials_default');
            $('#materials_template').append(materials);
            materials.show();
            addRemovable();
          }
        );

        //Script to remove Variation Boxes
        addRemovable();
      });

      function addRemovable() {
        $('.variations_remove_current').click(
          function() {
            if ($(this).parent().parent().hasClass('measurements_default') || $(this).parent().parent().hasClass('materials_default')) {
              $(this).parent().parent().parent().hide();
            } else {
              $(this).parent().parent().parent().remove();
            }
          }
        );
      }
SCRIPTS;

    return $scripts_inline;
  }

}

/* End of file curadoria.php */
/* Location: ./application/controllers/admin/curadoria.php */
