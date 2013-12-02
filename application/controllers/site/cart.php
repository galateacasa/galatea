<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class with all methods necessary to galatea cart work
 *
 * PHP 5.3+
 *
 * @package Controllers
 * @subpackage Site
 * @category Galatea
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @see Base_Controller
 */
class Cart extends Base_Controller
{

    public function __construct()
    {

        parent::__construct();

        // Load common library
        $this->load->library('cart');

    }

    /**
     * Main action to list all cart products
     *
     * @access public
     * @return void
    */
    public function index()
    {
        /* Check if have anything into the shopping cart */
        if( !$this->cart->contents() ) $this->__goHome();

        // Load necessary helpers
        $this->load->helper( array('form', 'to_money') );

        // Instanciate a new user
        $user = new User( $this->session->userdata('id') );

        // Define delivery time
        $delivery_time = 0;
        foreach ($this->cart->contents() as $row_id => $product)
            if($delivery_time < $product['options']['delivery_time']) $delivery_time = $product['options']['delivery_time'];

        // Convert delivery time to a date
        $delivery_time = date('d/m/Y', strtotime("+$delivery_time days"));

        //Calc total cart with discounts
        $total_cart = $this->cart->total();
        $discount_coupon = array('hash' => '', 'value' => '', 'id' => '');

        //Calculate the total cart discount the used coupon
        if ( $this->session->userdata('discount_coupon') ) {
            $discount_coupon = $this->session->userdata('discount_coupon');
            $total_cart -= $discount_coupon['value'];
        }

        // Calculate the total cart discount the used credit
        if ( $this->session->userdata('user_credit') ) {

            $user_credit = $this->session->userdata('user_credit');

            //if credits less than total cart
            if ($total_cart > $user_credit) {

                $total_cart -= $user_credit;

            //if credits greater than total cart use only the amount need
            }else{

                $user_credit = $user_credit - ($user_credit - $total_cart);
                $total_cart -= $user_credit;
                $user_credit = number_format($user_credit, 2, '.','');
                $this->session->set_userdata('user_credit', $user_credit);

            }

        }

        // Set up default address
        $delivery_addresses[] = array(
            'id'         => 'default',
            'street'     => $user->street,
            'number'     => $user->number,
            'complement' => $user->complement,
            'areaCode'   => $user->areaCode,
            'phone'      => $user->phone,
            'country'    => $user->country,
            'district'   => $user->district,
            'state'      => $user->state->name,
            'city'       => $user->city->name,
            'city_id'    => $user->city_id,
            'zip'        => $user->zip,
            'default'    => TRUE
        );

        // Colect the user delivery address
        $user_delivery_addresses = $user->delivery_address->get();

        // Check if the user have any delivery address
        if( $user_delivery_addresses->exists() ) {
            // Set up all delivery address from user
            foreach ($user_delivery_addresses as $delivery_address) {

                $delivery_addresses[] = array(
                    'id'         => $delivery_address->id,
                    'street'     => $delivery_address->street,
                    'number'     => $delivery_address->number,
                    'complement' => $delivery_address->complement,
                    'areaCode'   => $delivery_address->areaCode,
                    'phone'      => $delivery_address->phone,
                    'country'    => $delivery_address->country,
                    'district'   => $delivery_address->district,
                    'state'      => $delivery_address->state->name,
                    'city'       => $delivery_address->city->name,
                    'city_id'    => $delivery_address->city_id,
                    'zip'        => $delivery_address->zip,
                    'default'    => FALSE
                );

            }
        }

        // The user have not been already selected the address?
        if( !$this->session->userdata('delivery_address_id') or !$this->session->userdata('delivery_address_valid') ) {

            // Get last address
            $last_address = end($delivery_addresses);

            // Get city information
            $city = new City($last_address['city_id']);

            // The city exists and logistics delivery to the address?
            if( $city->exists() and $city->reached_by_logistics ) {

                $this->session->set_userdata('delivery_address_id', $last_address['id']);
                $this->session->set_userdata('delivery_address_valid', TRUE);

            }else{

                $this->session->unset_userdata('delivery_address_valid');

            }

        }else{

            // Get delivery address is the default?
            if( $this->session->userdata('delivery_address_id') == 'default' ):
                $city = new City($user->city_id);
            else:
                $deliveryAddress = new Delivery_Address( $this->session->userdata('delivery_address_id') );
                $city = new City($deliveryAddress->city_id);
            endif;

            // The city exists and logistics delivery to the address?
            if( $city->exists() and $city->reached_by_logistics ):
                $this->session->set_userdata('delivery_address_valid', TRUE);
            else:
                $this->session->unset_userdata('delivery_address_valid');
            endif;

        }

        $categories = new Category();

        // Variables to be used at view
        {
            $toview['delivery_addresses'] = $delivery_addresses;
            $toview['delivery_time']      = $delivery_time;
            $toview['discount_coupon']    = $discount_coupon;
            $toview['total_cart']         = $total_cart;
            $toview['user']               = $user;
            $toview['categories']         = $categories->where('parent_id', 0)->get();
            $toview['user_credit']        = isset($user_credit) ? $user_credit : '';
        }

        $this->template->set_script(assets_url('js/plugins/customSelect.jquery.js'));
        $this->template->set_script(assets_url('js/site/cart/cart.js'));

        $this->load->view('site/common/header/main', $toview);
        $this->load->view('site/common/header/categories', $toview);
        $this->load->view('site/cart/cart', $toview);
        $this->load->view('site/common/footer/main', $toview);

    }

