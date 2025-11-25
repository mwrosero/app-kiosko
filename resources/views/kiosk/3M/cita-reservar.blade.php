@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => url()->previous()])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Revisa los datos'])

	<!-- Modal de error -->
    <div class="modal modal-top fade" id="ModalError" aria-labelledby="ModalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
	    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
	        <div class="modal-content">
	            <div class="modal-body text-center p-3 pb-0">
                    <h2 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium my-32">Información de tu seguro</h2>
	                <p class="fs--1 line-height-16 text-veris fw-normal" id="mensajeError"></p>
                    <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgError" id="mensajeError">Ocurrió un inconveniente con tu aseguradora, por favor toma un turno.</h3>
	            </div>
	            <div class="modal-footer pt-0 pb-3 px-3">
	                <a href="tel:+59346009600" id="btn-lamar" class="btn btn-primary-veris d-none m-0 w-100 px-4 py-3 mb-2"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
	                <button type="button" id="btn-dismiss-error" class="btn py-24 text-royal-blue border-royal-blue rounded-12 fs-24 line-height-32 w-100 d-none" data-bs-dismiss="modal">Regresar</button>
	                <a href="/menu/{{ $mac }}" id="btn-redirect-error" class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100 mt-3">Volver al inicio</a>
	            </div>
	        </div>
	    </div>
	</div>

	{{-- Modal cuando no existen mas agendas multiples --}}
	<div class="modal fade" id="modalSinAgendaMultiple" tabindex="-1" aria-labelledby="modalSinAgendaMultipleLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
	        <div class="modal-content">
	            <div class="modal-body text-center p-3 pb-2">
	                <h1 class="modal-title fs-24 line-height-28 fw-medium mb-3">Información</h1>
	                <p class="fs--1 line-height-16 fw-normal text-veris mb-3">Eliminaste todas las terapias reservadas, no queda información para mostrar.</p>
	            </div>
	            <div class="modal-footer pt-0 pb-3 px-3">                    
	                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100 btn-eliminar-cita">Entiendo</a>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Modal de pregunta para eliminar una cita -->
	<div class="modal fade" id="modalEliminarCitaMultiple" tabindex="-1" aria-labelledby="modalEliminarCitaMultipleLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
	        <div class="modal-content">
	            <div class="modal-body text-center p-3 pb-2">
	                <h1 class="modal-title fs-24 line-height-28 fw-medium mb-3">Eliminar Terapia</h1>
	                <p class="fs--1 line-height-16 fw-normal text-veris mb-3">¿Estás seguro de que deseas eliminar la terapia 3?</p>
	                <input type="hidden" id="indexItem">
	            </div>
	            <div class="modal-footer pt-0 pb-3 px-3">                    
	                <div class="btn btn-lg btn-primary-veris w-100 m-0 mb-3 px-4 py-3 btn-eliminar-cita" data-bs-dismiss="modal">Sí, eliminar</div>
	                <button type="button" class="btn btn-lg btn-outline-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal">No,cancelar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row d-flex justify-content-center align-items-start h-100 mx-0">
			<div class="col-7 px-32 h-100 d-flex flex-column justify-content-start align-items-center mx-auto mt-0 pt-56" style="overflow-y: auto; height: 70vh !important;">
				<section class="p-3 mb-3 invisible detalles-cita-box">
			        <div class="row g-4 justify-content-center">
			            <div class="col-12 box-card-precio">
			                <div class="card border-0 shadow-veris">
			                    <div class="card-header bg-royal-blue-tint-80 rounded-top-12 p-3">
			                        <h5 class="text-secundary-00 fw-medium fs-24 line-height-32 m-0">{{ __('Precio') }} </h5>
			                    </div>
			                    <div class="card-body py-2 px-0">
			                        <div class="row gx-0 justify-content-center align-items-center box-precio pt-1 pb-1">
			                        </div>
			                    </div>
			                    {{-- <div class="card-footer d-flex justify-content-between border-top p--2" id="contentLinkPago">
			                        <div class="mx-1">
			                            <p class="fs-16 line-height-20 mb-0 fw-medium">{{ __('¿Alguien más pagará esta cita?') }}</p>
			                            <p class="fs-16 line-height-20 mb-0">{{ __('Genera tu link de pago') }}</p>
			                        </div>
			                        <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 line-height-16 ms-3 px-3 py-2">{{ __('Enviar link') }}</a>
			                    </div> --}}
			                </div>
			            </div>
			            <div class="col-12 mt-4">
			                <div class="card border-0 shadow-veris">
			                    <div class="card-header bg-royal-blue-tint-80 rounded-top-12 p-3">
			                        <h5 class="text-secundary-00 fw-medium fs-24 line-height-32 m-0">{{ __('Detalles de la cita') }}</h5>
			                    </div>
			                    <div class="card-body p--2">
			                        <div class="multiple d-none" id="contentDetalleCitaMultiple">
			                            <div class="d-flex justify-content-start align-items-center border-bottom pb--2 box-label-items-descuento d-none">
			                                <i class="fa-solid fa-circle-info text-pink fs-24 p-2 me-2"></i>
			                                <p class="fs--1 line-height-16 mb-0 text-veris-dark">Con <b>descuento</b>, no se puede reagendar.</p>
			                            </div>
			                            <div class="accordion" id="detalleMultiple">
			                            </div>
			                        </div>
			                        <div class="unica d-none" id="contentDetalleCita">
			                            {{-- <p class="text-royal-blue fw-medium mb-0" id="nombreEspecialidad"></p>
			                            <p class="fw-medium fs--1 mb-0">{{ isset($data->central) ? $data->central->nombreSucursal : 'VIRTUAL' }}</p>
			                            <p class="fs--2 mb-0">{{ $data->horario->dia2 }} <b class="text-normal text-royal-blue fw-normal">{{ $data->horario->horaInicio }} {{ $meridiano }}</b></p>
			                            <p class="fs--2 mb-0">Dr(a) {{ $data->horario->nombreMedico }}</p>
			                            <p class="fs--2 mb-0">{{ $data->paciente->nombrePaciente }}</p>
			                            <p class="fs--2 mb-0">{{ isset($data->convenio->nombreConvenio) ? $data->convenio->nombreConvenio : '' }}</p> --}}
			                        </div>
			                    </div>
			                    <div class="card-footer pt-0 p--2 d-none" id="msg-cita">
			                    </div>
			                </div>
			            </div>
			        </div>
			        <div class="row justify-content-center">
			            <div class="col-12 text-center mt-5">
			                {{-- <a href="#" id="btn-pagar" class="btn btn-lg btn-primary-veris d-none w-100">{{ __('Pagar') }}</a> --}}
			                <button id="btn-pagar" class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100">{{ __('Pagar') }}</button>
			            </div>
			        </div>
			    </section>
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<style>
    .text-pink{
        color: #EF2E79 !important;
    }
    .bg-silver{
        background: #EAF0FD;
    }
    .item-numeration-24{
        width: 24px;
        height: 24px;
    }
    .text-veris-dark{
        color: #0A2240;
    }
    .accordion-item:last-child {
        border: 0px !important;
    }
    .accordion-item.active .label-error-reserva-header{
        display: none !important;
    }
    .bg-pink-light{
        background: #FFE5EF;
    }
