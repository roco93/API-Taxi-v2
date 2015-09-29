<?php
error_reporting(E_ALL ^ E_DEPRECATED);
defined('BASEPATH') OR exit('No direct script access allowed');


class AsyncWebRequest extends Thread {
    public $url;
    public $data;
    public $arrayT=[];

    public function __construct($url){
        $this->url = $url;
    }
    
    public function run(){
        $url = $this->url;
        $arrayT= $this->arrayT;
        /*
        * If a large amount of data is being requested, you might want to
        * fsockopen and read using usleep in between reads
        */
        foreach ($url as $key => $value) {
            $json=$this->conexionLABPLC($value);
            array_push($arrayT, $json["Taxi"]);
        }
        $this->arrayT=$arrayT; 
    }

    private function conexionLABPLC ($urlApi){
        $request = curl_init();
        curl_setopt($request,CURLOPT_URL,$urlApi);

        //esta linea es importante para poder procesar la respuesta json
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        //ejecutamos
        $respuesta = curl_exec($request);
        curl_close($request);
        
        //convertimos el json de respuesta en un array asociativo
        $json = json_decode($respuesta, true);
        return $json;
    }

}

