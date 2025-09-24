@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/tratamientos/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Detalle de tratamiento'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'tratamientos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="info-tratamiento d-flex justify-content-start align-items-center gap-2 px-0 py-32">
					
				</div>
				<div class="w-100">
					<div class="col-12 bg-royal-blue-tint-90 my-2 p-3 fs-18 line-height-24 fw-medium">
						Órdenes pendientes
					</div>
				</div>
				<div class="w-100" id="listadoOrdenes">
					{{-- <div class="col-12 px-32 py-4 fs-18 line-height-24 fw-medium d-flex justify-content-between align-items-center border-bottom-midnight-blue-tint-80">
						<img src="https://dikg1979lm6fy.cloudfront.net/app/cmv/servicios/procedimiento_tp.png" alt="" width="56px">
						<div class="mx-3 flex-grow-1">
							<h2 class="text-royal-blue-shade-20 fw-medium fs-16 line-height-20 mb-1">Farmacia</h2>
							<p class="fs-14 line-height-16 mb-12 fw-normal"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> 23/07/2025</p>
							<div class="text-orange-dark fs-12 line-height-16">
								<i class="fa-solid fa-circle fs-16 me-1"></i><span class="fs-12 line-height-16">Por comprar</span>
							</div>
						</div>
						<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-detalle-chequeo">Ver detalle</button>
					</div> --}}
				</div>
			</div>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tratamiento = JSON.parse(localStorage.getItem('tratamiento'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "cita");
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await cargarInfoTratamiento();
		await cargarDetalleTratamiento();

		$('body').on('click', '.btn-detalle-orden', async function(){
			let item = JSON.parse($(this).attr('item-rel'));
			console.log(item);
			await mostrarDetalleOrden(item);
			$('#modalDetalleOrdenTratamiento').modal('show');
		})

	})

	async function mostrarDetalleOrden(detalle){
		let elemContent = ``;
		let buttonActions = ``;

		let tituloDetalle = (detalle.tipoServicio == "LABORATORIO") ? `${detalle.tipoServicio}` : `${detalle.tipoServicio} - ${detalle.nombreEspecialidad}`;
		let elemHeader = `<h3 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium mb-2 text-capitalize">${tituloDetalle.toLowerCase()}</h3>
	        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-40 me-1">Profesional:</span> ${tratamiento.nombreMedico.toLowerCase()}</p>
	        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-40 me-1 text-capitalize">Central médica:</span> </p>
	        ${ mostrarConvenio(tratamiento, 40) }`;

	    let elemTotales = `<p class="col-6 mb-0 fs-16 line-height-20 fw-medium text-dark-veris">Subtotal</p>
                    <p class="col-6 mb-0 fs-16 line-height-20 fw-medium text-end text-royal-blue">$8.40</p>`;

		
		if(detalle.tipoServicio == "LABORATORIO"){
			buttonActions += `<button class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" data-bs-dismiss="modal">Cerrar</button>`;
			if(detalle.detalleLaboratorio !== null){
				$.each(detalle.detalleLaboratorio.listaOrdenesDetalle, function(key, value){
					elemContent += `<li class="row text-dark-veris border-bottom-midnight-blue-tint-80 pb-3">
				    	<p class="col-6 mb-0 fs-12 line-height-16 text-capitalize">${value.nombrePrestacion.toLowerCase()}</p>
			            <p class="col-2 mb-0 fs-12 text-center line-height-16">$10.40</p>
			            <p class="col-2 mb-0 fs-12 text-center line-height-16">-$2.40</p>
			            <p class="col-2 mb-0 fs-12 text-center line-height-16">$8.40</p>
					</li>`
				})
			}
		}else{
			elemContent += `<li class="row text-dark-veris border-bottom-midnight-blue-tint-80 pb-3">
		    	<p class="col-6 mb-0 fs-12 line-height-16 text-capitalize">${detalle.nombrePrestacion.toLowerCase()}</p>
	            <p class="col-2 mb-0 fs-12 text-center line-height-16">$10.40</p>
	            <p class="col-2 mb-0 fs-12 text-center line-height-16">-$2.40</p>
	            <p class="col-2 mb-0 fs-12 text-center line-height-16">$8.40</p>
			</li>`
			if(detalle.esPagada == "S"){
				if(detalle.esAgendable == "S"){
					if(detalle.detalleReserva !== null){
						buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar w-50">Agendar</button>`;
					}else{
						buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar w-50">Agendar</button>`;
					}
				}
			}else{
				buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar w-50">Agendar</button>`;
			}
		}

		$('.box-actions-detalle-orden').html(buttonActions)
		

		$('.header-orden').html(elemHeader);
		$('.listado-items-orden-detalle').html(elemContent);
		$('.totalesDetalleOrden').html(elemTotales);
		//$('.listado-items-orden-detalle')
	}

	function mostrarConvenio(detalle){
		let elem = ``
		if(detalle.nombreConvenio !== null){
			elem += `<p class="fs-14 line-height-16 fw-medium mb-2"><span class="text-royal-blue-shade-20 me-1">Convenio:</span> ${detalle.nombreConvenio}</p>`
		}
		return elem;
	}

	async function cargarInfoTratamiento(){
		$('.info-tratamiento').html(`<div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8 h-100">
		        <img src="${tratamiento.urlImagenEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
		    </div>
		    <div class="box-info-agendamiento flex-grow-1">
		        <h3 class="fs-20 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${tratamiento.nombreEspecialidad.toLowerCase()}</h3>
		        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${tratamiento.nombreMedico.toLowerCase()}</p>
		        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> </p>
		        ${ mostrarConvenio(tratamiento, 20) }
		        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Enviado:</span> ${ capitalizarPrimeraLetra(tratamiento.fechaTratamientoFormat) }</p>
		    </div>`)
	}

	let detalleTratamiento;
	async function cargarDetalleTratamiento(showLoader = true){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/mis_tratamientos/detalles?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&codigoTratamiento=${tratamiento.codigoTratamiento}`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.pendientes.length == 0){
        	//Empty space
        	$('#listadoOrdenes').html(`<div class="text-center mt-5 pt-5">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
					<p class="text-center py-40 mb-0 fs-28 line-height-32">No tienes órdenes <br> pendientes para tu tratamiento</p>
					<a href="/cita-elegir-paciente/{{ $mac }}" class="d-none btn bg-royal-blue text-white fs-24 line-height-32 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
				</div>`);
        }else{
        	detalleTratamiento = data.data
       		await drawCardsServicio();
        }
	}

	function boxEstadoPago(value){
		let elem = ``;
		if(value.esPagada == "S"){
			elem += `<div class="text-green-dark fs-12 line-height-16">
				<i class="fa-solid fa-circle fs-16 me-1"></i><span class="fs-12 line-height-16">Comprado</span>
			</div>`;
		}else{
			elem += `<div class="text-orange-dark fs-12 line-height-16">
				<i class="fa-solid fa-circle fs-16 me-1"></i><span class="fs-12 line-height-16">Por comprar</span>
			</div>`;
		}
		return elem;
	}

	async function drawCardsServicio(){
		let elem = ``;
		$.each(detalleTratamiento.pendientes, function(key, value){
		    elem += `<div class="col-12 px-32 py-4 fs-18 line-height-24 fw-medium d-flex justify-content-between align-items-center border-bottom-midnight-blue-tint-80">
				<img src="${value.urlImagenTipoServicio}" alt="" width="56px">
				<div class="mx-3 flex-grow-1">
					<h2 class="text-royal-blue-shade-20 fw-medium fs-16 line-height-20 mb-1 text-capitalize">${value.nombreServicio.toLowerCase()}</h2>
					<p class="fs-14 line-height-16 mb-12 fw-normal"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> </p>
					${boxEstadoPago(value)}
				</div>
				<button item-rel='${JSON.stringify(value)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 px-3 p-12 btn-detalle-orden">Ver detalle</button>
			</div>`
		})
		
		$('#listadoOrdenes').html(elem);
	}

	function mostrarConvenio(detalle, tintText){
		let elem = ``
		if(detalle.nombreConvenio !== null){
			elem += `<p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-${tintText} me-1">Convenio:</span> ${detalle.nombreConvenio.toLowerCase()}</p>`
		}
		return elem;
	}

	function drawCardItem(detalle){
		return `<div class="col-6 col-md-6 box-agenda">
				<div class="rounded-16 border-royal-blue-tint-60 border-inside p-12 d-flex justify-content-between align-items-stretch">
				    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
				        <img src="${detalle.urlImagenEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
				    </div>
				    <div class="box-info-agendamiento flex-grow-1">
				        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</h3>
				        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${detalle.nombreMedico.toLowerCase()}</p>
				        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> </p>
				        ${ mostrarConvenio(detalle) }
				        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
							<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-ver-orden">Ver órdenes</button>
				        </div>
				    </div>
				</div>
			</div>`
	}
</script>
@endsection