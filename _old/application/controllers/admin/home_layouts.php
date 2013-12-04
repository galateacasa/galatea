<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_layouts extends CI_Controller
{

  public function index()
  {
    $breadcrumb = array(
      'Home'            => site_url('admin'),
      'Layouts da Home' => site_url('admin/home_layouts')
    );

    $this->template->set_breadcrumb($breadcrumb);
    $home_layouts = new Home_layout();
    $home_layouts->get();

    # Variables
    {
      $toview['home_layouts'] = $home_layouts->get();
      $toview['home_layouts'] = $home_layouts;
    }

    $this->template->load('admin', 'admin/home_layout/index', $toview);
  }

  public function create()
  {
    $home_layout = new Home_layout();

    # The form was submitted?
    if ($this->input->post())
    {
      $this->form_validation->set_rules('name', 'Nome', 'required');
      $this->form_validation->set_rules('ambiance', 'Ambiente', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');

      if( $this->form_validation->run() )
      {
        $home_layout->name                = $this->input->post('name');
        $home_layout->ambiance_id         = $this->input->post('ambiance');
        $home_layout->home_layout_type_id = 1;

        if( $home_layout->save() )
        {

          foreach ($this->input->post('products') as $product) {
            $home_layout_new_item = new Item($product);
            $home_layout->save($home_layout_new_item);
          }

          $this->session->set_flashdata('success', 'Salvo com sucesso!');
          redirect(site_url('admin/home_layouts/'));

        }else{
          $this->session->flashdata('error', $home_layout->error->transaction);
          redirect(site_url('admin/home_layouts/edit/'.$home_layout->id));          
        }

      }else{
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('admin/home_layouts/create'));        
      }
    }

    $breadcrumb = array(
      'Home'            => site_url('admin'),
      'Layouts da Home' => site_url('admin'),
      'Criar'           => "#"
    );

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/admin/home_layouts/create.js'));

    $ambiances = new Ambiance();
    $layouts = new Home_layout_type();

    $products = new Item();
    $products->where( array('type' => 2, 'status' => 1) );

    # Variables
    {
      $toview['home_layout'] = $home_layout;
      $toview['layouts']     = $layouts->get();
      $toview['ambiances']   = $ambiances->get();
      $toview['products']    = $products->get();
    }

    $this->template->load('admin', 'admin/home_layout/create', $toview);
  }

  function edit($home_layout_id)
  {
    $home_layout = new Home_layout($home_layout_id);

    if( $home_layout->exists() )
    {
      if( $this->input->post() )
      {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('ambiance', 'Ambiente', 'required');
        $this->form_validation->set_message('required', 'Preencha o campo %s.');
        if (!$this->form_validation->run()) {
          redirect(site_url('admin/home_layouts/edit/'.$home_layout->id));
        }

        $home_layout->name = $this->input->post('name');
        $home_layout->ambiance_id = $this->input->post('ambiance');
        $home_layout->home_layout_type_id = 1;

        $home_layout_items = $home_layout->item->get();

        foreach($home_layout_items as $item) {
          $home_layout->delete($item);
        }

        if(!$home_layout->save()){
          $this->session->set_flashdata('error', $home_layout->transaction->error);
          redirect(site_url('admin/home_layouts/edit/'.$home_layout->id));
        }

        foreach ($this->input->post('products') as $product) {
          $home_layout_new_item = new Item($product);
          $home_layout->save($home_layout_new_item);
        }

        $this->session->set_flashdata('success', 'Salvo com sucesso!');
        redirect(site_url('admin/home_layouts'));
      }

      $ambiances = new Ambiance();
      $layouts   = new Home_layout_type();
      $products  = new Item();
      $products->where(array('type' => 2, 'status' => 1));

      $current_products = array();
      foreach($home_layout->item->get() AS $current_product) {
        $current_products[] = $current_product->id;
      }


      $breadcrumb = array(
        'Home' => site_url('admin'),
        'Layouts da Home' => site_url('admin/home_layouts'),
        'Editar' => "#"
        );

      # Variables to the view
      {
        $toview['home_layout']      = $home_layout;
        $toview['ambiances']        = $ambiances->get();
        $toview['layouts']          = $layouts->get();
        $toview['products']         = $products->get();
        $toview['current_products'] = $current_products;
      }

      $this->template->set_breadcrumb($breadcrumb);
      $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
      $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
      $this->template->load('admin', 'admin/home_layout/edit', $toview);
    }else{
      $this->session->set_flashdata('error', 'Layout não encontrado.');
      redirect(site_url('admin/home_layouts'));      
    }
  }

  function remove($home_layout_id) {
    $home_layout = new Home_layout($home_layout_id);
    $home_layout_items = $home_layout->item->get();

    foreach($home_layout_items as $item) {
      $home_layout->delete($item);
    }
    $home_layout->delete();

    $this->session->set_flashdata('success', 'Removido com sucesso.');
    redirect(site_url('admin/home_layouts'));
  }
}
/* End of file home_layouts.php */
/* Location: ./application/controllers/admin/home_layouts.php */
