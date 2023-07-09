<?php

function calculateDiscount($price, $discount)
{
    return $price - ($price * ($discount) / 100);
}

function ip_info()
{
    $ip = request()->ip();
    if($ip == '127.0.0.1'){
        return false;
    }

    if(session()->has('ip_info')){
        $ip_info = session('ip_info');
        if($ip_info && $ip_info->ip == $ip){
            return $ip_info;
        }
    }
    $ip_info = Stevebauman\Location\Facades\Location::get($ip);
    session(['ip_info' => $ip_info]);
    return $ip_info;
}
        

function currency_converter($amount = 1, $from = 'BDT', $to = 'USD')
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=$to&from=$from&amount=$amount",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: u6y3ObeADXF4Z8vCZsSxsBtFa0C6KERA"
    ),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $return_value = 0.0114673;

    $response = json_decode($response);
    if(isset($response->result)){
        $return_value = json_decode($response)->result;
    }
    return $return_value;
}

function currency_sign()
{
    $ip_info = ip_info();
    $currency_sign = '৳';
    if($ip_info && $ip_info->countryCode != 'BD'){
        $currency_sign = '$';
    }
    return $currency_sign;
}


function currency_amount($amount = 1)
{
    $ip_info = ip_info();
    $convert_amount = $amount;
    if($ip_info && $ip_info->countryCode != 'BD'){
        $convert_amount = currency_converter();
        $convert_amount = $convert_amount * $amount;
    }
    return number_format($convert_amount, 2);
}

function currency_rate(){
    $ip_info = ip_info();
    $convert_amount = 1;
    if($ip_info && $ip_info->countryCode != 'BD'){
        $convert_amount = currency_converter();
    }
    return $convert_amount;
}