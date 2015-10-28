<?php

class ControllerPaymentPmt extends Controller
{
    private $error;

    public function index()
    {
        $this->load->language('payment/pmt');

        $data['text_testmode'] = $this->language->get('text_testmode');
        // Set up confirm/back button text
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['button_back'] = $this->language->get('button_back');

        // Load model for checkout page
        $this->load->model('checkout/order');

        // Load order into memory
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

				//populate data to invoke form
        $data['full_name'] = $order_info['payment_firstname'].' '.$order_info['payment_lastname'];

        $currency = $order_info['currency_code'];
        $data['currency_code'] = $order_info['currency_code'];
        //we only support EUR
        $data['currency_code'] = 'EUR';

        //discount
        if ($this->config->get('pmt_discount')){
          $data['discount'] = 'true';
        }else{
          $data['discount'] = 'false';
        }

        $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false) * 100;
        $data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false) * 100;

        if ($this->config->get('pmt_test')) {
            $data['customer_code'] = $this->config->get('pmt_test_customer_code');
            $data['customer_key'] = $this->config->get('pmt_test_customer_key');
        } else {
            $data['customer_code'] = $this->config->get('pmt_real_customer_code');
            $data['customer_key'] = $this->config->get('pmt_real_customer_key');
        }
                // Other params for payment page
                $data['email'] = $order_info['email'];

                // Encrypt order id for verification
                //$this->load->library('encryption');

                //$encryption = new Encryption($this->config->get('config_encryption'));
                //$enc = $encryption->encrypt($this->session->data['order_id']);
                //for security reasons we encrypt the order id
                $data['order_id'] = $this->session->data['order_id'];
                //encrypted version
                //$data['order_id'] =$enc;
                $route = $_GET['route'];

                // Set success/fail urls
                $data['redirector_success'] = HTTPS_SERVER.'index.php?route=payment/pmt/success&';
                //$data['redirector_success'] = urlencode($enc);
                $data['redirector_failure'] = HTTPS_SERVER.'index.php?route=payment/pmt/failure&';

                //adresss

                $data['street'] = $order_info['payment_address_1'].' '.$order_info['payment_address_2'];
        $data['city'] = $order_info['payment_city'];
        $data['province'] = $order_info['payment_zone'];
        $data['citycode'] = $order_info['payment_postcode'];

                //locale
                $data['locale'] = strtolower($order_info['language_code']);

                // we have a list of supported localtes, if locale is not in the list we degault to en.

                $available_locales = array('ca','en','es','eu','fr','gl','it','pl','ru');
        if (!in_array($data['locale'], $available_locales)) {
            $data['locale'] = 'en';
        }

                //shipping price
                $i = 0;

        if (isset($this->session->data['shipping_method'])){
          $shipping = $this->session->data['shipping_method'];

          if (!empty($shipping)) {
              $data['products'][$i]['description'] = $shipping['title'];
              $data['products'][$i]['quantity'] = 1;
              $data['products'][$i]['amount'] = $shipping['cost'];
              ++$i;
          }
        }

          //taxes
          	$taxes = $this->cart->getTaxes();
            $tax_price=0;
            foreach ($taxes as $t => $price){
                $tax_price+=$price;
            }

            if ($tax_price > 0){
              $data['products'][$i]['description'] ="Taxes";
              $description[]="Taxes";
              $data['products'][$i]['quantity'] = 1;
              $data['products'][$i]['amount'] = $tax_price;
              ++$i;
            }

                //product description
                $products = $this->cart->getProducts();
                $description="";
        foreach ($products as $key => $item) {
            $data['products'][$i]['description'] = $item['name'] . " ( ".$item['quantity'].") ";
            $description[]=$item['name'] . " ( ".$item['quantity'].") ";
            $data['products'][$i]['quantity'] = $item['quantity'];
            $data['products'][$i]['amount'] = $item['price'] * $item['quantity'];
            ++$i;
        }
        $data['description']=implode(",",$description);


                //dynamic callback
                $data['callback'] = HTTPS_SERVER.'index.php?route=payment/pmt/callback';


        $dataToEncode = $data['customer_key'].$data['customer_code'].$data['order_id'].$data['total'].$data['currency_code'].$data['redirector_success'].$data['redirector_failure'].$data['callback'].$data['discount'];

        $data['signature'] = sha1($dataToEncode);
                //form url
                $data['action'] = 'https://pmt.pagantis.com/v1/installments';

                // Render page template
                $this->id = 'payment';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/payment/pmt.tpl')) {
            return $this->load->view($this->config->get('config_template').'/template/payment/pmt.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/pmt.tpl', $data);
        }
    }

    public function failure()
    {
        $this->language->load('payment/pmt');

        $this->document->setTitle($this->language->get('heading_fail'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false,
          );

        $data['heading_title'] = $this->language->get('heading_fail');
        $data['text_message'] = $this->language->get('message_fail');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['continue'] = $this->url->link('checkout/checkout', '', 'SSL');

        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/common/success.tpl')) {
            $this->template = $this->config->get('config_template').'/template/common/success.tpl';
        } else {
            $this->template = 'default/template/common/success.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header',
        );

        $this->response->setOutput($this->render());
    }

    public function success()
    {
        $this->response->redirect(HTTPS_SERVER.'index.php?route=checkout/success');
    }

    public function callback()
    {
        $json = file_get_contents('php://input');
        $temp = json_decode($json, true);
        $data = $temp['data'];
        $order_id = $data['order_id'];

        $event = $temp['event'];

        //we got a new correct sale
        if ($event == 'charge.created') {
            $this->load->model('checkout/order');
        /* encrypted version
                // e is the encrypted order ID
                $e = $order_id;


                // load encryption component and checkout modeul
                $this->load->library('encryption');


                // Create new encryption object and try to decrypt order value
                $encryption = new Encryption($this->config->get('config_encryption'));

                if ($e) {
                    $order_id = $encryption->decrypt($e);
                } else {
                    $order_id = 0;
                }

                // Hack detection
                if(!$order_id) die('ERROR - Hack attempt detected');
                */
                // Load order, and verify the order has not been processed before, if it has, go to success page
                $order_info = $this->model_checkout_order->getOrder($order_id);
                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_status_id'), 'Order ID: '.$order_id,true);

            if ($order_info) {
                if ($order_info['order_status_id'] != 0) {
                    $this->response->redirect(HTTPS_SERVER.'index.php?route=checkout/success');
                }
            }


        } elseif ($event == 'charge.failed') {
            //do nothing
        }
    }
}
