<?php
/**
 * CI service that sends all emails from the application
 *
 * @author  Gustavo Franco
 * @since   2013-07-10
 */
class EmailService
{
  /** @public $ciEmailService Email Service Instance */
  private $ciEmailService;
  private $codeIgniter;

  /**
   * Constructor method
   *
   * @author Gustavo Franco
   * @since  2013-07-10
   */
  public function __construct() {
    $this->codeIgniter = &get_instance();
    $this->ciEmailService = $this->codeIgniter->load->library('email');
  }

  /**
   * Main method to send emails
   *
   * @param  string $to Recipient
   * @param  string $subject Subject
   * @param  string $message Message
   * @return boolean
   * @author Gustavo Franco
   * @since  2013-07-10
   */
  protected function send($to, $subject, $message)
  {
    $this->codeIgniter->email->to($to)
                        ->from(EMAIL_GALATEA, CONTATO_GALATEA)
                        ->bcc(EMAIL_GALATEA)
                        ->subject($subject)
                        ->message($message)
                        ->send();
  }

  /**
   * Return the result of view render
   *
   * @param  string $view View path
   * @param  array  $vars Variables to view
   * @return string HTML
   * @author Gustavo Franco
   * @since  2013-07-10
   */
  protected function render($view, array $vars) {
    return $this->codeIgniter->load->view($view, $vars, TRUE);
  }

}

/* End of library EmailService */
/* Path: ./application/libraries/EmailService.php */
