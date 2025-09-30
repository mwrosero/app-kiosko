@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Gestionar chequeos ocupacionales'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'chequeos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="menu-inside d-flex justify-content-start align-items-center gap-2 mt-40" id="menu-horizontal">
				</div>
				<div class="container box-fecha px-0">
					<div class="row py-32 cards-items d-flex justify-content-between align-items-start" id="content-area">
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
	localStorage.setItem("origen", "Listatratamientos");
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await cargarMisChequeos();

		$('body').on('click','.item-servicio', async function(){
			$('.item-servicio').removeClass('bg-royal-blue text-white item-selected').addClass('border-royal-blue-tint-60 text-royal-blue');
			$(this).addClass('bg-royal-blue text-white item-selected').removeClass('border-royal-blue-tint-60 text-royal-blue')
			await drawCardsServicio();
		});

		$('body').on('click', '.btn-activar-chequeo', async function(){
			let chequeo = JSON.parse($(this).parent().attr('data-rel'));
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
			
			await mostrarDetalleModalChequeoActivar(chequeo);
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
				console.log(0)
				let aceptacion = await aceptarEntregaResultadosChequeo();
				if(aceptacion.code != 200){
					console.log(1)
					return;
				}else{
					console.log(2)
					detalleChequeoSeleccionado.esAutorizadoEnvResultDg = true;
				}
			}

			let secuenciaPrestacionesXAfiliado = [];
			$.each(detalleChequeoSeleccionado.detalles, function(key, value){
				if(value.cantidadDisponible > 0){
			    	secuenciaPrestacionesXAfiliado.push(value.secuenciaPreXAfi)
			    }
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

		$('body').on('click', '.btn-notificar-llegada', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			let notificar = await notificarLlegada(detalle.detalles[0].codigoOrdApoyo);
			if(notificar.code != 200){
				return;
			}
			await mostrarDetalleModalChequeoDetalle(detalle);
			$('.title-detalle-chequeo').html(detalle.nombreServicioNivel1.toLowerCase())
			$('#modalDetalleChequeo').modal('show');
			await cargarMisChequeos(false)
		})

		$('body').on('click', '.btn-reagendar', async function(){
			let detalle = JSON.parse($(this).attr('data-rel'));
			let item = JSON.parse($(this).attr('item-rel'));
			let origen = "Listatratamientos";
			console.log(detalle)
			console.log(item)

			let dataCita = {}
			let modalidad = (item.esTeleconsulta) ? 'S' : 'N';
	        dataCita.online = modalidad;
	       	
	       	dataCita.especialidad = {
	            codigoEspecialidad: item.codigoEspecialidadServicio,
	            nombre : item.nombreEspecialidad,
	            imagen : item.urlImagenTipoServicio,
	            esOnline : modalidad,
	            codigoServicio : item.codigoServicio,
	            codigoPrestacion : item.codigoPrestacion,
	            codigoTipoAtencion : "C",
	            // codigoSucursal : item.codigoSucursal,
	            origen: "Listatratamientos"
	        };

	        let dataCitaReserva = {
                "paciente": {
                    "tipoIdentificacion": datosCliente.codigoTipoIdentificacion,
                    "numeroIdentificacion": datosCliente.numeroIdentificacion,
                    "numeroPaciente": datosCliente.idPaciente,
                    "primerNombre": datosCliente.primerNombre,
                    "segundoNombre": datosCliente.segundoNombre,
                    "primerApellido": datosCliente.primerApellido,
                    "segundoApellido": datosCliente.segundoApellido,
                    "pacPacNumero": datosCliente.idPaciente,
                    // "idPersona": "MTQwMDc4MDA3Ni0y",
                },
                "convenio": {
                	"codigoCliente": null,
                    "codigoConvenio": detalle.codigoConvenio,
                    "nombreConvenio": detalle.nombreConvenio,
                    "codigoTipoConvenio": detalle.codigoTipoConvenio,
                    "nombreTipoConvenio": detalle.nombreTipoConvenio,
                    "permitePago": "S",
                    "permiteReserva": "S"//(detalle.esAgendable || detalle.requiereAgendamientoPrevio) ? "S" : "N"
                },
                "tratamiento": {
                    "numeroOrden": item.numeroOrden,
                    "codigoEmpOrden": 1,//detalle.codigoEmpresa,
                    "lineaDetalle": item.lineaDetalleOrden,
                    "codigoEmpOrden": 1,
                    "esPagada": "S"
                },
                "online": (detalle.esTeleconsulta) ? "S" : "N",
                "especialidad": {
                    "codigoEspecialidad": item.codigoEspecialidadServicio,
                    "nombre" : (item.hasOwnProperty('nombreEspecialidadServicio') &&  item.nombreEspecialidadServicio !== null) ? item.nombreEspecialidadServicio : item.nombrePrestacion,
	            	"imagen" : item.urlImagenTipoServicio,
                    "esOnline": modalidad,
                    "codigoServicio": item.codigoServicio,
                    "codigoPrestacion": item.codigoPrestacion,
                    "codigoTipoAtencion": "C",
                    // "codigoSucursal": detalle.codigoSucursal,
                    "origen": "Listatratamientos"
                },
                "reservaEdit": {
                	"estaPagada": "S",
	                "numeroOrden": item.numeroOrden,
	                "lineaDetalleOrden": item.lineaDetalleOrden,
	                "codigoEmpresaOrden": 1,//item.codigoEmpresaOrden
	                "idOrdenAgendable": item.numeroOrden,
	                "idCita": item.codigoReserva
                },
                "ciudad": {
	                "codigoPais": 1,
	                "codigoProvincia": 1,
	                "codigoCiudad": 1
	            },
                "origen": origen,
            }

            console.log(dataCitaReserva)
            {{-- return; --}}

            localStorage.setItem('agendamiento', JSON.stringify(dataCitaReserva));
			if(detalle.esTeleconsulta){
                location.href = '/citas-elegir-fecha-doctor/{{ $mac }}';
            }else{
                location.href = '/cita-elegir-datos/{{ $mac }}';
            }
		})

		$('body').on('click', '.btn-agendar', async function(){
			let detalle = JSON.parse($(this).attr('data-rel'));
			let item = JSON.parse($(this).attr('item-rel'));
			let origen = "Listatratamientos";

			console.log(detalle)
			console.log(item)
			

			let dataCita = {}
			let modalidad = (item.esTeleconsulta) ? 'S' : 'N';
	        dataCita.online = modalidad;
	       	
	       	dataCita.especialidad = {
	            codigoEspecialidad: item.codigoEspecialidadServicio,
	            nombre : item.nombreEspecialidad,
	            imagen : item.urlImagenTipoServicio,
	            esOnline : modalidad,
	            codigoServicio : item.codigoServicio,
	            codigoPrestacion : item.codigoPrestacion,
	            codigoTipoAtencion : "C",
	            // codigoSucursal : item.codigoSucursal,
	            origen: "Listatratamientos"
	        };

	        let dataCitaReserva = {
                "paciente": {
                    "tipoIdentificacion": datosCliente.codigoTipoIdentificacion,
                    "numeroIdentificacion": datosCliente.numeroIdentificacion,
                    "numeroPaciente": datosCliente.idPaciente,
                    "primerNombre": datosCliente.primerNombre,
                    "segundoNombre": datosCliente.segundoNombre,
                    "primerApellido": datosCliente.primerApellido,
                    "segundoApellido": datosCliente.segundoApellido,
                    "pacPacNumero": datosCliente.idPaciente,
                    // "idPersona": "MTQwMDc4MDA3Ni0y",
                },
                "convenio": {
                	"codigoCliente": null,
                    "codigoConvenio": detalle.codigoConvenio,
                    "nombreConvenio": detalle.nombreConvenio,
                    "codigoTipoConvenio": detalle.codigoTipoConvenio,
                    "nombreTipoConvenio": detalle.nombreTipoConvenio,
                    "permitePago": "S",
                    "permiteReserva": "S"//(detalle.esAgendable || detalle.requiereAgendamientoPrevio) ? "S" : "N"
                },
                "tratamiento": {
                    "numeroOrden": item.numeroOrden,
                    "codigoEmpOrden": 1,//detalle.codigoEmpresa,
                    "lineaDetalle": item.lineaDetalleOrden,
                    "codigoEmpOrden": 1,
                    "esPagada": "S"
                },
                "online": (detalle.esTeleconsulta) ? "S" : "N",
                "especialidad": {
                    "codigoEspecialidad": item.codigoEspecialidadServicio,
                    "nombre" : (item.hasOwnProperty('nombreEspecialidadServicio') &&  item.nombreEspecialidadServicio !== null) ? item.nombreEspecialidadServicio : item.nombrePrestacion,
	            	"imagen" : item.urlImagenTipoServicio,
                    "esOnline": modalidad,
                    "codigoServicio": item.codigoServicio,
                    "codigoPrestacion": item.codigoPrestacion,
                    "codigoTipoAtencion": "C",
                    // "codigoSucursal": detalle.codigoSucursal,
                    "origen": "Listatratamientos"
                },
                "origen": origen,
            }

            console.log(dataCitaReserva)
            {{-- return; --}}

            localStorage.setItem('agendamiento', JSON.stringify(dataCitaReserva));
			if(detalle.esTeleconsulta){
                location.href = '/citas-elegir-fecha-doctor/{{ $mac }}';
            }else{
                location.href = '/cita-elegir-datos/{{ $mac }}';
            }

			{{-- let datosServicio = $(this).data('rel');
	        let url = $(this).attr('url-rel');
	        let esTerapiaAgrupada = $(this).attr('esTerapiAgrupada-rel');
	        // console.log(datosServicio.detallesServicios)
	        // return
	        if(esTerapiaAgrupada !== undefined && esTerapiaAgrupada !== null && esTerapiaAgrupada == "true"){
	            esTerapiaAgrupada = true;
	        }else{
	            esTerapiaAgrupada = false;
	        }

	        if(datosServicio.permiteReserva == "N" && !esTerapiaAgrupada){
	            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        }

	        console.log('datosServicio', datosServicio);
	        let modalidad;
	        if (datosServicio.modalidad === 'ONLINE') {
	            modalidad = 'S';
	        } else if (datosServicio.modalidad === 'PRESENCIAL') {
	            modalidad = 'N';
	        }

	        dataCita.online = modalidad;
	        let tipoServicio = datosServicio.tipoServicio.toLowerCase();
	        dataCita.tipoFlujo = "agenda/tratamiento/"+tipoServicio;
	        tipoFlujo = dataCita.tipoFlujo;

	        dataCita.especialidad = {
	            codigoEspecialidad: datosServicio.codigoEspecialidad,
	            nombre : datosServicio.nombreEspecialidad,
	            imagen : datosServicio.urlImagenTipoServicio,
	            esOnline : modalidad,
	            codigoServicio : datosServicio.codigoServicio,
	            codigoPrestacion : datosServicio.codigoPrestacion,
	            codigoTipoAtencion : datosServicio.codigoTipoAtencion,
	            codigoSucursal : datosServicio.codigoSucursal,
	            origen: "Listatratamientos"
	        };
	        dataCita.origen = "Listatratamientos";
	        dataCita.convenio = ultimoTratamiento.datosConvenio;
	        dataCita.convenio.origen = "Listatratamientos";

	        dataCita.tratamiento = {
	            cantidadIntervalosReserva: datosServicio.cantidadIntervalosReserva,
	            numeroOrden: datosServicio.idOrden,
	            codigoEmpOrden: datosServicio.codigoEmpresa,
	            lineaDetalle: datosServicio.lineaDetalleOrden,
	            esPagada: datosServicio.esPagada
	        }

	        if(esTerapiaAgrupada){
	            dataCita.tipoFlujo = "agenda/tratamiento/terapia_agrupada";
	            dataCita.detallesServicios = datosServicio.detallesServicios;
	            dataCita.secuenciaAtencion = secuenciaAtencion.secuenciaAtenciones;
	            dataCita.datosTratamiento = datosTratamiento;
	            dataCita.cantidadMaximaAgenda = parseInt($(this).attr('qty-rel'));
	            localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
	            location = "/agendamiento-multiple/{{ $tokenMods }}";
	            return;
	        }

	        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
	            let controlEmbarazo = await validacionConvenio(dataCita);
	            if(controlEmbarazo){
	                $('#datosGen').val(data);
	                $('.btn-respuesta-embarazo').attr("url-rel",$url);
	                $('#modalEmbarazo').modal("show");
	            }else{
	                localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
	                location = url;
	            }
	        }else{
	            localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
	            location = url;
	        } --}}
		})

		$('body').on('click', '.btn-detalle-chequeo', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			await mostrarDetalleModalChequeoDetalle(detalle);
			$('.title-detalle-chequeo').html(detalle.nombreServicioNivel1.toLowerCase())
			$('#modalDetalleChequeo').modal('show')
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

	async function mostrarDetalleModalChequeoDetalle(detalle){
		let elem = ``;
		$.each(detalle.detalles, function(key, value){
			let labelStatus = (value.muestraEntregada) ? `Realizado` : `Por realizar`;
			if(detalle.nombreServicioNivel1 == "LABORATORIO"){
				// muestraEntregada
				elem += `<li class="d-flex justify-content-between align-items-start mb-2">
					${value.nombrePrestacion}
					<span class="badge rounded-pill p-1 fs-10 line-height-14 border-royal-blue text-royal-blue ms-2">${labelStatus}</span>
				</li>`;
			}else{
				let buttonElem = ``;
				if(value.requiereAgendamientoPrevio || value.esAgendable){
					if(value.codigoReserva !== null){ //value.muestraEntregada
						buttonElem += `<button item-rel='${JSON.stringify(value)}' data-rel='${JSON.stringify(detalle)}' class="btn fs-10 line-height-14 border-royal-blue text-royal-blue rounded-8 p-12 px-3 ms-3 btn-reagendar">Reagendar</button>`;
					}else{
						buttonElem += `<button item-rel='${JSON.stringify(value)}' data-rel='${JSON.stringify(detalle)}' class="btn fs-10 line-height-14 border-royal-blue text-royal-blue rounded-8 p-12 px-3 ms-3 btn-agendar">Agendar</button>`;
					}
				}else{
					buttonElem += `<span class="badge rounded-pill p-1 fs-10 line-height-14 border-royal-blue text-royal-blue ms-3">${labelStatus}</span>`;
				}
				elem += `<li class="d-flex justify-content-between align-items-start mb-2">
					${value.nombrePrestacion}
					${buttonElem}
				</li>`;
			}
		})
		$('.listado-items-chequeo-detalle').html(elem);
	}

	let detalleChequeoSeleccionado;
	async function aceptarEntregaResultadosChequeo(){
	    //localStorage.getItem("idPreTransaccion")
	    let args = [];
	    args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/autorizar_envio_resultado_chequeo?macAddress=${mac}&idPaciente=${datosCliente.idPaciente}&secuenciaAfiliado=${detalleChequeoSeleccionado.secuenciaAfiliado}`;
	    args["method"] = "POST";
	    args["showLoader"] = true;
	    args["token"] = accessToken;
	    args["bodyType"] = "json";
	    args["dismissAlert"] = true;
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
        // $('#modalActivarChequeo').modal('hide')
        if(data.code == 200){
        	await cargarMisChequeos();
        }else{
			$('#modalError').modal('show')
			$('.titleError').html(`Ha ocurrido un error`)
			$('.msgError').html(data.message);
        }
	}

	async function mostrarDetalleModalChequeoActivar(chequeo){
		let elem = ``;
		$.each(chequeo.detalles, function(key, value){
			elem += `<li class="p-3 border-bottom-midnight-blue-tint-80">${value.nombrePrestacion}</li>`
		})
		$('.listado-items-chequeo').html(elem);
	}

	let chequeos;
	async function cargarMisChequeos(showLoader = true){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/mis_chequeos?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.length == 0){
        	//Empty space
        	$('#content-area').html(`<div class="text-center mt-5 pt-5">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
					<p class="text-center py-40 mb-0 fs-28 line-height-32">No tienes chequeos ocupacionales <br> agendados</p>
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
		let qtyItems = detalle.detalles.length;
		let elem = ``;
		if(accionBoton == "ACTIVAR_CHEQUEO"){ // || detalle.nombreServicioNivel1 == "LABORATORIO"
			elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-activar-chequeo">Activar</button>`;
		}else if(accionBoton == "ACTIVAR_LABORATORIO"){
			elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-notificar-llegada">Notificar llegada</button>`;
		}else{
			if(qtyItems == 1){
				let item = detalle.detalles[0];
				if(item.requiereAgendamientoPrevio || item.esAgendable){
					// Prestacion agendable
					if(item.codigoReserva !== null){
						elem += `<button item-rel='${JSON.stringify(item)}' data-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 border-royal-blue text-royal-blue rounded-8 p-12 px-3 btn-reagendar">Reagendar</button>
							<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-consultorio" consultorio-rel='${(detalle.detalles[0].nombreSitio.split(' '))[1]}'>Ver consultorio</button>`;
					}else{
						elem += `<button item-rel='${JSON.stringify(item)}' data-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar">Agendar</button>`;
					}
				}else{
					elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-detalle-chequeo">Ver detalle</button>`;
				}
			}else{
				elem += `<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-detalle-chequeo">Ver detalle</button>`;
			}
		}
		return elem;
	}

	function detallesReserva(detalle){
		let title = (detalle.detalles.length == 1) ? detalle.detalles[0].nombreServicio : detalle.nombreServicioNivel1;
		let elem = `<h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${title.toLowerCase()}</h3>`;
		elem += `<p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Empresa:</span> ${detalle.nombreConvenio.toLowerCase()}</p>`;
		return elem;
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