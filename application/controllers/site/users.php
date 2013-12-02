<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Class for user main usr actions
 *
 * PHP version 5.3+
 *
 * @category Galatea
 * @package Controllers
 * @subpackage Site
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arhur@aduarte.net>
 * @see CI_Controller
 *
 */
class Users extends CI_Controller
{
  /**
   * profile
   *
   * show user profile
   *
   * @access public
   * @return void
   */
  public function profile($username)
  {
    // Helper to format MySQL datatime and HTML markup
    $this->load->helper( array('message_date', 'html') );

    // Load social links library
    $this->load->library( array('social_links', 'vote_button', 'message') );

    // Define a new user instance
    $user = new User();
    $user->where('username', $username)->get();

    // Check if the user exists
    if( !$user->exists() )
    {
      // Set error message
      $this->session->set_flashdata('error', 'Perfil não encontrado.');

      // Redirect user to the 404 not found page
      redirect('galatea_404');
    }

    // Verify if logged user is the owner of the profile
    $loggedUser = $user->id == $this->session->userdata('id') ? $user : new User( $this->session->userdata('id') );
    // if ( $user->id == $this->session->userdata('id') ) {
    //   $loggedUser = $user;
    // }else{
    //   $loggedUser
    // }

    // Followings
    $user_following = new User_Vote();
    $user_following->where( array('user_voted_id'=> $user->id) )->get();

    // Followers
    $user_followers = new User_Vote();
    $user_followers->where('user_id', $user->id)->get();

    // Products
    $user_products = new Item();
    $user_products->where( array('user_id' => $user->id, 'status' => 1, 'type' => 2) )
                  ->order_by('create_date', 'desc')
                  ->get();

    // Products starred
    $user_products_starred = new Item();
    $user_products_starred->where( array('status' => 1, 'type' => 2) )
                          ->where_related_item_vote('user_id', $user->id)
                          ->order_by('create_date', 'DESC')
                          ->get();

    // Projects
    $user_projects = new Item();
    $user_projects->where( array('user_id' => $user->id, 'status' => 1, 'type' => 1, 'delivery_date <' => date('Y-m-d') ) )
                  ->order_by('create_date', 'DESC')
                  ->get();

    // Projects starred
    $user_projects_starred = new Item();
    $user_projects_starred->where( array('status' => 1, 'type' => 1, 'delivery_date <' => date('Y-m-d') ) )
                          ->where_related_item_vote('user_id', $user->id)
                          ->order_by('create_date', 'DESC')
                          ->get();

    // Ambiances
    $user_ambiances = new Ambiance();
    $user_ambiances->where( array('user_id' => $user->id, 'status' => 1) )
                   ->order_by('create_date', 'desc')
                   ->get();

    // Ambiances starred
    $user_ambiances_starred = new Ambiance();
    $user_ambiances_starred->where('status', 1)
                           ->where_related_ambiance_vote('user_id', $user->id)
                           ->order_by('create_date', 'desc')
                           ->get();

   // Messages received
   $user_messages = array();
   $user_unread_messages = new User_Message();
   $user_unread_messages->select("*")
                        ->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y as %H:%i:%s'), 'create_date')
                        ->where('user_id', $loggedUser->id)
                        ->where('read_date', 0)
                        ->order_by('create_date', 'desc')
                        ->get();

    foreach ($user_unread_messages as $user_message) {
      if($user_message->type == 1){
        $title = " te deixou uma mensagem:";
      }else{
        $title = " está seguindo você";
      }
      $msg = <<< MESSAGE
        <mark>{$user_message->sender->name}</mark>{$title}
        {$user_message->message}
        <span class="time">{$user_message->create_date}</span>
MESSAGE;

      $msg = str_replace(array("\r\n", "\r", "\n"), "", $msg);
      $user_messages[] = array('id' => $user_message->id, 'type' => 1, 'content' => $msg);
    }

    //Project messages received
    $item_unread_messages = new Item_Message();
    $item_unread_messages->select("*")
                         ->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y as %H:%i:%s'), 'create_date');
    $item_unread_messages->where_related('item', 'user_id', $loggedUser->id)
                         ->where('read_date', 0)
                         ->order_by('create_date', 'desc')
                         ->get();

    foreach ($item_unread_messages as $item_message) {
      if ($item_message->type == 1) {
        //messages
        if($item_message->item->type == 1){
          $title = " deixou uma mensagem no projeto ".$item_message->item->name.":";
        }else{
          $title = " deixou uma mensagem no produto ".$item_message->item->name.":";
        }
      }else{
        //Votes
        if($item_message->item->type == 1){
          $title = " está seguindo o projeto ".$item_message->item->name.":";
        }else{
          $title = " está seguindo o produto ".$item_message->item->name.":";
        }

      }
      $msg = <<< MESSAGE
      <mark>{$item_message->sender->name}:</mark>{$title}
            {$item_message->message}
          <span class="time">{$item_message->create_date}</span>
MESSAGE;

      $msg = str_replace(array("\r\n", "\r", "\n"), "", $msg);
      $user_messages[] = array('id' => $item_message->id, 'type' => 2, 'content' => $msg);
    }

    // Define social links object
    $social_links = new Social_Links();

    // Define vote button object
    $vote_button  = new Vote_Button();

    // Define message and reviews object
    $message = new Message();
    $message->define('profile', $user->id);

    // Set scripts
    {
      $scripts = array(
        'lib/jquery-ui-1.9.2.custom.min',
        'site/VerticalSlider',
        'site/HorizontalSlider',
        'site/script'
      );

      // Set all external scripts
      foreach($scripts as $script) $this->template->set_script( assets_url('js/' . $script . '.js') );
    }

    // Add custom script for user profile
    $this->template->set_script( assets_url('js/site/user/profile.js') );

    // Define variables to be used into the view
    {
      $toview['user']                   = $user;
      $toview['user_following']         = $user_following;
      $toview['user_followers']         = $user_followers;
      $toview['user_products']          = $user_products;
      $toview['user_products_starred']  = $user_products_starred;
      $toview['user_projects']          = $user_projects;
      $toview['user_projects_starred']  = $user_projects_starred;
      $toview['user_ambiances']         = $user_ambiances;
      $toview['user_ambiances_starred'] = $user_ambiances_starred;
      $toview['user_unread_messages']   = $user_messages;
      $toview['social_links']           = $social_links;
      $toview['vote_button']            = $vote_button;
      $toview['message']                = $message;
    }

    // Views to be included
    {
      $auxiliar_views = array(
        'information',
        'products',
        'projects',
        'ambiances',
        'friends',
        'messages'
      );

      foreach($auxiliar_views as $auxiliar_view)
        $toview['profile_' . $auxiliar_view] = $this->load->view("site/user/profile/$auxiliar_view", $toview, true);
    }

    // Load template
    $this->template->load('site', 'site/user/profile', $toview);
  }

