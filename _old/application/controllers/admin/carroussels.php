<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carroussels extends CI_Controller {

    public $path = "/images/carroussels/";

  public function index(){
    $carroussels = new Carroussel();
    $carroussels->order_by('title', 'asc');
    $toview['carroussels'] = $carroussels->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Carroussel' => site_url('admin/carroussels')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/carroussel/index', $toview);
  }

  public function create(){
    if($this->input->post()){
      $carroussel = new Carroussel();
      $carroussel->title = $this->input->post('title');
      $carroussel->description = $this->input->post('description');
      $carroussel->link = $this->input->post('link');
      $carroussel->image = $this->input->post('image');
      if(!$carroussel->save()){
        $this->session->set_flashdata('error', $carroussel->error->transaction);
        redirect(site_url('admin/carroussels/create'));
      }
      $this->session->set_flashdata('success', 'Salvo com sucesso.');
      redirect(site_url('admin/carroussels/edit/'.$carroussel->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Carroussel' => site_url('admin/carroussels'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/carroussel/create');
  }

  public function edit($carroussel_id){
    $carroussel = new Carroussel($carroussel_id);
    if(!$carroussel->exists()){
      $this->session->set_flashdata('error', 'Carroussel não encontrada');
      redirect(site_url('admin/carroussels'));
    }

    if($this->input->post()){
      $carroussel->title = $this->input->post('title');
      $carroussel->description = $this->input->post('description');
      $carroussel->link = $this->input->post('link');
      $carroussel->image = $this->input->post('image');
      if(!$carroussel->save()){
        $this->session->set_flashdata('error', $carroussel->error->transaction);
        redirect(site_url('admin/carroussels/edit/'.$carroussel->id));
      }

      $this->session->set_flashdata('success', 'Salvo com successo.');
    }

    $toview['carroussel'] = $carroussel;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Carroussel' => site_url('admin/carroussels'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/carroussel/edit', $toview);
  }

    public function remove($carroussel_id){
        $carroussel = new Carroussel($carroussel_id);
        if(!$carroussel->exists()){
            $this->session->set_flashdata('error', 'Carroussel não encontrado.');
            redirect(site_url('admin/carroussels'));
        }
        $this->load->library('s3', 's3');
        $fullpath = $this->config->item('s3_ambient').$this->path;
        $this->s3->deleteObject($this->config->item('s3_bucket'), $fullpath . $carroussel->image);
        $carroussel->delete();
        $this->session->set_flashdata('success', 'Removido com sucesso.');
        redirect(site_url('admin/carroussels'));

    }

}

/* End of file carroussels.php */
/* Location: ./application/controllers/admin/carroussels.php */
