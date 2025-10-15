@extends('template.app-template')
@section('content')
<div class="container px-0 d-flex flex-column justify-content-center min-vh-100">
	<div class="position-absolute d-flex gap-3 align-items-center" style="top: 15px;right: 15px;">
		<div class="dropdown">
			{{-- dropdown-toggle --}}
			<button class="btn btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-configuracion.svg" alt="">
			</button>
			<ul class="dropdown-menu rounded-8 p-0" aria-labelledby="dropdownMenuButton1">
				<li class="fs-16 line-height-20"><a class="dropdown-item px-3 py-2" href="/lider/{{ $mac }}">Lider de Caja</a></li>
				<li class="d-none fs-16 line-height-20 ingresar-host"><a class="dropdown-item px-3 py-2" href="/host/{{ $mac }}">Ingresar Host</a></li>
				<li class="fs-16 line-height-20 central-caja d-none"><div class="dropdown-item px-3 py-2 text-capitalize disabled" type="button"></div></li>
				<li class="d-none fs-16 line-height-20 cerrar-sesion label-username"><div class="dropdown-item px-3 py-2 disabled" type="button"></div></li>
				<li class="d-none fs-16 line-height-20 cerrar-sesion btn-logout"><div class="dropdown-item px-3 py-2 text-red-dark" type="button">Cerrar sesión</div></li>
			</ul>
		</div>

		{{-- <button class="btn btn-sm">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-configuracion.svg" alt="">
		</button> --}}
	</div>
	<div class="row">
		<div class="col-8 offset-2 d-flex justify-content-center">
			<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/vericita-logo.svg" alt="">
		</div>
		<div class="col-12 d-flex justify-content-center my-112">
			<h3 class="text-center text-white fw-bold fs-64 line-height-64">Bienvenido a Veris</h3>
		</div>
	</div>
	{{-- <div class="row rounded-24 bg-white p-44" style="margin-bottom: 350px;"> --}}
	<div class="row rounded-24 bg-white p-44">
		<div class="col-12 text-center my-5 pb-5">
			<h2 class="fw-bold fs-40 line-height-40">¿Cómo quieres empezar?</h2>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="C">
				<div class="box-icon-home w-100 d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-cedula.svg" alt="">
				</div>
				<p class="fs-24 line-height-28 fw-medium mt-2">Con número<br>de cédula</p>
			</div>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="P">
				<div class="box-icon-home w-100 d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-pasaporte.svg" alt="">
				</div>
				<p class="fs-24 line-height-28 fw-medium mt-2">Con número<br> de Pasaporte</p>
			</div>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="N">
				<div class="box-icon-home w-100 d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-nombres.svg" alt="" width="70px;">
				</div>
				<p class="fs-24 line-height-28 fw-medium mt-2">Con nombres<br>y apellidos</p>
			</div>
		</div>
	</div>
</div>
<style>
	body{
		background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/bg-kiosko.jpg) no-repeat center !important;
		background-size: cover !important;
	}
	.box-icon-home{
		width: 150px;
		height: 120px;
	}
	.box-icon-home img{
		max-width: 80px;
		object-fit: cover;
	}
</style>
<script>
	callCounter = false;
	activarInactividad = false;
	document.addEventListener("DOMContentLoaded", async function () {
		await cargarParametros();
		deleteStorage();
		$('body').on('click','.item-access', async function(){
			let type = $(this).attr('type-rel')
			localStorage.setItem("tipo", type);
			location.href = '/ingreso/{{ $mac }}'
		});
	})

	async function cargarParametros(){
		if(localStorage.getItem('parametrosGenerales') !== null){
			return;
		}
		
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/parametros?macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	localStorage.setItem("parametrosGenerales",JSON.stringify(data.data));
        }
	}

	function deleteStorage(){
		//localStorage.clear();
		localStorage.removeItem("tipo");
		localStorage.removeItem("datosCliente");
		localStorage.removeItem("trackId");
		localStorage.removeItem("usuarioDigital");
		localStorage.removeItem("idPreTransaccion");
		localStorage.removeItem("detalle-paquete-preventivo");
		localStorage.removeItem("idPreTransaccion");
		localStorage.removeItem("paquete");
		localStorage.removeItem("origen");
		localStorage.removeItem("itemAgregado");
		localStorage.removeItem("agendamiento");
		localStorage.removeItem("agrupacionFacturar");
		localStorage.removeItem("datosFacturados");
		localStorage.removeItem("pagoUnico");
		localStorage.removeItem("datosPacienteNuevo");
		localStorage.removeItem("tratamiento");
	}

	async function cargarParametros(){
		if(localStorage.getItem('parametrosGenerales') !== null){
			return;
		}
		
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/parametros?macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	localStorage.setItem("parametrosGenerales",JSON.stringify(data.data));
        }
	}
</script>
@endsection