  /**
   * edit
   *
   * edit user
   *
   * @access public
   * @return void
   */
  public function edit()
  {

    // The user is logged in?
    if( !$this->session->userdata('id') ) {
      $this->__goLogin();
    }

    // Instanciate a new user
    $user = new User( $this->session->userdata('id') );

    // The user exists?
    if ( !$user->exists() ) {
      $this->__goLogin();
    }

    // The form was submitted?
    if( $this->input->post() ) {

      $this->load->helper( array('clear_number', 'first_cap') );

      // Form rules to be used into form validation
      $form_rules = array(

        // First name
        array(
          'field' => 'name',
          'label' => 'Nome',
          'rules' => 'required',
        ),

        // Last name
        array(
          'field' => 'surname',
          'label' => 'Sobrenome',
          'rules' => 'required',
        ),

        // Zip code
        array(
          'field' => 'zip',
          'label' => 'CEP',
          'rules' => 'required',
        ),

        // Area code
        array(
          'field' => 'areaCode',
          'label' => 'DDD',
          'rules' => 'required',
        ),

        // Phone
        array(
          'field' => 'phone',
          'label' => 'Telefone',
          'rules' => 'required',
        ),

        // Street name
        array(
          'field' => 'street',
          'label' => 'Rua',
          'rules' => 'required',
        ),

        // Number
        array(
          'field' => 'number',
          'label' => 'Número',
          'rules' => 'required',
        ),

        array(
          'field' => 'state',
          'label' => 'Estado',
          'rules' => 'required',
        ),

        array(
          'field' => 'city',
          'label' => 'Cidade',
          'rules' => 'required',
        ),

        array(
          'field' => 'country',
          'label' => 'País',
          'rules' => 'required',
        ),

      );

      // Define form rules
      $this->form_validation->set_rules($form_rules);

      // The user is a supplier?
      if($user->role == 2){
        $this->form_validation->set_rules('company_name', 'Razão Social', 'required')
                              ->set_rules('cnpj', 'CNPJ', 'required');
      }else{
        $this->form_validation->set_rules('cpf', 'CPF', 'required');
      }

      $this->form_validation->set_message('required', 'O campo %s é obrigatório.');

      $user->name        = clear_number( first_cap( $this->input->post('name') ) );
      $user->surname     = clear_number( first_cap( $this->input->post('surname') ) );
      $user->cpf         = $this->input->post('cpf');
      $user->description = $this->input->post('description');
      $user->image       = $this->input->post('image');

      //suppliers data
      if ( $user->role == 2 ) {
        $user->company_name = $this->input->post('company_name');
        $user->cnpj         = $this->input->post('cnpj');
      }

      // Any expertise was submitted? (usually when a supplier update their profile)
      if ( $this->input->post('expertise') ) {

        // Remove old user expertise relationships
        $user_expertise_del = new User_Expertise();
        $user_expertise_del->where('user_id', $user->id)->get();
        $user_expertise_del->delete_all();

        // Add news
        foreach ( $this->input->post('expertise') as $exp ) {

          $user_expertise = new User_Expertise();
          $user_expertise->user_id = $user->id;
          $user_expertise->expertise_id = $exp;

          // Save everything
          $user_expertise->save();
        }

      }

      // Any delivery address was submitted?
      if ( $this->input->post('delivery_address') ) {

        // Get delivery address data
        $_addresses = $this->input->post('delivery_address');

        // Have any address to be updated?
        if ( isset($_addresses['old']) ) $this->__updateAddresses($_addresses['old']);

        // Have any new address to be added?
        if ( isset($_addresses['new']) ) $this->__saveAddresses($_addresses['new']);

      }else{
        $this->__deleteAddresses();
      }

      /**
       * Set up all new user data
       *
       * City and state only will be set up if the country is Brasil (ID = 36)
       */
      {
        $user->zip        = $this->input->post('zip');
        $user->areaCode   = $this->input->post('areaCode');
        $user->phone      = $this->input->post('phone');
        $user->street     = $this->input->post('street');
        $user->number     = $this->input->post('number');
        $user->complement = $this->input->post('complement');
        $user->country_id = $this->input->post('country_id');
        $user->state_id   = $this->input->post('country_id') == 36 ? $this->input->post('state_id') : 0;
        $user->city_id    = $this->input->post('country_id') == 36 ? $this->input->post('city_id') : 0;
      }

      // Check if all data was saved
      if ( $user->save() ) {

        // Set success message
        $this->session->set_flashdata('success', 'Dados atualizados com sucesso');

        // Check if is neccessary to redirect the user to the cart page
        if ( $this->input->post('go_cart') ):
          redirect('carrinho-de-compras');
        else:
          redirect('minha-conta');
        endif;

      }

    }

    // Instanciate new extersite model
    $expertises = new Expertise();

    // Define delivery address as empty
    $deliveryAddress = FALSE;

    // The user has defined any delivery address?
    if ( $user->delivery_address->get()->exists() ) {

      // Add all address form
      foreach( $user->delivery_address->get() as $_deliveryAddress):

        // Define default country ID if necessary
        $_deliveryAddress->country_id = isset($_deliveryAddress->country_id) ? $_deliveryAddress->country_id : 36;

        // Define the data to be used from user
        $_data['data'] = $_deliveryAddress->to_array();

        // Define countries information
        $_data['countries'] = $this->__getCountries(TRUE);

        // Render the view
        $deliveryAddress .= $this->load->view('site/user/edit/delivery_address_old', $_data, TRUE);

      endforeach;

    }

    // Define states and cities
    {
      $states = form_dropdown('state_id', $this->__getData(new State(), TRUE), $user->state_id, 'class="styled state" id="state_id"');

      $cities = new City();
      $cities->where('state_id', $user->state_id);
      $cities = form_dropdown('city_id', $this->__getData($cities, TRUE), $user->city_id, 'class="styled city" id="city_id"');
    }
    // Define view variables
    {
      $toview['expertises']        = $expertises->get();
      $toview['user']              = $user;
      $toview['countries']['all']  = $this->__getCountries(TRUE);
      $toview['countries']['user'] = isset($user->country_id) ? $user->country_id : 36; // 36 means Brasil in database
      $toview['deliveryAddress']   = $deliveryAddress;
      $toview['content']           = 'site/user/edit';
      $toview['current_menu']      = 'edit_user';
    }


    // Define external scripts
    $external_scripts = array(
      'plugins/jquery.maskedinput',
      'plugins/jquery.jqEasyCharCounter',
      'site/address_search',
      'site/user/edit'
    );

    // Set all external scripts
    foreach ( $external_scripts as $external_script ) $this->template->set_script( assets_url("js/$external_script.js") );

    // Load template
    $this->template->load('site', 'site/about/index', $toview);
  }

