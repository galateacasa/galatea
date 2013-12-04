<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller
{
  public function end_voting_projects()
  {
    $projects = new Item();
    $projects->where( array('status' => 1, 'delivery_date' => date('Y-m-d')) )->get();

    foreach($projects as $project)
    {
      $data = array(
        'designer_name'  => $project->user->name,
        'designer_image' => '',
        'project_name'   => $project->name,
        'project_image'  => ''
      );

      $this->send_email($data);
    }
  }

  private function send_email($data = array())
  {
    $data['title'] = "Parabéns para {$data['designer_name']}! O projeto {$data['project_name']} ganhou a votação do mês!";
    $data['text'] = array(
      $data['project_image'] . $data['designer_image'],
      "A GALATEA produzirá um protótipo deste projeto, e em breve ele estará a venda no site. Se você votou nesta ideia, ganhará 5% de desconto na compra.",
      "Obrigado por fazer parte da Galatea!",
      "Time Galatea Casa"
    );

    # Send email
    {
      $this->load->library('email');

      $this->email->from('email@email.com', 'Name');
      $this->email->to('someone@example.com');
      $this->email->cc('another@example.com');
      $this->email->bcc('and@another.com');

      $this->email->subject('subject');
      $this->email->message('message');

      $this->email->send();
    }
  }
}

/* End of file cronjob.php */
/* Location: ./application/controllers/cronjob.php */
