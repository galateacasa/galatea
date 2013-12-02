<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Balances extends Base_Controller {

  public function index($page = 1)
  {

    # The user is logged in?
    if( $this->session->userdata('id') )
    {
      $user = new User( $this->session->userdata('id') );

      # The user exists?
      if( $user->exists() )
      {
        //Credits from products sells
        $product_sells = new User_Balance();
        $product_sells->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
        $product_sells->where(array('user_id' => $user->id, 'tracking' => 'home'));
        $product_sells->get();

        //Credits from ambiance sells
        $ambiance_sells = new User_Balance();
        $ambiance_sells->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
        $ambiance_sells->where(array('user_id' => $user->id, 'tracking' => 'ambiance'));
        $ambiance_sells->get();

        //Products
        $products = new Item();
        $products->where(array('status'=>1, 'type' => 2));
        $products->order_by("create_date", "desc");
        $products->get();

        $toview['product_sells'] = $product_sells;
        $toview['ambiance_sells'] = $ambiance_sells;
        $toview['products'] = $products;
        $toview['user'] = $user;
        $toview['current_menu'] = 'user_balance';
        $toview['content'] = 'site/user_balance/index';

        $this->template->load('site', 'site/about/index', $toview);
      }else{
        redirect('/login');
      }

    }else{
      redirect('/login');
    }
  }

  function credit_recovery(){
    $usr = $this->session->userdata('user');
    $user = new User($usr['id']);

    //redirect to login if cannot find user
    if(!$user->exists()){
      redirect(site_url('login'));
    }

    if($this->input->post()){
      $this->form_validation->set_rules('value', 'Valor a ser resgatado', 'required|decimal');
      $this->form_validation->set_rules('name', 'Nome Titular NF', 'required');
      $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
      $this->form_validation->set_rules('bank', 'Banco', 'required');
      $this->form_validation->set_rules('account', 'Conta Corrente', 'required');
      $this->form_validation->set_rules('agency', 'Agência', 'required');
      $this->form_validation->set_rules('fiscal', 'Upload da Nota Fiscal', 'required');
      
      $this->form_validation->set_message('required', 'O campo %s é obrigatório.');
      $this->form_validation->set_message('decimal', 'O campo %s deve ser um valor monetário.');

      #if validation fails return to form
      if (!$this->form_validation->run()) {
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('site/user_balances/credit_recovery'));
      }

      $user_balance = new User_Balance();
      $user_balance->where_related($user)
                   ->get();
      #if user dont have credits to recover return to "meus creditos" page
      if(!$user_balance->exists()){
        $this->session->set_flashdata('error', 'Usuário não possui créditos.');
        redirect(site_url('site/user_balances'));
      }

      //create the credit recovery solicitation
      $credit_recovery = new Credit_Recovery();
      $credit_recovery->user_id = $user->id;
      $credit_recovery->value = $this->input->post('value');
      $credit_recovery->name = $this->input->post('name');
      $credit_recovery->cnpj = $this->input->post('cnpj');
      $credit_recovery->bank = $this->input->post('bank');
      $credit_recovery->account = $this->input->post('account');
      $credit_recovery->agency = $this->input->post('agency');
      $credit_recovery->status = $this->input->post('status');

      //NF upload
      $this->load->library('s3', 's3');
      $path = 'files/fiscal';
      $bucket = $this->config->item('s3_bucket');
      $fullpath = $this->config->item('s3_ambient')."/".$this->path."/";

      $file = $_FILES['fiscal']['tmp_name'];
      $filename = $_FILES['fiscal']['name'];
      $basename = substr($filename, 0, strripos($filename, '.'));
      $ext = substr($filename, strripos($filename, '.'));
      $name = uniqid() . $ext;

      if(!$this->s3->putObjectFile($file, $bucket, $fullpath . $name, S3::ACL_PUBLIC_READ)){
        $this->session->set_flashdata('error', 'Falha no upload da NF');
      }

      $credit_recovery->fiscal = $name;
      $credit_recovery->save();
      
      $this->session->set_flashdata('success', 'Solicitação criada com sucesso.');
      redirect(site_url('site/user_balances'));

    }

    $toview['user'] = $user;
    $toview['current_menu'] = 'user_balance';
    $toview['content'] = 'site/user_balance/credit_recovery';

    $this->template->load('site', 'site/about/index', $toview);
  }
}

/* End of file user_balance.php */
/* Location: ./application/controllers/site/user_balance.php */
