<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class KioskController extends Controller
{

    public function index($mac) {
        $token = Veris::getToken();
        // dd($token);
        return view('kiosk.home')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function ingreso($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.ingreso')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function menu($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.menu')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function proximasCitas($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.proximas-citas')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function paquetesPreventivos($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.paquetes-preventivos')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function detallePaquete($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.detalle-paquete')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function asignarPaquete($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.asignar-paquete')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function citaElegirPaciente($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.cita-elegir-paciente')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function citaElegirModalidad($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.cita-elegir-modalidad')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function citaElegirDatos($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.cita-elegir-datos')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function citaElegirFecha($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.cita-elegir-fecha')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function citaReservar($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.cita-reservar')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function carrito($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.carrito')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function datosFacturacion($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.datos-facturacion')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function listaMetodosPago($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.lista-metodos-pago')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function pagoExitoso($mac) {
        // $token = session('accessToken');
        $token = Veris::getToken();
        return view('kiosk.pago-exitoso')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function refreshToken(){
        $token = Veris::getToken();
        if($token != ""){
            $msg = [
                "code" => 200,
                "message" => "",
                "idToken" => $token
            ];
        }else{
            $msg = [
                "code" => 400,
                "message" => "No se pudo generar el token"
            ];
        }

        return response()->json($msg);
    }
}
