<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_Management_home extends CI_Controller {

  public function index(){
    $home_layout = new Home_Layout();
    $toview = array(
      'layouts' => $home_layout->get()
    );
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Gerenciamento de sites' => site_url('admin/site_management_home')
    );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin','admin/site_management/home', $toview);
  }


  public function create(){

    $ambiance = new Ambiance();
    $item = new Item();

    if($this->input->post()){
      $home_layout = new Home_Layout();
      $home_layout->name = $this->input->post('name');

      $iditem = array();
      foreach($this->input->post('items') as $id_item){
        $iditem[] = $id_item;
      }
      $item = new Item();
      $item->where_in('id', $iditem)->get();

      $id_ambiance = $this->input->post('ambiance');
      $ambiance = new Ambiance($id_ambiance);
      $ambiance->where('id', $id_ambiance)->get();

      $home_layout->save(
        array(
          $ambiance,
          $item->all
        )
      );

      $home_layout->save();
      $this->session->set_flashdata('success', 'Criado com sucesso');
      redirect(site_url('admin/site_management_home'));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Gerenciamento de sites' => site_url('admin/site_management_home'),
      'Gravar' => '#'
    );

    $toview['ambiances'] = $ambiance->get();
    $toview['items']     = $item->get();

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/site_management/create', $toview);
  }


  public function edit($home_id){
    $home_layout = new Home_Layout($home_id);

    $item = new Item();
    $ambiance = new Ambiance();

    if(!$home_layout->exists()){
      $this->session->set_flashdata('error', 'Home não encontrada');
      redirect(site_url('admin/site_management_home'));
    }


    if($this->input->post()){
      //apaga tudo
      $home_layout = new Home_Layout();
      $home_layout->where('id', $home_id)->get();

      foreach($home_layout->item->get() as $id_item){
        $iditem[] = $id_item->id;
      }
      $item = new Item();
      $item->where_in('id', $iditem)->get();


      foreach($home_layout->ambiance->get() as $id_ambiance){
        $idambiance[] = $id_ambiance->id;
      }
      $ambiace = new Ambiance();
      $ambiace->where_in('id', $idambiance)->get();


      if(!$home_layout->exists()){
        $this->session->set_flashdata('error', 'Home não encontrada');
        redirect(site_url('admin/site_management_home'));
      }

      $home_layout->delete(
        array(
          $item->all,
          $ambiace->all
        )
      );
      $home_layout->delete();

      //insere novamente
      $home_layout = new Home_Layout();
      $home_layout->name = $this->input->post('name');

      $iditem = array();
      foreach($this->input->post('product') as $id_item){
        $iditem[] = $id_item;
      }
      $item = new Item();
      $item->where_in('id', $iditem)->get();

      $id_ambiance = $this->input->post('ambiance');
      $ambiance = new Ambiance($id_ambiance);
      $ambiance->where('id', $id_ambiance)->get();

      $home_layout->save(
        array(
          $ambiance,
          $item->all
        )
      );

      if(!$home_layout->save()){
        $this->session->set_flashdata('error', $home_layout->error->transaction);
        redirect(site_url('admin/site_management_home/edit/'.$home_layout->id));
      }

      $this->session->set_flashdata('success', 'Salvo com successo.');
      redirect(site_url('admin/site_management_home'));

    }

    $toview['home_layout'] = $home_layout;
    $toview['items'] = $item->get();
    $toview['ambiances'] = $ambiance->get();

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Gerenciamento de sites' => site_url('admin/site_management_home'),
      'Editar' => '#'
    );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/site_management/edit', $toview);
  }


  public function remove($id){
    $home_layout = new Home_Layout();
    $home_layout->where('id', $id)->get();

    foreach($home_layout->item->get() as $id_item){
      $iditem[] = $id_item->id;
    }
    $item = new Item();
    $item->where_in('id', $iditem)->get();


    foreach($home_layout->ambiance->get() as $id_ambiance){
      $idambiance[] = $id_ambiance->id;
    }
    $ambiace = new Ambiance();
    $ambiace->where_in('id', $idambiance)->get();


    if(!$home_layout->exists()){
      $this->session->set_flashdata('error', 'Home não encontrada');
      redirect(site_url('admin/site_management_home'));
    }


    $home_layout->delete(
      array(
        $item->all,
        $ambiace->all
      )
    );
    $home_layout->delete();
    $this->session->set_flashdata('success', 'Removido com sucesso.');
    redirect(site_url('admin/site_management_home'));
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */