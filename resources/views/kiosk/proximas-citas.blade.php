@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Próximas citas'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'proximas-citas'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="menu-inside d-flex justify-content-start align-items-center gap-2 mt-40" id="menu-horizontal">
				</div>
				{{-- <div class="menu-inside d-flex justify-content-start align-items-center gap-2 overflow-auto">
					<div type="button" tipoServicio-rel="L" class="item-servicio text-nowrap bg-royal-blue text-white p-3 rounded-8 fs-14 line-height-16">
						Consultas
					</div>
				</div> --}}
				<div class="container box-fecha px-0" id="content-area">
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
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await cargarProximasCitas();

		$('body').on('click','.item-servicio', async function(){
			$('.item-servicio').removeClass('bg-royal-blue text-white item-selected').addClass('border-royal-blue-tint-60 text-royal-blue');
			$(this).addClass('bg-royal-blue text-white item-selected').removeClass('border-royal-blue-tint-60 text-royal-blue')
			await drawCardsServicio();
		});

		$('body').on('click', '.btn-consultorio', function(){
			let nombreConsultorio = $(this).attr('consultorio-rel');
			{{-- $('.nombreConsultorio').html(`#${nombreConsultorio}`); --}}
			$('.nombreConsultorio').html(`${nombreConsultorio}`);
			$('#modalConsultorio').modal('show')
		})

		$('body').on('click', '.btn-ver-detalle-lab', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			await mostrarDetalleLaboratorioModal(detalle);
			$('#modalDetalleOrdenTratamiento').modal('show');
		})

		$('body').on('click', '.btn-notificar-llegada', async function(){
			let detalle = JSON.parse($(this).attr('item-rel'));
			let notificar = await notificarLlegada(detalle.codigosOrdenesApoyo[0]);
			if(notificar.code != 200){
				await cargarProximasCitas();
				return;
			}else{
				$('#modalDetalleOrdenTratamiento').modal('hide');
				$('#modalError').modal('show')
				$('.titleError').html(`Orden activada`)
				$('.msgError').html("Por favor espere ser llamado");
			}
		})

		$('body').on('click', '.btn-pagar', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			let datosPago;

			if(detalle.nombreEspecialidad == "OPTICA"){
				let lineaDetalleOrdenArr = [];

        		$.each(detalle.detalles, function(key, value){
					lineaDetalleOrdenArr.push(value.lineaDetalleOrden)
				})
				let codigoConvenio = null;
				if(detalle.beneficio !== null){
					if(detalle.beneficio.convenio !== null){
						codigoConvenio = detalle.beneficio.convenio.codigoConvenio;
					}
				}
				datosPago = {
					"tratamientos": {
					    "idPaciente": datosCliente.idPaciente,
					    "numeroOrden": detalle.detalles[0].numeroOrden,
					    "codigoConvenio": codigoConvenio,
					    "detalles": lineaDetalleOrdenArr
					}
				}
			}else{
				datosPago = {
					"reserva": {
						"codigoReserva": detalle.codigoReserva
					}
				}
			}
			await agregarItem(datosPago, true);
		})

		$('body').on('click', '.btn-agendar', async function(){
			let dataCita = JSON.parse($(this).parent().attr('data-rel'));
			delete dataCita.reservaEdit;
			dataCita.paciente.idPaciente = dataCita.paciente.numeroPaciente;
			dataCita.paciente.pacPacNumero = dataCita.paciente.numeroPaciente;
			if(dataCita.beneficio !== null){
				dataCita.convenio = dataCita.beneficio.convenio;
			}else{
				dataCita.convenio = {
                    "nombreConvenio": "Ninguno",
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                }
			}
			dataCita.online = (dataCita.esTeleconsulta) ? "S" : "N";
			// console.log(dataCita);return;
			localStorage.setItem('agendamiento', JSON.stringify(dataCita));
			if(dataCita.esTeleconsulta){
				location.href = '/citas-elegir-fecha-doctor/{{ $mac }}'
			}else{
				location.href = '/cita-elegir-datos/{{ $mac }}'
			}
		})

		$('body').on('click', '.btn-CambiarFechaCita', async function(){
			let dataCita = JSON.parse($(this).parent().attr('data-rel'));
			dataCita.paciente.idPaciente = dataCita.paciente.numeroPaciente;
			dataCita.paciente.pacPacNumero = dataCita.paciente.numeroPaciente;
			if(dataCita.beneficio !== null){
				if(dataCita.beneficio.convenio !== null){
					dataCita.convenio = dataCita.beneficio.convenio;
				}else{
					dataCita.convenio = {
	                    "nombreConvenio": dataCita.beneficio.paquete.nombrePaquete,
	                    "permitePago": "S",
	                    "permiteReserva": "S",
	                    "idCliente": null,
	                    "codigoConvenio": null,
	                }					
				}
			}else{
				dataCita.convenio = {
                    "nombreConvenio": "Ninguno",
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                }
			}

			{{-- console.log(dataCita);
			return; --}}
			dataCita.online = (dataCita.esTeleconsulta) ? "S" : "N";
			localStorage.setItem('agendamiento', JSON.stringify(dataCita));
			if(dataCita.esTeleconsulta){
				location.href = '/citas-elegir-fecha-doctor/{{ $mac }}'
			}else{
				location.href = '/cita-elegir-datos/{{ $mac }}'
			}
		})

		$('body').on('click', '.BK_btn-CambiarFechaCita', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			console.log(detalle)
			{{-- estaPagado
			beneficio.convenio --}}
			
			let params = {}
			let modalidad = (detalle.esTeleconsulta) ? 'S' : 'N';

            params.online = modalidad;
            params.especialidad = {
                codigoEspecialidad: data.idEspecialidad,
                codigoPrestacion  : data.codigoPrestacion,
                codigoServicio   : data.codigoServicio,
                codigoTipoAtencion: data.codigoTipoAtencion,
                esOnline : modalidad,
                nombre : data.nombreEspecialidad,
            }
            params.convenio = detalle.beneficio.convenio;

            params.paciente = {
                "numeroIdentificacion": data.numeroIdentificacion,
                "tipoIdentificacion": data.tipoIdentificacion,
                "nombrePaciente": data.nombrePaciente,
                "numeroPaciente": data.numeroPaciente
            }

            params.central = {
                "codigoSucursal": data.codigoSucursal,
                "nombreSucursal": data.sucursal
            }
            params.ciudad = {
                "codigoPais": data.idPais,
                "codigoProvincia": data.idProvincia,
                "codigoCiudad": data.idCiudad
            }

            params.reservaEdit = {
                "estaPagada": data.estaPagado,
                "numeroOrden": data.numeroOrden,
                "lineaDetalleOrden": data.lineaDetalleOrden,
                "codigoEmpresaOrden": data.codigoEmpresaOrden,
                "idOrdenAgendable": data.idOrdenAgendable,
                "idCita": data.codigoReserva,
                "esSesionOdonto": data.esSesionOdonto
            }
            if(data.esSesionOdonto == "S"){
                params.sesion = {
                    secuenciaPlanTto: data.secuenciaPlanTto,
                    numeroSesion: data.numeroSesion,
                    tiempoSesion: data.tiempoSesion,
                };
                params.detalleSesion = {
                    tipoAtencion: data.tipoAtencion,
                    tiempoSesion: data.tiempoSesion,
                    duracion: data.duracion
                }
            }
            params.origen = "inicios";
            params.tipoFlujo = tipoFlujo;
            localStorage.setItem('agendamiento', JSON.stringify(params));
            location = url;

		})

	})

	let servicios;
	async function cargarProximasCitas(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/proximas_citas?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&idPreTransaccion=${localStorage.getItem("idPreTransaccion")}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.length == 0){
        	//Empty space
        	$('#content-area').html(`<div class="text-center mt-5 pt-5">
						<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
						<p class="text-center py-40 mb-0 fs-28 line-height-32">Aún no tienes citas médicas <br> agendadas</p>
						<a href="/cita-elegir-paciente/{{ $mac }}" class="btn bg-royal-blue text-white fs-24 line-height-32 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
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
		let labelSubHeader = ``;
		$.each(data, function(key, value){
			if(value.nombreServicioN1 == "LABORATORIO"){
				elem += `<p class="mt-4 mb-0 fs-18 line-height-24 text-silver-neutral-80 fw-light">Antes de acudir al laboratorio debes activiar tu orden, esto ayudará a nuestro equipo de laboratorio a saber que llegaste</p>
					<div class="row box-dia pt-4">`
					labelSubHeader = `Enviado`
			}else{
				elem += `<div class="row box-dia pt-64">`
				labelSubHeader = `Agendada para`
			}
			$.each(value.fechaAtencionGrouped, function(k, v){
				let cards = ``;
				$.each(v, function(k1, v1){
					if(value.nombreServicioN1 == "LABORATORIO"){
						cards += drawCardLabItem(v1, value.nombreServicioN1);
					}else{
						cards += drawCardItem(v1, value.nombreServicioN1);
					}
				})
				elem += `
					<div class="col-12 fs-18 line-height-24 fw-medium">
						<span class="text-royal-blue">${labelSubHeader}:</span> ${k}
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

	function drawStatusButtons(detalle, nombreServicio = "CONSULTA"){
		let elem = ``;
		if(nombreServicio == "LABORATORIO"){
			return `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-ver-detalle-lab">Ver detalle</button>`;
		}else if(nombreServicio == "OPTICA" ){
			if(detalle.hasOwnProperty('agregadoCarrito') && detalle.agregadoCarrito){
				elem += `<button class="btn disabled fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Agregado al carrito</button>`
			}else{
				elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Pagar ahora</button>`
			}
		}else{
			let estaPagado = detalle.estaPagado;
			let condicionTiempo = detalle.condicionTiempo;
			if(estaPagado){
				if(detalle.codigoReserva === null){
					elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar">Agendar</button>`;
				}else{
					if(condicionTiempo == "TIEMPO_AGOTADO"){
						elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-CambiarFechaCita">Reagendar</button>`;
					}else{
						//(detalle.nombreSitio.split(' '))[1]
						elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3 btn-CambiarFechaCita">Reagendar</button>
							<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-consultorio" consultorio-rel='${detalle.nombreSitio.toLowerCase()}'>Ver consultorio</button>`;
					}
				}
			}else{
				if(detalle.codigoReserva !== null){
					elem += `<button class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3 btn-CambiarFechaCita">Reagendar</button>`;
				}
				if(!detalle.agregadoCarrito){
					if(detalle.codigoReserva !== null){
						elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Pagar ahora</button>`
					}else{
						elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar">Agendar</button>`;
					}
				}else{
					elem += `<button class="btn disabled fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-pagar">Agregado al carrito</button>`
				}
			}
		}
		return elem;
	}

	function drawCardItem(detalle, nombreServicio){
		return `<div class="col-6 col-md-6 box-agenda mb-4">
					${drawStatusBox(detalle)}
					<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
					    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
					        <img src="${detalle.iconoEspecialidad}" class="m-2" width="56px" alt="">
					    </div>
					    <div class="box-info-agendamiento flex-grow-1">
					        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${(detalle.nombreEspecialidad !== null) ? detalle.nombreEspecialidad.toLowerCase() : ``}</h3>
					        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${(detalle.nombreMedico !== null) ? detalle.nombreMedico.toLowerCase() : ``}</p>
					        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> ${(detalle.nombreSucursal !== null) ? detalle.nombreSucursal.toLowerCase() : ``}</p>
					        <p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Hora:</span> ${(detalle.horaInicioFin !== null) ? detalle.horaInicioFin : ``}</p>
					        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
								${drawStatusButtons(detalle,nombreServicio)}
					        </div>
					    </div>
					</div>
				</div>`
	}

	function drawCardLabItem(detalle, nombreServicio){
		let nombreCardLab = `Laboratorio`;
		if(detalle.beneficio !== null){
			if(detalle.beneficio.convenio !== null){
				nombreCardLab = `Laboratorio`
			}else if(detalle.beneficio.paquete !== null){
				nombreCardLab = detalle.beneficio.paquete.nombrePaquete;
			}
		}else if(detalle.descripcionBeneficio !== null){
			nombreCardLab = detalle.descripcionBeneficio;
		}
		let profesional = (detalle.nombreMedico !== null) ? detalle.nombreMedico : `Médico externo`
		return `<div class="col-6 col-md-6 box-agenda mb-4">
					${drawStatusBox(detalle)}
					<div class="box-contenido rounded-bottom-16 border-royal-blue-tint-60 border-top-0 border-inside p-12 d-flex justify-content-between align-items-stretch">
					    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
					        <img src="${detalle.iconoEspecialidad}" class="m-2" width="56px" alt="">
					    </div>
					    <div class="box-info-agendamiento flex-grow-1">
					        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize"></h3>
					        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize">${nombreCardLab.toLowerCase()}</p>
							<p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${profesional.toLowerCase()}</p>
							<p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Orden:</span> ${detalle.detalles[0].numeroOrden}</p>
					        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
								${drawStatusButtons(detalle,nombreServicio)}
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

	async function mostrarDetalleLaboratorioModal(detalle){
		$('.th-details-prestaciones').addClass('d-none');
		let elemContent = ``;
		let buttonActions = `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-notificar-llegada w-50" data-bs-dismiss="modal">Activar</button>`;
		$.each(detalle.detalles, function(key, value){
			if(value.estadoExamen == "PENDIENTE"){
				activar = true;
				codigoOrdenApoyo = value.codigoOrdenApoyo;
			}
			elemContent += `<li class="row text-dark-veris border-bottom-midnight-blue-tint-80 py-3">
		    	<p class="col-12 mb-0 fs-12 line-height-16 text-capitalize">${value.nombrePrestacion.toLowerCase()}</p>
	            {{-- <p class="col-2 mb-0 fs-12 text-center line-height-16"></p>
	            <p class="col-2 mb-0 fs-12 text-center line-height-16"></p>
	            <p class="col-2 mb-0 fs-12 text-center line-height-16"></p> --}}
			</li>`
		})
		$('.title-modal-detalle-orden').html(`Revisa el detalle de la orden: <span class='text-royal-blue'>${detalle.detalles[0].numeroOrden}</span>`)
		$('.box-actions-detalle-orden').html(buttonActions);
		$('.listado-items-orden-detalle').html(elemContent);
	}
</script>
@endsection