  /**
   * Send an email to some user
   * @param  object $user    User object generated from Data Mapper
   * @param  string $subject Subject to me used into the email subject field
   * @param  string $body    Email body content
   * @return void
   */
  public function send_email($user, $subject, $body)
  {
    // Check if all parameters was set
    if($user and $subject and $body)
    {
      $this->load->helper('words_to_html');

      $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
      $this->email->to($user->email);
      $this->email->subject($subject);
      $this->email->message($body);
      $this->email->send();
    }
  }

  public function send_change_password_email($user, $hash)
  {
    $data['title'] = "Olá {$user->name},";
    $data['text'] = array(
      "Para criar uma nova senha, clique no link abaixo:",
      anchor("site/users/change_password?hash=$hash", base_url('site/users/change_password')),
      "Obrigado,",
      "Time Galatea Casa.",
    );

    // Send email
    $this->send_email($user, 'Troque sua senha na Galatea Casa', $this->load->view('site/common/email/default', $data, TRUE));
  }

  /**
   * send_confirmation_email
   *
   * send user confirmation email
   *
   * @access public
   * @param object $user
   * @return void
   */
  function send_confirmation_email($user = FALSE)
  {
    // The user was set up?
    if($user)
    {
      $data['title'] = "Olá {$user->name},";
      $data['text'] = array(
        "Para confirmar seu cadastro na Galatea, por favor clique no link abaixo.",
        anchor("validate_email/{$user->email_confirmation_hash}",
        base_url("validate_email/{$user->email_confirmation_hash}")),
        "A GALATEA nasceu de um pequeno grupo de apaixonados por design e decora&ccedil;&atilde;o que tem como miss&atilde;o oferecer m&oacute;veis incr&iacute;veis a pre&ccedil;os justos. Como? " . anchor('site/about/index/about_galatea','Leia mais aqui') . ".",
        "Seja bem-vindo!",
        "Time Galatea Casa."

      );

      $this->send_email($user, 'Galatea - Confirme seu cadastro', $this->load->view('site/common/email/default', $data, TRUE));
    }
  }

