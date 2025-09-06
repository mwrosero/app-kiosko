@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/detalle-paquete/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => '¿Para quién es el paquete?'])
	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row g-3 d-flex justify-content-between align-items-start h-100 mx-0">
			{{-- <div class="col-2 pb-4">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div> --}}
			{{-- style="overflow-y: auto; max-height: 70vh !important;" --}}
			<div class="col-10 offset-1 px-32 h-100">
				<div class="row mt-40">
					<div class="col-6 mb-4">
						<div class="p-3 text-center border-silver rounded-8 shadow-veris">sasdasd</div>
					</div>
					<div class="col-6 mb-4">
						<div class="p-3 text-center border-silver rounded-8 shadow-veris">sasdasd</div>
					</div>
					<div class="col-6 mb-4">
						<div class="p-3 text-center border-silver rounded-8 shadow-veris">sasdasd</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let paquete = JSON.parse(localStorage.getItem('paquete'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "paquete");
	
	document.addEventListener("DOMContentLoaded", async function () {

		await grupoFamiliar();
		
        $('body').on('click', '.btn-pagar', async function(){
			let datosPago = {
				"paquetesPromocionales": {
					"codigoPaquete": paquete.codigoPaquete,
					"idPaciente": datosCliente.idPaciente
				}
			}
			await agregarItem(datosPago);
		})

	})

	async function grupoFamiliar(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/grupo_familiar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
	}

	async function agregarItem(datosPago){
		console.log(datosPago);
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/agregar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify(datosPago);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	location.href = '/datos-facturacion/{{ $mac }}';
        }else{
        	$('#modalError').modal('show');
			$('.titleError').html(`Atención`);
			$('.msgError').html(data.message);
        }
	}
</script>
@endsection