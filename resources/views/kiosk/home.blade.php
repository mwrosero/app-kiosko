@extends('template.app-template')
@section('bodybg')
bg-royal-blue-tint-90
@endsection
@section('content')
<div class="container px-0 d-flex flex-column justify-content-end min-vh-100">
	{{-- @include('components.header') --}}
	<div class="row rounded-24 bg-white p-44" style="margin-bottom: 350px;">
		<div class="col-12 text-center my-5 pb-5">
			<h2 class="fw-bold fs-40 line-height-40">¿Cómo quieres empezar?</h2>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="C">
				<div class="box-icon-home d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-cedula.svg" alt="">
				</div>
				<p class="fs-24 line-height-28 fw-medium">Con número<br>de cédula</p>
			</div>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="P">
				<div class="box-icon-home d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-pasaporte.svg" alt="">
				</div>
				<p class="fs-24 line-height-28 fw-medium">Con número<br> de Pasaporte</p>
			</div>
		</div>
		<div class="col-4">
			<div class="item-access card rounded-24 bg-royal-blue-tint-90 border-0 text-center p-44" type-rel="N">
				<div class="box-icon-home d-flex justify-content-end align-items-center mx-auto">
					<img class="img-fluid mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-nombres.svg" alt="">
				</div>
				<p class="fs-24 line-height-28 fw-medium">Con nombres<br>y apellidos</p>
			</div>
		</div>
	</div>
</div>
<style>
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
	document.addEventListener("DOMContentLoaded", async function () {
		await cargarParametros();
		deleteStorage();
		$('body').on('click','.item-access', async function(){
			let type = $(this).attr('type-rel')
			localStorage.setItem("tipo", type);
			location.href = '/ingreso/{{ $mac }}'
		});
	})

	function deleteStorage(){
		localStorage.removeItem("tipo");
		localStorage.removeItem("datosCliente");
		localStorage.removeItem("trackId");
		localStorage.removeItem("usuarioDigital");
		{{-- localStorage.removeItem("detalle-paquete-preventivo");
		localStorage.removeItem("idPreTransaccion");
		localStorage.removeItem("paquete");
		localStorage.removeItem("origen");
		localStorage.removeItem("itemAgregado");
		localStorage.removeItem("agendamiento");
		localStorage.removeItem("agrupacionFacturar");
		localStorage.removeItem("datosFacturados");
		localStorage.removeItem("pagoUnico"); --}}
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