<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ambiances extends CI_Controller {

  public function index(){
    $ambiances = new Ambiance();
    $ambiances->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $ambiances->order_by('create_date', 'desc');
    $toview['ambiances'] = $ambiances->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Ambientes' => site_url('admin/ambiances')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/ambiance/index', $toview);
  }

  public function create(){
    $ambiance = new Ambiance();
    if ($this->input->post()) {
      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');
      if (!$this->form_validation->run()) {
        redirect(site_url('admin/ambiances/create'));
      }
      $ambiance->name = $this->input->post('name');
      $ambiance->description = $this->input->post('description');
      $ambiance->user_id = $this->input->post('user');
      if ($this->input->post('sub_category')) {
        $ambiance->category_id = $this->input->post('sub_category');
      }else{
        $ambiance->category_id = $this->input->post('category');
      }

      //SAVE IMAGE
      if($this->input->post('image')){
        $image = $this->input->post('image');
        $ambiance->image = $image;
      }

      if(!$ambiance->save()){
        $this->session->flashdata('error', $ambiance->error->transaction);
        redirect(site_url('admin/ambiances/edit/'.$ambiance->id));
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
    }
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Ambientes' => site_url('admin/ambiances'),
      'Criar' => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/admin/ambiance/create.js'));

    $toview['ambiance'] = $ambiance;
    $this->template->load('admin', 'admin/ambiance/create', $toview);
  }

  function edit($ambiance_id){
    $ambiance = new Ambiance($ambiance_id);
    if(!$ambiance->exists()){
      $this->session->set_flashdata('error', 'Ambiente não encontrado.');
      redirect(site_url('admin/ambiances'));
    }
    if($this->input->post()){
      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');
      if (!$this->form_validation->run()) {
        redirect(site_url('admin/ambiances/edit/'.$ambiance->id));
      }

      $ambiance->name = $this->input->post('name');
      $ambiance->description = $this->input->post('description');
      if ($this->input->post('sub_category')) {
        $ambiance->category_id = $this->input->post('sub_category');
      }else{
        $ambiance->category_id = $this->input->post('category');
      }

      $ambiance->image = $this->input->post('image');

      if(!$ambiance->save()){
        $this->session->set_flashdata('error', $ambiance->transaction->error);
        redirect(site_url('admin/ambiances/edit/'.$ambiance->id));
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
    }

    $toview['ambiance'] = $ambiance;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Ambientes' => site_url('admin/ambiances'),
      'Editar' => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/ambiance/edit', $toview);
  }
}
/* End of file ambiances.php */
/* Location: ./application/controllers/admin/ambiances.php */
