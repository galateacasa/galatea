<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends CI_Controller {

  function index($page = 1){
    $this->load->library('pagination');
    $params = "";

    $user = $this->session->userdata('user');
    if(!$user[ 'role'] == 2 ){
      $this->session->set_flashdata('error', 'Acesso negado');
      redirect('site/orders');
    }

    $this->load->library('pagination');

    $supplier = new User($user['id']);

    $orders = new Order();
    $date_start = date('Y-m-d', strtotime('-6 month'));
    $date_end = date("Y-m-d");
    if ($_GET) {
      if ($this->input->get('search')) {
        $search = $this->input->get('search');
        $orders->where('id',$search);
        $params .= "?search=".$search;
      }

      if ($this->input->get('date_start') && $this->input->get('date_end')) {
        $date_start = pt_to_mysql_date($this->input->get('date_start'));
        $date_end = pt_to_mysql_date($this->input->get('date_end'));
        $params .= (empty($params)?"?":"&")."date_start=".$this->input->get('date_start')."&date_end=".$this->input->get('date_end');
      }

    }
    $date_start = $date_start . " 00:00:00";
    $date_end = $date_end . " 23:59:59";
    $where = "create_date BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
    $orders->where($where);

    $orders->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $orders->where_related("order_item/item/disponibility/user", $supplier);
    $orders->group_by('id');
    $orders->get_paged($page, 10);

    //Pagination
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('site/suppliers/index/');
    $config['total_rows'] = $orders->paged->total_rows;
    $config[ 'suffix'] = $params;
    $this->pagination->initialize($config);

    $toview['paginate'] = $this->pagination->create_links();
    $toview['date_start'] = ($this->input->get('date_start'))?$this->input->get('date_start'):date('d/m/Y', strtotime('-6 month'));
    $toview['date_end'] = ($this->input->get('date_end'))?$this->input->get('date_end'):date("d/m/Y");
    $toview['search'] = ($this->input->get('search'))?$this->input->get('search'):"";

    $toview['orders'] = array();
    foreach($orders as $order){
      $toview['orders'][] = array(
        'id' => $order->id,
        'create_date' => $order->create_date,
        'client_name' => $order->user->name,
        'total' => number_format($order->order_item->select_sum('price')->get()->price ,2 ,',' ,'.'),
        'status' => status_to_literal_pagseguro($order->order_status->select('status')->select_max('id')->get()->status)
        );
    }

    $this->template->set_style(assets_url('css/plugins/datepicker/datepicker.css'));
    $this->template->set_script(assets_url('js/plugins/datepicker/bootstrap-datepicker.js'));
    $this->template->set_script(assets_url('js/site/supplier/index.js'));
    $this->template->load('main', 'site/supplier/index', $toview);
  }

  function sell($order_id){
    $order = new Order($order_id);
    $user = new User($order->user_id);
    if ($order->exists()) {
      //ORDER
      $toview['order'] = $order;

      //STATUS
      $order->order_status->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
      $toview['order_status'] = $order->order_status->get();

      //ORDER ITEMS
      $toview['order_items'] = array();
      foreach ($order->order_items->get() as $order_item) {
        $toview['order_items'][] = array(
          'id' => $order_item->item->id,
          'name' => $order_item->item->name,
          'price' => $order_item->disponibility_variation_value->get()->disponibility_price_variation->get()->price,
          'qty' => $order_item->qty,
          'variations' => $order_item->disponibility_variation_value->name
          );
      }


      //DELIVERY ADDRESS
      $delivery_address = $order->delivery_address->get();
      if ($delivery_address->exists()) {
        $toview['delivery_address'] = $delivery_address;
      }else{
        $toview['delivery_address'] = $user;
      }

      $this->template->load('main', 'site/supplier/sell', $toview);
    } else {
      $this->session->set_flashdata('error', 'Pedido não encontrado');
      redirect('site/orders');
    }
  }

  function welcome_page()
  {
    # The user is logged in and his is a supplier?
    if( $this->session->userdata('role') == 2 and $this->session->userdata('id') )
    {
      $user = new User( $this->session->userdata('id') );

      $projects = new Item();
      $projects->where( array('status' => 1, 'type' => 1) )
               ->include_related_count('item_vote')
               ->get();

      $toview['projects'] = $projects;
      $toview['user']     = $user;

      $this->template->load('site', 'site/supplier/welcome_page', $toview);
    } else {
      redirect('404');
    }

  }

}

/* End of file suppliers.php */
/* Location: ./application/controllers/site/suppliers.php */
