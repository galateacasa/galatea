<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller
{
  /**
   * Set form rules
   * @var array
   */
  private $form_rules = array(

    // Name
    array(
      'field' => 'name',
      'label' => 'Nome do projeto',
      'rules' => 'required'
    ),

    // Description
    array(
      'field' => 'description',
      'label' => 'Descrição do projeto',
      'rules' => 'required|max_length[300]'
    ),

    // Description
    array(
      'field' => 'category',
      'label' => 'Categoria',
      'rules' => 'required'
    ),

    // Height
    array(
      'field' => 'measurements[height][]',
      'label' => 'Altura',
      'rules' => 'required'
    ),

    // Width
    array(
      'field' => 'measurements[width][]',
      'label' => 'Largura',
      'rules' => 'required'
    ),

    // Depth
    array(
      'field' => 'measurements[depth][]',
      'label' => 'Profundidade',
      'rules' => 'required'
    ),

    // Materials
    array(
      'field' => 'materials[]',
      'label' => 'Acabamento',
      'rules' => 'required'
    )

  );

  /**
   * Set category URL for AJAX requests
   * @var string
   */
  private $category_url;

  /**
   * Amazon URL that holds images
   * @var string
   */
  private $amazon_url;

  function __construct()
  {
    parent::__construct();

    // The user is logged in?
    if ( !$this->session->userdata('id') ) redirect('login');

    // Load needed helper
    $this->load->helper('html');

    // Define page URL
    $this->category_url = site_url('ajax/categories/get');

    // Define amazon URL for images
    $this->amazon_url = amazon_url('images/items');
  }

  public function index($page = 1)
  {
    $this->load->library('pagination');
    $params = "";

    $usr = $this->session->userdata('user');
    $developer = new User($usr['id']);

    $items = new Item();
    $items->where_related($developer);


    $date_start = date('Y-m-d', strtotime('-6 month'));
    $date_end = date("Y-m-d");
    if ($_GET) {
      if ($this->input->get('search')) {
        $search = $this->input->get('search');
        $items->ilike('name', $search);
        $params .= "?search=".$search;
      }


      if ($this->input->get('date_start') && $this->input->get('date_end')) {
        $date_start = pt_to_mysql_date($this->input->get('date_start'));
        $date_end = pt_to_mysql_date($this->input->get('date_end'));
        $params .= (empty($params)?"?":"&")."date_start=".$this->input->get('date_start')."&date_end=".$this->input->get('date_end');
      }
    }
    $date_start = $date_start . " 00:00:00";
    $date_end = $date_end . " 23:59:59";
    $where = "create_date BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
    $items->where($where);

    $items->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $items->order_by("create_date", "desc");
    $items->get_paged($page, 10);


    //Pagination
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('site/items/index/');
    $config['total_rows'] = $items->paged->total_rows;
    $config[ 'suffix'] = $params;
    $this->pagination->initialize($config);

    $toview['paginate'] = $this->pagination->create_links();
    $toview['items'] = $items;
    $toview['date_start'] = ($this->input->get('date_start'))?$this->input->get('date_start'):date('d/m/Y', strtotime('-6 month'));
    $toview['date_end'] = ($this->input->get('date_end'))?$this->input->get('date_end'):date("d/m/Y");
    $toview['search'] = ($this->input->get('search'))?$this->input->get('search'):"";

    $this->template->set_style(assets_url('css/plugins/datepicker/datepicker.css'));
    $this->template->set_script(assets_url('js/plugins/datepicker/bootstrap-datepicker.js'));
    $this->template->set_script(assets_url('js/site/item/index.js'));
    $this->template->load('main', 'site/item/index', $toview);
  }

  /**
   * Send supplier to the product request form
   * @param  integet $product_id Product unique ID
   * @return void
   */
  public function build($project_id)
  {
    # Define a new item
    $project = new Item($project_id);

    # Get only approved products (product = type 2)
    $project->where( array('status' => 1, 'type' => 2) );

    # Check if the product exists
    if( $project->exists() )
    {
      # Get logged user data
      $userdata = $this->session->userdata('user');

      # Define a new user
      $user = new User($userdata['id']);

      # Check if the user is a supplier
      if($userdata['role'] == 2)
      {
        # Check if the form was submitted
        if( $this->input->post() )
        {
          # Set the form rules to be applyed
          $this->form_validation->set_rules('subject', 'Assunto', 'required')
                                ->set_rules('message', 'Mensagem', 'required');

          # Check if all rules passed
          if( $this->form_validation->run() )
          {
            # Load email library
            $this->load->library('email');

            # Set email configurations
            {
              $this->email->from($user->email, $user->name);
              $this->email->to(EMAIL_GALATEA);
              $this->email->subject( $this->input->post('subject') );
              $this->email->message( $this->input->post('message') );
            }

            # Send email
            $this->email->send();

            # Define success message
            $this->session->set_flashdata('success', 'Sua mensagem foi enviada com sucesso. Nossa equipe entrará em contato por email ou telefone nos próximos dias.');

            # Redirect the user back to the product page
            redirect( site_url('site/items/show/' . $project->id) );

          }else{
            $this->session->set_flashdata('error', 'Verifique os campos "assunto" e "mensagem".');
          }
        }

        # Load HTML helper
        $this->load->helper('html');

        # Define breadcrumbs
        $breadcrumbs['breadcrumbs'] = array(

          # Main page
          array(
            'href'  => site_url(),
            'title' => 'Página inicial',
            'name'  => 'Home'
          ),

          # Category page
          array(
            'href'  => site_url('site/categories/show/' . $project->category->id),
            'title' => 'Projetos na categoria ' . $project->category->name,
            'name'  => $project->category->name
          ),

          # Product page
          array(
            'href'  => site_url('site/items/show/' . $project->id),
            'title' => 'Página do produto ' . $project->name,
            'name'  => $project->name
          )
        );

        # Define datas
        {
          $data['product']     = $project;
          $data['breadcrumbs'] = $this->load->view('site/common/breadcrumbs', $breadcrumbs, true);
          $data['user'] = $user;
        }

        # Load template
        $this->template->load('site', 'site/disponibility/create', $data);

      }else{

        # Define error message
        $this->session->set_flashdata('error', 'Somente fornecedores podem produzir projetos.');

        # Redirect the user
        redirect( site_url('site/disponibilities/show/' . $project->id) );
      }

    }else{

      # Set error message
      $this->session->set_flashdata('error', 'O produto que você está procurando não existe ou deixou de ser fabricado.');

      # Redirect user to the home page
      redirect( site_url() );

    }
  }

  /**
   * Create a new item (kown as project)
   * @return void
   */
  public function create()
  {
    // Check if the form was submitted
    if( $this->input->post() )
    {
      // Set the rules to be applyed
      $this->form_validation->set_rules( $this->form_rules );

      // Check if all rules passed
      if( $this->form_validation->run() )
      {
        // Create a new item database map instance
        $item = new Item();

        // Set the fields to be saved into the database
        {
          $item->user_id     = $this->session->userdata('id');
          $item->name        = $this->input->post('name');
          $item->description = $this->input->post('description');
          $item->category_id = $this->input->post('category');
          $item->type        = 1; // Set as a project
        }

        // Check if the values has been saved correctly
        if( !$item->save() ){
          $this->session->set_flashdata('error', $item->error->transaction);
          redirect('site/items');
        }

        // Save measures
        {
          // Get all measures values
          $measures = $this->input->post('measurements');

          // Save all values
          for($i = 0; $i < count($measures['height']); $i++)
          {
            $measure = new Item_Variation_Measurement();
            $measure->item_id = $item->id;
            $measure->width   = $measures['width'][$i];
            $measure->height  = $measures['height'][$i];
            $measure->depth   = $measures['depth'][$i];
            $measure->save();
          }
        }

        // Save materials
        {
          // Get all materials values
          $materials = $this->input->post('materials');

          // Save all values
          for($i = 0; $i < count($materials); $i++)
          {
            $material = new Item_Variation_Material();
            $material->item_id  = $item->id;
            $material->material = $materials[$i];
            $material->item_id   = $item->id;
            $material->save();
          }
        }

        // Check if principal_image was sent
        if( $this->input->post('image') )
        {
          $principal_image = $this->input->post('image');
          $item_image            = new Item_Image();
          $item_image->item_id   = $item->id;
          $item_image->image     = $principal_image;
          $item_image->principal = 1;
          $item_image->save();
        }

        // Check if any secondary_image was sent
        if( $this->input->post('images') )
        {
          // Define secondary_images array
          $secondary_images = $this->input->post('images');

          // Save all images into database
          foreach ($secondary_images as $secondary_image) {
            $item_images = new Item_Image();
            $item_images->item_id = $item->id;
            $item_images->image   = $secondary_image;
            $item_images->save();
          }
        }

        // Load necessary libraries to send email
        $this->load->library( array('email/EmailService', 'email/EmailSite') );

        // Send message
        $emailSite = new EmailSite();
        $emailSite->sendProjectSubmitted(array(
            'title'     => 'Recebemos o seu projeto!',
            'userEmail' => $item->user->email,
            'userName'  => $item->user->name
        ));

        // Set success message
        $this->session->set_flashdata('success', 'Projeto cadastrado com sucesso! Nossa Curadoria enviará uma resposta por email em até cinco dias úteis. Enquanto isso, confira nesta página todos os projetos em votação');

        // Redirect the user to the public page
        redirect( site_url('categoria/vote') );
      }else{
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('site/items/create'));
      }
    }else{
      // Get custom styles
      $this->get_styles();

      // Get custom scripts
      $this->get_scripts();

      // Define document title
      $this->template->set_title('Enviar projeto - Galatea');

      // Create breadcrumbs markup
      $breadcrumbs['breadcrumbs'] = array(

        // Main page
        array(
          'href'  => site_url(),
          'title' => 'Página inicial',
          'name'  => 'Home'
        ),

        // Create project page
        array(
          'href'  => site_url('sites/items/create'),
          'title' => 'Enviar projeto',
          'name'  => 'Enviar projeto'
        )

      );

      // Create the databases map User based into the logged int user
      $data['user'] = new User($this->session->userdata('id'));

      // Create a new database object to map Items
      $data['item'] = new Item();

      // Create a new database object to map Categories
      $data['category'] = new Category();

      // Define breadcrumb html markup
      $data['breadcrumbs'] = $this->load->view('site/common/breadcrumbs', $breadcrumbs, TRUE);

      // Load template
      $this->template->load('site', 'site/item/create', $data);
    }
  }

  /**
   * Edit a specific item
   * @param  integer $item_id Item ID
   * @return void
   */
  public function edit($item_id)
  {
    // Collect logged user data
    $userdata = $this->session->userdata('user');

    // Instanciate a new Item database
    $item = new Item($item_id);

    // Check if the item exists
    if( $item->exists() and $item->user_id == $userdata['id'] )
    {
      // Check if the form was submitted
      if( $this->input->post() )
      {
        // Define the rules to be validated
        $this->form_validation->set_rules( $this->form_rules );

        // Check if all rules is validated
        if( $this->form_validation->run() )
        {
          // Check if the sub-category was sent
          if( $this->input->post('sub_category') ):
            $category_id = $this->input->post('sub_category');
          else:
            $category_id = $this->input->post('main_category');
          endif;

          // Update item
          $item->where('id', $item->id)->update(
            array(
              'name'        => $this->input->post('name'),
              'description' => $this->input->post('description'),
              'category_id' => $category_id
            )
          );

          // Get all materials
          $item_materials = new Item_Variation_Material();
          $item_materials->where('item_id', $item->id)->get();

          // Remove all materials entries
          foreach($item_materials as $item_material) $item_material->delete();

          // Define variations information
          $materials = $this->input->post('materials');

          // Update item variation material
          for($i = 0; $i < count($materials); $i++ )
          {
            // Instanciate a new item material variation object
            $item_material = new Item_Variation_Material();
            $item_material->item_id  = $item->id;
            $item_material->material = $materials[$i];

            // Save object
            $item_material->save();
          }

          // Define variations information
          $item_measurements = new Item_Variation_Measurement();
          $item_measurements->where('item_id', $item->id)->get();

          // Delete all measurements entries
          foreach($item_measurements as $item_measurement) $item_measurement->delete();

          // Define variations information
          $measurements = $this->input->post('measurements');

          // Update item variation measurements
          for($i = 0; $i < count($measurements['height']); $i++ )
          {
            // Instanciate a new item material variation object
            $item_measurement = new Item_Variation_Measurement();
            $item_measurement->item_id = $item->id;
            $item_measurement->height  = $measurements['height'][$i];
            $item_measurement->width   = $measurements['width'][$i];
            $item_measurement->depth   = $measurements['depth'][$i];

            // Save object
            $item_measurement->save();
          }

          // Check if any image was sent
          if( $this->input->post('images') )
          {
            // Delete all current images from database
            {
              $images = new Item_image();
              $images->where('item_id', $item->id)->get();
              foreach($images as $image) $image->delete();
            }

            // Define principal image that was sent from form
            if($this->input->post('image')){
              $principal_image = $this->input->post('image');

              // Save principal_image into database
              $item_image            = new Item_image();
              $item_image->item_id   = $item->id;
              $item_image->image     = $principal_image;
              $item_image->principal = 1;
              $item_image->save();
            }

            // Define secondary_images that was sent from form
            $secondary_images = $this->input->post('images');

            // Save all images into database
            foreach ($secondary_images as $secondary_image) {
              $item_image          = new Item_image();
              $item_image->item_id = $item->id;
              $item_image->image   = $secondary_image;
              $item_image->save();
            }

          }

          // Set success message
          $this->session->set_flashdata('success', "As alterações realizadas no projeto {$item->name} foram salvas com sucesso!");

          // Redirect user to the public page
          redirect( base_url('site/items/show/' . $item->id) );

        }else{
          // Define error message
          $this->session->set_flashdata('error', 'Por favor, verifique os dados do projeto');
        }
      }

      // Define document title
      $this->template->set_title($item->name . ' - Galatea');

      if( $this->input->post() )
      {
        $main_category = $this->input->post('main_category');
        $sub_category  = $this->input->post('sub_category');
        $measurements  = $this->input->post('measurements');
        $materials     = $this->input->post('materials');
      }else{

        // Define measurements
        foreach( $item->Item_Variation_Measurement->get() as $measurement) {
          $measurements['height'][] = $measurement->height;
          $measurements['width'][]  = $measurement->width;
          $measurements['depth'][]  = $measurement->depth;
        }

        // Define materials
        foreach( $item->Item_Variation_Material->get() as $material) $materials[] = $material->material;

        // Check if item category have any parent category
        $item_category = new Category($item->category_id);
        if($item_category->parent_id == 0):
          $main_category = $item_category->id;
          $sub_category  = 0;
        else:
          $main_category = $item_category->parent_id;
          $sub_category  = $item_category->id;
        endif;

      }

      // Load scripts
      $this->get_scripts($main_category, $sub_category);

      // image upload scripts
      // principal image
      $item_image_principal = new Item($item->id);
      $item_image_principal->item_image->where('principal', 1)->get();
      $principal_image = $item_image_principal->item_image->image;

      //secondary images
      $item_secondary_images = new Item($item->id);
      $secondary_images = '';
      foreach ($item_secondary_images->item_image->where('principal', 0)->get() as $image ){
        $secondary_images .= empty($secondary_images) ? $image->image : ";".$image->image;
      };

      $scripts_edit = <<<SCRIPTS
      new Dropdown( 'main-category', 'sub-category', '{$this->category_url}', {$main_category}, {$sub_category});

      //Custom input upload
      $('#principal_img').customFileInput();

      // Script to upload principal image
        new upload_box('dropbox_principal', '', 'images/items', '{$this->amazon_url}', 1, 'result_box_principal', '{$principal_image}', 240, 100, 'principal_img');

        //Custom input upload
      $('#secondary_img').customFileInput();

      // Script to upload secondary images
      new upload_box('dropbox_secondary', '', 'images/items', '{$this->amazon_url}', 5, 'thumbnails', '{$secondary_images}', 240, 100, 'secondary_img');
SCRIPTS;
      $this->template->set_script('', $scripts_edit);

      // Load styles
      $this->get_styles();

      // Breadcrumbs variables
      $breadcrumbs['breadcrumbs'] = array(
        array(
          'href'  => site_url(),
          'title' => 'Página inicial',
          'name'  => 'Home'
        ),

        array(
          'href'  => site_url('site/categories/show/' . $item->category->id),
          'title' => 'Projetos na categoria ' . $item->category->name,
          'name'  => $item->category->name
        ),

        array(
          'href'  => site_url('site/items/show/' . $item->id),
          'title' => 'Página do item ' . $item->name,
          'name'  => $item->name
        ),

        array(
          'href'  => site_url('site/items/edit/' . $item->id),
          'title' => 'Página do item ' . $item->name,
          'name'  => 'Editar'
        )
      );

      // Define view variables
      {
        $data['breadcrumbs']   = $this->load->view('site/common/breadcrumbs', $breadcrumbs, TRUE);
        $data['main_category'] = $main_category;
        $data['item']          = $item;
        $data['measurements']  = $measurements;
        $data['materials']     = $materials;
        $data['images']        = $item->item_image->get();
      }

      // Define the template to be used
      $this->template->load('site', 'site/item/edit', $data);

    }else{

      // Set error message
      $this->session->set_flashdata('error', 'Projeto não encontrado.');

      // Redirect the user to a 404 Not Found page
      redirect( site_url() );
    }
  }

  /**
   * Responsible to show the public page for item (project)
   * @param  integer $item_id Item ID
   * @return void
   */
  function show($item_id)
  {
    // Instanciate a new item database object
    $item = new Item($item_id);

    // Check if the item exists into the database and it's approved by the admin
    if(
      $item->exists() and
      ($item->status != 0 or $item->user_id == $this->session->userdata('id') ) and
      $item->type == 1 and
      $item->delivery_date < date('Y-m-d')
    )
    {
      // Define document title
      $this->template->set_title($item->name . ' - Galatea');

      // Load the library for the Google Chart
      $this->load->library('googlechart');

      // Load messages library
      $this->load->library('message');

      // Define the item to be used into the Google Chart
      $this->googlechart->setItem($item);

      // Define messages
      $message = new Message();
      $message->define('project', $item_id);

      // Breadcrumbs variables
      $breadcrumbs['breadcrumbs'] = array(
        array(
          'href'  => site_url(),
          'title' => 'Página inicial',
          'name'  => 'Home'
        ),

        array(
          'href'  => site_url('site/categories/show/' . $item->category->id),
          'title' => 'Projetos na categoria ' . $item->category->name,
          'name'  => $item->category->name
        ),

        array(
          'href'  => site_url('site/items/show/' . $item->id),
          'title' => 'Página do item ' . $item->name,
          'name'  => $item->name
        )
      );

      // Social links
      {
        $this->load->library('social_links');
        $social_links = new Social_Links();

        $toview['socialLinks'] = $social_links->get($item->name, $item->description, $item->item_image->get()->image, base_url('site/items/show/' . $item->id));
      }

      $related_items = new Item();
      $related_items->where( array('category_id' => $item->category->id, 'id !=' => $item->id) );

      // Set variables to be used into the view
      {
        $toview['item']          = $item;
        $toview['breadcrumbs']   = $this->load->view('site/common/breadcrumbs', $breadcrumbs, true);
        $toview['related_items'] = $related_items;
        $toview['user']          = new User( $this->session->userdata('id') );
        $toview['message']       = $message;
      }

      $inline_scripts = <<<SCRIPTS

        $(document).ready(function () {

          $('#btnAdd').click(function () {
            $('#divShort').append("");
            short.InValidate();
          });

          $("#carousel").jCarouselLite({
            btnNext: ".next",
            btnPrev: ".prev"
          });

        });
SCRIPTS;

      // Define JavaScript files that need to be included
      {
        // Libraries
        $this->template->set_script( assets_url('js/lib/jquery-ui-1.9.2.custom.min.js') );
        $this->template->set_script( $this->googlechart->getRemoteScript() ); // Google Chart

        $this->template->set_script( assets_url('js/plugins/jquery.ae.image.resize.min.js') );
        $this->template->set_script( assets_url('js/plugins/customSelect.jquery.js') );
        $this->template->set_script( assets_url('js/plugins/jquery.mCustomScrollbar.js') );
        $this->template->set_script( assets_url('js/plugins/jquery.tinyscrollbar.min.js') );

        $this->template->set_script( assets_url('js/site/item/show.js') );
        $this->template->set_script( assets_url('js/site/script.js') );
        $this->template->set_script( assets_url('js/site/thumb.js') );

        $this->template->set_script('', $inline_scripts);
        $this->template->set_script('', $this->googlechart->getInlineScript() ); // Google chart parameters
      }

      // Load the correctly template
      $this->template->load('site', 'site/item/show', $toview);

    }else{

      // Set error message
      $this->session->set_flashdata('error', 'Item não encontrado ou em processo de aprovação');

      // Redirect user to 404 Not Fount page
      $this->redirect404();

    }
  }

  //Remove Variations that are not included in the $arrVariations array
  //Remove Variation values that are not included in the $arrValues array
  public function removeVariations($item_id, $arrVariations, $arrValues){
    $item = new Item($item_id);

    //Variations Values
    $item_variation_values = new Item_Variation_Value();
    $item_variation_values->where_related('item_variation/item','id', $item);
    if(count($arrValues) > 0){
      $item_variation_values->where_not_in('id', $arrValues);
    }
    $item_variation_values->get();
    if (!$item_variation_values->delete_all()) {
      $this->session->set_flashdata('error', 'Erro ao excluir valor de variação');
      redirect(site_url('admin/items/edit/'.$item_id));
    }

    //Variations
    $item_variations = new Item_Variation();
    $item_variations->where_related('item', 'id', $item);

    if(count($arrVariations) > 0) $item_variations->where_not_in('id', $arrVariations);

    $item_variations->get();

    if(!$item_variations->delete_all()){
      $this->session->set_flashdata('error', 'Erro ao excluir variações');
      redirect(site_url('admin/items/edit/'.$item_id));
    }
  }

  /**
   * Redirect user to 404 Not Fount page
   * @return void
   */
  private function redirect404(){
    redirect( site_url('galatea_404') );
  }

  /**
   * Retriave the rules to be used into the form
   * @return array Form rules
   */
  private function get_form_rules(){
    return $this->form_rules;
  }

  /**
   * Get the common styles to be used into some views
   * Usually used by "create" and "edit" method
   * @return void
   */
  private function get_styles()
  {
    // Define inline styles
    $inline_styles = <<<STYLES

      #dropbox_principal {
        background: #E7E6E6;
        color: #979797;
        display: block;
        width: 690px;
        margin: 20px 0;
        padding: 43px 0;
        text-align: center;
        text-transform: uppercase;
        float: left;
      }

      #result_box_principal{
        background: #CECECE;
        display: block;
        float: right;
        height: 100px;
        margin: 20px 0;
        overflow: hidden;
        text-align: center;
        text-transform: uppercase;
        width: 240px;
      }

      #result_box_principal img {
        display: block;
        margin: 0 auto;
        max-height: 100%;
        max-width: 100%;
      }

      #dropbox_secondary {
        background: #E7E6E6;
        color: #979797;
        display: block;
        width: 100%;
        margin: 20px 0;
        padding: 43px 0;
        text-align: center;
        text-transform: uppercase;
        float: left;
      }

      #thumbnails {
        margin-bottom: 100px;
      }

      #thumbnails img{
        display: block;
        margin: 0 auto;
        max-height: 100%;
        max-width: 100%;
      }

      #thumbnails li {
        border: 1px solid;
        display: inline;
        float: left;
        height: 70px;
        margin-left: 40px;
        overflow: hidden;
        width: 140px;
      }

      .category_select{
        top: 16px;
        left: 8px !important;
      }

