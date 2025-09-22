@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Gestionar chequeos ocupacionales'])
	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row g-3 d-flex justify-content-between align-items-start h-100 mx-0">
			{{--  pb-4 --}}
			<div class="col-2">
				@include('components.access-bar', ['page' => 'chequeos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 py-40 h-100" style="overflow-y: auto; max-height: 70vh !important;">
				<div class="menu-inside d-flex justify-content-start align-items-center gap-2 overflow-auto" id="menu-horizontal">
				</div>
				{{-- <div class="menu-inside d-flex justify-content-start align-items-center gap-2 overflow-auto">
					<div type="button" tipoServicio-rel="L" class="item-servicio text-nowrap bg-royal-blue text-white p-3 rounded-8 fs-14 line-height-16">
						Consultas
					</div>
				</div> --}}
				<div class="container box-fecha px-0">
					<div class="row py-32 cards-items d-flex justify-content-between align-items-start" id="content-area">
						
					</div>
					{{-- <div class="text-center mt-5 pt-5">
						<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
						<p class="text-center py-40 mb-0 fs-28 line-height-32">Aún no tienes citas médicas <br> agendadas</p>
						<a href="/nueva-cita/{{ $mac }}" class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
					</div> --}}
					{{-- <div class="row box-dia pt-74">
						<div class="col-12 fs-18 line-height-24 fw-medium">
							<span class="text-royal-blue">Agendada para:</span> Viernes 18 de Julio, 2025
						</div>
					</div>
					<div class="row py-32 cards-items d-flex justify-content-between align-items-start">
						<div class="col-6 col-md-6 box-agenda">
							<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium bg-orange-light text-orange-dark">
								<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">No atendida</span>
							</div>
							<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
							    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
							        <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/especialidad.svg" class="m-2 img-fluid" alt="">
							    </div>
							    <div class="box-info-agendamiento flex-grow-1">
							        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2">Agendamiento</h3>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Profesional:</span>Alban Galvez Juliana Romina</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Central médica:</span>Veris - Kennedy</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Hora:</span>12:00-12:20</p>
							        <div class="box-action py-32 pb-0 d-flex justify-content-end align-items-center gap-2">
							        	<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
							        	<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-consultorio">Ver consultorio</button>
							        </div>
							    </div>
							</div>
						</div>
						<div class="col-6 col-md-6 box-agenda">
							<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium gradient-green text-green-dark">
								<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">Cita pagada</span>
							</div>
							<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
							    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
							        <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/especialidad.svg" class="m-2 img-fluid" alt="">
							    </div>
							    <div class="box-info-agendamiento flex-grow-1">
							        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2">Agendamiento</h3>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Profesional:</span>Alban Galvez Juliana Romina</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Central médica:</span>Veris - Kennedy</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Hora:</span>12:00-12:20</p>
							        <div class="box-action py-32 pb-0 d-flex justify-content-end align-items-center gap-2">
							        	<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
							        	<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3">Ver consultorio</button>
							        </div>
							    </div>
							</div>
						</div>
					</div>
					<div class="row box-dia pt-74">
						<div class="col-12 fs-18 line-height-24 fw-medium">
							<span class="text-royal-blue">Agendada para:</span> Sábado 19 de Julio, 2025
						</div>
					</div>
					<div class="row py-32 cards-items d-flex justify-content-between align-items-start">
						<div class="col-6 col-md-6 box-agenda">
							<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium bg-red-light text-red-dark">
								<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">Pago pendiente</span>
							</div>
							<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
							    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
							        <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/especialidad.svg" class="m-2 img-fluid" alt="">
							    </div>
							    <div class="box-info-agendamiento flex-grow-1">
							        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2">Agendamiento</h3>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Profesional:</span>Alban Galvez Juliana Romina</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Central médica:</span>Veris - Kennedy</p>
							        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Hora:</span>12:00-12:20</p>
							        <div class="box-action py-32 pb-0 d-flex justify-content-end align-items-center gap-2">
							        	<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
							        	<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3">Pagar</button>
							        </div>
							    </div>
							</div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "cita");
	document.addEventListener("DOMContentLoaded", async function () {
		await cargarMisChequeos();

		$('body').on('click','.item-servicio', async function(){
			$('.item-servicio').removeClass('bg-royal-blue text-white item-selected').addClass('border-royal-blue-tint-60 text-royal-blue');
			$(this).addClass('bg-royal-blue text-white item-selected').removeClass('border-royal-blue-tint-60 text-royal-blue')
			await drawCardsServicio();
		});

		$('body').on('click', '.btn-activar-chequeo', async function(){
			let chequeo = JSON.parse($(this).attr('data-rel'));
			detalleChequeoSeleccionado = chequeo;
			if(!chequeo.esAutorizadoEnvResultDg){
				$('.box-aceptacion').removeClass('d-none');
				$('.btn-activar').attr('disabled', true);
			}
			$('.nombreTipoContratoLabel').html('');
			
			$('#nombreAceptacion').html(datosCliente.nombreCompleto);
			$('#cedulaAceptacion').html(datosCliente.numeroIdentificacion);
			$('#empresaAceptacion').html(detalleChequeoSeleccionado.nombreConvenio);
			$('#'+chequeo.nombreTipoContrato.toLowerCase()+'ChequeoAceptacion').html("X");
			
			await mostrarDetalleModalChequeo(chequeo);
			$('#modalActivarChequeo').modal('show')
		})

		$('body').on('change', '#autorizacion', function(){
            if($('#autorizacion').is(':checked')) {
                $('.btn-activar').attr('disabled', false);
            } else {
                $('.btn-activar').attr('disabled', true);
            }
        })

		$('body').on('click', '.btn-activar', async function(){
			if(!detalleChequeoSeleccionado.esAutorizadoEnvResultDg){
				let aceptacion = await aceptarEntregaResultadosChequeo();
				if(aceptacion.code != 200){
					return;
				}else{
					detalleChequeoSeleccionado.esAutorizadoEnvResultDg = true;
				}
			}

			let secuenciaPrestacionesXAfiliado = [];
			$.each(detalleChequeoSeleccionado.detalles, function(key, value){
			    secuenciaPrestacionesXAfiliado.push(value.secuenciaPreXAfi)
			})

			let datosPago = {
				"chequeos": {
				    "idPaciente": datosCliente.idPaciente,
				    "codigoConvenio": detalleChequeoSeleccionado.codigoConvenio,
				    "secuenciaPrestacionesXAfiliado": secuenciaPrestacionesXAfiliado
				}
			}
			let agreagarItem = await agregarItem(datosPago, true, true);
			if(agreagarItem.code != 200){
				return;
			}
			await activarChequeo();
		})

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

		$("#modalAceptacionResultados").on('shown.bs.modal', function () {
            console.log("El modal ha sido abierto.");
            // clearInterval(temporizadorInactividad)
        });

        // Detectar cuando el modal se cierra
        $("#modalAceptacionResultados").on('hidden.bs.modal', function () {
            console.log("El modal ha sido cerrado.");
            // reiniciarConteo();
        });
	})

	let detalleChequeoSeleccionado;
	async function aceptarEntregaResultadosChequeo(){
	    //localStorage.getItem("idPreTransaccion")
	    let args = [];
	    args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/autorizar_envio_resultado_chequeo?macAddress=${mac}&idPaciente=${datosCliente.idPaciente}&secuenciaAfiliado=${detalleChequeoSeleccionado.secuenciaAfiliado}`;
	    args["method"] = "POST";
	    args["showLoader"] = true;
	    args["token"] = accessToken;
	    args["bodyType"] = "json";
	    args["data"] = JSON.stringify({
	        "secuenciaAfiliado": detalleChequeoSeleccionado.secuenciaAfiliado
	    });
	    const data = await call(args);
	    console.log(data);
	    if(data.code != 200){
	    	$('#modalError').modal('show')
			$('.titleError').html(`Ha ocurrido un error`)
			$('.msgError').html(data.message);
	    }
	    return data;
	}

	async function activarChequeo(){
		let agrupacion = await obtenerAgrupaciones();
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/facturar?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
        	"idAgrupacion": agrupacion
        });
        args["dismissAlert"] = true;
        const data = await call(args);
        console.log(data);
        $('#modalActivarChequeo').modal('hide')
        if(data.code == 200){
        	await cargarMisChequeos();
        }else{
			$('#modalError').modal('show')
			$('.titleError').html(`Ha ocurrido un error`)
			$('.msgError').html(data.message);
        }
	}

	async function mostrarDetalleModalChequeo(chequeo){
		let elem = ``;
		$.each(chequeo.detalles, function(key, value){
			elem += `<li class="p-3 border-bottom-midnight-blue-tint-80">${value.nombrePrestacion}</li>`
		})
		$('.listado-items-chequeo').html(elem);
	}

	let chequeos;
	async function cargarMisChequeos(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/mis_chequeos?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.length == 0){
        	//Empty space
        	$('#content-area').html(`<div class="text-center mt-5 pt-5">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
					<p class="text-center py-40 mb-0 fs-28 line-height-32">No tienes chequeos ocupacioanles <br> agendadas</p>
					<a href="/cita-elegir-paciente/{{ $mac }}" class="d-none btn bg-royal-blue text-white fs-24 line-height-32 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
				</div>`);
        }else{
        	chequeos = data.data
        	await drawMenuHorizontal();
       		await drawCardsServicio();
        }
	}

	async function drawCardsServicio(){
		let servicio = $('.item-selected').attr('servicio-rel')
		let data = chequeos.filter(s => s.nombreTipoContrato === servicio);
		let elem = ``;
		$.each(data, function(key, value){
			elem += drawCardItem(value)
		})
		$('#content-area').html(elem);
	}

	function drawStatusBox(detalle){
		return `<div class="box-estado rounded-top-8 d-flex justify-content-end align-items-center px-3 py-12 fw-medium gradient-green text-green-dark">
						<i class="fa-solid fa-circle fs-16 me-2"></i><span class="fs-12 line-height-16">Cita pagada</span>
					</div>`;

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
		let accionBoton = detalle.accionBoton;
		let elem = ``;
		if(accionBoton == "ACTIVAR_CHEQUEO"){
			elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-activar-chequeo" data-rel='${JSON.stringify(detalle)}'>Activar</button>`;
		}else{
			elem += ``;
		}
		return elem;
		if(estaPagado){
			if(condicionTiempo == "TIEMPO_AGOTADO"){
				elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-reagendar">Reagendar</button>`;
			}else{
				elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
					<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-consultorio" consultorio-rel='${(detalle.nombreSitio.split(' '))[1]}'>Ver consultorio</button>`;
			}
		}else{
			elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3">Reagendar</button>
				<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Agregar al carrito</button>`//Pagar
		}
		return elem;
	}

	function detallesReserva(detalle){
		return `<p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Empresa:</span> ${detalle.nombreConvenio}</p>`;
		/*`<h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</h3>
        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${detalle.nombreMedico.toLowerCase()}</p>
        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> ${detalle.nombreSucursal.toLowerCase()}</p>
        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Empresa:</span> ${detalle.horaInicioFin}</p>`;*/
	}

	function drawCardItem(detalle){
		return `<div class="col-6 col-md-6 box-agenda mb-4">
					${drawStatusBox(detalle)}
					<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
					    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8 px-2">
					        <img src="${detalle.imagenServicioNivel1}" class="m-2 img-fluid" width="56px" alt="">
					    </div>
					    <div class="box-info-agendamiento flex-grow-1">
							${detallesReserva(detalle)}
					        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
								${drawStatusButtons(detalle)}
					        </div>
					    </div>
					</div>
				</div>`
	}

	async function drawMenuHorizontal(data){
		let menu = ``;
		let tipos = [];
		$.each(chequeos, function(key, value){
			if (!tipos.includes(value.nombreTipoContrato)){
				let classBtn = 'border-royal-blue-tint-60 text-royal-blue'
				if(key == 0){
					classBtn = 'bg-royal-blue text-white item-selected';
				}
				menu += `<div type="button" class="item-servicio text-nowrap ${classBtn} p-3 rounded-8 fs-14 line-height-16 text-capitalize" servicio-rel='${value.nombreTipoContrato}'>
					${value.nombreTipoContrato.toLowerCase()}
				</div>`;
				tipos.push(value.nombreTipoContrato)
			}
		})
		$('#menu-horizontal').html(menu)
	}
</script>
@endsection