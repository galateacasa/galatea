<?php

/**
 * Controller to solve PagSeguro returns
 */
class Pagseguro extends CI_Controller {
  /**
   * Receive notifications from PagSeguro API
   * @return void
   */
  function notify($order_id = FALSE) {
    # Add necessary library
    include(APPPATH . "libraries/pagseguro/PagSeguroLibrary.php");

    # Create PagSeguro object responsible to define credentials
    $credentials = new PagSeguroAccountCredentials(LOGIN_PAGSEGURO, TOKEN_PAGSEGURO);

    # The received notification is a transaction?
    // if( TRUE )
    if( $this->input->post('notificationType') )
    {
      try
      {
        # Get transaction data
       $PagSeguroTransaction = PagSeguroNotificationService::checkTransaction($credentials, $this->input->post('notificationCode'));

        # Instanciate new order based on ID. From test or from PagSeguro?
        // $order = new Order($order_id);
        $order = new Order( $PagSeguroTransaction->getReference() );

        # The order exists?
        if( $order->exists() )
        {
          # Payment information
          {
           $paymentMethod = $PagSeguroTransaction->getPaymentMethod();
           $paymentType   = $PagSeguroTransaction->getType();
           $paymentStatus = $PagSeguroTransaction->getStatus();
          }

          # Define fields to be updated and save it
          {
            $order->status         = $paymentStatus->getValue();
            $order->payment_method = $paymentType->getType();
            // $order->status         = 4; # payment
            // $order->status         = 7; # cancelled
            // $order->payment_method = 202; # Visa credit card
          }

          # Update order

          # Load necessary libraries to send email
          $this->load->helper( array('address_to_array', 'date_brazilian') );
          $this->load->library( array('email/EmailService', 'email/EmailSite') );

          # Send email that confirms the order
          $email = new EmailSite();

          # Prepare shared data
          $emailClientData = array(
            'userName'    => $order->user->name,
            'userEmail'   => $order->user->email,
            'orderNumber' => $order->id,
            'scheadule'   => 0
          );

          # From test or from PagSeguro?
          $status = $paymentStatus->getValue();
          // $status = 4; # payment
          // $status = 7; # cancelled

          # Custom action based on payment status
          switch($status)
          {
            case 1: # Waiting for payment.
            case 2: # In analysis. (paid with credit card)
            case 3: # Paid. (but can be cancelled)
              exit(); # Nothing will be done
            break;

            # Available to be retrieved.
            case 4:
              # Define new order create date
              $order->create_date = date('Y-m-d');

              # Define title
              $emailClientData['title'] = "Seu pedido #{$order->id} foi autorizado";

              # Define user address
              $emailClientData['userAddress'] = empty($order->delivery_address_id) ? address_to_array($order->user->delivery_address->get(), $order->user->name, $order->user->surname) : address_to_array( new User($order->user->id) );

              # Order total
              $emailClientData['total'] = 0;

              # Define bought products
              foreach($order->order_item->get() as $orderItem)
              {
                # Define sub total of the order
                $subTotal = $orderItem->qty * $orderItem->price;

                # Define the product of the order
                $product  = $orderItem->item;

                # Define more one product
                $emailClientData['products'][] = array(
                  'productQuantity'   => $orderItem->qty,
                  'productName'       => $product->name,
                  'designerName'      => $product->user->name,
                  'productPrice'      => $orderItem->price,
                  'productPriceTotal' => $subTotal
                );

                # Increment que order total
                $emailClientData['total'] += $subTotal;

                # Send email to a supplier
                {
                  # Define measuraments
                  $productMeasurament = array(
                    $orderItem->item_variation_measurement->width,
                    $orderItem->item_variation_measurement->height,
                    $orderItem->item_variation_measurement->depth
                  );

                  # Mount measurament text
                  $productMeasurament = implode('cm x ', $productMeasurament) . ' (LxAxP)';

                  # Instanciate a new supplier informantio about an item
                  $itemSupplier = new Items_Supplier();
                  $itemSupplier->where('item_id', $product->id)->get();

                  # Instanciate a new user
                  $supplier = new User($itemSupplier->user_id);

                  # Get all comoon products in all open orders
                  $allOrderItems = new Order_Item();
                  $allOrderItems->select_func('sum', '@qty', 'qty')
                                ->where_related_order('status', 0)
                                ->where('item_id', $orderItem->item_id)
                                ->get();

                  # Products monthly rate
                  $productsTotalOrder = $allOrderItems->qty / $itemSupplier->production_amount;

                  # Scheadule amount in days
                  $scheaduleAmount = $productsTotalOrder > 1 ? ceil($productsTotalOrder) * $product->delivery_time : $product->delivery_time;

                  # Define data to the email
                  $emailSupplierData = array(
                    'title'              => "Aviso de novo pedido #{$order->id}",
                    'supplierEmail'      => $supplier->email,
                    'supplierName'       => $supplier->name,
                    'orderNumber'        => $order->id,
                    'productName'        => $product->name,
                    'productMaterial'    => $orderItem->item_variation_material->material,
                    'productMeasurament' => $productMeasurament,
                    'orderDate'          => date_brazilian($order->create_date),
                    'scheaduleDate'      => date('d/m/Y', strtotime("+$scheaduleAmount days")),
                    'scheaduleAmount'    => $product->delivery_time - 15
                  );

                  # This item scheadule is longer then the actual defined? So define the new one!
                  if($emailClientData['scheadule'] < $scheaduleAmount) $emailClientData['scheadule'] = $scheaduleAmount + 10;

                  # Send email to the supplier
                  $email->sendOrderProduce($emailSupplierData);
                }

                # Send email to the product designer
                {
                  # Define data
                  $emailDesignerData = array(
                    'title'         => "Vendemos: {$product->name}",
                    'designerName'  => $product->user->name,
                    'designerEmail' => $product->user->email,
                    'productName'   => $product->name,
                    'productURL'    => base_url("produto/{$product->slug}")
                  );

                  # Send an email
                  $email->sendDesignerCredit($emailDesignerData);
                }

                # This order was come from any ambiance?
                foreach( $orderItem->user_balance->get() as $userBalance )
                {
                  if( !empty($userBalance->ambiance_id) ):
                    # Instanciate ambiance from this order item
                    $orderItemAmbiance = new Ambiance( $orderItem->user_balance->get()->ambiance_id );

                    # Define necessary data
                    $emailUserAmbianceData = array(
                      'title'     => "Sua imagem \"{$orderItemAmbiance->title}\" gerou uma venda!",
                      'userEmail' => $orderItemAmbiance->user->email,
                      'userName'  => $orderItemAmbiance->user->name,
                      'imageName' => $orderItemAmbiance->title,
                      'royalties' => 'R$' . number_format($subTotal * ( floatval(AMBIANCE_SELL_ROYALTIES) / 100), 2, ',', '.')
                    );

                    # Send an email
                    $email->sendAmbianceCredit($emailUserAmbianceData);
                  endif;
                }
              }

              # Send email
              $email->sendOrderAuthorized($emailClientData);

              // foreach ($order_items->result() as $order_item):

              //   $user_balance_update = array('status' => $status);
              //   $this->db->where('order_item_id', $order_item->id);

              //   if( $this->db->update('user_balance', $user_balance_update) ){
              //     log_message('error', 'Update user_balance');
              //   }else{
              //     log_message('error', 'user_balance not updated: ');
              //   }

              // endforeach;
            break;

            case 5: # In dispute.
            case 6: # Refunded
            case 7: # Cancelled.
              # Instanciate new email class
              $emailSite = new EmailSite();

              # Send cancelled order
              $emailSite->sendOrderCancelled(array(
                  'title' => 'Pedido #' . $order->id . ' cancelado',
                  'userEmail' => $order->user->email,
                  'userName' => $order->user->name . ' ' . $order->user->surname,
                  'orderNumber' => $order->id
              ));
            break;

            # Have nothing to do if we don't know the transaction status
            default:
              exit();
            break;
          }

          # Update order information
          $order->save();
          echo "Deu certo!";

        }else{
          throw new Exception("O número da ordem de compra solicitato não existe no banco de dados");
        }

      } catch (PagSeguroServiceException $e) {
        $error = $e->getMessage();
        log_message('error', $error);
      }
    }else{
      echo "Nada recebido.";
    }
  }

  /**
   * Callback for PagSeguro API
   * @return void
   */
  public function callback() {
    // Add PagSeguro library
    include(APPPATH . "libraries/pagseguro/PagSeguroLibrary.php");

    $credentials = new PagSeguroAccountCredentials(PAGSEGURO_LOGIN, PAGSEGURO_TOKEN);
    $transaction = PagSeguroTransactionSearchService::searchByCode(
      $credentials, $this->input->get('transaction_id')
    );

    $order = new Order($transaction->getReference());

    // The specific order exists?
    if( $order->exists() ) {
      // Save PagSeguro transaction ID
      $order->payment_code = $this->input->get('transaction_id');
      $order->save();

      // Send confirmation message
      $this->load->library( array('email/EmailService', 'email/EmailSite') );
      $emailSite->sendPaymentReceived(array(
        'title'       => 'Recebemos o seu pagamento!',
        'userName'    => $order->user->name,
        'userEmail'   => $order->user->email,
        'orderNumber' => $order->id
      ));

      // Load view
      $this->template->load('site', 'site/cart/callback', array('order_id' => $order->id));
    }
  }
}
