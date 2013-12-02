<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

  public function index(){
    $users = new User();
    $users->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $users->order_by('create_date', 'desc');
    $toview['users'] = $users->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Usuários' => site_url('admin/users')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/user/index', $toview);
  }

  function create(){
    $user = new User();
    if ($this->input->post()) {
      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Senha', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');
      if ($this->form_validation->run()) {
        $user->name = $this->input->post('name');
        $user->email = $this->input->post('email');
        $user->password = md5($this->input->post('password'));
        $user->street = $this->input->post('street');
        $user->number = $this->input->post('number');
        $user->complement = $this->input->post('complement');
        $user->district = $this->input->post('district');
        $user->zip = $this->input->post('zip');
        $user->state_id = (int) $this->input->post('state');
        $user->city_id = (int) $this->input->post('city');
        $user->areaCode = (int) $this->input->post('areaCode');
        $user->phone = $this->input->post('phone');
        $user->role = (int) $this->input->post('role');

        if($this->input->post('expertises')){
          foreach ($this->input->post('expertises') as $expertise_id) {
            $user_expertise = new User_Expertise();
            $user_expertise->user_id = $user->id;
            $user_expertise->expertise_id = $expertise_id;
            if(!$user_expertise->save()){
              $this->session->set_flashdata('error', $user_expertise->error->transaction);
              redirect(site_url('admin/users/create'));
            }
          }
        }

        if ($this->input->post('person_type') == 'pf') {
          $user->cpf = $this->input->post('cpf');
          $user->rg = $this->input->post('rg');
        } else {
          $user->cnpj = $this->input->post('cnpj');
          $user->ie = $this->input->post('ie');
        }
        if(!$user->save()){
          $this->session->flashdata('error', $user->error->transaction);
          redirect(site_url('admin/users/create'));
        }

        $this->session->set_flashdata('success', 'Salvo com sucesso!');
        redirect(site_url('admin/users/edit/'.$user->id));
      }
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Usuários' => site_url('admin/users'),
      'Criar' => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.maskedinput.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.validate.js'));
    $this->template->set_script(assets_url('js/admin/user/create.js'));

    $toview['user'] = $user;
    $this->template->load('admin', 'admin/user/create', $toview);
  }

  function edit($user_id){
    $user = new User($user_id);
    if(!$user->exists()){
      $this->session->set_flashdata('error', 'Usuário não encontrado.');
      redirect(site_url('admin/users'));
    }

    if ($this->input->post()) {
      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');
      if ($this->form_validation->run()) {

        $user->name = $this->input->post('name');
        if ($this->input->post('password')) {
          $user->password = md5($this->input->post('password'));
        }
        $user->street = $this->input->post('street');
        $user->number = $this->input->post('number');
        $user->complement = $this->input->post('complement');
        $user->district = $this->input->post('district');
        $user->zip = $this->input->post('zip');
        $user->state_id = (int) $this->input->post('state');
        $user->city_id = (int) $this->input->post('city');
        $user->areaCode = (int) $this->input->post('areaCode');
        $user->phone = $this->input->post('phone');
        $user->role = (int) $this->input->post('role');

        if($this->input->post('expertises')){
          foreach ($this->input->post('expertises') as $expertise_id) {
            $user_expertise = new User_Expertise();
            $user_expertise->where('user_id', $user->id);
            $user_expertise->where('expertise_id', $expertise_id);
            $user_expertise->get();

          //Save only if dont exists
            if(!$user_expertise->exists()){
              $user_expertise->user_id = $user->id;
              $user_expertise->expertise_id = $expertise_id;
              if(!$user_expertise->save()){
                $this->session->set_flashdata('error', $user_expertise->error->transaction);
                redirect(site_url('admin/users/edit/'.$user->id));
              }
            }

          }
        }

        if ($this->input->post('person_type') == 'pf') {
          $user->cpf = $this->input->post('cpf');
          $user->rg = $this->input->post('rg');
          $user->cnpj = '';
          $user->ie = '';
        } else {
          $user->cnpj = $this->input->post('cnpj');
          $user->ie = $this->input->post('ie');
          $user->cpf = '';
          $user->rg = '';
        }
        $user->save();

        $this->session->set_flashdata('success', 'Salvo com sucesso!');
        redirect(site_url('admin/users/edit/'.$user->id));
      }
    }

    $toview['user'] = $user;

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Usuários' => site_url('admin/users'),
      'Editar' => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_style(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.css'));
    $this->template->set_script(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.maskedinput.js'));
    $this->template->set_script(assets_url('js/admin/user/edit.js'));

    $this->template->load('admin', 'admin/user/edit', $toview);
  }

}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
