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
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="row border-bottom py-32">
					<div class="col-6 offset-3 border d-flex justify-content-between align-items-center border-silver rounded-6 p-1 mb-3">
						<a href="/paquetes-preventivos/{{ $mac }}" class="btn p-3 rounded-4 fs-20 line-height-16 flex-fill">Comprar</a>
						<button class="btn p-3 rounded-4 bg-royal-blue text-white fs-20 line-height-16 flex-fill">Agendar</button>
					</div>
					<div class="col-10 offset-1 py-4 d-flex justify-content-between align-items-center gap-2">
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
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await obtenerMisPaquetesPreventivos();

        {{-- $('body').on('click', '.btn-comprar', function(){
        	let paquete = $(this).attr('dat
        	args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/proximas_citas?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;a-rel');
        	console.log(paquete);
        	localStorage.setItem("paquete", paquete);
        	location.href = `/detalle-paquete/{{ $mac }}`;
        }) --}}

        $('body').on('click', '.btn-detalle-paquete', async function(){
        	localStorage.setItem('detalle-paquete-preventivo', $(this).attr('data-rel'))
			location.href = `/detalle-paquete-comprado/{{ $mac }}`;
		})

	})

	let servicios;
	async function obtenerMisPaquetesPreventivos(){
		let args = [];
		//tipoGestion: TODOS, FACTURADOS, ASIGNADOS
       	args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/paquetes?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&tipoGestion=FACTURADOS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
        	let elem = ``;
            $.each(data.data, function(key, value){
            	let pathUrl = (value.urlImagen == "" || value.urlImagen === null) ? `{{asset('assets/img/paquete-default.png')}}` : value.urlImagen;
                elem += `<div class="col-md-6 mt-0 mb-3 item-promocion" id="promocion-${value.secuenciaPaquetePaciente}">
                    <div class="card m-1 mt-0 mb-0 border-royal-blue-tint-90 rounded-16 h-100">
                        <div class="card-header position-relative feature-img-promocion m-3 rounded-8 border-0" style="background: url(${pathUrl}) no-repeat center;">
                        </div>
                        <div class="card-body p-3 py-0">
                            <h2 class="line-height-24 fs-20 text-royal-blue fw-medium mb-1">${capitalizarPrimeraLetra(value.nombreComercialPaquete)}</h2>
                			<p class="fs-12 line-height-16 text-capitalize mb-1">${datosCliente.nombreCompleto.toLowerCase()}</p>
                			<p class="fs-12 line-height-16 text-capitalize mb-0">Válida hasta: <span class="text-royal-blue">${value.fechaVigencia}</span></p>
                        </div>
                        <div class="card-footer border-0 d-flex justify-content-end align-items-center p-3 pt-0 mt-4 bg-transparent">
                			<div class="btn bg-royal-blue text-white fs-14 line-height-16 px-3 py-2 btn-detalle-paquete" data-rel='${JSON.stringify(value)}'>Usar paquete</div>
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
<style>
	.feature-img-promocion{
		height: 230px;
	}
</style>
@endsection