  /**
   * Send user specific message based into role
   *
   * @access public
   * @param integer $role User role ID reference
   * @param string  $name User name
   * @return void
   */
  public function sendWelcomeEmail($role, $name)
  {
      // Put only the first letter uppercase
      $user->name = ucwords( strtolower($name) );

      switch($role) {

        // Supplier
        case 2:
          $data['title'] = "{$name}, seja bem-vindo a Galatea!";
          $data['text'] = array(
            "A GALATEA &eacute; um novo modelo no mercado da alta movelaria. Conectamos pessoas, tiramos boas ideias do papel e entregamos m&oacute;veis de qualidade na sua casa. E o melhor: com a mesma qualidade das lojas de alto padr&atilde;o mas a um pre&ccedil;o at&eacute; seis vezes menor.",
            "Como? Trabalhando junto com voc&ecirc;.",

            "<strong>Produza para a Galatea: temos pedidos novos todos os meses para voc&ecirc;.</strong><br>".

            "Se voc&ecirc; &eacute; especialista em produ&ccedil;&atilde;o de m&oacute;veis e objetos de decora&ccedil;&atilde;o, prima pela qualidade e possui pre&ccedil;o competitivo, n&atilde;o tenha d&uacute;vidas: seremos excelentes parceiros.",

            "Procuramos fornecedores s&eacute;rios para atender a clientes em todo o Brasil. Os pedidos chegam a voc&ecirc; por email &agrave; medida que as vendas s&atilde;o feitas no site. Toda a parte comercial &eacute; resolvida pela GALATEA e voc&ecirc; ficar&aacute; focado apenas naquilo que sabe fazer melhor. " . anchor('site/about/index/supplier', 'Saiba mais.'),

            "Veja " . anchor('site/categories/show_projects', 'aqui') . " os projetos GALATEA que precisam de fornecedores.",

            "Seja bem-vindo!",

            "Time Galatea Casa."

          );
          break;

        // Designer
        case 3:
          $data['title'] = "{$name}, seja bem-vindo a Galatea!";
          $data['text'] = array(
            "A GALATEA &eacute; um novo modelo no mercado da alta movelaria. Conectamos pessoas, tiramos boas ideias do papel e entregamos m&oacute;veis de qualidade na sua casa. E o melhor: com a mesma qualidade das lojas de alto padr&atilde;o mas a um pre&ccedil;o at&eacute; seis vezes menor.",

            "Como? Trabalhando junto com voc&ecirc;.",

            "<strong>Desenhe m&oacute;veis para a Galatea: aqui sua ideia vira produto.</strong><br>".

            "Apostamos no conceito de crowdsourcing para fazer a liga&ccedil;&atilde;o direta entre quem cria e quem consome m&oacute;veis de alta qualidade. Envie seu projeto para a gente. Se ele for aprovado e vencer a vota&ccedil;&atilde;o do p&uacute;blico, a GALATEA cuidar&aacute; de todo o processo: prototipagem, produ&ccedil;&atilde;o, comercializa&ccedil;&atilde;o e distribuição do seu produto. Voc&ecirc; receber&aacute; royalties de acordo com as vendas. " . anchor('site/about/index/credits', 'Saiba mais') . ".", "Conhe&ccedil;a alguns de nossos produtos preferidos:<br>".

            "- Rack Duo, por Silvia Grilli<br>".
            "- Vaso Cactus, por Regina Escher<br>".
            "- Lumin&aacute;ria Champignon, por Luiz Camara",

            "Seja bem-vindo!",

            "Time Galatea Casa."

          );
          break;

        // Decorator
        case 4:
          $data['title'] = "{$name}, seja bem-vindo a Galatea!";
          $data['text'] = array(
            "A GALATEA &eacute; um novo modelo no mercado da alta movelaria. Conectamos pessoas, tiramos boas ideias do papel e entregamos m&oacute;veis de qualidade na sua casa. E o melhor: com a mesma qualidade das lojas de alto padr&atilde;o mas a um pre&ccedil;o at&eacute; seis vezes menor.",

            "Como? Trabalhando junto com voc&ecirc;.",

            "<strong>Seja um decorador GALATEA: aqui seu bom gosto vale dinheiro.</strong><br> N&atilde;o importa em que lugar do mundo voc&ecirc; est&aacute;, a GALATEA &eacute; a ponte entre o seu bom gosto e o p&uacute;blico interessado em ideias de decora&ccedil;&atilde;o.",

            "Na galeria " . anchor('site/ambiances', 'Inspire-me') . ", voc&ecirc; pode postar imagens de ambientes decorados e sugerir os m&oacute;veis GALATEA que poderiam compor aquele espa&ccedil;o. Se algu&eacute;m se inspirar com a sua ideia e fizer a compra do m&oacute;vel sugerido, voc&ecirc; ganhar&aacute; 1% do valor da venda. " . anchor('site/about/index/credits', 'Saiba mais') . ".",

            "Seja bem-vindo!",

            "Time Galatea Casa."

          );
          break;

        // Client
        case 5:
          $data['title'] = "{$name}, seja bem-vindo a Galatea!";
          $data['text'] = array(
            "A GALATEA &eacute; um novo modelo no mercado da alta movelaria. Conectamos pessoas, tiramos boas ideias do papel e entregamos m&oacute;veis de qualidade na sua casa. E o melhor: com a mesma qualidade das lojas de alto padr&atilde;o mas a um pre&ccedil;o at&eacute; seis vezes menor.",

            "<strong>Como?</strong>",

            "1. <strong>Sob demanda</strong>. Sem o risco de estoques &ldquo;encalhados&rdquo;, o pre&ccedil;o cai.<br>".

            "2. <strong>Online</strong>. Sem o custo de uma loja f&iacute;sica, o pre&ccedil;o cai.<br>".

            "3. <strong>Qualidade</strong>. Os melhores materiais e os fabricantes mais qualificados para cada tipo de m&oacute;vel.<br>".

            "4. <strong>Design</strong>. O pr&oacute;ximo grande nome do design pode estar aqui. Fique de olho.<br>". "5. <strong>Efici&ecirc;ncia</strong>. Nosso processo baseado em crowdsourcing aproveita conhecimentos coletivos para criar conceitos e solu&ccedil;&otilde;es inteligentes para nossos m&oacute;veis. V&aacute;rias cabe&ccedil;as pensam melhor que uma.",

            "<strong>Na GALATEA voc&ecirc; pode:</strong><br>".

            "- Encontrar m&oacute;veis de alto padr&atilde;o, originais, exclusivos e pelos pre&ccedil;os mais justos do mercado;<br>".

            "- Interagir com arquitetos e designers e contribuir com a sua opini&atilde;o no processo produtivo;<br>".

            "- Votar nos projetos que voc&ecirc; quer ver produzidos. Se ao final da vota&ccedil;&atilde;o o seu m&oacute;vel escolhido for o vencedor, voc&ecirc; ter&aacute; 5% de desconto na compra;<br>".

            "- Conhecer em primeira m&atilde;o novos talentos do design;<br>".

            "- Inspirar outras pessoas com o seu bom gosto &ndash; e ser recompensado por isso. Saiba mais.<br>",
            "Conhe&ccedil;a alguns de nossos produtos preferidos:<br>",

            "- Rack Duo, por Silvia Grilli<br>".

            "- Cadeira Palhinha, por Estudio Galatea<br>".

            "- Buffet Americano, por Luiz Camara",

            "Seja bem-vindo!",

            "Time Galatea Casa."
          );
          break;

      }

      $body = $this->load->view('site/common/email/default', $data, TRUE);
      $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
      $this->email->to($user->email);
      $this->email->subject('Galatea - Seja bem vindo!');
      $this->email->message($body);
      $this->email->send();

  }

