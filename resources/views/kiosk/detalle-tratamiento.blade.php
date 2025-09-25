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
	let dataCita = {};
	dataCita.paciente = {
        "numeroIdentificacion": datosCliente.numeroIdentificacion,
        "tipoIdentificacion": datosCliente.codigoTipoIdentificacion,
        "nombrePaciente": datosCliente.nombreCompleto,
        "numeroPaciente": datosCliente.idPaciente,
        "pacPacNumero": datosCliente.idPaciente,
    }
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "cita");
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await cargarInfoTratamiento();
		await cargarDetalleTratamiento();

		$('body').on('click', '.btn-detalle-orden', async function(){
			let item = JSON.parse($(this).attr('item-rel'));
			console.log(item);
			await mostrarDetalleOrdenModal(item);
			$('#modalDetalleOrdenTratamiento').modal('show');
		})

		{{-- $('body').on('click', '.btn-agendar', async function(){
		}) --}}

		$(document).on('click', '.btn-sesion', async function(){
	        let datosServicio = $(this).data('rel');
	        let convenio = JSON.parse($(this).attr('convenio-rel'));
	        let url = $(this).attr('url-rel');

	        if(datosServicio.permiteReserva == "N"){
	            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        }

	        dataCita.sesion = datosServicio;
	        dataCita.convenio = convenio;

	        if(datosServicio.detalleReserva !== null){
	            dataCita.reservaEdit = {
	                "estaPagada": datosServicio.esPagada,
	                "numeroOrden": datosServicio.idOrden,
	                "lineaDetalleOrden": datosServicio.lineaDetalleOrden,
	                "codigoEmpresaOrden": datosServicio.codigoEmpresa,
	                //"idOrdenAgendable": datosServicio.detalleReserva.idOrdenAgendable,
	                "idCita": datosServicio.detalleReserva.codigoReserva,
	            }
	        }

	        let modalidad;
	        if (datosServicio.modalidad === 'ONLINE') {
	            modalidad = 'S';
	        } else if (datosServicio.modalidad === 'PRESENCIAL') {
	            modalidad = 'N';
	        }

	        dataCita.online = modalidad;

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

	        dataCita.central = {
	            "codigoSucursal": datosServicio.codigoSucursal,
	            "nombreSucursal": datosServicio.sucursal
	        }
	        dataCita.ciudad = {
	            "codigoPais": datosServicio.idPais,
	            "codigoProvincia": datosServicio.idProvincia,
	            "codigoCiudad": datosServicio.idCiudad
	        }

	        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	        location = url;
	    });

	    $(document).on('click', '.btn-agendar', async function(){
	        let datosServicio = $(this).data('rel');
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
	            localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	            location = "/agendamiento-multiple/{{ $mac }}";
	            return;
	        }

	        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
	            let controlEmbarazo = await validacionConvenio(dataCita);
	            if(controlEmbarazo){
	                $('#datosGen').val(data);
	                $('.btn-respuesta-embarazo').attr("url-rel",$url);
	                $('#modalEmbarazo').modal("show");
	            }else{
	                localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	                location = url;
	            }
	        }else{
	            localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	            location = url;
	        }
	        
	    });

	    $('body').on('click', '.btn-respuesta-embarazo', async function(){
	        let estaEmbarazada = $(this).attr('respuesta-rel');
	        dataCita.estaEmbarazada = estaEmbarazada;
	        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	        let ruta = $(this).attr('url-rel');
	        location.href = ruta;
	    })

	    // boton btn-pagar
	    $(document).on('click', '.btn-pagar', async function(){
	    	$('#modalDetalleOrdenTratamiento').modal('hide')
	        let datosServicio = $(this).data('rel');
	        let convenio = JSON.parse($(this).attr('convenio-rel'));
	        console.log(datosServicio);

	        {{-- if(datosServicio.esPagada == "N" && datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL"){
	            $('#mensajeNoPermiteCambiar').html('Para agendar este procedimiento acerquese a caja con el turno que emitiremos');
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        } --}}
	        if(datosServicio.tipoCard == "LAB"){
	        	if(datosServicio.permitePago == "S" && datosServicio.esPagada == "N"){
	        		let lineaDetalleOrdenArr = [];

	        		$.each(datosServicio.detalleLaboratorio.listaOrdenesDetalle, function(key, value){
						lineaDetalleOrdenArr.push(value.lineaDetalle)
					})
	        		
	        		let datosPago = {
						"tratamientos": {
						    "idPaciente": detalleTratamiento.idPaciente,
						    "numeroOrden": datosServicio.idOrden,
						    "codigoConvenio": detalleTratamiento.datosConvenio.codigoConvenio,
						    "codigoTratamiento": detalleTratamiento.codigoTratamiento,
						    "detalles": lineaDetalleOrdenArr
						}
					}
					await agregarItem(datosPago);
	        		return;
	        	}else{
	        		return;
	        	}
	        }

	        if(datosServicio.permitePago == "N" && datosServicio.tipoCard != "LAB"){
	            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        }else if(datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL" && datosServicio.permitePago == "N"){
	            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        }
	        // console.log(datosServicio);return;
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
	        dataCita.convenio = convenio;
	        dataCita.convenio.origen = "Listatratamientos";
	        dataCita.datosTratamiento = datosServicio;
	        dataCita.datosTratamiento.origen = "Listatratamientos";
	        console.log(dataCita)

	        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	        location.href = $(this).attr("url-rel");
	    });

		$(document).on('click', '.btn-informacion', function(){
			console.log(9)
	        let datos = JSON.parse($(this).attr('data-rel'));
	        let datosTratamiento = JSON.parse($(this).attr('datosTratamiento-rel'));
	        if(datosTratamiento.mostrarTerapiasAgrupadas == "S" && datos.tipoCard == "AGENDA_TERAPIA" && datos.esCaducado == "N"){
	            let datosServicio = datos;
	            let esTerapiaAgrupada = true;
	            // console.log(datosServicio.detallesServicios)
	            // return
	            {{-- if(datosServicio.permiteReserva == "N"){
	                $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
	                $('#modalPermiteCambiar').modal('show');
	                return;
	            } --}}
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

	            dataCita.tipoFlujo = "agenda/tratamiento/terapia_agrupada";
	            dataCita.detallesServicios = datosServicio.detallesServicios;
	            dataCita.secuenciaAtencion = secuenciaAtencion.secuenciaAtenciones;
	            dataCita.datosTratamiento = datosTratamiento;
	            dataCita.cantidadMaximaAgenda = parseInt($(this).attr('qty-rel'));
	            localStorage.setItem('agendamiento', JSON.stringify(dataCita));
	            location = "/agendamiento-multiple/{{ $mac }}";;
	            return;
	        }else{
	        	console.log()
	            $("#informacionCitaModal").modal('show');
	        }
	        
	        //if (datos.esCaducado === "S" && datos.esAgendable === "S") {
	        if (false) {
	            // CAMBIAR TITUOLO MODAL
	            $('#tituloModalInformacionCita').text('Orden expirada');
	            $('#mensajeInformacionCita').text('El tiempo para agendar esta orden expiró, puedes agendar la cita sin cobertura.');
	            // limpiar footer
	            $('#footerInformacionCita').empty();
	            // agregar boton agendar y salir
	            let ruta = "/citas-elegir-fecha-doctor/{{ $mac }}";
	            if (datos.modalidad == "PRESENCIAL") {
	                ruta = "/cita-elegir-datos/{{ $mac }}";
	            }
	            let esTerapiaAgrupada = false;
	            let qtyMaximaAgrupado = 0;
	            if(datos.tipoCard == "AGENDA_TERAPIA"){
	                esTerapiaAgrupada = true;
	                qtyMaximaAgrupado = datos.cantidadMaximaAgenda;
	            }
	            $('#footerInformacionCita').append(`<div class="modal-footer pt-0 pb-3 px-3">
	                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3 btn-agendar" data-bs-dismiss="modal" qty-rel='${qtyMaximaAgrupado}' esTerapiAgrupada-rel='${esTerapiaAgrupada}' url-rel="${ruta}" data-rel='${JSON.stringify(datos)}' id="btnAgendarCitaModal__BK">{{ __('Agendar') }}</button>
	                </div>
	                <div class="modal-footer pt-0 pb-3 px-3">
	                    <button type="button" class="btn fs--18 line-height-24 m-0 w-100 text-primary-veris px-4 py-3" data-bs-dismiss="modal">{{ __('Salir') }}</button>
	                </div>`);
	        } else if(datos.esAgendable === "N") {
	                $('#tituloModalInformacionCita').text('Información');
	                $('#mensajeInformacionCita').text(datos.mensaje);
	                $('#footerInformacionCita').empty();
	                $('#footerInformacionCita').append(`<div class="modal-footer pt-0 pb-3 px-3">
	                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
	                    </div>`)
	        } else {
	            $('#mensajeInformacionCita').text(datos.mensaje);
	        }
	    });

		$(document).on('click', '.btn-CambiarFechaCita', function(){
	        console.log('click entro a cambiar fecha');
	        let data = $(this).data('rel');
	        let url = $(this).attr('url-rel');
	        let convenio = JSON.parse($(this).attr('convenio-rel'));
	        // console.log(convenio);return;

	        if(data.permiteReserva == "N" && data.esPagada != "S"){
	            $('#mensajeNoPermiteCambiar').html(data.mensajeBloqueoReserva);
	            $('#modalPermiteCambiar').modal('show');
	            return;
	        }

	        console.log('dataCa', data);
	        console.log('urlCa', url);
	        // const dataConvenio = await consultarConvenios(data);
	        // const dataPaciente = await consultarDatosPaciente(data);
	        let esVirtual = "N";
	        if(data.modalidad != "PRESENCIAL"){
	            esVirtual = "S";
	        }
	        
	        let params = {}
	        let tipoServicio = data.tipoServicio.toLowerCase();
	        tipoFlujo = "reagenda/tratamiento/"+tipoServicio;
	        params.tipoFlujo = tipoFlujo;;
	        params.online = esVirtual;
	        params.especialidad = {
	            codigoEspecialidad: data.codigoEspecialidad,
	            codigoPrestacion  : data.codigoPrestacion,
	            codigoServicio   : data.codigoServicio,
	            codigoTipoAtencion: data.codigoTipoAtencion,
	            esOnline : esVirtual,
	            nombre : data.nombreEspecialidad,
	        }
	        {{-- params.paciente = {
	            "numeroIdentificacion": data.numeroIdentificacion,
	            "tipoIdentificacion": data.tipoIdentificacion,
	            "nombrePaciente": data.nombrePaciente,
	            "numeroPaciente": data.pacPacNumero
	        } --}}
	        params.paciente = dataCita.paciente;
	        params.central = {
	            "codigoSucursal": data.detalleReserva.codigoSucursal,
	            "nombreSucursal": data.detalleReserva.nombreSucursal
	        }
	        params.ciudad = {
	            "codigoPais": data.idPais,
	            "codigoProvincia": data.idProvincia,
	            "codigoCiudad": data.idCiudad
	        }
	        params.reservaEdit = {
	            "estaPagada": data.esPagada,
	            "numeroOrden": (data.numeroOrden) ? data.numeroOrden : data.idOrden,
	            "lineaDetalleOrden": data.lineaDetalleOrden,
	            "codigoEmpresaOrden": (data.codigoEmpresaOrden) ? data.codigoEmpresaOrden : data.codigoEmpresa,
	            "idOrdenAgendable": data.idOrdenAgendable,
	            "idCita": data.detalleReserva.codigoReserva
	        }
	        params.origen = "inicios";
	        params.convenio = convenio;
	        
	        localStorage.setItem('agendamiento', JSON.stringify(params));
	        location = url;
	    });

	})

	async function obtenerValoresOrden(detalle){
		let lineaDetalleOrdenArr = [];
		if(detalle.detallesServicios == null && detalle.detalleLaboratorio == null){
			lineaDetalleOrdenArr.push(detalle.lineaDetalleOrden)
		}else if(detalle.detalleLaboratorio !== null){
			$.each(detalle.detalleLaboratorio.listaOrdenesDetalle, function(key, value){
				lineaDetalleOrdenArr.push(value.lineaDetalle)
			})
		}

		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/util/valorizar_prestaciones?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&codigoTratamiento=${tratamiento.codigoTratamiento}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
	    args["data"] = JSON.stringify({
	        "numeroOrden": detalle.idOrden,
			"lineaDetalleOrden": lineaDetalleOrdenArr,
			"codigoConvenio": detalleTratamiento.datosConvenio.codigoConvenio,
			"secuenciaAfiliado": detalleTratamiento.datosConvenio.secuenciaAfiliado,
			"codigoTratamiento": tratamiento.codigoTratamiento,
	    });
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        return data;
	}

	async function mostrarDetalleOrdenModal(detalle){
		let elemContent = ``;
		let detallePrestacionesValores = await obtenerValoresOrden(detalle);
		let valorTotal = 0;
		if(detallePrestacionesValores.code == 200){
			$.each(detallePrestacionesValores.data, function(key, value){
				let nombrePrestacion = value.nombrePrestacion.replace(/\u00A0/g, " ").replace(/\n/g, "<br>");
				elemContent += `<li class="row text-dark-veris border-bottom-midnight-blue-tint-80 py-3">
			    	<p class="col-6 mb-0 fs-12 line-height-16">${capitalizarPrimeraLetra(nombrePrestacion)}</p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16">$${value.valorServicio.toFixed(2)}</p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16">$${value.valorEmpresa.toFixed(2)}</p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16">$${value.valorPaciente.toFixed(2)}</p>
				</li>`
				valorTotal += value.valorTotal;
			})
		}else if(detalle.detalleLaboratorio !== null){
			// Default
			console.log("default")
			$.each(detalle.detalleLaboratorio.listaOrdenesDetalle, function(key, value){
				elemContent += `<li class="row text-dark-veris border-bottom-midnight-blue-tint-80 py-3">
			    	<p class="col-6 mb-0 fs-12 line-height-16 text-capitalize">${value.nombrePrestacion.toLowerCase()}</p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16"></p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16"></p>
		            <p class="col-2 mb-0 fs-12 text-center line-height-16"></p>
				</li>`
			})
		}
		let buttonActions = ``;
		let sucursal = (detalle.nombreSucursal !== null) ? `<p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-40 me-1 text-capitalize">Central médica:</span> ${detalle.nombreSucursal.toLowerCase()}</p>` : ``;

		let tituloDetalle = (detalle.tipoServicio == "LABORATORIO") ? `${detalle.tipoServicio}` : `${detalle.tipoServicio} - ${detalle.nombreEspecialidad}`;
		let elemHeader = `<h3 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium mb-2 text-capitalize">${tituloDetalle.toLowerCase()}</h3>
	        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-40 me-1">Profesional:</span> ${tratamiento.nombreMedico.toLowerCase()}</p>
			${sucursal}
	        ${ mostrarConvenio(tratamiento, 40) }`;

	    let elemTotales = `<p class="col-6 mb-0 fs-16 line-height-20 fw-medium text-dark-veris">Subtotal</p>
                    <p class="col-6 mb-0 fs-16 line-height-20 fw-medium text-end text-royal-blue">$${valorTotal.toFixed(2)}</p>`;

		buttonActions = determinarCondicionesBotones(detalle, 'PENDIENTE', detalleTratamiento)
		
		/*if(detalle.tipoServicio == "LABORATORIO"){
			buttonActions += `<button class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" data-bs-dismiss="modal">Cerrar</button>`;
		}else{
			if(detalle.esPagada == "S"){
				if(detalle.esAgendable == "S"){
					if(detalle.detalleReserva !== null){
						if(detalle.habilitaBotonAgendar == "S"){
							buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-reagendar w-50">Reagendar</button>`;
						}else{
							buttonActions += `<button class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" data-bs-dismiss="modal">Cerrar</button>`;
						}
					}else{
						buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar w-50">Agendar</button>`;
					}
				}
			}else{
				buttonActions += `<button item-rel='${JSON.stringify(detalle)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-agendar w-50">Agendar</button>`;
			}
		}*/

		$('.box-actions-detalle-orden').html(buttonActions)
		

		$('.header-orden').html(elemHeader);
		$('.listado-items-orden-detalle').html(elemContent);
		$('.totalesDetalleOrden').html(elemTotales);
		//$('.listado-items-orden-detalle')
	}

	function determinarCondicionesBotones(datosServicio, estado, datosTratamiento){
        if(datosServicio.tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
            console.log(datosServicio, estado, datosTratamiento)
            console.log(datosServicio)
        }
        let services = datosServicio;
        if (datosServicio.length == 0) {
            console.log(88)
            return `<div></div>`;
        } else{
            // console.log(datosServicio.tipoAgenda)
            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                case "AGENDA_TERAPIA" :
                    let respuestaAgenda = "";
                    let esTerapiaAgrupada = false;
                    let qtyMaximaAgrupado = 0;
                    if(datosServicio.tipoCard == "AGENDA_TERAPIA"){
                        esTerapiaAgrupada = true;
                        qtyMaximaAgrupado = datosServicio.cantidadMaximaAgenda;
                        // console.log(datosServicio.cantidadMaximaAgenda)
                    }
                    // Agregar ver orden 
                    //respuestaAgenda += ` <a class="btn btn-sm text-primary-veris shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard">Ver orden</a>`;
                    if(datosServicio.estado == 'PENDIENTE_AGENDAR'){
                        if(datosServicio.esExterna == "N"){
                            //respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                        }else{
                            console.log(44)
                            //respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                        }
                        if(datosServicio.esCaducado == 'S' || datosServicio.esAgendable == "N"){
                            // mostrar boton de informacion que llama al modal de informacion
                            respuestaAgenda += `<a href="#" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-informacion" qty-rel='${qtyMaximaAgrupado}' esTerapiAgrupada-rel='${esTerapiaAgrupada}' data-rel='${JSON.stringify(datosServicio)}' datosTratamiento-rel='${JSON.stringify(datosTratamiento)}'>Agendar</a>`;
                        } else {
                            if(datosServicio.permiteReserva == 'S'){
                                if (datosServicio.habilitaBotonAgendar == 'S' && datosServicio.esExterna == "N") {
                                    let ruta = "/citas-elegir-fecha-doctor/{{ $mac }}";
                                    if (datosServicio.modalidad == "PRESENCIAL") {
                                        ruta = "/cita-elegir-datos/{{ $mac }}";
                                    }
                                    respuestaAgenda += `<div qty-rel='${qtyMaximaAgrupado}' esTerapiAgrupada-rel='${esTerapiaAgrupada}' url-rel="${ruta}" data-rel='${JSON.stringify(datosServicio)}' class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-agendar">Agendar</div>`;
                                } else {
                                    if(datosServicio.esExterna == "N"){
                                        respuestaAgenda += `<a href="#" class="btn btn-sm fs--1 px-3 py-2 border-0  fw-normal fs--1 disabled" style="background-color: #F3F0F0 !important; color: darkgrey !important;">Agendar </a>`;
                                    }
                                }
                            } else {
                                // abrir modal no permite reserva
                                // respuestaAgenda += `<button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" data-bs-toggle="modal" data-bs-target="#mensajeNoPermiteReservaModal">Agendar</button>`;
                                respuestaAgenda += `<button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-agendar shadow-none" esTerapiAgrupada-rel='${esTerapiaAgrupada}' qty-rel='${qtyMaximaAgrupado}' data-rel='${JSON.stringify(datosServicio)}'>Agendar</button>`;
                            }
                        }
                    } else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        //respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Ver orden</a>`;
                        let ruta = "/citas-elegir-fecha-doctor/{{ $mac }}";
                        if (datosServicio.modalidad == "PRESENCIAL") {
                            ruta = "/cita-elegir-datos/{{ $mac }}";
                        }
                        if (datosServicio.permitePago == 'S' && datosServicio.esPagada == "N"){
                            // mostrar boton de pagar
                            if(datosServicio.detalleReserva === null){
                                //respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                            }else{
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }

                            respuestaAgenda += `<div url-rel="/citas-datos-facturacion/{{ $mac }}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-pagar" data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}'>Pagar</div>`;
                        }else if(datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            if(datosServicio.modalidad != "ONLINE" && datosServicio.esPagada == "S"){
                                //respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                            }
                            if((datosServicio.esPagada == "S" && datosServicio.modalidad == "ONLINE") || datosServicio.esPagada == "N"){
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }else{
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }
                            if(datosServicio.modalidad == "ONLINE" && datosServicio.esPagada == "S"){
                                respuestaAgenda += `<a href="${datosServicio.detalleReserva.idTeleconsulta}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50">Conectarme</a>`;
                            }
                            if(datosServicio.esPagada == "N"){
                                respuestaAgenda += `<div url-rel="/citas-datos-facturacion/{{ $mac }}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-pagar" data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}'>Pagar</div>`;
                            }
                        } else if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            // respuestaAgenda += `<a href="#" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" onclick="mostrarInformacion('${datosServicio.detalleReserva.mensajeInformacion}')">Agendar</a>`;
                            respuestaAgenda = `<div class="btn btn-sm btn-outline-primary-veris fs--1 fw-normal btn-cita-informacion line-height-16 shadow-none border-0 pe-0 me-0" onclick="mostrarInformacion('${datosServicio.detalleReserva.mensajeInformacion}')">
                                        <i class="fa-solid fa-circle-info text-warning line-height-20" style="font-size:22px"></i>
                                    </div>`
                        } 
                    }else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        console.log(datosServicio.tipoServicio)
                        if(datosServicio.tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
                            respuestaAgenda += `<button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-detalle-multiple-atendido" data-rel='${JSON.stringify(datosServicio)}' datosTratamiento-rel='${JSON.stringify(datosTratamiento)}'>Ver detalle</button>`; 
                        }else{
                            //respuestaAgenda += ` <button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`; 
                        }
                    } 
                    return respuestaAgenda;
                    break;
                case "LAB":
                    // console.log('estadossss', estado);
                    let respuesta = "";
                    if (estado == 'PENDIENTE'){
                        if(datosServicio.verResultados != "S" && datosServicio.aplicaSolicitud != "S" && datosServicio.permitePago != "S"){
                            // respuesta += ` <button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                            //respuesta += ` <button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                            let params = {}
                            params.idPaciente = detalleTratamiento.idPaciente;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            if(datosServicio.modalidad == "PRESENCIAL"){
                                respuesta += `<div url-rel="/citas-laboratorio/{{$mac}}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'><i class="fa-solid fa-circle-info me-2 line-height-20"></i>Agendar</div>`;
                            }else{
                                respuesta += `<div url-rel="/citas-laboratorio/{{$mac}}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'>Pagar</div>`;
                            }
                        }else{
                            //respuesta += ` <button type="button" class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }
                        
                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            let ruta = "/laboratorio-domicilio/" + "{{ $mac }}";
                            respuesta += `<a url-rel="${ruta}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-veris btnSolicitarLaboratorio" data-rel='${JSON.stringify(datosServicio)}'>Ver resultados</a>`;
                        
                        } else {
                            respuesta += ``;
                        }
                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            let ruta = "/laboratorio-domicilio/" + "{{ $mac }}";
                            respuesta += `<a url-rel="${ruta}" class="btn btn-sm btn-primary-veris shadow-none me-1 btnSolicitarLaboratorio" data-rel='${JSON.stringify(datosServicio)}'><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                            
                        
                        } else if (datosServicio.permitePago == "S"){
                            if(datosServicio.esPagada == "N"){
                                let params = {}
                                params.idPaciente = detalleTratamiento.idPaciente;
                                params.numeroOrden = datosServicio.idOrden;
                                params.codigoEmpresa = datosServicio.codigoEmpresa;
                                let ulrParams = btoa(JSON.stringify(params));
                                respuesta += `<div url-rel="/citas-laboratorio/{{$mac}}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'>Pagar</div>`;
                            }else{
                                respuesta += `<div url-rel="/citas-laboratorio/{{$mac}}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'><i class="fa-solid fa-circle-info me-2 line-height-20"></i>Agendar</div>`;
                            }
                        }
                    } else if (estado == 'REALIZADO'){
                        // console.log('estadossss2', estado);
                        respuesta = "";
                        //respuesta += ` <button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    
                    }else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        //respuestaAgenda += ` <button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;  
                    }
                    return respuesta;
                    break;
                case "RECETAS" :
                    let respuestaReceta = ``;
                    if (estado == 'REALIZADO') {
                        //respuestaReceta += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        respuestaReceta += `<button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btnVerOrden" data-bs-toggle="offcanvas" data-bs-target="#detalleRecetaMedica" aria-controls="detalleRecetaMedica" data-rel='${JSON.stringify(datosServicio)}'>Ver receta</button>`;
                    } else if(estado == "PENDIENTE") {
                        if(datosServicio.aplicaSolicitud != "S"){
                            //respuestaReceta += ` <button class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }else{
                            //respuestaReceta += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }
                        if(datosServicio.aplicaSolicitud == "S"){
                            respuestaReceta += `<a href="/farmacia-domicilio/${codigoTratamiento}" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        }
                    }
                    return respuestaReceta;
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    if(estado == "PENDIENTE"){
                        //respuestaOdontologia += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        // ABRIRE MODAL DE VIDEO CONSULTA
                        respuestaOdontologia += `<button type="button" class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50" data-bs-toggle="modal" data-bs-target="#mensajeVideoConsultaModal">Agendar</button>`;
                    }else if(estado == 'REALIZADO'){
                        //respuestaOdontologia += ` <button class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    }
                    return respuestaOdontologia;
                    break;
                case "SESION":
                    let ruta = "/detalle-sesion/{{ $mac }}";
                    let respuestaSesion = "";
                    respuestaSesion += `<div url-rel="${ruta}" data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn p-3 bg-royal-blue text-white rounded-12 fs-18 line-height-24 w-50 btn-sesion">Ver sesión<i class="fa-solid fa-angle-right ms-2"></i></div>`;
                    return respuestaSesion;
                    break;

            }
        }
    }

	function mostrarConvenio(detalle){
		let elem = ``
		if(detalle.nombreConvenio !== null){
			elem += `<p class="fs-14 line-height-16 fw-medium mb-2"><span class="text-royal-blue-shade-20 me-1">Convenio:</span> ${detalle.nombreConvenio}</p>`
		}
		return elem;
	}

	async function cargarInfoTratamiento(){
		let sucursal = (tratamiento.nombreSucursal !== null) ? `<p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> ${tratamiento.nombreSucursal.toLowerCase()}</p>` : ``;

		$('.info-tratamiento').html(`<div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8 h-100">
		        <img src="${tratamiento.urlImagenEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
		    </div>
		    <div class="box-info-agendamiento flex-grow-1">
		        <h3 class="fs-20 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${tratamiento.nombreEspecialidad.toLowerCase()}</h3>
		        <p class="fs-14 line-height-16 fw-medium mb-2 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${tratamiento.nombreMedico.toLowerCase()}</p>
		        ${sucursal}
		        ${ mostrarConvenio(tratamiento, 20) }
		        <p class="fs-14 line-height-16 fw-medium mb-2"><span class="text-royal-blue-shade-20 me-1">Enviado:</span> ${ capitalizarPrimeraLetra(tratamiento.fechaTratamientoFormat) }</p>
		    </div>`)
	}

	let secuenciaAtencion;
	let ultimoTratamientoData;
	let ultimoTratamiento;
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
        	secuenciaAtencion = data.data;
            ultimoTratamientoData = data.data;
            ultimoTratamiento = data.data;

        	detalleTratamiento = data.data;
       		await drawCardOrden();
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

	async function drawCardOrden(){
		let elem = ``;
		//<p class="fs-14 line-height-16 mb-12 fw-normal"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> </p>
		$.each(detalleTratamiento.pendientes, function(key, value){
			//if(detalleTratamiento.mostrarTerapiasAgrupadas == "S"){}
			if(value.detallesServicios == null){
				let buttonActionCard = (value.tipoCard !== "RECETAS") ? `<button item-rel='${JSON.stringify(value)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 px-3 p-12 btn-detalle-orden">Ver detalle</button>` : ``;
				let labelNumeroOrden = (value.tipoCard !== "RECETAS") ? `<p class="fs-14 line-height-16 mb-2 fw-normal"><span class="text-royal-blue-shade-40">Nro. Orden:</span> ${value.idOrden}</p>` : ``;

			    elem += `<div class="col-12 px-32 py-4 fs-18 line-height-24 fw-medium d-flex justify-content-between align-items-center border-bottom-midnight-blue-tint-80">
					<img src="${value.urlImagenTipoServicio}" alt="" width="56px">
					<div class="mx-3 flex-grow-1">
						<h2 class="text-royal-blue-shade-20 fw-medium fs-16 line-height-20 mb-1 text-capitalize">${value.nombreServicio.toLowerCase()}</h2>
			    		${labelNumeroOrden}
						<p class="fs-14 line-height-16 mb-12 fw-normal d-none"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> ${value.fechaCaducidad}</p>
			    		${determinarFechaCaducidadEncabezado(value, detalleTratamiento)}
						${boxEstadoPago(value)}
					</div>
					${buttonActionCard}
				</div>`
			}
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
		let sucursal = (detalle.nombreSucursal !== null) ? `<p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> ${detalle.nombreSucursal.toLowerCase()}</p>` : ``;
		return `<div class="col-6 col-md-6 box-agenda">
				<div class="rounded-16 border-royal-blue-tint-60 border-inside p-12 d-flex justify-content-between align-items-stretch">
				    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
				        <img src="${detalle.urlImagenEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
				    </div>
				    <div class="box-info-agendamiento flex-grow-1">
				        <h3 class="fs-18 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</h3>
				        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${detalle.nombreMedico.toLowerCase()}</p>
				        ${sucursal}
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