STYLES;

    // Set inline styles
    $this->template->set_style('', $inline_styles);
  }

  /**
   * Get the common scripts to be used into some views
   * Usually used by "create" and "edit" method
   * @return void
   */
  private function get_scripts($dropdown_main = 0, $dropdown_sub = 0)
  {
    // Define scripts that need to be updated dynamically
    $scripts_inline = <<<SCRIPTS
      // Script to work with dropdown options for categories

SCRIPTS;

    // Set external JavaScripts
    {
      // Scripts
      $scripts = array(
        'site/tooltip',
        'site/upload_box',
        'plugins/jquery.jqEasyCharCounter',
        'plugins/jquery.ae.image.resize.min',
        'site/item/item-scripts'
      );

      // Set all scripts
      foreach($scripts as $script) $this->template->set_script( assets_url('js/' . $script . '.js') );
    }

    // Set scripts
    $this->template->set_script('', $scripts_inline);
  }

  public function produce(){
    $usr = $this->session->userdata('user');
    $user = new User($usr['id']);

    //projects most voted
    $projects_most_voted = new Item();
    $projects_most_voted->where(array('type' => 1, 'status' => 1 ));
    $projects_most_voted->include_related_count('item_vote');
    $projects_most_voted->order_by('item_vote_count', 'desc');
    $projects_most_voted->get();

    $products_most_voted = new Item();
    $products_most_voted->where(array('type' => 2, 'status' => 1 ));
    $products_most_voted->include_related_count('item_vote');
    $products_most_voted->order_by('item_vote_count', 'desc');
    $products_most_voted->get();

    $toview['user']                = $user;
    $toview['projects_most_voted'] = $projects_most_voted;
    $toview['products_most_voted'] = $products_most_voted;
    $toview['current_menu']        = 'produce';
    $toview['content']             = 'site/item/produce';
    $this->template->load('site', 'site/about/index', $toview);
  }

}