  /**
   * validate_email
   *
   * validate the user subscription
   *
   * @access public
   * @param string $hash
   * @return void
   */
  public function validate_email($hash)
  {
    if( !empty($hash) )
    {
      $user = new User();
      $user->where('email_confirmation_hash', $hash)->get();

      if( $user->exists() )
      {
        $user->email_confirmed = TRUE;

        if( $user->save() )
        {
          //LOGIN
          $usr = array(
            "id"    => $user->id,
            "name"  => $user->name,
            "email" => $user->email,
            "role"  => $user->role
          );

          $this->session->set_userdata($usr);

          if( !empty($user->state_id) && !empty($user->city_id) )
          {
            $location = array(
              'state_id' => $user->state_id,
              'city_id' => $user->city_id
            );

            $this->session->set_userdata('location', $location);
          }

          $this->session->set_flashdata('success', 'Seu email foi confirmado com sucesso.');

          $this->sendWelcomeEmail($user->role);

          //send supplier to his welcome page
          if($user->role == 2) redirect(site_url('site/suppliers/welcome_page'));

        }else{
          $this->session->set_flashdata('error', $user->error->transaction);
          redirect(site_url());
        }

      }else{
        $this->session->set_flashdata('error', 'HASH não encontrado');
        redirect(site_url());
      }

    }

    redirect(site_url());
  }

