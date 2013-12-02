<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount_coupons extends CI_Controller {

  /**
   * Set form rules
   * @var array
   */
  private $form_rules = array(

    # Hash
    array(
      'field' => 'hash',
      'label' => 'Código',
      'rules' => 'required'
      ),

    # Value
    array(
      'field' => 'value',
      'label' => 'Valor',
      'rules' => 'required|numeric'
      ),

    # Type
    array(
      'field' => 'type',
      'label' => 'Tipo de desconto',
      'rules' => 'required'
      )
    );

  public function index(){
    $discount_coupons = new Discount_Coupon();
    $discount_coupons->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $discount_coupons->select_func("DATE_FORMAT", array("@start_date", '[,]', '%d/%m/%Y'), 'start_date');
    $discount_coupons->select_func("DATE_FORMAT", array("@end_date", '[,]', '%d/%m/%Y'), 'end_date');
    $discount_coupons->order_by('create_date', 'desc');
    $toview['discount_coupons'] = $discount_coupons->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Cupons de desconto' => site_url('admin/discount_coupons')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/discount_coupon/index', $toview);
  }

  public function create(){
    if($this->input->post()){

      # Set the rules to be applyed
      $this->form_validation->set_rules( $this->form_rules );

        # Check if all rules passed
      if( !$this->form_validation->run() ){
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('admin/discount_coupons/create'));
      }
      //coupon expire date
      $start_date = $this->input->post('start_date') ? pt_to_mysql_date($this->input->post('start_date'))." 00:00:00" : NULL;
      $end_date = $this->input->post('end_date') ? pt_to_mysql_date($this->input->post('end_date'))." 23:59:59" : NULL;

<<<<<<< HEAD
=======
    if($this->input->post()){
>>>>>>> refs/heads/categories
      $discount_coupon = new Discount_Coupon();
      $discount_coupon->type = $this->input->post('type');
      $discount_coupon->value = $this->input->post('value');
      $discount_coupon->min_sell_value = $this->input->post('min_sell_value');
      $discount_coupon->max_utilizations = $this->input->post('max_utilizations');
      $discount_coupon->start_date = $start_date;
      $discount_coupon->end_date = $end_date;
      $discount_coupon->description = $this->input->post('description');
      $discount_coupon->hash = $this->input->post('hash');

      $discount_coupon->save();

      $this->session->set_flashdata('success', 'Salvo com sucesso');
      redirect('admin/discount_coupons/edit/'.$discount_coupon->id);
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Cupons de desconto' => site_url('admin/discount_coupons'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/discount_coupon/create');
  }

  public function edit($discount_coupon_id){
    $discount_coupon = new Discount_Coupon();
    $discount_coupon->select("*")->select_func("DATE_FORMAT", array("@start_date", '[,]', '%d/%m/%Y'), 'start_date');
    $discount_coupon->select_func("DATE_FORMAT", array("@end_date", '[,]', '%d/%m/%Y'), 'end_date');
    $discount_coupon->where('id', $discount_coupon_id);
    $discount_coupon->get();

    if(!$discount_coupon->exists()){
      $this->session->set_flashdata('error', 'Cupom de desconto não encontrado.');
      redirect('admin/discount_coupons');
    }

    if($this->input->post()){
<<<<<<< HEAD
      //coupon expire date
      $start_date = $this->input->post('start_date') ? pt_to_mysql_date($this->input->post('start_date'))." 00:00:00" : NULL;
      $end_date = $this->input->post('end_date') ? pt_to_mysql_date($this->input->post('end_date'))." 23:59:59" : NULL;

=======
      $discount_coupon->value = $this->input->post('value');
      $discount_coupon->percent = $this->input->post('percent');
>>>>>>> refs/heads/categories
      $discount_coupon->description = $this->input->post('description');
      $discount_coupon->type = $this->input->post('type');
      $discount_coupon->value = $this->input->post('value');
      $discount_coupon->min_sell_value = $this->input->post('min_sell_value');
      $discount_coupon->max_utilizations = $this->input->post('max_utilizations');
      $discount_coupon->start_date = $start_date;
      $discount_coupon->end_date = $end_date;
      $discount_coupon->save();

      $this->session->set_flashdata('success', 'Salvo com sucesso');
      redirect(site_url('admin/discount_coupons'));
    }
    $toview['discount_coupon'] = $discount_coupon;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Cupons de desconto' => site_url('admin/discount_coupons'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/discount_coupon/edit', $toview);
  }

}

/* End of file discount_coupons.php */
/* Location: ./application/controllers/admin/discount_coupons.php */
