<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

  public function index($page = false)
  {

    if ( $this->input->post() ) {
      # Set the form rules to be applyed
      $this->form_validation->set_rules('name', 'Nome', 'required')
                            ->set_rules('email', 'Email', 'required|valid_email');

      # Check if all rules passed
      if( $this->form_validation->run() )
      {
        # Load email library
        $this->load->library('email');

        # Set email configurations
        {
          $this->email->from($this->input->post('email'), $this->input->post('name'));
          $this->email->to(EMAIL_GALATEA);
          $this->email->subject( $this->input->post('subject') );
          $this->email->message( $this->input->post('message') . "\n\n(" . $this->input->post('ddd') . ") " . $this->input->post('phone') . "\n Número do pedido:" . $this->input->post('order') );
        }

        # Send email
        $this->email->send();

        # Define success message
        $this->session->set_flashdata('success', 'Sua mensagem foi enviada com sucesso. Nossa equipe entrará em contato por email ou telefone em breve.');

      }else{
        $this->session->set_flashdata('error', 'Verifique os campos "nome" e "email".');
      }
    }

    $toview['current_menu'] = ($page ? $page : 'about_galatea');

    $usr = $this->session->userdata('user');
    $user = new User($usr['id']);

    $toview['user'] = $user;
    $toview['content'] = "site/about/$page";
    $categories = new Category();

    $toview['categories'] = $categories->where('parent_id', 0)->order_by('id', 'asc')->get();

    $toview['scripts'] = array(
      'lib/jquery-ui-1.9.2.custom.min',
      'plugins/upload',
      'plugins/jquery.filedrop',
      'plugins/jquery.ae.image.resize.min',
      'plugins/jquery.fileinput',
      'plugins/customSelect.jquery',
      'plugins/jquery.validate',
      'plugins/jquery.maskedinput',
      'site/about/index',
    );

    $this->load->view('site/common/header/main', $toview);
    $this->load->view('site/common/header/categories', $toview);
    $this->load->view('site/about/index', $toview);
    $this->load->view('site/common/footer/main', $toview);

  }

  public function saveUserData(){

    $this->form_validation->set_rules('name', 'Nome', 'required');
    //$this->form_validation->set_rules('surname', 'Sobrenome', 'required');
    $this->form_validation->set_rules('cpf', 'CPF', 'required');
    $this->form_validation->set_rules('description', 'Sobre', 'required');
    $this->form_validation->set_rules('zip', 'Cep', 'required');
    $this->form_validation->set_rules('phone', 'Telefone', 'required');
    $this->form_validation->set_rules('street', 'Rua', 'required');
    $this->form_validation->set_rules('number', 'Número', 'required');
    $this->form_validation->set_rules('complement', 'Complemento', 'required');
    $this->form_validation->set_rules('city', 'Cidade', 'required');
    $this->form_validation->set_rules('state', 'Estado', 'required');
    //$this->form_validation->set_rules('country', 'País', 'required');

    $this->form_validation->set_message('required', 'O campo %s é obrigatório');

    if(!$this->form_validation->run()){
      $this->session->set_flashdata('erro', validation_errors());
      redirect();
    }

    $user = $this->session->userdata;

    $users = new User($user['user']['id']);
    $users->name = $this->input->post('name');
    $users->cpf = $this->input->post('cpf');
    $users->email = $this->input->post('email');
    $users->description = $this->input->post('description');
    $users->image = $this->input->post('file');
    $users->district = $this->input->post('district');
    $users->cnpj = $this->input->post('cnpj');
    $users->zip = $this->input->post('zip');
    $users->phone = str_replace('-','',$this->input->post('phone'));
    $users->street = $this->input->post('street');
    $users->number = $this->input->post('number');
    $users->complement = $this->input->post('complement');
    $users->city_id = $this->input->post('city');
    $users->state_id = $this->input->post('state');
    $users->create_date = date('Y-m-d G:i:s');
    $users->save();


    $user_exp = new User_Expertise();
    $user_exp->where('user_id', $users->id)->get();
    $user_exp->delete();
    $user_exp->user_id      = $users->id;
    $user_exp->expertise_id = $this->input->post('expertise');
    $user_exp->save();

    for($i=0; $i < count($_POST['zip_del']); $i++){
      $delivery = new Delivery_Address();
      $delivery->user_id = $users->id;
      // $delivery->street = $this->input->post('street_del')[$i];
      // $delivery->number = $this->input->post('number_del')[$i];
      // $delivery->complement = $this->input->post('complement_del')[$i];
      // $delivery->district = $this->input->post('district_del')[$i];
      $delivery->state_id = 12;
      $delivery->city_id = 2823;
      // $delivery->zip = $this->input->post('zip_del')[$i];
      $delivery->create_date = date('Y-m-d G:i:s');
      $delivery->save();
    }

    redirect('site/about');

  }

}

/* End of file about.php */
/* Location: ./application/controllers/site/about.php */
