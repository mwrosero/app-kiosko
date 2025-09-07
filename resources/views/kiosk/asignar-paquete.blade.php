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
				<div class="row mt-40" id="listaPacientes">
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
		
        $('body').on('click', '.btn-asignar', async function(){
        	let paciente = JSON.parse($(this).attr('data-rel'));
			let datosPago = {
				"paquetesPromocionales": {
					"codigoPaquete": paquete.codigoPaquete,
					"idPaciente": paciente.pacPacNumero
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
        if(data.code == 200){
        	let elem = ``;
        	$.each(data.data, function(key, value){
        		let backgroundClass = ( value.genero === "F" ) ? "bg-magenta" : "bg-royal-blue";

                elem += `<div class="col-6 mb-4">
                    <div class="card h-100 cursor-pointer p-3 text-center border-silver rounded-8 shadow-veris btn-asignar" data-rel='${JSON.stringify(value)}'>
                        <div class="card-body text-center px-3 py-2">
                           	<div class="d-flex ${backgroundClass} justify-content-center rounded-circle mx-auto align-items-center mb-3 fs-28 line-height-28 fw-medium text-white" style="width: 64px; height: 64px;">
                                ${value.primerNombre.charAt(0).toUpperCase()}
                            </div>
                            <p class="text-veris fw-medium fs-18 line-height-24 mb-2">${capitalizarElemento(value.primerNombre)} <br> ${capitalizarElemento(value.primerApellido)} ${capitalizarElemento(value.segundoApellido)}</p>
                            <p class="text-veris fs-16 line-height-20 mb-0 text-capitalize">${value.nombreTipoParentesco.toLowerCase()}</p>
                        </div>
                    </div>
                </div> `;
            })
            $('#listaPacientes').html(elem)
        }
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