<?php

/**
 * Class that sends all emails from site
 *
 * @author  Gustavo Franco
 * @since   2013-07-10
 */
class EmailSite extends EmailService
{
  /**
   * Send the order received message
   *
   * @param  array $data   Email content
   * @return boolean
   * @author  Gustavo Franco
   * @since   2013-07-10
   */
  public function sendOrderReceived(array $data)
  {
    $subject = 'Recebemos seu pedido #' . $data['orderNumber'];
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderReceived', $data)
    ));

    return $this->send($data['userEmail'], $subject, $message);
  }

  /**
   * Send the payment received message
   *
   * @param  array $data   Email content
   * @return boolean
   * @author  Gustavo Franco
   * @since   2013-10-30
   */
  public function sendPaymentReceived(array $data)
  {
    $subject = 'Recebemos seu pagamento #' . $data['orderNumber'];
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/paymentReceived', $data)
    ));

    return $this->send($data['userEmail'], $subject, $message);
  }

  /**
   * Send the project submitted message
   *
   * @param  array $data Email content
   * @return boolean
   * @author Gustavo Franco
   * @since  2013-07-17
   */
  public function sendProjectSubmitted(array $data)
  {
    $subject = 'Projeto submetido com sucesso!';
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/projectSubmitted', $data)
    ));

    return $this->send($data['userEmail'], $subject, $message);
  }

  /**
   * Email to be send when an order was set up as authorized
   *
   * @param (array) $data = Data to be used into eh view
   * @since 2013-07-18
   * @return void
   */
  public function sendOrderAuthorized(array $data)
  {
    # Prepare message content
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderAuthorized', $data)
    ));

    # Send an email
    $this->send($data['userEmail'], $data['title'], $message);
  }

  /**
   * Send an advice to a supplier asking for initiate the production
   *
   * @param  (array)  $data = All necessary data do send an email with specific information
   * @since  2013-07-18
   * @return void
   */
  public function sendOrderProduce(array $data)
  {
    # Prepare message content
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderProduce', $data)
    ));

    # Send an email
    $this->send($data['supplierEmail'], $data['title'], $message);
  }

  /**
   * Email noticing the design about credits from sold product
   *
   * @param  (array)  $data = All necessary data to be used into an email and view
   * @since  2013-07-18
   * @return void
   */
  public function sendDesignerCredit(array $data)
  {
    # Prepare message content
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderDesignerCredit', $data)
    ));

    # Send an email
    $this->send($data['designerEmail'], $data['title'], $message);
  }

  /**
   * Email to tell ambiance owner about credit gain
   *
   * @param  (array)  $data = All necessary date to make and send an email
   * @since  2013-07-18
   * @return void
   */
  public function sendAmbianceCredit(array $data)
  {
    # Prepare message content
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderAmbianceCredit', $data)
    ));

    # Send an email
    $this->send($data['userEmail'], $data['title'], $message);
  }

  /**
   * Send the order canceled by user message
   *
   * @param  array $data Email content
   * @return boolean
   * @author Gustavo Franco
   * @since  2013-07-25
   */
  public function sendOrderCancelled(array $data)
  {
    # Prepare message content
    $message = $this->render('emails/templates/default', array(
        'content' => $this->render('emails/site/orderCancelled', $data)
    ));

    # Send an email
    $this->send($data['userEmail'], $data['title'], $message);
  }

}

/* End of library EmailSite */
/* Location: ./application/libraries/EmailSite.php */