</style>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let dataCita = JSON.parse(localStorage.getItem('agendamiento'));
	trackId = localStorage.getItem('trackId');
	
    // variables globales

    let online = dataCita?.online;
    let nombreEspecialidad = capitalizarCadaPalabra(dataCita.especialidad.nombre);
    var tipoIdentificacion = parseInt(dataCita.paciente.tipoIdentificacion);
    if (isNaN(tipoIdentificacion)) {
        tipoIdentificacion = parseInt(dataCita.paciente.codigoTipoIdentificacion);
    }
    // let tipoIdentificacion = dataCita.paciente.tipoIdentificacion;
    let numeroIdentificacion = dataCita.paciente.numeroIdentificacion;
    let codigoEspecialidad = dataCita.especialidad.codigoEspecialidad;
    let secuenciaAfiliado = dataCita.convenio.secuenciaAfiliado || '' ;
    let codigoConvenio = dataCita.convenio.codigoConvenio || '';
    //let idIntervalo = dataCita.horario.idIntervalo || '';
    //let porcentajeDescuentos = dataCita.horario.porcentajeDescuento;
    let medPayPlan = dataCita.convenio.informacionExternaPlan;
    
    let permiteReserva = dataCita.convenio.permiteReserva;
    // let dia2 = dataCita.horario.dia2;
    let idCliente = dataCita.convenio.idCliente;
    let rutaImagenConvenio = dataCita.convenio.rutaImagenConvenio;
    // let horaInicio = dataCita.horario.horaInicio;

    let permitePago = "S";
    if(dataCita.convenio.permitePago){
        permitePago = dataCita.convenio.permitePago;
    }

    document.addEventListener("DOMContentLoaded", async function () {
        if(dataCita.hasOwnProperty('detalle_multiple')){
            $('#contentDetalleCitaMultiple').parent().addClass('py-0 px-0')
            $('.multiple').removeClass('d-none');
        }else{
            $('.unica').removeClass('d-none');
            $('#msg-cita').removeClass('d-none')
        }

        if(dataCita.hasOwnProperty('tratamiento')){
            $('.box-card-precio').addClass('d-none')
        }else{
            $('.box-card-precio').removeClass('d-none')
        }
        

        if(dataCita.reserva){
            await eliminarReserva();
        }
        if(dataCita.reservaEdit && dataCita.reservaEdit.estaPagada === "S" && dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
            let elem = `<p class="text-royal-blue fs--16 line-height-20 fw-medium mb-1 text-center">Servicio pagado<i class="fa-solid fa-circle-check text-success ms-2"></i></p>`;
            $('.box-precio').html(elem);
            $('#btn-pagar').html("Continuar").removeClass('d-none');

            let elemMsg = ``;
            elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2 mb-3">
                <i class="fa-solid fa-circle-info text-royal-blue fs-2 p-2 me-2"></i>
                <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Estás modificando el canal de atención, si realizas el cambio <b class="fw-medium text-veris">tu atención será virtual.</b></p>
            </div>`;
            elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                <i class="fa-solid fa-circle-info text-warning fs-2 p-2 me-2"></i>
                <p class="fs--1 line-height-16 mb-0" id="infoMessage style="color: #0A2240;">Esta acción no puede deshacerse</p>
            </div>`;
            $('#msg-cita').append(elemMsg);

        }else{
            if(dataCita.hasOwnProperty('items')){
                // Por pagar
                let text_btn = "Agendar";
                $.each(dataCita.detalle_pre_agendamiento, function(key, value){
                    if(value.request.estaPagada == "N" && value.request.permitePago == "S" && dataCita.origen !== "paquetes"){
                        text_btn = "Pagar";
                    }
                })
                $('#btn-pagar').html(text_btn).removeClass('d-none');
                if(dataCita.origen !== "paquetes"){
                    await obtenerPrecioMultiple();
                }else{
                    $('.box-precio').html(`<div class="col-12 text-center"><h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal">$0.00</h1></div>`);
                }
            }else{
                await obtenerPrecio();
            }
        }

        if(dataCita.hasOwnProperty('detalle_multiple')){
            await llenarDataDetallesCitasMultiples();
        }else{
            await llenarDataDetallesCitas();
        }

        $('body').on('click', '#btn-pagar', async function () {
            if(dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
                await cambiarModalidadCita();
            }else{
                if(dataCita.hasOwnProperty('items')){
                    await validarPagoMultiple();
                }else{
                    await reservarCita();
                }
            }
        });

        $('.detalles-cita-box').removeClass('invisible')

        $('body').on('click', '.btn-eliminar-reserva-multiple', async function () {    
            $('#indexItem').val($(this).attr('index-rel'));
            $('#modalEliminarCitaMultiple').modal('show');
        })

        $('body').on('click', '.btn-eliminar-cita', async function () {
            let indexItem = $('#indexItem').val();
            await eliminarReserva(dataCita.detalle_pre_agendamiento[parseInt(indexItem)].response.codigoReserva)
        })

        $('body').on('click', '.btn-editar-cita', async function () {
            let indexItem = $(this).attr('index-rel');
            await editarReservaMultiple(indexItem, dataCita.detalle_pre_agendamiento[parseInt(indexItem)].response.codigoReserva)
        })

    });

    async function validarReservas(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/validacionReservas?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        // //args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";

        let aplicaProntoPago = 'S';
        if(dataCita.convenio.aplicaProntoPago){
            aplicaProntoPago = dataCita.convenio.aplicaProntoPago;
        }
        let citas = [];
        $.each(dataCita.detalle_pre_agendamiento, function(key, value){
            citas.push({
                "codigoReserva": value.response.codigoReserva,
                "codigoServicio": value.request.codigoServicio,
                "codigoPrestacion": value.request.codigoPrestacion,
                "esOnline": value.request.esOnline,
                "porcentajeDescuento": value.request.porcentajeDescuento,
                "valorCita": value.response.valorCanalVirtual,
                "estaPagada": value.request.estaPagada
            })
        })
        let payload = {
            "codigoConvenio": codigoConvenio,
            "secuenciaAfiliado": secuenciaAfiliado,
            "aplicaProntoPago": aplicaProntoPago,
            "permitePago": permitePago,
            "listaCita": citas
        }
        args["data"] = JSON.stringify(payload);
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.code == 200){
            return data;
        }
    }

    async function editarReservaMultiple(index, codigoReserva){
        const data = await validarReservas();
        console.log(data);
        if(data.code == 200){
            console.log(index, codigoReserva)
            dataCita.esEdicion = true;
            dataCita.position = index;
            dataCita.detalleEdicion = data.data.listaCita.find(item => item.codigoReserva === parseInt(codigoReserva));
            guardarData();
            location.href = `/citas-elegir-fecha-doctor/{{ $mac }}`;
        }
    }

    async function reservaEstaPagada(codigoReserva){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/reserva/${codigoReserva}?macAddress={{ $mac }}&canalOrigen=${canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            if(data.data !== null){
                return data.data.datosReserva.estaPagada;
            }
        }
        return "N";
    }

    async function eliminarReserva(codigoReserva = null){
        let codigoReservaEliminar = (codigoReserva === null) ? dataCita.reserva.codigoReserva : codigoReserva;
        let puedeEliminar = await reservaEstaPagada(codigoReservaEliminar);
        if(puedeEliminar == "S"){
            showMessage('warning','Atención','Reserva ya se encuentra pagada')
            $('#btn-pagar').parent().addClass('d-none');
            return;
        }
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = dataCita.paciente.numeroIdentificacion;
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/eliminarReserva?macAddress={{ $mac }}&codigoReserva=${codigoReservaEliminar}`
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);

        //Menos para edictar reserva 
        if(data.code == 200){
            if(codigoReserva === null){
                delete dataCita.reserva;
                guardarData();
            }else{
                let indexItem = parseInt($('#indexItem').val());
                console.log({indexItem})
                $('.accordion-item-'+indexItem).remove();
                dataCita.detalle_multiple.splice(indexItem, 1);
                dataCita.detalle_pre_agendamiento.splice(indexItem, 1);
                dataCita.items.splice(indexItem, 1);
                guardarData();
                if(dataCita.detalle_pre_agendamiento.length == 0){
                    $('#precioTotal').html(``);
                    $('#detalleMultiple').html(``);
                    
                    $('#modalSinAgendaMultiple').modal('show');
                }else{
                    $('.box-buttons-multiple').each(function(key, value) {
                        // Dentro de cada .box-buttons-multiple busca el botón
                        $(this).find('button').attr('index-rel', key );
                    });
                    await obtenerPrecioMultiple();
                }
            }
        }

    }

    async function llenarDataDetallesCitasMultiples(){
        let elem = ``;
        let tieneDescuento = false;
        // <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" 
        $.each(dataCita.detalle_multiple, function(key, value){
            let iconDescuento = ``;
            let badgeDescuento = ``;
            if(value.porcentajeDescuento > 0){
                tieneDescuento = true;
                iconDescuento = `<i class="fa-solid fa-circle-info text-pink fs-20 p-2 me-2"></i>`
                badgeDescuento = `<span class="px-3 py-1 ms-2 fw-medium bg-pink-light text-pink rounded-pill text-veris-dark" style="font-size:10px; line-height:12px;">
                        -${value.porcentajeDescuento}%
                    </span>`;
            }
            let nombrePaciente;
            if(dataCita.paciente.nombrePaciente){
                nombrePaciente = dataCita.paciente.nombrePaciente;
            }else{
                nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
            }
            elem += `<div class="accordion-item border-bottom accordion-item-${key}">
                <h2 class="accordion-header" id="panelsStayOpen-${key}">
                    <button class="accordion-button p-2 py-2 my-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${key}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${key}">
                        <div class="w-100">
                            <div class="d-flex justify-content-start align-items-center fs--16 line-height-16 text-capitalize text-royal-blue">
                                <span class="p-2 d-flex justify-content-center align-items-center rounded-circle bg-silver me-2 fs--1 line-height-16 item-numeration-24">${ key+1 }</span> ${ dataCita.items[key].nombreServicio.toLowerCase() }
                            </div>
                            <div class="d-flex justify-content-start align-items-center fs-16 line-height-20 my-1">
                                <span class="p-2 d-flex justify-content-center align-items-center rounded-circle bg-silver me-2 fs--1 line-height-16 item-numeration-24 invisible">${ key+1 }</span>
                                <span class="px-2 py-1 me-2 bg-silver rounded-pill text-veris-dark fw-normal">
                                    <i class="text-royal-blue bi bi-calendar4 me-1"></i> ${value.dia2}
                                </span>
                                <span class="px-2 py-1 bg-silver rounded-pill text-veris-dark fw-normal time-reserva-${dataCita.detalle_pre_agendamiento[key].response.codigoReserva}">
                                    <i class="text-royal-blue bi bi-smartwatch me-1"></i> ${value.horaInicio} ${ determinarMeridiano(value.horaInicio) }
                                </span>
                                ${ iconDescuento }
                            </div>
                            <div class="d-flex justify-content-start align-items-center my-0 label-error-reserva-header d-none label-error-reserva-${dataCita.detalle_pre_agendamiento[key].response.codigoReserva}">
                                <span class="p-2 d-flex justify-content-center align-items-center rounded-circle bg-silver me-2 fs--1 line-height-16 item-numeration-24 invisible">${ key+1 }</span>
                                <p class="mb-0 d-flex justify-content-start align-items-center fs-16 line-height-20 text-danger-veris">
                                    <i class="fa-solid fa-circle-info me-1 p-0"></i> Este horario ya no está disponible
                                </p>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse${key}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-${key}">
                    <div class="accordion-body px-0">
                        <div class="d-flex justify-content-start align-items-center fs-16 line-height-20 my-0">
                            <span class="p-2 d-flex justify-content-center align-items-center rounded-circle bg-silver me-2 fs--1 line-height-16 item-numeration-24 invisible">${ key+1 }</span>
                            <div class="px-2 py-1 text-veris-dark fw-normal">
                                <p class="mb-1 line-height-16 fw-bold text-capitalize">${value.nombreSucursal.toLowerCase()}</p>
                                <p class="mb-1 line-height-16 fw-normal text-capitalize">Terapista: ${value.nombreMedico.toLowerCase()}</p>
                                <p class="mb-1 line-height-16 fw-normal text-capitalize">${nombrePaciente.toLowerCase()}</p>
                                <p class="mb-1 line-height-16 fw-normal text-royal-blue d-flex justify-content-start align-items-center">$${ dataCita.detalle_pre_agendamiento[key].response.valorCanalVirtual.toFixed(2) } ${badgeDescuento}</p>
                                <p class="mb-1 d-flex justify-content-start align-items-center text-danger-veris d-none label-error-reserva-${dataCita.detalle_pre_agendamiento[key].response.codigoReserva}">
                                    <i class="fa-solid fa-circle-info me-1 p-0"></i>Este horario ya no está disponible
                                </p>
                                <div class="mt-2 d-flex justify-content-start align-items-center box-buttons-multiple">
                                    <button index-rel='${key}' class="btn btn-primary-veris px-3 py-2 border-0 text-white shadow-none fw-normal fs--1 me-2 btn-editar-cita">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>Editar cita
                                    </button>
                                    <button index-rel='${key}' class="btn bg-transparent  px-3 py-2 border-0 text-danger-veris shadow-none fw-normal fs--1 btn-eliminar-reserva-multiple">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        })
        if(tieneDescuento){
            $('.box-label-items-descuento').removeClass('d-none');
        }
        $('#detalleMultiple').html(elem);
        $('#btn-pagar').removeClass('d-none');
    }

    async function validarPagoMultiple(){
        const validacionReserva = await validarReservas();
        let puedeReservar = validacionReserva.data.listaCita.find(item => item.estado !== "Disponible");

        if(puedeReservar === undefined){
            //Iniciar proceso de reserva
            let puedeCrearPreTrx = false;
            $.each(dataCita.detalle_pre_agendamiento, function(key, value){
                if(value.request.estaPagada == "N" && value.request.permitePago == "S"){
                    puedeCrearPreTrx = true;
                }
            })
            if(puedeCrearPreTrx){
                await crearPreTransaccion();
            }else{
                guardarData();
                location.href = '/pago-realizado/{{ $mac }}';
            }
        }else{
            $.each(validacionReserva.data.listaCita, function(key, value){
                if(value.estado !== "Disponible"){
                    $(`.label-error-reserva-${value.codigoReserva}`).removeClass('d-none');
                }
            })
        }
    }

    // llenar los datos en contentDetalleCita con los datos de dataCita
    async function llenarDataDetallesCitas(){
        let sucursal;
        let dia;
        let horaInicio;
        let horaFin;
        if(dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
            //let datosAgenda = await obtenerDatosReserva(dataCita.reservaEdit.idCita);
            sucursal = `Veris - Virtual`;
            dia = dataCita.horario.fechaReserva;
            horaInicio = dataCita.horario.horaInicio;
            horaFin = dataCita.horario.horaFin;
        }else{
            if(dataCita.online == "S"){
                sucursal = dataCita.horario.nombreSucursal;
            }else{
                sucursal = dataCita.central.nombreSucursal;
            }
            dia = dataCita.horario.dia;
            horaInicio = dataCita.horario.horaInicio;
            horaFin = dataCita.horario.horaFin;
        }
        let elem = `<p class="text-royal-blue fs-22 line-height-26 fw-medium mb-1"  id="nombreEspecialidad">${capitalizarCadaPalabra(nombreEspecialidad)}</p>`;
        if(dataCita.online == "N"){    
            elem += `<p class="text-secundary-00 fw-medium fs-20 line-height-24 mb-1">${capitalizarCadaPalabra(sucursal)}</p>`;
        }
        let nombrePaciente;
        if(dataCita.paciente.nombrePaciente){
            nombrePaciente = dataCita.paciente.nombrePaciente;
        }else{
            nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
        }

        elem += `<p class="fs-16 line-height-20 mb-1 text-secundary-00">${capitalizarElemento(dia)} <span class="text-royal-blue fw-normal">${horaInicio} - ${horaFin} ${determinarMeridiano(horaInicio)}</span></p>
            <p class="text-secundary-00 fs-16 line-height-20 mb-1 text-capitalize">Dr(a) ${dataCita.horario.nombreMedico.toLowerCase()}</p>
            <p class="text-primary-tint-20 fs-16 line-height-20 mb-1 text-capitalize">${nombrePaciente.toLowerCase()}</p>`;
        if(dataCita.convenio.codigoConvenio){
            elem += `<p class="text-primary-tint-20 fs-16 line-height-20 mb-1 text-capitalize">${ (dataCita.convenio.nombreConvenio) ? dataCita.convenio.nombreConvenio.toLowerCase() : ''}</p>`
        }
        $('#contentDetalleCita').html(elem);

        if(dataCita.convenio.codigoConvenio){
            $('#contentLinkPago').removeClass('d-none');
        }

    }

    // determinar si es PM o AM segun horaInicio
    function determinarMeridiano(horaInicio){
        let partesHora = horaInicio.split(':');
        let hora = parseInt(partesHora[0]);
        let meridiano = "AM";
        if (hora >= 12) {
            meridiano = "PM";
        }
        return meridiano;
    }

    async function obtenerPrecioMultiple(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoReserva = ''; 
        let numeroOrden = ''; 
        let codigoEmpOrden = '';
        let lineaDetalle = '';
        let aplicaCredito = 'N';
        let aplicaProntoPago = 'S';

        if(dataCita.horario.porcentajeDescuento > 0){
            aplicaCredito = "S";
        }

        if(dataCita.convenio.aplicaProntoPago){
            aplicaProntoPago = dataCita.convenio.aplicaProntoPago;
        }

        if(dataCita.reservaEdit){
            codigoReserva = dataCita.reservaEdit.idCita;
            numeroOrden = dataCita.reservaEdit.numeroOrden || '';
            codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden || '';
            lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden || '';
        }
        if(dataCita.tratamiento && !dataCita.sesion){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
        }

        if(!dataCita.estaPagado){
            lineaDetalle = '';
        }

        let codigoUsuario = dataCita.paciente.numeroIdentificacion;
        let cantidad = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            cantidad = dataCita.tratamiento.cantidadIntervalosReserva
        }

        let argsSesion = '';
        if(dataCita.sesion){
            argsSesion = `&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}`;
        }
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/lista/precio?macAddress={{ $mac }}&canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&idIntervalos=${dataCita.horario.idIntervalo}&permitePago=${permitePago}&codigoConvenio=${codigoConvenio}&esOnline=${dataCita.online}&porcentajeDescuento=${dataCita.horario.porcentajeDescuento}&aplicaProntoPago=${aplicaProntoPago}&codigoPrestacion=${dataCita.especialidad.codigoPrestacion}&codigoServicio=${dataCita.especialidad.codigoServicio}&secuenciaAfiliado=${secuenciaAfiliado}&aplicaCredito=${aplicaCredito}&numeroOrden=${numeroOrden}&codEmpOrden=${codigoEmpOrden}&lineaDetalle=${lineaDetalle}&cantidad=${cantidad}${argsSesion}`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        let payload = [];
        $.each(dataCita.detalle_pre_agendamiento, function(key,value){
            payload.push({
                "idIntervalos": value.request.idIntervalos,
                "esOnline": dataCita.online,
                "numeroOrden": value.request.numeroOrden,
                "lineaDetalle": value.request.lineaDetalle,
                "codEmpOrden": value.request.codigoEmpOrden,
                "porcentajeDescuento": value.request.porcentajeDescuento,
                "codigoPrestacion": value.request.codigoPrestacion,
                "codigoServicio": value.request.codigoServicio,
                "cantidad": value.request.cantidad,
                "codigoReserva": value.response.codigoReserva,
                "secuenciaTransaccion": value.response.secuenciaTransaccion,
                "fechaSeleccionada": value.request.fechaSeleccionada,
                "estaPagada": value.request.estaPagada
            })
        })
        args["data"] = JSON.stringify(payload);
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            let { valor, porcentajeDescuento, valorCanalVirtual  } = data.data;
            var porcentajeDescuentoCopago = porcentajeDescuento;
            var subtotalCopago = valor;
            var valorTotalCopago = valorCanalVirtual;
            var subtotalCopagoFloat = parseFloat(valor);
            var valorTotalCopagoFloat = parseFloat(valorCanalVirtual);
            let params = {};

            let elem = ``;
            let descuentoLabel = ``;
            let classNone = 'd-none';
            if(porcentajeDescuentoCopago > 0){
                classNone = '';
                descuentoLabel = `*Se aplicó un ${porcentajeDescuentoCopago}% ${data.data.mensajeDescuento}`;
            }

            if(codigoConvenio){
                console.log('subTotal', subtotalCopagoFloat, 'valorTotal', valorTotalCopagoFloat);
                elem += `<div class="col-3 text-center">
                            <img src="${rutaImagenConvenio}" alt="" class="img-fluid" width="86" height="">
                        </div>
                        <div class="col-5 text-center">`;

                if(subtotalCopagoFloat > valorTotalCopagoFloat){
                elem +=     `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                                <del class="fs-16 line-height-20" id="precioBase">$${valor.toFixed(2)}</del>
                            </p>`;
                }
                        elem += `<h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal" style="white-space: nowrap;">$${valorTotalCopago.toFixed(2)}</h1>
                        </div>
                        <p class="text-center text-royal-blue fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }else{
                elem += `<div class="col-12 text-center">`
                if(porcentajeDescuentoCopago > 0){
                    elem += `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                        <del class="fs-16 line-height-20" id="precioBase">$${valor.toFixed(2)}</del>
                    </p>`;
                }
                elem += `<h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal">$${valorTotalCopago.toFixed(2)}</h1>
                </div>
                <p class="text-center text-royal-blue fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }


            $('.box-precio').html(elem);
            if(dataCita.origen === "paquetes"){
                $('.box-precio').html(`<div class="col-12 text-center"><h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal">$0.00</h1></div>`);
            }
        }
    }
    
    async function obtenerPrecio() {
        if(dataCita.origen == "paquetes"){
            $('.box-card-precio').addClass('d-none');
            $('.box-precio').html(`<div class="col-12 text-center"><h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal">$0.00</h1>
                </div>`);
            $('#msg-cita').append(`<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-royal-blue fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Puedes <b class="fw-medium text-veris">reagendar</b> tu cita las veces que necesites.</p>
                    </div>`);
            $('#btn-pagar').html("Agendar").removeClass('d-none');
            return;
        }
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoReserva = ''; 
        let numeroOrden = ''; 
        let codigoEmpOrden = '';
        let lineaDetalle = '';
        let aplicaCredito = 'N';
        let aplicaProntoPago = 'S';

        if(dataCita.horario.porcentajeDescuento > 0){
            aplicaCredito = "S";
        }

        if(dataCita.convenio.aplicaProntoPago){
            aplicaProntoPago = dataCita.convenio.aplicaProntoPago;
        }

        if(dataCita.reservaEdit){
            codigoReserva = dataCita.reservaEdit.idCita;
            numeroOrden = dataCita.reservaEdit.numeroOrden || '';
            codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden || '';
            lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden || dataCita.reservaEdit.lineaDetalle;
        }
        if(dataCita.tratamiento && !dataCita.sesion){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
            
        }

        {{-- if(!dataCita.estaPagado){ --}}
        if(lineaDetalle === null){
            lineaDetalle = '';
        }

        let codigoUsuario = dataCita.paciente.numeroIdentificacion;
        let cantidad = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            cantidad = dataCita.tratamiento.cantidadIntervalosReserva
        }

        let argsSesion = '';
        if(dataCita.sesion){
            argsSesion = `&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}`;
        }

        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/precio?macAddress={{ $mac }}&canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&idIntervalos=${dataCita.horario.idIntervalo}&permitePago=${permitePago}&codigoConvenio=${codigoConvenio}&esOnline=${dataCita.online}&porcentajeDescuento=${dataCita.horario.porcentajeDescuento}&aplicaProntoPago=${aplicaProntoPago}&codigoPrestacion=${dataCita.especialidad.codigoPrestacion}&codigoServicio=${dataCita.especialidad.codigoServicio}&codigoReserva=${codigoReserva}&secuenciaAfiliado=${secuenciaAfiliado}&aplicaCredito=${aplicaCredito}&codigoReserva=${codigoReserva}&numeroOrden=${numeroOrden}&codEmpOrden=${codigoEmpOrden}&lineaDetalle=${lineaDetalle}&cantidad=${cantidad}${argsSesion}`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["token"] = "{{ $accessToken }}";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "fechaSeleccionada": dataCita.horario.dia2,
            "idCliente": idCliente,
            "estaPagada": (dataCita.reservaEdit) ? dataCita.reservaEdit.estaPagada : 'N',
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "medPayPlan": medPayPlan
        });
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        
        if(data.code == 200){
            let { valor, porcentajeDescuento, valorCanalVirtual  } = data.data;
            var porcentajeDescuentoCopago = porcentajeDescuento;
            var subtotalCopago = valor;
            var valorTotalCopago = valorCanalVirtual;
            var subtotalCopagoFloat = parseFloat(valor);
            var valorTotalCopagoFloat = parseFloat(valorCanalVirtual);
            let params = {};

            let elem = ``;
            let descuentoLabel = ``;
            let classNone = 'd-none';
            if(porcentajeDescuentoCopago > 0){
                classNone = '';
                descuentoLabel = `*Se aplicó un ${porcentajeDescuentoCopago}% ${data.data.mensajeDescuento}`;
            }
            console.log(porcentajeDescuentoCopago)
            console.log(descuentoLabel)

            if(valorCanalVirtual == 0){
                $('#btn-pagar').html('Continuar')
            }

            if(codigoConvenio){
                console.log('subTotal', subtotalCopagoFloat, 'valorTotal', valorTotalCopagoFloat);
                elem += `<div class="col-3 text-center">
                            <img src="${rutaImagenConvenio}" alt="" class="img-fluid" width="86" height="">
                        </div>
                        <div class="col-5 text-center">`;

                if(subtotalCopagoFloat > valorTotalCopagoFloat){
                elem +=     `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                                <del class="fs-16 line-height-20" id="precioBase">$${valor.toFixed(2)}</del>
                            </p>`;
                }
                        elem += `<h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal" style="white-space: nowrap;">$${valorTotalCopago.toFixed(2)}</h1>
                        </div>
                        <p class="text-center text-veris fw-medium fs-18 line-height-22 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }else{
                elem += `<div class="col-12 text-center">`
                if(porcentajeDescuentoCopago > 0){
                    elem += `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                        <del class="fs-16 line-height-20" id="precioBase">$${valor.toFixed(2)}</del>
                    </p>`;
                }
                elem += `<h1 class="text-royal-blue fw-medium fs-48 line-height-56 mb-0" id="precioTotal">$${valorTotalCopago.toFixed(2)}</h1>
                </div>
                <p class="text-center text-veris fw-medium fs-18 line-height-22 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }


            $('.box-precio').html(elem);

            let elemMsg = ``;

            if(dataCita.horario.porcentajeDescuento == 0 && permiteReserva == "S" && permitePago == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-royal-blue fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Puedes <b class="fw-medium text-veris">reagendar</b> tu cita las veces que necesites.</p>
                    </div>`;
            }
            //Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.
            if(dataCita.horario.porcentajeDescuento > 0 && permitePago == "S" && data.data.mensajeAlerta !== null){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-warning fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">${data.data.mensajeAlerta}</p>
                    </div>`;
            }
            if(online == "S"){
                if((dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") && valorTotalCopago > 0) {
                    elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                            <i class="fa-solid fa-circle-info text-royal-blue fs-2 p-2 me-2"></i>
                            <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Recuerda que para poder conectarte a tu cita <b class="fw-medium text-veris">debes pagarla en los próximos 30 minutos</b>.</p>
                        </div>`;
                }
            }
            if(permitePago == "N"){
                if((dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") && valorTotalCopago > 0){
                    elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                            <i class="fa-solid fa-circle-info text-royal-blue fs-2 p-2 me-2"></i>
                            <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;"><b class="fw-medium">Recuerda</b> llegar <b class="fw-medium text-veris">20 minutos antes</b> de la cita y acercarte a caja para realizar el pago.</p>
                        </div>`;
                }
            }
            $('#msg-cita').append(elemMsg);
            
            dataCita.precio = data.data;
            //let urlParams = btoa(JSON.stringify(params));
            if(dataCita.tratamiento && dataCita.tratamiento.esPagada && dataCita.tratamiento.esPagada =="S"){
                $('#btn-pagar').html('Continuar');
                $('#btn-pagar').attr('href','/pago-realizado/{{ $mac }}');
            }
            if (dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") {
                $('#btn-pagar').attr('href','/citas-datos-facturacion/{{ $mac }}');
            }else{
                $('#btn-pagar').html('Continuar');
                $('#btn-pagar').attr('href','/pago-realizado/{{ $mac }}');
            }
            $('#btn-pagar').removeClass('d-none');

            if((data.data.mensajeValidacion !== "" && data.data.mensajeValidacion !== null) || (data.data.mensajeValidacion2 !== "" && data.data.mensajeValidacion2 !== null)){
                //$('#mensajeError').html(`${data.data.mensajeValidacion} <br> ${(data.data.mensajeValidacion2 !== null) ? data.data.mensajeValidacion2 : ""}`);
                $('.btn-action-error').addClass('d-none');
                if(data.data.aplicaCondicionesSeguro){
                    //redirecciona al home
                    $('#btn-redirect-error').removeClass('d-none');
                }else{
                    //dismiss modal
                    $('#btn-dismiss-error').removeClass('d-none');
                }
                if(data.data.mostraOpcionLlamar){
                    $('#btn-lamar').attr("href","tel:+593"+data.data.numeroContactCenter);
                }
                $('#ModalError').modal("show");
            }
        }
        return data;
    }

    async function cambiarModalidadCita(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/cambiarModalidadCita`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        let datosReserva = {
            "codigoReserva": dataCita.reservaEdit.idCita,
            "canalOrigen": _canalOrigen
        }
        args["data"] = JSON.stringify(datosReserva);
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);

        if (data.code == 200){
            location.href = '/pago-realizado/{{ $mac }}';
        }
    }

    async function reservarCita(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/reservar?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        let estaPagada = "N";
        if(dataCita.reservaEdit != null ) {
            estaPagada = dataCita.reservaEdit.estaPagada;
        }

        if(dataCita.origen == "paquetes"){
            estaPagada = "S";
            dataCita.precio = {
                "valorCanalVirtual": 0,
                "secuenciaTransaccion": null,
                "valorCanalVirtual": 0,
                "valorDescuento": 0,
                "valor": 0,
                "numeroAutorizacion": 0
            }
        }

        let datosReserva = {
            "numeroIdentificacion": dataCita.paciente.numeroIdentificacion,
            "tipoIdentificacion": tipoIdentificacion,
            "idIntervalos": dataCita.horario.idIntervalo,
            "codigoEmpresa": 1,
            "codigoEspecialidad": dataCita.especialidad.codigoEspecialidad,
            "codigoPrestacion": dataCita.especialidad.codigoPrestacion,
            "usuarioLogin": datosCliente.numeroIdentificacion,
            "esOnline": dataCita.online,
            "origen": 4,
            "motivoConsulta": "",
            "codigoServicio": dataCita.especialidad.codigoServicio,
            "canalOrigenAgendamiento": "MVE",
            "codigoEmpresaRegistro": 1,
            "codigoSucursalRegistro": null,
            "porcentajeDescuento": dataCita.horario.porcentajeDescuento,
            "permitePago": dataCita.convenio.permitePago,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
            "canalOrigen": _canalOrigen,
            "enviarLinkPago": null,
            "valorizacion": dataCita.precio.valorCanalVirtual,
            /*precio o reagendamiento*/
            "secuenciaTransaccion": dataCita.precio.secuenciaTransaccion,
            "valorCita": dataCita.precio.valorCanalVirtual,
            "valorDescuento": dataCita.precio.valorDescuento,
            "valorSubtotalCita": dataCita.precio.valor,
            "numeroAutorizacion": dataCita.precio.numeroAutorizacion,
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "fechaSeleccionada": dataCita.horario.dia2,
            /*Si estoy modificando/tratamiento o sino N*/
            "estaPagada": estaPagada
        }

        /*Para reagendamiento*/
        //"codigoReservaCambio": "string",

        if(dataCita.origen == "paquetes"){
            datosReserva.secuenciaPaquetePaciente = dataCita.secuenciaPaquetePaciente
            datosReserva.itemPaquete = dataCita.detalleItemPaquete.itemPaquete;
            // if(dataCita.tratamiento){
                /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
                {{-- datosReserva.numeroOrden = dataCita.detalleItemPaquete.numeroOrden; --}}
                datosReserva.numeroOrden = null;
                {{-- datosReserva.codigoEmpOrden = dataCita.detalleItemPaquete.codigoEmpresaOrden; --}}
                datosReserva.codigoEmpOrden = 1;
                datosReserva.lineaDetalle = dataCita.detalleItemPaquete.lineaDetalleOrden;
            // }
        }
        
        if(dataCita.online == "N"){
            datosReserva.codigoSucursal = dataCita.central.codigoSucursal;
        }    

        /*Solo si tiene convenio seleccionado*/
        if(dataCita.convenio.codigoConvenio){
            datosReserva.codigoEmpConvenio = 1;
            datosReserva.codigoConvenio = dataCita.convenio.codigoConvenio;
            datosReserva.idCliente = dataCita.convenio.idCliente;
        }

        if(dataCita.tratamiento){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
        }

        if(dataCita.reservaEdit){
            /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
            datosReserva.numeroOrden = dataCita.reservaEdit.numeroOrden;
            datosReserva.codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden;
            datosReserva.lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden;
            datosReserva.codigoReservaCambio = dataCita.reservaEdit.idCita;
        }

        if(dataCita.sesion){
            datosReserva.secuenciaPlanTto = dataCita.sesion.secuenciaPlanTto;
            datosReserva.numeroSesion = dataCita.sesion.numeroSesion;
            datosReserva.tipoAtencion = dataCita.detalleSesion.tipoAtencion;
            datosReserva.tiempoSesion = dataCita.detalleSesion.tiempoSesion;
            datosReserva.numeroOrden = dataCita.sesion.idOrden;
            datosReserva.lineaDetalle = dataCita.sesion.lineaDetalleOrden
        }

        args["data"] = JSON.stringify(datosReserva);
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        {{-- return; --}}

        if (data.code == 200){
            dataCita.reserva = data.data;
            guardarData();
            if(dataCita.tratamiento && dataCita.tratamiento.esPagada == "S"){
                location.href = '/pago-realizado/{{ $mac }}';
                return;
            }
            if(data.data.permitePago == "S"){
                /*
                https://api-phantomx.veris.com.ec/${api_war}/v1/agenda/validarPermitePago?macAddress={{ $mac }}&canalOrigen=MVE_CMV&codigoUsuario=0926178534&tipoItem=C&codigoReserva=4222668939
                */
                // await crearPreTransaccion()
                let datosPago = {
					"reserva": {
						"codigoReserva": dataCita.reserva.codigoReserva
					}
				}
                if(dataCita.hasOwnProperty('agregadoCarrito') && dataCita.agregadoCarrito){
                    location.href = `/carrito/${mac}`;
                }else{
				    await agregarItem(datosPago, true);
                }
                //location.href = '/citas-datos-facturacion/{{ $mac }}';
            }else{
                location.href = '/pago-realizado/{{ $mac }}';

                {{-- if(dataCita.precio.valorCanalVirtual > 0){
                    location.href = '/pago-realizado/{{ $mac }}';
                }else{
                    let datosPago = {
                        "reserva": {
                            "codigoReserva": dataCita.reserva.codigoReserva
                        }
                    }
                    if(dataCita.hasOwnProperty('agregadoCarrito') && dataCita.agregadoCarrito){
                        location.href = `/carrito/${mac}`;
                    }else{
                        let addItem = await agregarItem(datosPago, true, true);
                        if(addItem.code != 200){
                            return;
                        }
                        await facturarActivarReserva();
                    }
                } --}}
            }
        }else{
            //guardarData();
            //location.href = '/citas-datos-facturacion/{{ $mac }}';
            alert(data.message);
        }
    }

    async function facturarActivarReserva(){
        let agrupacion = await obtenerAgrupaciones();
        let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/facturar?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "idAgrupacion": agrupacion
        });
        //args["dismissAlert"] = true;
        const data = await call(args);
        console.log(data);
        // $('#modalActivarChequeo').modal('hide')
        if(data.code == 200){
            location.href = '/pago-realizado/{{ $mac }}';
        }else{
            $('#modalError').modal('show')
            $('.titleError').html(`Ha ocurrido un error`)
            $('.msgError').html(data.message);
        }
    }

    async function crearPreTransaccion(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/facturacion/crear_pretransaccion?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        
        let idPaciente = dataCita.paciente.numeroPaciente;
        let tipoServicio = "CITA";
        let tipoSolicitud = null;

        let codigoConvenio;
        let secuenciaAfiliado;
        
        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            tipoServicio = "ORDEN";
            addPrestacionesToModal();
            $("#btn-ver-examenes").removeClass('d-none');
        }

        if(dataCita.ordenExterna){
            // addPrestacionesToModal();
            $('.modalDesglose-size').removeClass('modal-lg');
            $('.modalDesglose-size').addClass('modal-md');
            $("#btn-ver-examenes").removeClass('d-none');
            $('#modalDesglose .modal-header').hide();
            // idPaciente = dataCita.paciente.numeroPaciente;
            codigoConvenio = dataCita.ordenExterna.pacientes[0].codigoConvenio;
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                tipoServicio = "ORDEN";
                tipoSolicitud = "LAB";
            }else{
                //obtenerPreparacionPrevia();
                tipoServicio = "DOMICILIO";
                tipoSolicitud = "LAB";
            }
        }else{
            if(!dataCita.paquete){
                codigoConvenio = dataCita?.convenio.codigoConvenio;
                secuenciaAfiliado = dataCita?.convenio.secuenciaAfiliado;
            }
        }

        if(dataCita.paquete){
            tipoServicio = "PAQUETE";
        }

        if(dataCita.sesion){
            tipoServicio = "CITA_ODO";
        }

        //Consultar si idPaciente es del que hizo login o del beneficiario de lo que se va a pagar
        let dataPT = {
            "idPaciente":idPaciente,
            //"codigoPreTransaccion": dataCita.reserva.secuenciaTransaccion,
            "tipoServicio": tipoServicio,
            "tipoSolicitud": tipoSolicitud,
            "codigoConvenio": codigoConvenio,
            "secuenciaAfiliado": secuenciaAfiliado,
        }

        if(dataCita.dataOrdenExterna){
            dataPT.codigoPreTransaccion = dataCita.dataOrdenExterna.codigoPreTransaccion
        }

        if(dataCita.reserva){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reserva.codigoReserva
            }]
        }

        if(dataCita.paquete){
            dataPT.paquete = {
                "codigoPaquete": dataCita.paquete.codigoPaquete
            }
        }

        if(dataCita.reservaEdit){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reservaEdit.idCita
            }]
        }


        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            dataPT.listaOrdenes = dataCita.listadoPrestaciones;
        }

        if(dataCita.ordenExterna){
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                dataPT.listaOrdenes = dataCita.ordenExterna.pacientes[0].examenes;
            }else{
                dataPT.codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;
            }
        }

        if(dataCita.hasOwnProperty('detalle_pre_agendamiento')){
            dataPT.listaCitas = [];
            $.each(dataCita.detalle_pre_agendamiento, function(key, value){
                if(value.request.estaPagada == "N"){
                    dataPT.listaCitas.push({
                        "codigoReserva": value.response.codigoReserva
                    })
                }
            })
        }

        // console.log(dataPT);
        // return;

        args["data"] = JSON.stringify(dataPT);
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.preTransaccion = data.data;
            guardarData();
            location.href = '/citas-datos-facturacion/{{ $mac }}';
        }else{
            alert(data.message);
        }
    }

    function guardarData(){
        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
    }
</script>
</script>
@endsection