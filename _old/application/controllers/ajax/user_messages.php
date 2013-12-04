<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Messages extends CI_Controller {

  public function get(){
    $user_id = $this->input->post('user_id');

    $user_messages = new User_Message();
    $user_messages->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $user_messages->where('user_id', $user_id);
    $user_messages->where('read', false);
    $user_messages->order_by('create_date');
    $user_messages->get();
    $return = array();
    foreach ($user_messages as $user_message) {
      $return[] = array(
        'id' => $user_message->id,
        'user_id' => $user_message->user_id,
        'user_name' => $user_message->user->name,
        'sender_id' => $user_message->sender_id,
        'sender_name' => $user_message->sender->name,
        'message' => $user_message->message
        );
    }
    echo json_encode(array('success'=>true, 'return'=>$return));
  }

  public function setUserMessageRead(){
    $message_id = $this->input->post('message_id');

    $user_message = new User_Message($message_id);
    if(!$user_message->exists()){
      echo json_encode(array('success'=>false, 'error'=> 'Mensagem não encontrada.'));
      die();
    }

    $user_message->read_date = date('Y-m-d H:i:s');
    $user_message->save();
    echo json_encode(array('success'=>true));
  }

  public function sendUserMessage(){
    $user_id = $this->input->post('user_id');
    $sender_id = $this->input->post('sender_id');
    $message = $this->input->post('message');

    $user_message = new User_Message();
    $user_message->user_id = $user_id;
    $user_message->sender_id = $sender_id;
    $user_message->message = $message;
    if(!$user_message->save()){
      echo json_encode(array('success'=>false));
      die();
    }

    echo json_encode(array('success'=>true));

  }

}

/* End of file messages.php */
/* Location: ./application/controllers/ajax/messages.php */
