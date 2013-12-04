<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller
{

  /**
   * Sales/Orders Control Panel
   * @return View - Control Panel of all Sales
   */
  public function index()
  {
    # Define order object
    {
      $order_list = new Order();
      $order_list->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date')
                 ->order_by('create_date', 'desc')
                 ->get();
    }

    # Define the breadcrumb
    $breadcrumb = array(
      'Home'    => site_url('admin'),
      'Pedidos' => site_url('admin/orders')
    );

    $orders = array();

    foreach ($order_list as $order) {
      $items = array();
      $value = 0;

      $items_list = new Order_item();
      $items_list->where(array('delete_date' => null, 'order_id' => $order->id));
      $items_list->get();
      $items = array();

      foreach ($items_list as $order_item) {
        $item = new Item($order_item->item_id);

        $suppliers_relation = new Items_supplier();
        $suppliers_relation->where(array('item_id' => $item->id));
        $suppliers_relation->get();
        $suppliers = array();
        foreach ($suppliers_relation as $supplier_relation) {
          $supplier = new User($supplier_relation->user_id);
          $suppliers[] = $supplier;
        }
        $item->suppliers = $suppliers;

        $value += $order_item->price;

        $items[] = $item;
      }
      $status = new Order_status();
      $status->where(array('order_id' => $order->id));
      $status->order_by('create_date', 'DESC');
      $status->limit(1);
      $status->get();

      $order->status = $status->status;
      $order->value = $value - $order->discount_coupon_value;
      $order->items = $items;
      $order->traffic_light = $this->getTrafficLight($order->estimated_delivery_date);
      $order->estimated_delivery_date = date('d/m/Y', strtotime($order->estimated_delivery_date));
      $orders[] = $order;
    }

    $toview['orders'] = $orders;

    $this->template->load('admin', 'admin/order/index', $toview);
    $this->template->set_breadcrumb($breadcrumb);
  }

  /**
   * Net Sales - Vendas Líquidas
   * @return View - Net Sales
   */
  public function net() {
    $orders = new Order();
    $orders->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $orders->order_by('create_date', 'desc');
    $toview['orders'] = $orders->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Pedidos' => site_url('admin/orders')
      );
    $this->template->set_breadcrumb($breadcrumb);
    #$this->template->load('admin', 'admin/order/index', $toview);
  }

  /**
   * Gross Sales - Vendas brutas
   * @return View - Gross Sales
   */
  public function gross() {
    $orders = new Order();
    $orders->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $orders->order_by('create_date', 'desc');
    $toview['orders'] = $orders->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Pedidos' => site_url('admin/orders')
      );
    $this->template->set_breadcrumb($breadcrumb);
    #$this->template->load('admin', 'admin/order/index', $toview);
  }

  /**
   * Sales by Product - Vendas por produto
   * @return View - Sales by Product
   */
  public function products() {
    $orders = new Order();
    $orders->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $orders->order_by('create_date', 'desc');
    $toview['orders'] = $orders->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Pedidos' => site_url('admin/orders')
      );
    $this->template->set_breadcrumb($breadcrumb);
    #$this->template->load('admin', 'admin/order/index', $toview);
  }

  /**
   * Cancellations - Cancelamentos
   * @return [view] [list of cancelled orders]
   */
  public function cancellations() {

  }

  /**
   * Sale/Order - Venda/Pedido
   * @param  [int]  $order_id [ID for the Order / ID da Venda]
   * @return [view]           [order details]
   */
  function order($order_id){
    $order = new Order($order_id);
    if(!$order->exists()){
      $this->session->set_flashdata('error', 'Pedido não encontrado.');
      redirect(site_url('admin/orders'));
    }


    $items = array();
    $value = 0;

    $items_list = new Order_item();
    $items_list->where(array('delete_date' => null, 'order_id' => $order->id));
    $items_list->get();
    $items = array();

    foreach ($items_list as $order_item) {
      $item = new Item($order_item->item_id);

      $value += $order_item->price;

      $items[] = $item;
    }
    $status = new Order_status();
    $status->where(array('order_id' => $order->id));
    $status->order_by('create_date', 'ASC');
    $status->get();

    $order->status = $status->status;
    $order->value = $value - $order->discount_coupon_value;
    $order->items = $items;
    $order->estimated_delivery_date = date('d/m/Y', strtotime($order->estimated_delivery_date));

    $toview['order'] = $order;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Pedidos' => site_url('admin/orders'),
      'Pedido : '.$order->id => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/order/order', $toview);
  }

  /**
   * getTrafficLight
   * @param  [SQL datetime] $delivery_date [delivery_date for Order]
   * @return [string]                [Status for the Traffic Light]
   */
  private function getTrafficLight($delivery_date) {
    $delivery_date = strtotime($delivery_date);
    $red = strtotime("+7 days");
    $yellow = strtotime("+15 days");
    if ($delivery_date <= $red) {
      return 'red';
    } else if ($delivery_date <= $yellow) {
      return 'yellow';
    } else {
      return 'green';
    }
  }

}

/* End of file orders.php */
/* Location: ./application/controllers/admin/orders.php */