    /**
     * Add a new item into the cart
     *
     * @access public
     * @return void
    */
    public function add()
    {
        // Define rules and message
        $this->form_validation->set_rules('measurement', 'Medida', 'required')
                              ->set_rules('material', 'Acabamento', 'required')
                              ->set_rules('qty', 'Quantidade', 'required|is_natural_no_zero')
                              ->set_message('required', 'O campo %s é obrigatório.')
                              ->set_message('is_natural_no_zero', 'Apenas valores inteiros, maiores que 0, são aceitos no campo %s.');

        // Validade the form
        if ( !$this->form_validation->run() ) {
            $this->session->set_flashdata( 'error', validation_errors() );
            $this->__goBack();
        }

        // Instanciate a new product
        $item = new Item( $this->input->post('item_id') );

        // Define product URL
        $redirecUrl = site_url("produto/{$item->slug}");

        // The product exists?
        if( !$item->exists() ) {
            $this->session->set_flashdata('error', 'Produto não encontrado.');
            $this->__goHome();
        }

        // Instanciate the variation measurement
        $measurement = new Item_Variation_Measurement();
        $measurement->where( array('item_id' => $item->id, 'id' => $this->input->post('measurement') ) )->get();

        // Check if the variation measurement exists for the specific product
        if( !$measurement->exists() ) {
            $this->session->set_flashdata('error', 'Medida inválida');
            $this->__goBack();
        }

        // Instanciate the variation material
        $material = new Item_Variation_Material();
        $material->where( array('item_id' => $item->id, 'id' => $this->input->post('material') ) )->get();

        // Check if the material exists for the specific product
        if( !$material->exists() ) {
            $this->session->set_flashdata('error', 'Acabamento inválido');
            $this->__goBack();
        }

        // Calculate the price by the variations choosed
        $price = $measurement->additional_amount + $material->additional_amount + $item->production_price;

        // Calculate the delivery_price
        $delivery_cost = $item->delivery_cost;
        $delivery_price = $price * $delivery_cost / 100;

        // Add to the price
        $price += $delivery_price;

        // Mount the variations options array
        $measures = array($measurement->width, $measurement->height, $measurement->depth);
        $measures = implode('cm X ', $measures) . 'cm';

        // Product image
        if ( $item->item_image->get()->exists() ) {
            $cart_img = amazon_url("images/items/{$item->item_image->image}", 120, 60);
        }else{
            $cart_img = assets_url('images/nopic.jpg');
        }

        // Ambiance link
        $ambiance_link = $this->input->post('ambiance_link');

        // Define witch data will be set up into the cart
        $data = array(

            'id'    => $item->id,
            'qty'   => $this->input->post('qty'),
            'price' => $price,
            'name'  => $item->name,
            'slug'  => $item->slug,

            'options' => array(
                'material'                 => $material->material,
                'measurement'              => $measures,
                'ambiance_link'            => $ambiance_link,
                'delivery_time'            => $item->delivery_time,
                'image'                    => $cart_img,
                'variation_material_id'    => $material->id,
                'variation_measurement_id' => $measurement->id,
            ),

        );

        // Set up to cart accept any word
        $this->cart->product_name_rules = '\d\D';

        // Add product to the cart
        $this->cart->insert($data);

        // Redirect the user to the shopping cart
        redirect('carrinho-de-compras');

    }

