<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Styles extends CI_Controller {

  public function index(){
    $styles = new Style();
    $styles->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $styles->order_by('create_date', 'desc');
    $styles->get();
    $toview['styles'] = $styles;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Estilos' => site_url('admin/styles')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/style/index', $toview);
  }

  public function create(){

    if($this->input->post()){
      $style = new Style();
      $style->name = $this->input->post('name');
      $style->description = $this->input->post('description');
      if(!$style->save()){
        $this->session->set_flashdata('error', $style->error->transaction);
        redirect(site_url('admin/styles/create'));
      }

      $this->session->set_flashdata('success', 'Criado com sucesso');
      redirect(site_url('admin/styles/edit/'.$style->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Estilos' => site_url('admin/styles'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/style/create');
  }

  public function edit($style_id){
    $style = new Style($style_id);

    if(!$style->exists()){
      $this->session->set_flashdata('error', 'Estilo não encontrada');
      redirect(site_url('admin/styles'));
    }

    if($this->input->post()){
      $style->name = $this->input->post('name');
      $style->description = $this->input->post('description');
      if(!$style->save()){
        $this->session->set_flashdata('error', $style->error->transaction);
        redirect(site_url('admin/styles/edit/'.$style->id));
      }

      $this->session->set_flashdata('success', 'Criado com sucesso');
      redirect(site_url('admin/styles/edit/'.$style->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Estilos' => site_url('admin/styles'),
      'Editar' => '#'
      );
    $toview['style'] = $style;
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/style/edit', $toview);
  }

  public function remove($style_id){
    $style = new Expertise($style_id);
    if(!$style->exists()){
      $this->session->set_flashdata('error', 'Estilo não encontrada.');
      redirect(site_url('admin/styles'));
    }
    $style->delete();
    $this->session->set_flashdata('success', 'Removido com sucesso.');
    redirect(site_url('admin/styles'));
  }

}

/* End of file styles.php */
/* Location: ./application/controllers/admin/styles.php */
