<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends base_controller
{
  /**
   * index
   *
   * login user
   *
   * @access public
   * @return void
   */
  public function index()
  {

    // The user is logged in? So... go to the home page!
    if( $this->session->userdata('id') ) redirect();

    if( $this->input->post() ) {

      if ( $this->session->userdata('return_path') ) {
        $path = $this->session->userdata('return_path');
        $this->session->unset_userdata('return_path');
      } else {
        $path = site_url('');
      }

      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Senha', 'required|md5');
      $this->form_validation->set_message('required', 'O campo %s é obrigatório.');

      if ( !$this->form_validation->run() ) {
        $this->session->set_flashdata('error', validation_errors() );
        $this->__goLogin();
      }

      $user = new User();

      $user->where( array(
        'email'    => $this->input->post('email'),
        'password' => $this->input->post('password'),
      ) )->get();

      // Check if the user exists
      if ( !$user->exists() ) {
        $this->session->set_flashdata('error', 'Login ou senha incorreto.');
        $this->__goLogin();
      }

      // Check if the email was confirmed
      if ( !$user->email_confirmed ) {
        $this->session->set_flashdata('error', 'Email não verificado.');
        $this->__goLogin();
      }

      // Keep logged option
      if ( $this->input->post('keep_logged') ) {

        $user->keep_logged_hash = uniqid('', true);
        $user->save();

        // set cookie for 1 year
        $cookie = array(
          'name'   => 'keep_logged_galatea',
          'value'  => $user->keep_logged_hash,
          'expire' => '86500'
        );

        // Define cookie
        $this->input->set_cookie($cookie);

      }

      // Define user session data
      $this->__defineSessionData($user);

      if ( !empty($user->state_id) && !empty($user->city_id) ) {

        $location = array(
          'state_id' => $user->state_id,
          'city_id'  => $user->city_id
        );

        $this->session->set_userdata('location', $location);

      }

      $this->session->set_flashdata('success', "Bem vindo {$user->name}");

      redirect($path);

    }

    $expertises = new Expertise();

    $toview['expertises'] = $expertises->get();

    // Load view
    $this->load->view('site/login', $toview);

  }


  function location()
  {
    $this->session->unset_userdata('location');

    if( $this->input->post() )
    {
      $location = array(
        'state_id' => $this->input->post('state'),
        'city_id'  => $this->input->post('city')
      );

      $this->session->set_userdata('location', $location);
    }

    // Send user to the home page
    redirect();
  }

  function facebook_login()
  {

    // Facebook library
    require(APPPATH . 'libraries/facebook/facebook' . EXT);

    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

    $data['facebook'] = new Facebook(

      array(
        'appId' => FACEBOOK_APP_ID,
        'secret' => FACEBOOK_API_SECRET,
        'cookie' => true,
        'domain' => site_url(),
      )

    );

    // See if there is a user from a cookie
    $data['session'] = $data['facebook']->getUser();
    $data['me'] = NULL;

    if ($data['session']) {

      try {
        $data['uid'] = $data['facebook']->getUser();
        $data['me'] = $data['facebook']->api('/me');
      } catch (FacebookApiException $e) {

      }

    }

    if ($data['me']) {
      $data['logoutUrl'] = $data['facebook']->getLogoutUrl();
      redirect('login/facebook_callback');
    } else {
      $data['loginUrl'] = $data['facebook']->getLoginUrl(array(
        "scope" => 'user_birthday, email',
        "redirect_uri" => site_url('login/facebook_login')
        ));
    }

    $this->load->view('site/facebook', $data);
  }

  public function facebook_callback()
  {
    require(APPPATH . 'libraries/facebook/facebook' . EXT);
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

    $data['facebook'] = new Facebook(array(
      'appId'  => FACEBOOK_APP_ID,
      'secret' => FACEBOOK_API_SECRET,
      'cookie' => true,
      'domain' => site_url(),
    ));

    $data['session'] = $data['facebook']->getUser();
    $data['me'] = NULL;

    if ($data['session']) {

      try {
        $data['uid'] = $data['facebook']->getUser();
        $data['me'] = $data['facebook']->api('/me');
      } catch (FacebookApiException $e) {
        echo 'Ops... ocorreu um erro!';
      }

    }

    if ($data['me']) {

      $image = 'https://graph.facebook.com/' . $data['me']['id'] . '/picture';

      if( !empty($data['me']['id']) )
      {

        //Verify Social Login and User
        $social_login = new Social_Login();
        $social_login->where(array('uid' => $data['me']['id']))->get();

        $user = new User();
        $user->where(array('email' => $data['me']['email']))->get();
        $usr = array();

        // the user already have the social login?
        if( !$social_login->exists() ) {

          //Create user
          $user->name     = $data['me']['first_name'];
          $user->surname  = $data['me']['last_name'];
          $user->email    = $data['me']['email'];
          $user->image    = $image;
          $user->role     = 5; // 5 mean client
          $user->username = file_get_contents( site_url("site/users/createUsername/{$user->name}/{$user->surname}/1") );

          // Try to save user
          if( $user->save() ) {

            $social_login->user_id  = $user->id;
            $social_login->uid      = $data['me']['id'];
            $social_login->provider = "Facebook";

            if( !$social_login->save() ) {

              // Set error message
              $this->session->set_flashdata(
                'error',
                'Ocorreu um erro ao realizar o cadastro através do Facebook. Tente o método convencional'
              );

              // Redirect user to the login page
              $this->__goLogin();

            }

            // Send user welcome email
            file_get_contents( site_url("site/users/sendWelcomeEmail/{$user->role}/{$user->name}") );

          } else {

            // Set error message
            $this->session->set_flashdata(
              'error',
              'Não foi possível realizar seu cadastro, pedimos que entre em contato com a Galatea'
            );

            // Redirect the user to the contact area
            redirect('atendimento');

          }

        }

        // Define user data at session
        $this->__defineSessionData($user);

        // Send user to the home page
        redirect();

      } else {
        $this->session->set_flashdata('error', 'Ocorreu um erro, tente novamente.');
        redirect();
      }

    } else {
      $this->session->set_flashdata('error', 'Ocorreu um erro, tente novamente.');
      redirect();
    }

  }

  public function logout()
  {

    // Data to be unset
    $array_items = array(
        "id"    => '',
        "name"  => '',
        "email" => '',
        "role"  => '',
        "user"  => '',
    );

    // Unset data
    $this->session->unset_userdata($array_items);

    // Delte all cookies
    delete_cookie('keep_logged_galatea');

    // Send user to the home page
    redirect();

  }

  /**
   * Define user session data
   *
   * @access private
   * @param  [object] $user User object with all necessary data
   * @return void
   */
  private function __defineSessionData($data)
  {
    // Define data
    $user = array(
      'id'       => $data->id,
      'name'     => $data->name,
      'email'    => $data->email,
      'role'     => $data->role,
      'username' => $data->username,
    );

    // Set as correctly way
    $this->session->set_userdata("user", $user);

    // Set as wrong way (deprecated)
    $this->session->set_userdata($user);

  }

  /**
   * Send user to the login page
   *
   * @access private
   * @return void
   */
  private function __goLogin()
  {
    redirect('login');
  }

}

/* End of file login.php */
/* Location: application/controllers/login.php */
?>