    /**
     * Set up user discount counpon
     *
     * @access public
     * @param  string | boolean $discount_coupon_hash Coupon discount reference
     * @return void
     */
    public function discount_coupon($discount_coupon_hash = false)
    {

        //clear coupon session
        $this->session->unset_userdata('discount_coupon');

        if (!$discount_coupon_hash) return false;

        $discount_coupon = new Discount_Coupon();

        $discount_coupon->select('id, hash, value, description, type, max_utilizations, min_sell_value')
                        ->select_func("UNIX_TIMESTAMP", array("@start_date"), 'start_date')
                        ->select_func("UNIX_TIMESTAMP", array("@end_date"), 'end_date')
                        ->where('hash', $discount_coupon_hash)->get();

        //validate coupon
        if ( !$discount_coupon->exists() ) {
            $this->session->set_flashdata('error', 'Cupom de desconto inválido');
            $this->__goCart();
        }

        //validate max utilizations
        if ($discount_coupon->max_utilizations > 0) {

            $utilizations = $discount_coupon->getUtilizations();

            if($utilizations >= $discount_coupon->max_utilizations){
                $this->session->set_flashdata('error', 'Não restam mais utilizações para este cupom');
                $this->__goCart();
            }

        }

        //validate min sell value
        $total_cart = $this->cart->total();

        if ($discount_coupon->min_sell_value > 0) {

            if ($total_cart < $discount_coupon->min_sell_value) {

                // Load necessarry helper
                $this->load->helper('to_money');

                // Set error message
                $this->session->set_flashdata('error', 'Para utilizar este cupom o valor total da compra deve ser no mínimo de ' . to_money($discount_coupon->min_sell_value) );

                // Redirect the user
                $this->__goCart();

            }

        }

        //validate expiration date
        $today = strtotime('now');

        if ($discount_coupon->start_date > 0 && $discount_coupon->start_date > $today ) {
            $this->session->set_flashdata('error', 'Período de validade do cupom não iniciado.');
            $this->__goCart();
        }

        if ($discount_coupon->end_date > 0 && $discount_coupon->end_date < $today ) {
            $this->session->set_flashdata('error', 'Período de validade do cupom finalizado');
            $this->__goCart();
        }

        //value discount
        $discount = 0;

        if($discount_coupon->type == 1){

            $discount = $discount_coupon->value;

        }else{

            //percentage discount
            $discount = ($total_cart * $discount_coupon->value/100);
            $discount = number_format($discount, 2);

        }

        //save used coupon in session
        $coupon_session = array(
            'hash'  => $discount_coupon->hash,
            'value' => $discount,
            'id'    => $discount_coupon->id
        );

        $this->session->set_userdata('discount_coupon', $coupon_session);

    }

