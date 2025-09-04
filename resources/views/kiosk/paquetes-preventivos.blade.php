@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Paquetes preventivos'])
	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row g-3 d-flex justify-content-between align-items-start h-100 mx-0">
			<div class="col-2 pb-4">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 h-100" style="overflow-y: auto; max-height: 70vh !important;">
				<div class="row border-bottom py-32">
					<div class="col-6 offset-3 border d-flex justify-content-between align-items-center border-silver rounded-6 p-1 mb-3">
						<button class="btn p-3 rounded-4 bg-royal-blue text-white fs-20 line-height-16 flex-fill">Comprar</button>
						<button class="btn p-3 rounded-4 fs-20 line-height-16 flex-fill">Agendar</button>
					</div>
					<div class="col-10 offset-1 py-4 d-flex justify-content-between align-items-center gap-2">
						<div class="input-group bg-beige-light border-midnight-blue-tint-80 search-box rounded-8">
		                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
		                    <input type="search" class="form-control bg-transparent fs-16 line-height-20 border-0 p-2 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Ejemplo: Exámenes de laboratorio" aria-describedby="search" style="outline: none;box-shadow: none;"/>
		                </div>
		                <button class="btn h-100 d-flex justify-content-between p-12 align-items-center fs-18 line-height-24 border-royal-blue text-royal-blue rounded-8" style="width: 175px;">
		                	Filtrar por
		                	<img src="{{asset('assets/img/fa-filter.svg')}}" alt="Filtrar">
		                </button>
					</div>
				</div>
				<div class="row py-3">
					<div class="col-12 filtros-elegidos d-flex justify-content-start align-items-center gap-2">
						<div class="item-categoria d-flex justify-content-between align-items-center gap-2">
							Mujeres <i class="fa-solid fa-xmark"></i>
						</div>
					</div>
					<div class="col-12">
						Paquetes
					</div>
				</div>
			</div>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	trackId = localStorage.getItem('trackId');
	document.addEventListener("DOMContentLoaded", async function () {
		//await cargarPaquetesPreventivos();

		$('body').on('click','.item-servicio', async function(){
			$('.item-servicio').removeClass('bg-royal-blue text-white item-selected').addClass('border-royal-blue-tint-60 text-royal-blue');
			$(this).addClass('bg-royal-blue text-white item-selected').removeClass('border-royal-blue-tint-60 text-royal-blue')
			await drawCardsServicio();
		});

		$('body').on('click', '.btn-consultorio', function(){
			let nombreConsultorio = $(this).attr('consultorio-rel');
			$('.nombreConsultorio').html(`#${nombreConsultorio}`);
			$('#modalConsultorio').modal('show')
		})

		$('body').on('click', '.btn-pagar', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			let datosPago = {
				"reserva": {
					"codigoReserva": detalle.codigoReserva
				}
			}
			await agregarItem(datosPago);
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
        args["data"] = JSON.stringify(datosPago);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	location.href = '/datos-facturacion/{{ $mac }}';
        }
	}

	let servicios;
	async function cargarPaquetesPreventivos(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/proximas_citas?macAddress={{ $mac }}&trackId=${trackId}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.length == 0){
        	//Empty space
        	$('#content-area').html(`<div class="text-center mt-5 pt-5">
						<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
						<p class="text-center py-40 mb-0 fs-28 line-height-32">Aún no tienes citas médicas <br> agendadas</p>
						<a href="/nueva-cita/{{ $mac }}" class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
					</div>`);
        }else{
        	servicios = data.data
        	//draw menu horizontal
        	await drawMenuHorizontal();
        	await drawCardsServicio();
        }
	}

	async function drawCardsServicio(){
		let servicio = $('.item-selected').attr('servicio-rel')
		let data = servicios.filter(s => s.nombreServicioN1 === servicio);
		let elem = ``;
		$.each(data, function(key, value){
			$.each(value.fechaAtencionGrouped, function(k, v){
				let cards = ``;
				$.each(v, function(k1, v1){
					cards += drawCardItem(v1)
				})
				elem += `<div class="row box-dia pt-64">
					<div class="col-12 fs-18 line-height-24 fw-medium">
						<span class="text-royal-blue">Agendada para:</span> ${k}
					</div>
				</div>
				<div class="row pt-32 cards-items d-flex justify-content-between align-items-start">
					${cards}
				</div>`
			})
		})
		$('#content-area').html(elem);
	}

	function drawStatusBox(detalle){
		let estaPagado = detalle.estaPagado;
		let condicionTiempo = detalle.condicionTiempo;
		let elem = ``;
		if(estaPagado){
			if(condicionTiempo == "TIEMPO_AGOTADO"){
				elem += `<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium bg-orange-light text-orange-dark">
						<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">No atendida</span>
					</div>`;
			}else{
				elem += `<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium gradient-green text-green-dark">
						<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">Cita pagada</span>
					</div>`;
			}
		}else{
			elem += `<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium bg-red-light text-red-dark">
						<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">Pago pendiente</span>
					</div>`
		}
		return elem;
	}

	function drawStatusButtons(detalle){
		let estaPagado = detalle.estaPagado;
		let condicionTiempo = detalle.condicionTiempo;
		let elem = ``;
		if(estaPagado){
			if(condicionTiempo == "TIEMPO_AGOTADO"){
				elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-reagendar">Reagendar</button>`;
			}else{
				elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
					<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-consultorio" consultorio-rel='${(detalle.nombreSitio.split(' '))[1]}'>Ver consultorio</button>`;
			}
		}else{
			elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
				<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Pagar</button>`
		}
		return elem;
	}

	function drawCardItem(detalle){
		return `<div class="col-6 col-md-6 box-agenda">
					${drawStatusBox(detalle)}
					<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
					    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
					        <img src="${detalle.iconoEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
					    </div>
					    <div class="box-info-agendamiento flex-grow-1">
					        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</h3>
					        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${detalle.nombreMedico.toLowerCase()}</p>
					        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> ${detalle.nombreSucursal.toLowerCase()}</p>
					        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Hora:</span> ${detalle.horaInicioFin}</p>
					        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
								${drawStatusButtons(detalle)}
					        </div>
					    </div>
					</div>
				</div>`
	}

	async function drawMenuHorizontal(data){
		let menu = ``;
		$.each(servicios, function(key, value){
			let classBtn = 'border-royal-blue-tint-60 text-royal-blue'
			if(key == 0){
				classBtn = 'bg-royal-blue text-white item-selected';
			}
			menu += `<div type="button" class="item-servicio text-nowrap ${classBtn} p-3 rounded-8 fs-14 line-height-16 text-capitalize" servicio-rel='${value.nombreServicioN1}'>
				${value.nombreServicioN1.toLowerCase()}
			</div>`;
		})
		$('#menu-horizontal').html(menu)
	}
</script>
@endsection