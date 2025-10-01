<?php

namespace App\Models;

use session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Veris extends Model
{
    use HasFactory;

    public const MACS_PARAMI = ["1C-69-7A-AE-99-3D","48-21-0B-2D-28-8F","48-21-0B-2D-1F-3C","48-21-0B-2D-2F-04","1C-69-7A-6A-CF-95"];

    //DEV
    public const BASE_URL = 'https://desa-turnero.phantomx.com.ec';
    public const BASE_URL_DIGITALES = 'https://api-phantomx.veris.com.ec';
    public const BASE_WAR = 'kiosko/v1';
    public const SEGURIDADES_WAR = 'seguridadtest/v1';
    public const BASE_WAR_DIGITALES = 'digitalestest/v1';
    public const CANAL_ORIGEN = 'MVE_CMV';
    public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';//UEhBTlRPTVhfRU1QUkVTQVJJQUw=
    public const IDORGANIZACION = 'adf4e264-cd20-4653-9a44-025b13050992';
    public const AMPLITUDE = "1cbd8baed97a6c8abf6b8e398b77cf6f";
    public const BASICAUTH = 'd3NLaW9za28zOlBoeEsxMCRrMDIwMjU=';
    public const BASICAUTHDIGITALES = 'QkFDS0VORFBIQU5UT006Q2xAdmUxMjM0';
    public const WEBURL = 'https://digiturno.akold.com';
    public const URLPAYMENT = 'https://miveris.akold.com';
    public const APPLICATION_LOGIN = 'UEhBTlRPTVhfRU1QUkVTQVJJQUw=';
    public const IDORGANIZACION_LOGIN = '365509c8-9596-4506-a5b3-487782d5876e';
    public const BASICAUTHPINPAD = 'd3NwaW5wYWQ6VyRQwqFOUEBEQVVUIzNOVMKhQ0BUSTBO';
    public const BASIC_URL_PINPAD = 'https://ipnws.veris.com.ec/pinpadTest-api/v1';
    public const APPLICATION_LOGIN_LIDER = 'UEhBTlRPTVhfV0VC';
    public const BASIC_LOGIN_LIDER = 'TFBMVUE6Q2xAdmUxMjM=';
    public const URL_EPI = 'http://ecstest.veris.com.ec/Verisrest/v1/formularioepi1';


    //PROD 
    // public const BASE_URL = 'https://turnero.phantomx.com.ec';
    // public const BASE_URL_DIGITALES = 'https://api.phantomx.com.ec';
    // public const BASE_WAR = 'kiosko/v1';
    // public const SEGURIDADES_WAR = 'seguridad/v1';
    // public const BASE_WAR_DIGITALES = 'digitales/v1';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    // public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const AMPLITUDE = "93127ac840f734cdcc8bf469f8bc95d5";
    // public const BASICAUTH = 'd3NLaW9za28zOlBoeEsxMCRrMDIwMjU=';
    // public const BASICAUTHDIGITALES = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';
    // public const WEBURL = 'https://digiturno.veris.com.ec';
    // public const URLPAYMENT = 'https://app.veris.com.ec';
    // public const APPLICATION_LOGIN = 'UEhBTlRPTVhfRU1QUkVTQVJJQUw=';
    // public const IDORGANIZACION_LOGIN = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const BASICAUTHPINPAD = 'd3NwaW5wYWQ6VyRQwqFOUEBEQVVUIzNOVMKhQ0BUSTBO';
    // public const BASIC_URL_PINPAD = 'https://phantom-wsinternos.phantomx.com.ec/pinpad-api/v1';
    // public const APPLICATION_LOGIN_LIDER = 'UEhBTlRPTVhfV0VC';
    // public const BASIC_LOGIN_LIDER = 'TFBMVUE6Q2xAdmUxMjM=';
    // public const URL_EPI = 'https://phantom-wsexternos.phantomx.com.ec/Verisrest/v1/formularioepi1';
 
    static function call(Array $config)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $config['endpoint']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // METHOD
        if( $config['method'] == 'POST' ){
            curl_setopt($ch, CURLOPT_POST, 1);
        }else if( $config['method'] == 'GET' || $config['method'] == 'PUT' ){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $config['method']);
        }

        $header = [];
        $header[] = 'application: ' . self::APPLICATION;
        $header[] = 'idorganizacion: ' . self::IDORGANIZACION;

        // AUTH
        if( isset($config['token']) && !isset($config['data'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $config['token'] ));
            $header[] = 'Authorization: Bearer ' . $config['token'];
        }

        // POST DATA
        if( isset($config['data']) && ($config['method'] == 'POST' || $config['method'] == 'PUT' ) ){
            $data_serialized = json_encode($config['data']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_serialized);
            
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($data_serialized);
            $header[] = 'content-language: es';
            
            if( isset($config['token']) ){
                $header[] = 'Authorization: Bearer ' . $config['token'];
            }
        }

        if( isset($config['basic']) ){
            $header[] = 'Authorization: Basic ' . $config['basic'];
            $header[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // LOGIN
        if( isset($config['username']) && isset($config['password'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
        }

        // dd($header);
        
        // API CALL
        try{
            $result = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
        }
        catch(\Exception $e){
            $result = [ 'error' => 'Falla en la llamada', ];
        }

        // RETURN DATA
        if( gettype($result) === 'string' )
            return json_decode($result);

        return $result;
    }

    /*
    * getToken
    * ----------------------------------------------
    * Peticion al webservice de Digiturno para obtener el token
    * de acceso para las peticiones CURL. Esto se debe
    * ejecutar una sola vez por sessión.
    * ----------------------------------------------
    */
    static function getToken()
    {
        $token = session('accessToken', null);

        /*if( $token !== null ){
            return $token;
        }*/
        
        $method = '/seguridad/login';
        // $response = Veris::call([
        //     'endpoint' => self::BASE_URL_DIGITALES.'/'.self::SEGURIDADES_WAR.$method,
        //     'basic' => self::BASICAUTHDIGITALES,
        //     'method'   => 'POST'
        // ]);

        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => self::APPLICATION,
                    'Authorization' => 'Basic '.self::BASICAUTH,
                ])->post(self::BASE_URL_DIGITALES.'/'.self::BASE_WAR.$method);
        $response = json_decode($res->body());

        // echo self::BASE_URL_DIGITALES.'/'.self::BASE_WAR.$method;
        // dd($response);
        
        session(['accessToken' => $response->data]);
        return $response->data;
    }

    static function getTokenPinPad()
    {
        $token = session('accessTokenPinPad', null);

        /*if( $token !== null ){
            return $token;
        }*/
        
        $method = 'autenticacion/login';
        // $response = Veris::call([
        //     'endpoint' => self::BASE_URL_DIGITALES.'/'.self::SEGURIDADES_WAR.$method,
        //     'basic' => self::BASICAUTHDIGITALES,
        //     'method'   => 'POST'
        // ]);

        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => self::APPLICATION,
                    'Authorization' => 'Basic '.self::BASICAUTHPINPAD,
                ])->post(self::BASIC_URL_PINPAD.'/'.$method);
        $response = json_decode($res->body());

        // echo self::BASIC_URL_PINPAD.'/'.$method;
        // dd($response);
        
        session(['accessTokenPinPad' => $response->data->accesToken]);
        return $response->data->accesToken;
    }

    static function getTokenLider()
    {
        $token = session('accessTokenLider', null);

        /*if( $token !== null ){
            return $token;
        }*/
        
        $method = 'autenticacion/login';
        // $response = Veris::call([
        //     'endpoint' => self::BASE_URL_DIGITALES.'/'.self::SEGURIDADES_WAR.$method,
        //     'basic' => self::BASICAUTHDIGITALES,
        //     'method'   => 'POST'
        // ]);

        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => self::APPLICATION_LOGIN_LIDER,
                    'IdOrganizacion' => self::IDORGANIZACION_LOGIN,
                    'Authorization' => 'Basic '.self::BASIC_LOGIN_LIDER,
                ])->post(self::BASE_URL_DIGITALES.'/'.self::BASE_WAR.'/'.$method);
        $response = json_decode($res->body());

        // echo self::BASE_URL_DIGITALES.'/'.self::BASE_WAR_DIGITALES.'/'.$method;
        // dd($response->data->accessToken);
        
        session(['accessTokenLider' => $response->data->accessToken]);
        return $response->data->accessToken;
    }

}