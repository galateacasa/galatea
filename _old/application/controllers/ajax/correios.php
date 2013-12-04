<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correios extends CI_Controller {

  public function address_search(){
    $zip = $this->input->get_post('zip');

    if( strstr($zip, '_') || strlen($zip) < 8 )
    {
      $zip = '0';
    }

    $zip = str_replace('.', '', $zip);
    $zip = str_replace('-', '', $zip);

    $url = 'http://republicavirtual.com.br/web_cep.php?cep='.urlencode($zip).'&formato=json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 0);

    $result = curl_exec($ch);
    curl_close($ch);
    if(!$result){
      echo "erro";
      die();
    }
    echo $result;
  }
}

/* End of file correios.php */
/* Location: ./application/controllers/ajax/correios.php */
