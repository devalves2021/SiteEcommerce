<?php
    class ClassPayment{
        private $url;
        private $post;
        private $token;
        private $payment;

//Curls
    private function curls($action){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        if($action=='token'){
            curl_setopt($ch,CURLOPT_HEADER,false);
        }else{
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json", "Authorization: Bearer ".$this->token->access_token.""));
        }
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this->post);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        ($action == 'token')?curl_setopt($ch,CURLOPT_USERPWD,CLIENTID.':'.SECRETKEY):false;
        $data=curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

//Get a acess token
    public function getToken()
    {
        $this->url=URL.'v1/oauth2/token';
        $this->post="grant_type=client_credentials"; 
        $this->token=$this->curls('token');
    }
    //Invoice
    public function invoice($data)
    {
        $this->getToken();
        $this->url=URL.'v1/payments/payment';
        $this->post=$data;
         return json_encode($this->curls('invoice'));
    }
    //Payment
    public function payment($data)
    {
        $this->getToken();
        $this->url=URL."v1/payments/payment/".$data['payment_id']."/execute/";
        $this->post=json_encode(array('payer_id'=>$data['payer_id']));
        return json_encode($this->curls('payment'));
    }
}