    /**
     * Check user credits
     *
     * @access public
     * @param  string | boolean $user_credit Amount
     * @return void | FALSE
     */
    public function user_credits($user_credit = false)
    {
        //clear user credit session
        $this->session->unset_userdata('user_credit');

        if ( !$user_credit ) return false;

        // The user is logged in?
        if ( !$this->session->userdata('user') ) {
            $this->session->set_flashdata('error', 'Efetue login para utilizar seus créditos');
            redirect('login');
        }

        //Get user credits
        $usr     = $this->session->userdata('user');
        $user    = new User($usr['id']);
        $credits = $user->getUserCredits();

        // Validate user credits amount
        if ($user_credit > $credits) {

            // Load necessary helper
            $this->load->helper('to_money');

            // Set up error message
            $this->session->set_flashdata('error', 'Você pode utilizar no máximo R$ ' . to_money($credits) . " Créditos.");

            // Send user to the cart
            $this->__goCart();
        }

        $this->session->set_userdata('user_credit', $user_credit);

    }

    /**
     * Update cart items
     *
     * @access public
     * @return void
    */
    public function update_cart()
    {
        // The form was submitted?
        if ( $this->input->post() ) {
            //Update Qty
            foreach ($this->input->post('qty') as $rowid => $qty) {

                $this->cart->update(array(
                    'rowid' => $rowid,
                    'qty' => $qty
                ));

            }

            //Credits
            if ( $this->input->post('user_credits') ) $this->user_credits($this->input->post('user_credits'));

            //Discount coupon
            $this->discount_coupon( $this->input->post('discount_coupon') );

            $this->session->set_flashdata('success', 'Carrinho atualizado');
        }

        $this->__goCart();

    }

    /**
     * Remove a specific item from cart
     *
     * @access public
     * @param  integer $rowid The row ID from the list of items from card
     * @return void
    */
    public function remove_item($rowid)
    {

        $data = array(
            'rowid' => $rowid,
            'qty'   => 0
        );

        $this->cart->update($data);
        $this->__goCart();

    }

    /**
     * Clear the shopping cart
     *
     * @access public
     * @return void
    */
    public function destroy() {
        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Todos os produtos foram retirados do carrinho.');
        redirect(site_url());
    }

