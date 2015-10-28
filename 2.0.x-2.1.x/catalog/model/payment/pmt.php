<?php

class ModelPaymentPmt extends Model
{
    public function getMethod($address)
    {
        $this->load->language('payment/pmt');

        if ($this->config->get('pmt_status')) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        //simulator in title
        //default title $this->language->get('text_title')
        /*
        $this->inst6 =$this->instAmount(6);
        $this->inst5 =$this->instAmount(5);
        $this->inst4 =$this->instAmount(4);
        $this->inst3 =$this->instAmount(3);
        $this->inst2 =$this->instAmount(2);
        $financia='Financiación: <script>function updateAmount(value){document.getElementById("inst_value").innerHTML=value; } </script>';
        $financia .= "<span id='inst_value'>".$this->inst6."</span> € /mes durante <select onChange=\"updateAmount(this.value);\"><option value='".$this->inst6."'>6</option><option value='".$this->inst5."'>5</option><option value='".$this->inst4."'>4</option><option value='".$this->inst3."'>3</option><option value='".$this->inst2."'>2</option></select> meses (Paga+Tarde)";
        $financia="test";
        */
        $financia = $this->language->get('text_title');
        if ($status) {
            $method_data = array(
                'code' => 'pmt',
                  'title' => $financia,
            'terms' => '',
                'sort_order' => $this->config->get('pmt_sort_order'),
              );
        }

        return $method_data;
    }

    /*
    * function instAmount
    * calculate the price of the installment
    * param $amount : amount in cents of the total loan
    * param $num_installments: number of installments, integer
    * return float with amount of the installment
    */
    public function instAmount ( $num_installments) {
      $discount =$this->config->get('pmt_discount');
      $this->load->model('checkout/order');
      // Load order into memory
      $amount =$this->cart->getTotal() * 100;
      if ( $discount){
        return round (($amount/100) / $num_installments,2);
      }
      $r = 0.25/365; #daily int
      $X = $amount/100; #total loan
      $aux = 1;  #first inst value
      for ($i=0; $i<= $num_installments-2;$i++) {
        $aux = $aux + pow(1/(1+$r) ,(45+30*$i));
      }
      return round( ($X/$aux),2);
    }

}
