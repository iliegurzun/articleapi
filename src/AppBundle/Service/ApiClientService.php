<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Service;

/**
 * Description of ApiService
 *
 * @author Ilie
 */
class ApiClientService 
{
    const SERVICE_NAME = 'app.api_client';
    
    protected $apiHost;
    
    public function createArticle($params)
    {
        $encoded = '';
        foreach($params as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    $encoded .=$name.'['.$key.']='.urlencode($val).'&';
                }
            } else {
                $encoded .= urlencode($name).'='.urlencode($value).'&';
            }
        }
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $this->apiHost);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
        
        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);      
        
        return $output;
    }
    
    public function setApiHost($apiHost)
    {
        $this->apiHost = $apiHost;
        
        return $this;
    }
}