    /**
     * Actions to finish the order, saving everything into the database and redirection
     * the user to the PagSeguro website.
     *
     * @access public
     * @return void
    */
    function finalize()
    {

        // Check if the cart have any items
        if(count($this->cart->contents()) === 0) {
            $this->session->set_flashdata('error', 'Coloque alguns produtos no carrinho de compras.');
            $this->__goHome();
        }

        // Get logged user data
        $user = new User( $this->session->userdata('id') );

        $data_set_up = FALSE;

        // All main information are set up?
        if( !empty($user->name) && !empty($user->surname) && !empty($user->cpf) ) {

            // The user is using additional address?
            if ($this->session->userdata('delivery_address_id') != 'default') {

                // Instanciate a new delivery address
                $delivery_address = new Delivery_Address( $this->session->userdata('delivery_address_id') );

                // All delivery address data are set up?
                if(
                    !empty($delivery_address->zip)      and
                    !empty($delivery_address->areaCode) and
                    !empty($delivery_address->phone)    and
                    !empty($delivery_address->street)   and
                    $delivery_address->number > 0       and
                    $delivery_address->state_id > 0     and
                    $delivery_address->city_id > 0      and
                    !empty($delivery_address->country)
                ) $data_set_up = TRUE;

                // Unset the variable to be used after this
                unset($delivery_address);

            }else if (!empty($user->zip) &&
                   !empty($user->areaCode) &&
                   !empty($user->phone) &&
                   !empty($user->street) &&
                   ($user->number !== 0) &&
                   ($user->state_id !== 0) &&
                   ($user->city_id !== 0) &&
                   !empty($user->country)) {
                    $data_set_up = TRUE;
            }

        }

        // The user is a supplier?
        if($user->role == 2 ) {

            // Company name and CNPJ was sent?
            if( empty($user->company_name) or empty($user->cnpj) ) {
                $data_set_up = FALSE;
                $this->session->set_flashdata('error', 'Você precisa informar a razão social e o CNPJ da empresa.');
                $this->__goUserEdit();
            }

        }

        // All needed information are set up?
        if(!$data_set_up) {

            $this->session->set_flashdata(
                'error',
                'É necessário que todos os campos obrigatórios para a compra sejam preenchidos.'
            );

            // Redirect the user to the profile edit page
            $this->__goUserEdit();
        }

        //Order
        // Calculate the estimated delivery date
        $delivery_time = 0;
        foreach ($this->cart->contents() as $citem)
            if($delivery_time < $citem['options']['delivery_time']) $delivery_time = $citem['options']['delivery_time'];

        $delivery_time = date('Y-m-d', strtotime('+'.$delivery_time.' days'));

        // Instanciate a order object
        $order = new Order();

        // Set some atributes
        {
            $order->user_id                 = $user->id;
            $order->estimated_delivery_date = $delivery_time;
            $order->status                  = 0;
        }

        // Check if the user delivery address is effective a delivery address
        if($this->session->userdata('delivery_address_id') != 'default') {

            // Instanciate a new delivery address
            $delivery_address = new Delivery_Address( $this->session->userdata('delivery_address_id') );

            // Check if the address exists
            if( $delivery_address->exists() ) {
                $order->delivery_address_id = $delivery_address->id;

            }else{
                $this->session->set_flashdata('error', 'Selecione um endereço de entrega válido.');
                $this->__goCart();
            }

        }

        // Try to save the order
        if( !$order->save() ) {
            $this->session->set_flashdata('error', $order->error->transaction);
            $this->__goHome();
        }

        // Load needed helpers
        $this->load->helper( array('clear_number', 'to_money') );

        // Add PagSeguro library
        include(APPPATH . "libraries/pagseguro/PagSeguroLibrary.php");

        // Create a new request
        $pagSeguro = new PagSeguroPaymentRequest();

        // Define variables to be used into the email tamplate
        $emailBody = array(
            'title'       => 'Recebemos o seu pedido!',
            'userName'    => $user->name,
            'userEmail'   => $user->email,
            'userAddress' => array(),
            'orderNumber' => $order->id,
            'total'       => to_money($this->cart->total()),
            'products'    => array()
        );

        // The user address is the default?
        if($this->session->userdata('delivery_address_id') == 'default') {

            $emailBody['userAddress'] = array(
                'userFullName' => "{$user->name} {$user->surname}",
                'street'       => $user->street,
                'number'       => $user->number,
                'complement'   => $user->complement,
                'district'     => $user->district,
                'state'        => $user->state->acronym,
                'city'         => $user->city->name,
                'zipCode'      => $user->zip
            );

        }else{

            // Instanciate a new delivery address
            $delivery_address = new Delivery_Address( $this->session->userdata('delivery_address_id') );

            // The address exists?
            if( $delivery_address->exists() ) {

                $emailBody['userAddress'] = array(
                    'userFullName' => "{$user->name} {$user->surname}",
                    'street'       => $delivery_address->street,
                    'number'       => $delivery_address->number,
                    'complement'   => $delivery_address->complement,
                    'district'     => $delivery_address->district,
                    'state'        => $delivery_address->state->acronym,
                    'city'         => $delivery_address->city->name,
                    'zipCode'      => $delivery_address->zip
                );

            }else{

                $this->session->set_flashdata('error', 'Selecione um endereço de entrega válido.');
                $this->__goCart();

            }

        }

        foreach ($this->cart->contents() as $row_id => $product) {

            $item = new Item($product['id']);

            $product['price'] = (double) $product['price'];

            // Add product information to be used into the email
            $emailBody['products'][] = array(
                'productQuantity'   => $product['qty'],
                'productName'       => $item->name,
                'designerName'      => $item->user->name,
                'productPrice'      => to_money($product['price']),
                'productPriceTotal' => to_money($product['subtotal'])
            );

            // Add product description to PagSeguro request
            $pagSeguro->addItem(
              $product['id'],
              substr($product['name'], 0, 50) . " " . $product['options']['material'] . $product['options']['measurement'],
              $product['qty'],
              $product['price']
            );

            //Save order_item
            $order_item = new Order_Item();
            $order_item->item_id                       = $product['id'];
            $order_item->item_variation_material_id    = $product['options']['variation_material_id'];
            $order_item->item_variation_measurement_id = $product['options']['variation_measurement_id'];
            $order_item->order_id                      = $order->id;
            $order_item->price                         = $product['price'];
            $order_item->qty                           = $product['qty'];

            // Try to save order item
            if( !$order_item->save() ) {
                $this->session->set_flashdata('error', $order_item->error->transaction);
                $this->__goHome();
            }

            // Save credits to the product's designer in user_balance table
            $designer = new User($item->user->id);

            // Validate user
            if ( $designer->exists() ) {

                //Save credits
                $designer_balance                   = new User_Balance();
                $designer_balance->order_item_id    = $order_item->id;
                $designer_balance->status           = 0; //new. change to approved when the order is finalized
                $designer_balance->tracking         = "home";
                $designer_balance->transaction_type = 1; // credit
                $designer_balance->user_id          = $designer->id;
                $designer_balance->value            = ($order_item->price * $order_item->qty) * (floatval(PRODUCT_SELL_ROYALTIES) / 100);

                // The credits was saved?
                if( !$designer_balance->save() ) {

                    $this->session->flashdata('error', "Falha ao creditar os valores desta venda ao designer {$designer->name}.");
                    $this->__goHome();

                }

            }

            //Save credits to the ambiance owner where the product is linked
            if ($product['options']['ambiance_link']) {

                //Validate ambiance
                $ambiance_link = new Ambiance($product['options']['ambiance_link']);

                // The ambiance exists?
                if( !$ambiance_link->exists() ) break;

                // Instanciate ambiance owner
                $ambiance_owner = new User($ambiance_link->user->id);

                // Ambiance owner exists?
                if( !$ambiance_owner->exists() ) break;

                // Save credits
                {
                    $ambiance_owner_balance = new User_Balance();

                    $ambiance_owner_balance->ambiance_id      = $ambiance_link->id;
                    $ambiance_owner_balance->order_item_id    = $order_item->id;
                    $ambiance_owner_balance->status           = 0; //new. change to approved when the order is finalized
                    $ambiance_owner_balance->tracking         = "ambiance";
                    $ambiance_owner_balance->transaction_type = 1; // credit
                    $ambiance_owner_balance->user_id          = $ambiance_owner->id;
                    $ambiance_owner_balance->value            = ($order_item->price * $order_item->qty) * (floatval(AMBIANCE_SELL_ROYALTIES) / 100);
                }

                // The credits was saved?
                if ( !$ambiance_owner_balance->save() ) {
                    $this->session->flashdata('error', 'Falha ao gravar créditos para o dono do ambiente.');
                    $this->__goHome();
                }

            }


        }

        // Load necessary libraries to send email
        $this->load->library( array('email/EmailService', 'email/EmailSite') );

        // Send email that confirms the order
        $emailSite = new EmailSite();
        $emailSite->sendOrderReceived($emailBody);

        // Define default area code if necessary
        $user->areaCode = $user->areaCode > 0 ? $user->areaCode : '11';

        // Set client information for PagSeguro
        $pagSeguro->setSender(
            "{$user->name} {$user->surname}",
            $user->email,
            $user->areaCode,
            str_replace('-', '', $user->phone)
        );

        // Check witch kind of address is used by the user
        if( $this->session->userdata('delivery_address_id') == 'default' ) {

            $shippingAddress = array(
                'city'       => $user->city->name,
                'complement' => $user->complement,
                'country'    => 'BRA',
                'district'   => $user->district,
                'number'     => $user->number,
                'postalCode' => $user->zip,
                'state'      => $user->state->acronymn,
                'street'     => $user->street
            );

        }else{

            //ADDRESS
            $shippingAddress = array(
                'city'       => $delivery_address->city->name,
                'complement' => $delivery_address->complement,
                'country'    => 'BRA',
                'district'   => $delivery_address->district,
                'number'     => $delivery_address->number,
                'postalCode' => $delivery_address->zip,
                'state'      => $delivery_address->state->acronymn,
                'street'     => $delivery_address->street
            );

        }

        // Define the correctly shipping address for PagSeguro
        $pagSeguro->setShippingAddress(
            $shippingAddress['postalCode'],
            $shippingAddress['street'],
            $shippingAddress['number'],
            $shippingAddress['complement'],
            $shippingAddress['district'],
            $shippingAddress['city'],
            $shippingAddress['state'],
            'BRA'
        );

        // Define currency for PagSeguro
        $pagSeguro->setCurrency('BRL');

        /*
            Define shipping type.
            3 means "NOT_SPECIFIED"
        */
        $pagSeguro->setShippingType(3);

        // Define order ID for PagSeguro
        $pagSeguro->setReference($order->id);

        //Set the discount
        $discount = 0;

        // The user used any credit?
        if ( $this->session->userdata('user_credit') ) {

            $user_balance = new User_Balance();

            $user_balance->save();
            $user_balance->status = 0; //new. change to approved when the order is finalized
            $user_balance->transaction_type = 2; // debit
            $user_balance->user_id = $user->id;
            $user_balance->value = $this->session->userdata('user_credit');

            //add to the discount ammount
            $discount += $this->session->userdata('user_credit');

        }

        // Any counpon was used?
        if ( $this->session->userdata('discount_coupon') ) {

            $discount_cnp = $this->session->userdata('discount_coupon');

            //validate session coupon
            $discount_coupon = new Discount_Coupon($discount_cnp['id']);

            // the coupon exists?
            if ( $discount_coupon->exists() ) {

                //save discount coupon in order
                $order->discount_coupon_id = $discount_coupon->id;
                $order->discount_coupon_value = $discount_coupon->value;
                $order->save();

                //add to the discount ammount
                $discount += $discount_coupon->value;
            }

        }

        //Set the discount
        //define discount value as a negative number
        $discount = $discount * -1;
        $pagSeguro->setExtraAmount($discount);

        // Register Sell in Pagseguro
        try
        {
            //Authenticate with Pagseguro user and token
            $credentials = new PagSeguroAccountCredentials(PAGSEGURO_LOGIN, PAGSEGURO_TOKEN);

            // Get payment URL
            $paymentURL = $pagSeguro->register($credentials);

            //Clear cart
            $this->cart->destroy();

            //Clear delivery address
            $this->session->unset_userdata('delivery_address_id');

            //clear discount coupon
            $this->session->unset_userdata('discount_coupon');

            //clear user credit
            $this->session->unset_userdata('user_credits');

            //Send user to Pagseguro ambient and finalize the sell
            redirect($paymentURL);

        }catch(PagSeguroServiceException $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            $this->__goCart();
        }

    }

    /**
     * Send user back to the page where he cames
     * @return void
     */
    private function __goBack()
    {
        // Address where the user came
        $referer = $_SERVER['HTTP_REFERER'];

        if ( empty($referer) ) {
            $this->__goHome();
        }else{
            redirect($referer);
        }
    }

    /**
     * Send the user to the cart
     *
     * @access private
     * @return void
     */
    private function __goCart()
    {
        redirect('site/cart');
    }

    /**
     * Send user to the edit page
     *
     * @access private
     * @return void
     */
    private function __goUserEdit()
    {
        redirect('minha-conta');
    }

    /**
     * Send user to the home page
     *
     * @access private
     * @return void
     */
    private function __goHome()
    {
        redirect('/');
    }

}

/* End of file cart.php */
/* Location: ./application/controllers/site/cart.php */
