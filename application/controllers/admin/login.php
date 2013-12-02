<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

  public function index(){
    if ($this->input->post()) {
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Senha', 'required');
      if ($this->form_validation->run()) {
        $user = new User();
        $user->where(array(
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password')),
          'role' => 1
          ))->get();
        if ($user->exists()) {

          $usr = array(
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'role'     => $user->role,
            'loggedIn' => TRUE,
          );

          $this->session->set_userdata("admin", $usr);
          $this->session->set_userdata($usr);

          if ($this->session->userdata('return_path')) {
            $path = $this->session->userdata('return_path');
          } else {
            $path = site_url('admin/admin');
          }
          redirect($path);
        } else {
          $this->session->set_flashdata('error', 'Login ou senha incorretos.');
          redirect(site_url('admin/login'));
        }
      }
    }
    $this->load->view('admin/login');
  }

  public function logout(){
    $this->session->unset_userdata('admin');
    redirect(site_url('admin'));
  }

}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */
