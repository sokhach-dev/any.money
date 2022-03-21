<?php

// https://docs.any.money/ru/sci_invoice/#web_form


$sec_key_sci="1OZHc0KIajJeWodzF_aOjFNOZSo3o1EWFlmm4S2iU0Bapto29UeLg1TYu35d6xqxWi7V";
$sec_key_api="PlexfqOuASCFFF83vSB2fPhBnfK0_gwuZ0jvjigZ3xFPKXFEtC2hGX_TO37Sx9QCv7Od";
$merchant="5375";
$amount="1"; // todo для bic проверка min: 0.001  max: 50 ? разделитель точка запятая ?
$in_curr="BTC";
$payway="btc";
$externalid=date("YmdHis"); ;
$expiry="1h30m";
$client_email="customer@domain.com";
$is_multipay= "true";
$callback_url="https://example.com/order_handler";
$redirect_url="https://example.com/order_page/";

$data=[
    "merchant" => $merchant,
    "amount" => $amount,
    "in_curr" => $in_curr,
    "payway" => $payway,
    "externalid" => $externalid,
    "expiry" => $expiry,
    "client_email" => $client_email,
    "is_multipay" => $is_multipay,
    "callback_url" => $callback_url,
    "redirect_url" => $redirect_url,
];
ksort($data);

var_dump($data);




function sign_form_data(string $key, array $data): string
{
    ksort($data);
    $s = '';
    foreach ($data as $k => $value) {
        if (in_array(gettype($value), array('array', 'object', 'NULL'))) {
            continue;
        }
        if (is_bool($value)) {
            $s .= $value ? "true" : "false";
        } else {
            $s .= $value;
        }
    }
    return hash_hmac('sha512', strtolower($s), $key);
}


$form='
<form name="payment" method="post" action="https://sci.any.money/invoice" accept-charset="UTF-8">
  <input type="hidden" name="sign" value="'.sign_form_data($sec_key_sci,$data).'"/>
  <input type="hidden" name="merchant" value="'.$merchant.'"/>
  <input type="hidden" name="amount" value="'.$amount.'"/>
  <input type="hidden" name="in_curr" value="'.$in_curr.'"/>
  <input type="hidden" name="payway" value="'.$payway.'"/>
  <input type="hidden" name="externalid" value="'.$externalid.'"/>
  <input type="hidden" name="expiry" value="'.$expiry.'"/>
  <input type="hidden" name="client_email" value="'.$client_email.'"/>
  <input type="hidden" name="is_multipay" value="'.$is_multipay.'"/>
   <input type="hidden" name="callback_url" value="'.$callback_url.'"/>
  <input type="hidden" name="redirect_url" value="'.$redirect_url.'"/>
 

 
  
  <input type="submit" value="Pay">
</form>
';


print $form;

