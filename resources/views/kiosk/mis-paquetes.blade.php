@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/paquetes-preventivos/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Paquetes preventivos'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'proximas-citas'])
			</div>
			<div class="col-10 px-32 d-flex flex-column overflow-auto contenido-central mt-0" style="overflow-y: auto;">
				<div class="row">
					<div class="col-12 mb-3">
						<div class="row" id="listado-paquetes">
						</div>
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
	
	document.addEventListener("DOMContentLoaded", async function () {
		await obtenerMisPaquetesPreventivos();

        {{-- $('body').on('click', '.btn-comprar', function(){
        	let paquete = $(this).attr('dat
        	args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/proximas_citas?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;a-rel');
        	console.log(paquete);
        	localStorage.setItem("paquete", paquete);
        	location.href = `/detalle-paquete/{{ $mac }}`;
        }) --}}

        $('body').on('click', '.btn-asignar', async function(){
			location.href = `/asignar-paquete/{{ $mac }}`;
		})

	})

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

	let servicios;
	async function obtenerMisPaquetesPreventivos(){
		let args = [];
		//tipoGestion: TODOS, FACTURADOS, ASIGNADOS
       	args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/paquetes?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&tipoGestion=TODOS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
        	let elem = ``;
            $.each(data.data, function(key, value){
                elem += `<div class="col-md-6 mt-0 mb-3 item-promocion" id="promocion-${value.secuenciaPaquetePaciente}">
                    <div class="card m-1 mt-0 mb-0">
                        <div class="card-header position-relative feature-img-promocion" style="background: url(${value.urlImagen}) no-repeat center;">
                        </div>
                        <div class="card-body p-3 pb-0">
                            <h2 class="title-promocion-mis-compras line-height-20 fs--16 mb-2">${capitalizarCadaPalabra(value.nombreComercialPaquete)}</h2>
                        </div>
                        <div class="card-footer border-0 d-flex justify-content-end align-items-center p-3 pt-0 mt-3">
                			<div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle-paquete" data-rel='${JSON.stringify(value)}'>Ver paquete</div>
                        </div>
                    </div>
                </div>`;
            })
            $('#listado-paquetes').html(elem);            
        }else{
            alert(data.message);
        }
	}
</script>
@endsection