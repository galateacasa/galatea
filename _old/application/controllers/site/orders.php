<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller
{
  public function index($page = 1)
  {
    # The user is logged in?
    if( $this->session->userdata('id') )
    {
      # Define user
      $user = new User( $this->session->userdata('id') );

      # The user exists?
      if( $user->exists() )
      {
        $orders = new Order();
        $orders->where_related($user);

        $date_start = date('Y-m-d', strtotime('-6 month'));
        $date_end = date("Y-m-d");

        # Any query string?
        if( $this->input->get() )
        {
          # The search terms are sent?
          if( $this->input->get('search') ) {
            $search = $this->input->get('search');
            $orders->ilike('id', $search);
            $params .= "?search=$search";
          }

          # The start and end date was set up?
          if( $this->input->get('date_start') && $this->input->get('date_end') ) {
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
        $orders->select_func("DATE_FORMAT", array("@estimated_delivery_date", '[,]', '%d/%m/%Y'), 'estimated_delivery_date');
        $orders->select_func("DATE_FORMAT", array("@delivery_date", '[,]', '%d/%m/%Y'), 'delivery_date');

        # Define the variables
        {
          $toview['orders'] = $orders->get();
          $toview['date_start'] = ($this->input->get('date_start'))?$this->input->get('date_start'):date('d/m/Y', strtotime('-6 month'));
          $toview['date_end'] = ($this->input->get('date_end'))?$this->input->get('date_end'):date("d/m/Y");
          $toview['search'] = ($this->input->get('search'))?$this->input->get('search'):"";
          $toview['content'] = 'site/order/orders';
          $toview['current_menu'] = 'orders';
          $toview['user'] = $user;
        }

        # Load the tamplate
        $this->template->load('site', 'site/about/index', $toview);

      }else{
        redirect('login');
      }

    }else{
      redirect('login');
    }
  }

  public function order($order_id) {

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

      $this->template->load('main', 'site/order/order', $toview);
    } else {
      $this->session->set_flashdata('error', 'Pedido não encontrado');
      redirect('site/orders');
    }
  }

  public function cancel_order($order_id){
    $order = new Order($order_id);
    if(!$order->exists()){
      $this->session->set_flashdata('error', 'Pedido não encontrado.');
      redirect(site_url('galatea_404'));
    }

    //Set cancelated status to order
    $order->status = 7;
    $order->save();

    $order_status = new Order_Status();
    $order_status->order_id = $order->id;
    $order_status->status = $order->status;
    $order_status->save();

    $total_order = 0;
    foreach ($order->order_item->get() as $order_item) {
      $total = $order_item->price * $order_item->qty;
      $total_order += $total;
    }
    $total_order = number_format($total_order, 2,  ',', '.');

    //Send user a email to confirmate order cancelation
    $subject = "Cancelamento do Pedido Galatea";
    $body = <<<BODY
    Olá {$order->user->name}.
    Este email é para oficializar o cancelamento do seguinte pedido:
    Número: $order->id
    Valor: $total_order

BODY;
    $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
    $this->email->to($order->user->email);
    $this->email->subject($subject);
    $this->email->message($body);
    $this->email->send();

    //Send galatea a email to inform the user intention to cancelate the order
    $subject = "O cliente ".$order->user->name." deseja cancelar o pedido de número: ".$order->id;
    $body = <<<BODY
    O cliente: {$order->user->name} {$order->user->email}
    Deseja cancelar o pedido:
    Número: $order->id
    Valor: $total_order

BODY;
    $this->email->from(EMAIL_GALATEA, CONTATO_GALATEA);
    $this->email->to(EMAIL_GALATEA);
    $this->email->subject($subject);
    $this->email->message($body);
    $this->email->send();

    redirect(site_url('site/orders'));

  }

}
