<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Delivery_Addresses extends CI_Controller {

  public function index() {
    $usr = $this->session->userdata('user');
    $user = new User($usr['id']);
    $delivery_adress = new Delivery_Address();
    $delivery_adress->where_related($user)->get();
    $toview['delivery_address'] = $delivery_adress;
    $this->template->load('main', 'site/delivery_address/index', $toview);
  }

  public function create() {
    if ($_POST) {
      $delivery_address = new Delivery_Address();
      $this->form_validation->set_rules('street', 'Endereço', 'required');
      $this->form_validation->set_rules('number', 'Número', 'required');
      $this->form_validation->set_rules('district', 'Bairro', 'required');
      $this->form_validation->set_rules('zip', 'CEP', 'required');
      $this->form_validation->set_rules('state', 'Estado', 'required');
      $this->form_validation->set_rules('city', 'Cidade', 'required');
      $this->form_validation->set_message('required', 'Preencha o campo %s.');
      if ($this->form_validation->run()) {
        $user = $this->session->userdata('user');
        $delivery_address->user_id = $user['id'];
        $delivery_address->street = $this->input->post('street');
        $delivery_address->number = $this->input->post('number');
        $delivery_address->complement = $this->input->post('complement');
        $delivery_address->district = $this->input->post('district');
        $delivery_address->state_id = $this->input->post('state');
        $delivery_address->city_id = $this->input->post('city');
        $delivery_address->zip = $this->input->post('zip');
        $delivery_address->save();
        $this->session->set_flashdata('success', 'Salvo com sucesso!');
        redirect(site_url('site/delivery_addresses/edit/' . $delivery_address->id));
      }
    }
    $this->template->set_script(assets_url('js/plugins/jquery.maskedinput.js'));
    $this->template->set_script(assets_url('js/site/delivery_address/create.js'));
    $this->template->load('main', 'site/delivery_address/create');
  }

  public function edit($delivery_address_id) {
    $delivery_address = new Delivery_Address($delivery_address_id);
    if ($delivery_address->exists()) {

      if ($_POST) {
        $this->form_validation->set_rules('street', 'Endereço', 'required');
        $this->form_validation->set_rules('number', 'Número', 'required');
        $this->form_validation->set_rules('district', 'Bairro', 'required');
        $this->form_validation->set_rules('zip', 'CEP', 'required');
        $this->form_validation->set_rules('state', 'Estado', 'required');
        $this->form_validation->set_rules('city', 'Cidade', 'required');
        $this->form_validation->set_message('required', 'Preencha o campo %s.');
        if ($this->form_validation->run()) {

          $delivery_address->street = $this->input->post('street');
          $delivery_address->number = $this->input->post('number');
          $delivery_address->complement = $this->input->post('complement');
          $delivery_address->district = $this->input->post('district');
          $delivery_address->state_id = $this->input->post('state');
          $delivery_address->city_id = $this->input->post('city');
          $delivery_address->zip = $this->input->post('zip');
          $delivery_address->save();
          $this->session->set_flashdata('success', 'Salvo com sucesso!');
          redirect(site_url('site/delivery_addresses'));
        }
      }
      $this->template->set_script(assets_url('js/plugins/jquery.maskedinput.js'));
      $this->template->set_script(assets_url('js/site/delivery_address/edit.js'));

      $toview['delivery_address'] = $delivery_address;
      $this->template->load('main', 'site/delivery_address/edit', $toview);
    } else {
      $this->session->set_flashdata('error', 'Endereço de entrega não encontrado.');
    }
  }

  public function delete($delivery_address_id) {
    $delivery_address = new Delivery_Address($delivery_address_id);
    if ($delivery_address->exists()) {
      $delivery_address->delete();
      $this->session->set_flashdata('success', 'Endereço de entrega removido.');
    } else {
      $this->session->set_flashdata('error', 'Endereço de entrega não encontrado.');
    }
    redirect(site_url('site/delivery_addresses'));
  }

}