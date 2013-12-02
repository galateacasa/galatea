<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expertises extends CI_Controller {

  public function index(){
    $expertises = new Expertise();
    $expertises->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $expertises->order_by('create_date', 'desc');
    $expertises->get();
    $toview['expertises'] = $expertises;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Expertises' => site_url('admin/expertises')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/expertise/index', $toview);
  }

  public function create(){

    if($this->input->post()){
      $expertise = new Expertise();
      $expertise->name = $this->input->post('name');
      $expertise->description = $this->input->post('description');
      if(!$expertise->save()){
        $this->session->set_flashdata('error', $expertise->error->transaction);
        redirect(site_url('admin/expertises/create'));
      }

      $this->session->set_flashdata('success', 'Criado com sucesso');
      redirect(site_url('admin/expertises/edit/'.$expertise->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Expertises' => site_url('admin/expertises'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/expertise/create');
  }

  public function edit($expertise_id){
    $expertise = new Expertise($expertise_id);

    if(!$expertise->exists()){
      $this->session->set_flashdata('error', 'Expertise não encontrada');
      redirect(site_url('admin/expertises'));
    }

    if($this->input->post()){
      $expertise->name = $this->input->post('name');
      $expertise->description = $this->input->post('description');
      if(!$expertise->save()){
        $this->session->set_flashdata('error', $expertise->error->transaction);
        redirect(site_url('admin/expertises/edit/'.$expertise->id));
      }

      $this->session->set_flashdata('success', 'Criado com sucesso');
      redirect(site_url('admin/expertises/edit/'.$expertise->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Expertises' => site_url('admin/expertises'),
      'Editar' => '#'
      );
    $toview['expertise'] = $expertise;
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/expertise/edit', $toview);
  }

  public function remove($expertise_id){
    $expertise = new Expertise($expertise_id);
    if(!$expertise->exists()){
      $this->session->set_flashdata('error', 'Expertise não encontrada.');
      redirect(site_url('admin/expertises'));
    }
    $expertise->delete();
    $this->session->set_flashdata('success', 'Removida com sucesso.');
    redirect(site_url('admin/expertises'));
  }

}

/* End of file expertises.php */
/* Location: ./application/controllers/admin/expertises.php */