  /**
   * Change user password or generate a new hash code for password reseting
   * @return void
   */
  public function change_password()
  {
    //Data from submit
    if($this->input->post()){

      //email informed
      if($this->input->post('email')){
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        if(! $this->form_validation->run() ){
          $this->session->set_flashdata('error', validation_errors());
          redirect(site_url('login'));
        }
        // Find user with the email
        $user = new User();
        $user->where('email', $this->input->post('email'))->get();
        if(!$user->exists()){
          $this->session->set_flashdata('error', 'Email não encontrado.');
          redirect(site_url('login'));
        }

        // Update user information with the new generated hash string
        $hash = md5( mt_rand() );
        $user->email_confirmation_hash = $hash;
        $user->save();


        // Send email to the user with the instructions
        $this->send_change_password_email($user, $user->email_confirmation_hash);
        $this->session->set_flashdata('success', 'Enviamos um email com as instruções de recuperação de senha.');
        redirect(site_url());
      }

      //Password update
      if($this->input->post('user_id')){

        $user = new User($this->input->post('user_id'));
        $this->form_validation->set_rules('password', 'Senha', 'required|matches[password_repeat]');
        $this->form_validation->set_rules('password_repeat', 'Confirmação de senha', 'required');
        if(! $this->form_validation->run() ){
          $this->session->set_flashdata('error', validation_errors());
          redirect(site_url('site/users/change_password?hash='.$user->email_confirmation_hash));
        }
        $pass = md5($this->input->post('password'));
        $user->password = $pass;
        $user->save();
        $this->session->set_flashdata('success', 'Senha alterada com sucesso.');
        redirect(site_url('login'));
      }
    }
    $toview['title'] = 'Informe seu email';

      // Check if the hash tag was set
    if( $this->input->get('hash') ){
      // Title
      $toview['title'] = 'Alterar senha';

      // Define that the password field should the showed
      $toview['show_password_fields'] = TRUE;

      // Find user by the hash
      $user = new User();
      $user->where('email_confirmation_hash', $this->input->get('hash'))->get();
      if(!$user->exists()){
        $this->session->set_flashdata('error', 'Hash não encontrado.');
        redirect(site_url());
      }
      $toview['user'] = $user;
    }

      // Define document title
    $this->template->set_title('Esqueci minha senha');
    $this->template->set_script(assets_url('js/site/user/change_password.js'));

      // Load template
    $this->template->load('site','site/change-password', $toview);

  }


