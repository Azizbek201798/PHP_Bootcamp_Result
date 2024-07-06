<?php

class Currency{

    const CB_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";

    public function Exchange($uzs, $currency){
        $data = $this->customCurrencies()[$currency];        
        return ceil($uzs / $data);
    
    }

    public function getCurrencyInfo(){

        $data = file_get_contents(self::CB_URL);
        return json_decode($data);

    }

    public function customCurrencies(){

        $currencies = (array)$this->getCurrencyInfo();
        $orderCurrencies = [];

        $i = 0;
        foreach($currencies as $currency){
            
            $orderCurrencies[$currency->Ccy] = $currency->Rate;
            
            if ($i == 10){ 
                break;
            } else{
                $i += 1;
            }
        
        }

        return $orderCurrencies;

    }

}

?>