  /**
   * Create a new user into the system
   *
   * @access public
   * @return void
   */
  public function create()
  {
    // The form was submitted?
    if ( $this->input->post() ) {

      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_rules('surname', 'Sobrenome', 'required');

      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|matches[confirm_email]');
      $this->form_validation->set_rules('confirm_email', 'Confirmação de email', 'required|valid_email');
      $this->form_validation->set_message('matches', 'O campo Confirmação de email e  email devem ser iguais.');

      $this->form_validation->set_rules('pass', 'Senha', 'required|matches[confirm_pass]');
      $this->form_validation->set_rules('confirm_pass', 'Confirmação de senha', 'required');
      $this->form_validation->set_message('matches', 'O campo Confirmação de Senha e  Nova Senha devem ser iguais.');

      // The user is a supplier?
      if ($this->input->post('role') == 2) {
        $this->form_validation->set_rules('company_name', 'Razão Social', 'required');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('zip', 'CEP', 'required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');
        $this->form_validation->set_rules('street', 'Rua', 'required');
        $this->form_validation->set_rules('number', 'Número', 'required');
        $this->form_validation->set_message('required', 'O campo %s é obrigatório.');
      }

      if ( !$this->form_validation->run() ) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('login');
      }

      $this->load->helper( array('clear_number', 'first_cap') );

      // Instanciate a new user
      $user = new User();

      // Define user variables
      {
        $user->name                    = clear_number( first_cap( $this->input->post('name') ) );
        $user->surname                 = clear_number( first_cap( $this->input->post('surname') ) );
        $user->username                = $this->createUsername();
        $user->areaCode                = $this->input->post('areaCode');
        $user->city_id                 = $this->input->post('city');
        $user->cnpj                    = $this->input->post('cnpj');
        $user->company_name            = $this->input->post('company_name');
        $user->complement              = $this->input->post('complement');
        $user->description             = $this->input->post('description');
        $user->district                = $this->input->post('district');
        $user->email                   = $this->input->post('email');
        $user->email_confirmation_hash = md5( uniqid( rand() ) );
        $user->email_confirmed         = false;
        $user->image                   = $this->input->post('image');
        $user->number                  = $this->input->post('number');
        $user->password                = md5($this->input->post('pass'));
        $user->phone                   = $this->input->post('phone');
        $user->role                    = $this->input->post('role');
        $user->state_id                = $this->input->post('estate');
        $user->street                  = $this->input->post('street');
        $user->zip                     = $this->input->post('zip');
      }

      // Save user information into database
      $user->save();

      //Send confirmation email
      $this->send_confirmation_email($user);
      $this->session->set_flashdata('success', 'Obrigado! Para finalizar o cadastro, verifique o email de confirmação que enviamos para você.');

      // The expertise was submitted?
      if ( $this->input->post('expertise') ) {
        foreach ($this->input->post('expertise') as $exp) {
          $user_expertise = new User_Expertise();
          $user_expertise->user_id      = $user->id;
          $user_expertise->expertise_id = $exp;
          $user_expertise->save();
        }
      }

      // Send user to the home page
      redirect('/');
    }
  }

  /**
   * Create username following specific rules
   *
   * @access public
   * @return string Valid username for system
   */
  public function createUsername($name = FALSE, $surname = FALSE, $asAPI = FALSE)
  {
    // Define base username
    if ($name and $surname) {
      $username = "{$name}-{$surname}";
    }else{
      $username = $this->input->post('name') . '-' . $this->input->post('surname');
    }

    // remove spaces from end and beginning
    $username = trim($username);

    // Replace any found space
    $username = str_replace(' ', '-', $username);

    // Define disallowed characters
    $disallowedCharacters = array(
      'a' => 'ÁÁÂÃÄäàáâãà',
      'e' => 'ÉÈÊËëéèê',
      'i' => 'ÍÌÎÏïíìî',
      'o' => 'ÓÒÕÔÖöóòõô',
      'u' => 'ÚÙÛÜüúùû',
      'c' => 'Çç',
    );

    // Clear all special characters
    foreach ($disallowedCharacters as $_allowed => $_disalloweds) {

      // Replace specific character
      foreach ( str_split($_disalloweds) as $_disallowed ) {
        $username = str_replace($_disallowed, $_allowed, $username);
      }

    }

    // The username is bigger then the database supports?
    if ( strlen($username) > 255 ) {
      $username = substr($username, 0, 255);
    }

    // Instanciate new user
    $user = new User();
    $user->where('username', $username)->get();

    // Exists any user with this username?
    if ( $user->exists() ) {

      // Load necessary helper
      $this->load->helper('string');

      // Search for unique username
      for ($index = 1; $index > 0; $index++) {

        // Instanciate new user and check for the username with increment string
        $_user = new User();
        $_user->where('username', increment_string($username, '-', $index))->get();

        // This specific user exists?
        if ( $_user->exists() ) {
          $index++;
        }else{
          $username = increment_string($username, '-', $index);
          break;
        }

      }

    }

    // Lowercase username
    $username = strtolower($username);

    if ($asAPI) {
      echo $username;
    }else{
      return $username;
    }

  }

  /**
   * Save multiple address
   * @param  (array) $addresses = Array with all needed arrays
   * @return void
   */
  private function __saveAddresses($addresses) {
    foreach($addresses as $address) $this->__saveAddress($address);
  }

  /**
   * Save or update an user delivery address
   * @param  (array) $address = All necessary data to be inserted or updated
   * @return void
   */
  private function __saveAddress($address)
  {
    // Instanciate a new delivery address data to be updated or created
    $deliveryAddress = isset($address['id']) ? new Delivery_Address($address['id']) : new Delivery_Address();

    /**
     * Define data
     *
     * City and state only will be set up if the country is Brasil (ID = 36)
     */
    {
      $deliveryAddress->user_id    = $this->session->userdata('id');
      $deliveryAddress->zip        = $address['zip'];
      $deliveryAddress->areaCode   = $address['areaCode'];
      $deliveryAddress->phone      = $address['phone'];
      $deliveryAddress->street     = $address['street'];
      $deliveryAddress->number     = $address['number'];
      $deliveryAddress->complement = $address['complement'];
      $deliveryAddress->country_id = $address['country_id'];
      $deliveryAddress->state_id   = $address['country_id'] == 36 ? $address['state_id'] : 0;
      $deliveryAddress->city_id    = $address['country_id'] == 36 ? $address['city_id'] : 0;
    }

    // Update/Save data
    $deliveryAddress->save();
  }

  /**
   * Update all necessary data and delete the rest
   * @param  (array) $address = All arrays with all data from address
   * @return void
   */
  private function __updateAddresses($address)
  {
    // Convert to array
    $_actualAddresses = $this->__userAddresses()->all_to_single_array('id');

    // Get only addresses that need to be deleted
    $toDelete = array_diff_key($_actualAddresses, $address);

    // Delete all needed addresses
    foreach($toDelete as $key => $val) {
      $_address = new Delivery_Address($key);
      $_address->delete();
    }

    // Save all necessary data
    $this->__saveAddresses($address);
  }

  /**
   * Delete all addresses from user
   * @return void
   */
  private function __deleteAddresses() {
    $this->__userAddresses()->delete_all();
  }

  /**
   * Get all delivery address from logged in user
   * @return (object) Delivery addresses object from Data Mapper ORM
   */
  private function __userAddresses() {
    $address = new Delivery_address();
    return $address->where('user_id', $this->session->userdata('id'))->get();
  }

  /**
   * Retriave data from specifica Data Mapper ORM object
   *
   * @access private
   * @param  object  $object        Data Mapper ORM object
   * @param  boolean $asSingleArray Is necessary to return an object?
   * @param  string  $field         Field name if is necessary to retriave as an array
   * @return object | array         Data
   */
  private function __getData($object, $asSingleArray = FALSE, $field = 'name')
  {
    return $asSingleArray ? $object->get()->all_to_single_array($field) : $object->get();
  }

  /**
   * Get all countries from database using Data Mapper ORM
   * @return (object | boolean) Countries information
   *
   * @deprecated It was descontinued, take a look into __getData()
   * @see  __getData()
   */
  private function __getCountries($asArray = FALSE)
  {
    // Get all countries informations
    $countries = new Country();

    // Convert to array if necessary
    $result = $asArray ? $countries->get()->all_to_single_array('name') : $countries->get();

    // Return data
    return $result;
  }

  /**
   * Send user to the login page
   *
   * @access private
   * @return void
   */
  private function __goLogin() {
    redirect('login');
  }

}

/* End of file users.php */
/* Location: ./application/controllers/site/users.php */
?>