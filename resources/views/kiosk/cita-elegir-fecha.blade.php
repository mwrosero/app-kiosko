@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => url()->previous()])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Elige los datos de tu cita'])
	<!-- Contenido principal -->
	<!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Veris</h1>
                    <p class="fs--16 fw-normal text-veris mb-3" id="mensajeError" ></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal" id="btnEntiendoError">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error agenda multiple -->
    <div class="modal fade" id="modalErrorAgendaMultiple" tabindex="-1" aria-labelledby="modalErrorAgendaMultipleLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs-24 line-height-28 fw-medium mb-3">Veris</h1>
                    <p class="fs-18 line-height-22 fw-normal text-veris mb-3" id="mensajeErrorAM" ></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de informativo agenda multiple mismo dia -->
    <div class="modal fade" id="modalConsultaMismoDiaAgendaMultiple" tabindex="-1" aria-labelledby="modalConsultaMismoDiaAgendaMultipleLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs-24 line-height-28 fw-medium mb-3">Información</h1>
                    <p class="fs-18 line-height-22 fw-normal text-veris mb-3">Ya tienes una cita agendada para este día. ¿Quieres agendar otra para el mismo día?</p>
                    <input type="hidden" id="horarioElegido">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    
                    <div class="btn btn-lg btn-primary-veris w-100 m-0 mb-3 px-4 py-3 btn-aceptar-mismo-dia" data-bs-dismiss="modal">Sí, agendar</div>
                    <button type="button" class="btn btn-lg btn-outline-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal">Elegir otra fecha</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detalle agenda multiple -->
    <div class="modal fade" id="modaDetalleAgendaMultiple" tabindex="-1" aria-labelledby="modaDetalleAgendaMultipleLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Terapias seleccionadas</h1>
                    <p class="fs--16 fw-normal text-veris mb-3" id="detalleItems"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error validacion fecha -->
    <div class="modal fade" id="modalValidacionFecha" tabindex="-1" aria-labelledby="modalValidacionFechaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información de tu seguro</h1>
                    <p class="fs--1 fw-normal" id="msg-validacion-fecha"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal" id="btnEntiendoError">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal elegir horario -->
    <div class="modal bg-transparent fade" id="elegirHorarioModal" tabindex="-1" aria-labelledby="elegirHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                	<h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32 text-center">Horarios</h2>
                    <div id="listaHorariosMedico" class="row g-2" style="max-height: 700px; overflow-y: auto;">
                        {{-- <div class="card card-body rounded-3 position-relative py-2 mb-2">
                            <a href="{{route('citas.detalleCita')}}">
                                <div class="badge-discount-top fs--3 fw-medium"><span>{{ __('-30%') }}</span></div>
                                <p class="fs--2 text-royal-blue text-center my-1">08:00 - 08:20</p>
                                <div class="badge-discount-bottom fs--3 fw-medium"><span>{{ __('descuento') }}</span></div>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-sm text-royal-blue fs--18 line-height-24 fw-medium shadow-none m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal NO HAY FECHA DISPONIBLES -->
    <div class="modal fade" id="sinFechaDisponibles" aria-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
        <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
            <div class="modal-content rounded-8 rounded-24">
                <div class="modal-body px-64 py-24 text-center">
                    <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32">Atención</h2>
                    <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgError">No tiene fechas disponibles.</h3>
                    {{-- El usuario ingresado para los datos de facturación es menor de edad, para continuar, cambia los datos por los de un usuario mayor de edad --}}
                    <a href="{{ url()->previous() }}" class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-75">Entendido</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal no hay medicos disponibles -->
    <div class="modal fade" i|d="sinMedicosDisponibles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sinMedicosDisponiblesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <div class="text-center">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3" id="sinMedicosDisponiblesLabel">Veris</h1>
                        <p class="fs--16 fw-normal text-veris mb-3">No tiene médicos disponibles.</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="{{ url()->previous() }}" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Contenido principal -->
    <main class="flex-grow-1 d-flex flex-column">
        <div class="row g-3 flex-grow-1 mx-0 ">
            <div class="col-2 box-accesos-lateral">
                @include('components.access-bar', ['page' => 'cita-medica'])
            </div>
            <div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central mt-0 pt-74" style="overflow-y: auto;">
                <div class="row g-0 justify-content-center">
                    <div class="col-auto p-0 bg-transparent box-agendamiento-multiple d-none" style="min-width: 375px;">
                        <div class="w-100 p-2 d-flex justify-content-between align-items-center">
                            <span>Terapias seleccionadas</span>
                            <button type="button" class="text-royal-blue bg-transparent text-decoration-underline cursor-pointer border-0" data-bs-toggle="modal" data-bs-target="#modaDetalleAgendaMultiple">Ver detalle</button>
                        </div>
                        <div class="w-100 mt-0 py-3 text-center fs-18 fw-medium label-info-agenda-multiple text-capitalize bg-white"></div>
                    </div>
                </div>
                <div class="row g-0 justify-content-center bg-royal-blue-shade-40">
                    <div class="col-auto p-3 bg-dark-blue-veris-medium" style="min-width: 375px;">
                        <p class="text-center text-white fw-medium fs-26 line-height-34 m-0 text-capitalize" id="month-name"></p>
                        <div class="row g-0 d-flex" style="height: 85px;">
                            <div class="col-12">
                                <div class="calendar-container invisible p-0 mb-1 w-100">
                                    <span class="arrow mt-3" id="prev-week">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </span>
                                    <div class="calendar-header">
                                        <div class="week-container pt-4 mt-1" id="week-days"></div>
                                    </div>
                                    <span class="arrow mt-3" id="next-week">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center align-items-start h-100 mx-0">
                    {{-- <div class="col-12 h-100 mt-0 pt-56" style="overflow-y: auto; height: 60vh !important;"> --}}
                    <div class="col-12 h-100 mt-0 pt-56">
                        <div class="row" id="listaMedicos">
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
	let dataCita = JSON.parse(localStorage.getItem('agendamiento'));
	trackId = localStorage.getItem('trackId');

	let currentDate = new Date();
    const daysOfWeek = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'];

    // Variables globales
    let dataOrigen = dataCita?.origen;  
    let renderCalendarExternaFecha;
    let pacienteExternaSolicitud;
    let examenes;
    let online;
    let codigoEspecialidad;
    let codigoSucursal;
    let codigoServicio;
    let codigoPrestacion;
    let nombreSucursal;
    let nombreEspecialidad;
    let codigoSolicitud;
    let latitud;
    let longitud;
    let fechaOrdenExterna;
    let codigoZona;

    let esPlanStar;

    let firstRender = true;
    let numeroSemanaCurso;
    let numeroMesCurso;
    let numeroMesSeleccionado;

    if(dataOrigen == 'ordenExternaSolicitud'){
        console.log('No se puede seleccionar fecha y doctor para una cita de orden externa');
        examenes = dataCita.ordenExterna.pacientes[0].examenes;
        pacienteExternaSolicitud = dataCita.ordenExterna;
        online = dataCita.online;
        codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;    
        latitud = dataCita.ordenExterna.latitud;
        longitud = dataCita.ordenExterna.longitud;
        codigoZona = dataCita.ordenExterna.codigoZona;
    } else {
        online = dataCita?.online;
        codigoEspecialidad = dataCita?.especialidad.codigoEspecialidad;

        if(dataOrigen == 'doctorFavorito'){
            codigoSucursal = dataCita?.especialidad.codigoSucursal;
        }else if (dataCita?.central){
            codigoSucursal = dataCita?.central.codigoSucursal;
        }else {
            codigoSucursal = ""
        }
        esPlanStar = dataCita?.convenio.esPlanStar || 'false';
        codigoServicio = dataCita?.especialidad.codigoServicio || ' ';
        codigoPrestacion = dataCita?.especialidad.codigoPrestacion || ' ';
        nombreSucursal = dataCita?.central?.nombreSucursal || ' ';
        nombreEspecialidad = dataCita?.especialidad.nombre || ' ';
    }
    
    let _fechaSeleccionada;
    // const daysOfWeek = ["D", "L", "M", "M", "J", "V", "S"];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearElement = document.getElementById('month-year');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    // let currentDate = new Date();
    numeroSemanaCurso = getWeekCurrent(currentDate);
    numeroMesCurso = currentDate.getMonth() + 1;
    numeroMesSeleccionado = numeroMesCurso;
    let fechasDisponibles = []; // Variable global para almacenar las fechas disponibles*/

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        $('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
        // if((dataCita.central && dataCita.central.codigoTipoSucursal == "CAP") || dataCita.hasOwnProperty('detalleItemPaquete')){

        if(dataCita.hasOwnProperty('items')){
            $('.box-agendamiento-multiple').removeClass('d-none');
            if(dataCita.hasOwnProperty('detalle_multiple')){
                $('.label-info-agenda-multiple').html(dataCita.items[dataCita.position].nombreServicio.toLowerCase());
            }else{
                $('.label-info-agenda-multiple').html(dataCita.items[0].nombreServicio.toLowerCase());
            }

            let elemsDetalle = ``;

            $.each(dataCita.items, function(key, value){
                let fechaAgendada = ``;
                if(dataCita.hasOwnProperty('detalle_multiple') && dataCita.detalle_multiple[key] !== undefined){
                    console.log(key)
                    console.log(dataCita.detalle_multiple[key])
                    fechaAgendada = `<p class="fs-18 line-height-22 fw-medium mb-0 flex-grow-1 text-end text-royal-blue">${dataCita.detalle_multiple[key].diaHora}</p>`
                }
                elemsDetalle += `<div class="d-flex w-100 justify-content-between align-items-center border-bottom py-2">
                    <p class="text-capitalize mb-0">${ value.nombreServicio.toLowerCase() }</p>
                    ${ fechaAgendada }
                </div>`;
            })

            $('#detalleItems').html(elemsDetalle)
        }

        if((dataCita.central && dataCita.central.codigoTipoSucursal == "CAP")){
            $('#nombreFiltro').addClass('d-none');
            $('#pills-tab').addClass('d-none');
            $('#listaMedicos').addClass('pt-3');
        }else{
            $('#nombreFiltro').removeClass('d-none');
            $('#pills-tab').removeClass('d-none');
        }
        if (dataCita.origen == 'ordenExternaSolicitud') {
            //renderCalendarExterna();
            fechasDisponibles = await obtenerFechasOrdenesExternas();
            //await renderCalendar();
            await renderWeek();
            // $('.dias-calendario').addClass('d-none');
            // $('.semana-'+numeroSemanaCurso).removeClass('d-none');
            let listaMedicos = $('#listaMedicos');
            listaMedicos.empty();
            $.each(dataCita.ordenExterna.pacientes, function(key, paciente){
                llenarListaExamenes(paciente, '#listaMedicos');
            })
            // setear titulo fecha doctor
            $('#btnAgendarOrdenExterna').removeClass('d-none');
            document.getElementById('nombreFiltro').innerHTML = 'Exámenes';
            $('#pills-tab').addClass('d-none');
        } else {
            await consultarFechasDisponibles();
            // renderWeek();
        }

        // Deshabilitar la navegación hacia atrás
        $('#prev-week').click(function() {
            const today = new Date();
            if (currentDate > today) {
                currentDate.setDate(currentDate.getDate() - 7);
                renderWeek();
            }
        });

        $('#next-week').click(function() {
            currentDate.setDate(currentDate.getDate() + 7);
            renderWeek();
        });

        $('body').on('click', '.day', async function(){
            $('.day').removeClass('selected-day');
            $(this).addClass('selected-day');
            let fechaSeleccionada = $(this).attr("fechaSeleccionada-rel");
            /*if (fechasDisponibles.includes(fechaSeleccionada)) {
                if(!$(this).hasClass('unavailable-day')){
                    if (!dataCita.origen || dataCita.origen != 'ordenExternaSolicitud'){
                        await consultarMedicos(fechaSeleccionada);
                    }
                }
            }*/
            if (!dataCita.origen || dataCita.origen != 'ordenExternaSolicitud'){
                await consultarMedicos(fechaSeleccionada);
            }
        })

        //renderWeek();

        $('body').on('click','.options-date', async function(){
            // let fechaSeleccionada = $('.selected-day').attr("fechaSeleccionada-rel");
            await consultarMedicos();
        })

        $('body').on('click','.btn-disponibilidad-medico', async function(){
            let horario = JSON.parse($(this).attr("data-horario"));
            dataCita.horario = horario; 
            if(dataCita.hasOwnProperty('items')){
                let esMismoDia = await validarMismoDia(horario);
                if(esMismoDia){
                    $('#horarioElegido').val($(this).attr("data-horario"))
                    $('#modalConsultaMismoDiaAgendaMultiple').modal('show');
                }else{
                    await preReservar(horario);
                }
            }else{
                let ruta = "/citas-revisa-tus-datos/" + "{{ $mac }}";
                if(dataCita.central && dataCita.central.codigoTipoSucursal == "CAP"){
                    ruta = "/cita-urgencias-ambulatorias/" + "{{ $mac }}";
                }
                localStorage.setItem('agendamiento', JSON.stringify(dataCita));
                window.location.href = ruta;
            }
        })
        $('body').on('click','.btn-aceptar-mismo-dia', async function(){
            let horario = JSON.parse($('#horarioElegido').val());
            dataCita.horario = horario;
            await preReservar(horario);
        })

        $('body').on('click','.btn-disponibilidad-medico-all', function(){
            let data = $(this).attr("data-rel")
            consultarDisponibilidadMedico(data, true);
        })
        // Listener para seleccionar un horario
        $('body').on('click', '.card-horario', function () {
            let horario = $(this).data('horario');
            if (dataCita.origen == 'ordenExternaSolicitud') {
                guardarHorarioEnDataCitaExterna(horario)
            }else{
                guardarHorarioEnDataCita(horario);
            }
        });

        // btnEntiendoError redirecciona a la página inicial
        $('#btnEntiendoError').click(function(){
            if(!dataCita.ordenExterna){
                window.location.href = "/menu/{{ $mac }}";
            }
        });

        // btnAgendarServicioOrdenExterna llama a la función consultarHorasMotorizados  
        $('#btnAgendarServicioOrdenExterna').click(async function(){
            let data = await consultarHorasMotorizados();        
        });
    });

    async function validarMismoDia(horario){
        console.log(horario);
        let fecha = horario.dia2;
        // $.each(dataCita.detalle_multiple, function(key,value){
        //     console.log(value)
        //     if(value.dia2 == fecha){
        //         console.log("BINGO")
        //         return true;
        //     }
        // })
        // return false;
        return (dataCita.hasOwnProperty('detalle_multiple')) ? dataCita.detalle_multiple.some(item => item.dia2 === fecha) : false;
    }

    async function preReservar(horario){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/reservarPrecio?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        //args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";

        // let aplicaCredito = "N";
        let aplicaProntoPago = "N";
        let medPayPlan = null;
        let esParticular = "N";
        if(dataCita.convenio.hasOwnProperty('informacionExternaPlan')){
            medPayPlan = dataCita.convenio.informacionExternaPlan;
        }

        if(dataCita.convenio.idCliente === null){
            esParticular = "N";
        }

        if(dataCita.convenio){
            // aplicaCredito = dataCita.convenio.aplicaPagoDigitalObligatorio;
            aplicaProntoPago = dataCita.convenio.aplicaPagoDigitalObligatorio;
        }

        let tipoIdentificacion = parseInt(dataCita.paciente.tipoIdentificacion);
        if (isNaN(tipoIdentificacion)) {
            tipoIdentificacion = parseInt(dataCita.paciente.codigoTipoIdentificacion);
        }

        let estaPagada = dataCita.items[dataCita.position].esPagada;
        
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
            "codigoServicio": dataCita.especialidad.codigoServicio,
            "canalOrigenAgendamiento": "MVE",
            "codigoEmpresaRegistro": null,
            "codigoSucursalRegistro": null,
            "porcentajeDescuento": dataCita.horario.porcentajeDescuento,
            "permitePago": dataCita.convenio.permitePago,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
            "canalOrigen": _canalOrigen,
            "enviarLinkPago": null,
            // "valorizacion": dataCita.precio.valorCanalVirtual,
            /*precio o reagendamiento*/
            // "secuenciaTransaccion": dataCita.precio.secuenciaTransaccion,
            // "valorCita": dataCita.precio.valorCanalVirtual,
            // "valorDescuento": dataCita.precio.valorDescuento,
            // "valorSubtotalCita": dataCita.precio.valor,
            // "numeroAutorizacion": dataCita.precio.numeroAutorizacion,
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "fechaSeleccionada": dataCita.horario.dia2,
            /*Si estoy modificando/tratamiento o sino N*/
            "estaPagada": estaPagada,
            "tipoProcesoVUA": null,
            "medPayPlan": medPayPlan,
            "itemPaquete": null,
            "secTarjeta": null,
            "secTarXPaciente": null,
            "secuenciaPaquetePaciente": null,
            "secuenciaTransaccion": null,
            "esParticular": esParticular,
            // "aplicaCredito": aplicaCredito,
            //"aplicaProntoPago": aplicaProntoPago,
            "cantidad": dataCita.items[dataCita.position].cantidad
        }

        if(dataCita.esEdicion && dataCita.detalleEdicion.estado == "Caducado"){
            datosReserva.codigoReservaCambio = dataCita.detalleEdicion.codigoReserva;
            datosReserva.secuenciaTransaccion = dataCita.detalle_pre_agendamiento[dataCita.position].response.secuenciaTransaccion;
        }

        if(dataCita.esEdicion && dataCita.detalleEdicion.estado == "Disponible"){
            datosReserva.codigoReservaCambio = dataCita.detalleEdicion.codigoReserva;
        }

        if(dataCita.online == "N"){
            datosReserva.codigoSucursal = dataCita.central.codigoSucursal;
        }  

        if(dataCita.convenio.codigoConvenio){
            // datosReserva.codigoEmpConvenio = 1;
            datosReserva.codigoConvenio = dataCita.convenio.codigoConvenio;
            datosReserva.idCliente = dataCita.convenio.idCliente;
        }

        if(dataCita.tratamiento){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                datosReserva.numeroOrden = dataCita.items[dataCita.position].numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.items[dataCita.position].codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.items[dataCita.position].lineaDetalleOrden;
            }
        }

        if(dataCita.origen == "paquetes"){
            if(dataCita.items[dataCita.position].hasOwnProperty('numeroOrden') && dataCita.items[dataCita.position].numeroOrden !== null){
                datosReserva.numeroOrden = dataCita.items[dataCita.position].numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.items[dataCita.position].codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.items[dataCita.position].lineaDetalleOrden;
            }else{
                datosReserva.secuenciaPaquetePaciente = dataCita.secuenciaPaquetePaciente
                datosReserva.itemPaquete = dataCita.items[dataCita.position].itemPaquete;
                // if(dataCita.tratamiento){
                    /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
                    // datosReserva.numeroOrden = dataCita.detalleItemPaquete.numeroOrden;
                    datosReserva.codigoEmpOrden = dataCita.items[dataCita.position].codigoEmpresaOrden;
                    // datosReserva.lineaDetalle = dataCita.detalleItemPaquete.lineaDetalleOrden;
                // }
            }
        }

        args["bodyType"] = "json";
        args["data"] = JSON.stringify(datosReserva);

        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            if(dataCita.esEdicion){
                dataCita.detalle_pre_agendamiento[dataCita.position] = {
                   "request": datosReserva,
                   "response": data.data 
                };
                dataCita.detalle_multiple[dataCita.position] = horario;
                localStorage.setItem('agendamiento', JSON.stringify(dataCita));
                
                location.href = "/citas-revisa-tus-datos/" + "{{ $mac }}";
            }else{
                if(!dataCita.hasOwnProperty('detalle_multiple')){
                    console.log(horario)
                    dataCita.detalle_multiple = [];
                }
                if(!dataCita.hasOwnProperty('detalle_pre_agendamiento')){
                    dataCita.detalle_pre_agendamiento = [];
                }
                dataCita.position = dataCita.position + 1;
                dataCita.detalle_pre_agendamiento.push({
                   "request": datosReserva,
                   "response": data.data 
                });
                dataCita.detalle_multiple.push(horario);
                localStorage.setItem('agendamiento', JSON.stringify(dataCita));
                
                location.href = "/detalle-agenda-multiple/" + "{{ $mac }}";
            }
        }else{
            $('#mensajeErrorAM').html(data.message)
            $('#modalErrorAgendaMultiple').modal('show');
        }
    }

    async function renderWeek() {
        const weekDaysContainer = $('#week-days');
        weekDaysContainer.empty();

        // Obtener la fecha actual y establecerla como el primer día a mostrar
        const firstDayOfWeek = new Date(currentDate);
        firstDayOfWeek.setHours(0, 0, 0, 0); // Eliminamos la parte de horas para comparar solo la fecha

        $('#month-name').text(firstDayOfWeek.toLocaleDateString('es-ES', { month: 'long' }));

        // Generar los días de la semana a partir del día actual
        for (let i = 0; i < 7; i++) {
            const day = new Date(firstDayOfWeek);
            day.setDate(firstDayOfWeek.getDate() + i); // Incrementamos para cada día

            const today = new Date();
            today.setHours(0, 0, 0, 0); // Comparación solo de fecha
            const isToday = day.toDateString() === today.toDateString();

            // Formatear la fecha como dd/mm/yyyy para la comparación
            const formattedDate = day.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            // Verificar si la fecha está en fechasDisponibles
            const isAvailable = fechasDisponibles.includes(String(formattedDate));
            console.log(formattedDate,isAvailable);
            const unavailableClass = '';
            // const unavailableClass = isAvailable ? '' : 'unavailable-day';
            const todayLabel = isToday ? '<div class="today-label fw-light fs-18 line-height-22">Hoy</div>' : '';

            // Crear el elemento del día
            const dayElement = $(`
                <div fechaSeleccionada-rel='${formattedDate}' class="day ${isToday ? 'selected-day' : ''} ${unavailableClass}">
                    ${todayLabel}
                    <span class="d-block fs-22 line-height-26">${daysOfWeek[day.getDay()]}</span>
                    <span class="d-block fs-22 line-height-26">${day.getDate()}</span>
                </div>
            `);

            weekDaysContainer.append(dayElement);
        }
        $('.calendar-container').removeClass('invisible');
    }

    async function validacionFecha(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/comercial/validacionFecha?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        //args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "fechaSeleccionada": $('.selected-day').attr("fechaSeleccionada-rel")
        });
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            if(data.data.mensajeValidacion1 != null){
                //mostrar mensaje
                if(data.data.aplicaCondicionesSeguro){
                    $('.box-disponibilidad').empty();
                }
                let msg = data.data.mensajeValidacion1+"<br>"+data.data.mensajeValidacion2;
                $('#msg-validacion-fecha').html(msg.replace(/\*(.*?)\*/g, '<b class="text-royal-blue">$1</b>'));
                $('#modalValidacionFecha').modal("show");
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    async function obtenerFechasOrdenesExternas(){
        var fechas = [];
        var fechaActual = new Date();
        fechaActual.setDate(fechaActual.getDate() + 1); // Empezar desde el día siguiente al actual
        for (var i = 0; i < 30; i++) { // Generar los próximos 15 días
            var dia = fechaActual.getDate();
            var mes = fechaActual.getMonth() + 1;
            var año = fechaActual.getFullYear();
            var fechaFormateada = (dia < 10 ? '0' : '') + dia + '/' + (mes < 10 ? '0' : '') + mes + '/' + año;
            fechas.push(fechaFormateada); // Añadir la fecha al array
            fechaActual.setDate(fechaActual.getDate() + 1); // Incrementar la fecha para el siguiente día
        }
        return fechas;
    }

    async function consultarFechasDisponibles(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/fechasdisponibles?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&idMedico=${codigoMedico}&esPlanStar=${esPlanStar}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);

        if (data.code == 200){
            fechasDisponibles = data.data; // Almacenar las fechas disponibles en la variable global
            let elemento = '';

            if(data.data.length > 0){
                _fechaSeleccionada = fechasDisponibles[0];
                await renderWeek();
                $('.dias-calendario').addClass('d-none');
                $('.semana-'+numeroSemanaCurso).removeClass('d-none');
                await consultarMedicos();
            } else {
                await renderWeek();
                $('#titleNoDisponibilidad').html(data.message);
                $('#sinFechaDisponibles').modal('show');
                /* Mostrar la modal cuando No hay fecha disponibles. */
                console.log("No hay fechas disponibles");
            }
            
            listaEspecialidades.append(elemento);    
        } else if (data.code != 200){
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }

        return data;
    }

    async function consultarMedicos(){
        console.log("-------------------------");
        let fechaSeleccionada = $('.selected-day').attr("fechaSeleccionada-rel");
        console.log("-------------------------");
        console.log(fechaSeleccionada);
        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
            let data = $(this).attr("data-rel");
            let necesitaValidacionFecha = await validacionFecha();
            console.log(necesitaValidacionFecha)
            if(necesitaValidacionFecha){
                $('#listaMedicos').empty();
                return;
            }
        }

        
        let soloDescuento = $('.options-date.active').attr("data-rel");
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        // console.log(fechaSeleccionada);

        let bloques = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            bloques = dataCita.tratamiento.cantidadIntervalosReserva
        }


        let urlAdicionales = ``;
        if(dataCita.convenio.hasOwnProperty('idCliente') && dataCita.convenio.idCliente !== null){
            urlAdicionales = `&codigoCliente=${dataCita.convenio.codigoCliente}&secuenciaAfiliado=${dataCita.convenio.secuenciaAfiliado}&codigoConvenio=${dataCita.convenio.codigoConvenio}`;
        }
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/medicos/horarios?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent($('.selected-day').attr("fechaSeleccionada-rel"))}&esPlanStar=${esPlanStar}&mostrarDisponibilidad=S&idPaciente=${dataCita.paciente.pacPacNumero}&soloDescuento=${soloDescuento}&bloques=${bloques}${urlAdicionales}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        let listaMedicos = $('#listaMedicos');
        listaMedicos.empty();
        let newArrayCard;
        if(codigoMedico != ""){
            newArrayCard = data.data.filter(item => item.codigoMedico === parseInt(codigoMedico))
        }else{
            newArrayCard = data.data;
        }
        console.log(newArrayCard)
        if (data.code == 200){
            let elemento = '';
            if(newArrayCard !== null && newArrayCard.length > 0){
                newArrayCard.forEach((medico) => {
                    let img_doctor = (medico.imagen != null) ? medico.imagen : '{{ asset('assets/img/svg/avatar_doctor.svg') }}';

                    if(dataCita.central && dataCita.central.codigoTipoSucursal == "CAP"){
                        elemento += `<div class="card shadow-none mt-3">
                            <div class="card-body p--2">
                                <div class="row g-2">
                                    <div class="col-3 text-center">
                                        <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                    </div>
                                    <div class="col-9">
                                        <h6 class="fs-14 line-height-16 fw-medium mb-1">Dr(a) ${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                        <p class="text-royal-blue fs-18 line-height-22 fw-medium mb-1">${capitalizarCadaPalabra(nombreSucursal)}</p>
                                        <p class="fs-18 line-height-22 fw-normal mb-1" style="color: 33D4E66;">${capitalizarCadaPalabra(nombreEspecialidad)}</p>
                                        <div class="d-flex mb-1">
                                            <p class="fs-18 line-height-22 fw-normal mb-0 me-1" style="color: #9EA7B3;">Disponibilidad:</p>
                                            <p class="fs-18 line-height-22 fw-normal mb-0" style="color: #0055AA;" id="disponibilidad">${medico.disponibilidad}</p>
                                        </div>
                                        <p class="fs-18 line-height-22 fw-normal mb-1" style="color: #9EA7B3;">Horarios: <b class="fw-normal" style="color: #0055AA;" id="horarios">${medico.horario}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end pt-0 pb--2 px--2">
                                <button type="button" class="btn btn-sm btn-primary-veris btn-disponibilidad-medico-all fs-18 line-height-22 fw-medium border-0 m-0 px-3 py-2" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                    Elegir Cita
                                </button>
                            </div>
                        </div>`;
                    }else{
                        let listadoHorarios = ``;
                        let cantidadMaxListado = (medico.intervalos.length >= 3) ? 3 : 1;
                        $.each(medico.intervalos, function(k,v){
                            if(k < cantidadMaxListado){
                                listadoHorarios += drawHorarioMedico(v);
                            }else{
                                return false;
                            }
                        })

                        //${ (dataCita.online == "N") ? `<p class="text-royal-blue fs-18 line-height-22 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}

                        let esMedicoAnterior = (medico.esMedicoAnterior == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-cita-atendida d-flex justify-content-between align-items-center gap-1 ${ (medico.esFavorito == "S") ? `flex-grow-1` : `` } me-2">
                                            <i class="fa-solid fa-clock" style="color:#2F7833;"></i>
                                            <span class="fw-normal fs--2" style="color:#2F7833;">Te atendiste con este doctor</span>
                                        </div>` : ``;
                        
                        let esFavorito = (medico.esFavorito == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-fav-atendida">
                                            <i class="fa-solid fs--2 fa-heart" style="color:#D84315;"></i>
                                        </div>` : ``;

                        elemento += `<div class="border-light-sky-blue-tint-60 rounded-8 px-3 py-32 mb-3 d-flex justify-content-center align-items-start gap-4">
                            <div class="header-doctor d-flex justify-content-between align-items-start mb-3" style="flex: 0 0 40% !important; max-width: 40% !important;">
                                <div class="picture-doctor border-box-light-blue border-3 rounded-circle" style="background: url(${img_doctor}) no-repeat top center;background-size: cover;">
                                </div>
                                <div class="content-doctor ms-2">
                                    <div class="name-rate d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fs-20 line-height-24 fw-medium flex-grow-1 m-0">${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                        <div class="star-box text-center ms-1" style="width: 36px">
                                            <i class="fa-solid fa-star fw-bold star-ico fs-32 d-block"></i>
                                            <span class="d-block fw-normal fs-14 line-height-16 mt-1 rate-label">5.0</span>
                                        </div>
                                    </div>
                                    ${ (dataCita.online == "N") ? `<p class="text-royal-blue fs-16 line-height-22 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}
                                    <p class="fs-16 line-height-22 fw-normal mb-1 text-silver-neutral-80">${capitalizarCadaPalabra(nombreEspecialidad)}</p>
                                    <div class="info-adicional-medico d-flex justify-content-between align-items-center">
                                        ${esMedicoAnterior}
                                        ${esFavorito}
                                    </div>
                                </div>
                            </div>
                            <div class="border-start-silver-neutral-40 mx-2 h-100"></div>
                            <div class="dates-doctor flex-grow-1">
                                <p class="fs-18 line-height-22 fw-medium mb-2 text-royal-blue">Horario más próximo:</p>
                                <div class="row g-2">
                                    ${listadoHorarios}
                                    <div class="col-6">
                                        <div class="cursor-pointer waves-effect p-3 w-100 bg-time-doctor-alt rounded-3 d-flex justify-content-center align-items-center btn-disponibilidad-medico-all" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                            <span class="fs-16 line-height-20 text-center mb-0">Ver más horarios</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                })
            }else{

                /* Mostrar la modal cuando No hay médicos disponibles. */
                console.log("No hay médicosS disponibles");
                let nohayHorarios = $('#listaMedicos');
                let elementoHorarios = '';
                let str = ($('.options-date.active').attr("data-rel") == "N") ? `No hay médicos disponibles este día.` : `Lo sentimos, no hay horarios con<br>descuento disponibles para este día.`;
                let img = ($('.options-date.active').attr("data-rel") == "N") ? `{{ asset('assets/img/svg/sin_medicos.svg') }}` : `{{ asset('assets/img/svg/sin_horarios.svg') }}`;
                elementoHorarios += `<div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <p class="fw-medium fs--16 line-height-24 text-veris">${str}</p>
                                                <img src="${img}" class="img-fluid mb-3" alt="">
                                            </div>
                                        </div>
                                    </div>`;
                nohayHorarios.append(elementoHorarios);
                
            }

            listaMedicos.append(elemento);    
        }
        return data;
    }

    function drawHorarioMedico(horario, size = 6, isPopup = false){        
        let aditionalClass = `box-badge-discount-time`;
        let esAuto = ``;
        let elem = ``;
        if(isPopup){
            esAuto = `mx-auto`;
            aditionalClass = `box-badge-discount-time-popup`;
            elem += `<div class="box-badge-discount-time-popup-label position-absolute">
                <span class="badge-discount-time position-absolute fs-14 line-height-16 fw-medium">descuento</span>
            </div>`;
        }

        // if(horario.porcentajeDescuento > 0 && !dataCita.hasOwnProperty('detalleItemPaquete')){
        if(horario.porcentajeDescuento > 0 ){
            return `<div class="col-${size}">
                <div class="cursor-pointer waves-effect btn-disponibilidad-medico p-3 w-100 bg-time-doctor box-time-doctor-with-discount position-relative rounded-3 d-flex justify-content-end align-items-center" data-horario='${JSON.stringify(horario)}'>
                    <div class="${aditionalClass} position-absolute">
                        <span class="badge-discount-time position-absolute fs-14 line-height-16 fw-medium">-${horario.porcentajeDescuento}%</span>
                    </div>
                    <span class="fs-18 line-height-20 text-center mb-0 ${esAuto}">${horario.horaInicio} - ${horario.horaFin}</span>
                    ${elem}
                </div>
            </div>`;
        }else{
            return `<div class="col-${size}">
                <div class="cursor-pointer waves-effect btn-disponibilidad-medico p-3 w-100 bg-time-doctor rounded-3 d-flex justify-content-center align-items-center" data-horario='${JSON.stringify(horario)}'>
                    <span class="fs-18 line-height-20 text-center mb-0">${horario.horaInicio} - ${horario.horaFin}</span>
                </div>
            </div>`;
        }
    }

    async function consultarDisponibilidadMedico(dataMedico, esPopup = false){
        let medico = JSON.parse(dataMedico);
        let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let listaHorariosMedico = $('#listaHorariosMedico');
        listaHorariosMedico.empty();
        let bloques = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            bloques = dataCita.tratamiento.cantidadIntervalosReserva
        }

        let argsSesion = '';
        if(dataCita.sesion){
            argsSesion = `&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}&tiempoSesion=${dataCita.detalleSesion.tiempoSesion}&tipoAtencion=${dataCita.detalleSesion.tipoAtencion}`;
        }
        let urlAdicionales = ``;
        if(dataCita.convenio.hasOwnProperty('idCliente') && dataCita.convenio.idCliente !== null){
            urlAdicionales = `&codigoCliente=${dataCita.convenio.codigoCliente}&secuenciaAfiliado=${dataCita.convenio.secuenciaAfiliado}&codigoConvenio=${dataCita.convenio.codigoConvenio}`;
        }
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/agenda/medicos/disponibilidad?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}&filtroIntervalos=SOLO_DISPONIBLES&idMedico=${medico.codigoMedico}&esPlanStar=${esPlanStar}&bloques=${bloques}${argsSesion}${urlAdicionales}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(7,data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((horario) => {
                    elemento += drawHorarioMedico(horario,12, esPopup);
                })
            } else {
                elemento += `<div class="card card-horario card-body rounded-3 position-relative py-3 mb-2>
                    <p class="fs-14 line-height-16 text-royal-blue text-center mb-0">${data.message}</p>
                </div>`;
            }
            
            listaHorariosMedico.append(elemento);    
        }

        return data;
    }

    function guardarHorarioEnDataCita(horario) {
        dataCita.horario = horario;
        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
    }

    // llenar lista de medicos con examenes
    function llenarListaExamenes(paciente, idElement) {
        let elemento = '';

        // Limitar la lista de exámenes a mostrar inicialmente
        const examenesLimitados = paciente.examenes.slice(0, 3);
        const mostrarVerTodo = paciente.examenes.length > 3;

        // Construir el contenido inicial de la lista, separando el nombre del paciente
        elemento += `
            <div class="card-body p-2">
                <div class="examenLista">
                    <h6 class="fw-medium mb-0">${paciente.nombrePacienteOrden}</h6>
                    <div class="listaExamenes">
                        ${examenesLimitados.map(examen => `
                            <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                        `).join('')}
                        ${mostrarVerTodo ? '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo" paciente-rel="'+paciente.numeroIdentificacion+'">Ver todo</p>' : ''}
                    </div>
                </div>
            </div>
        `;

        $(idElement).append(elemento);

        // Delegar el evento clic desde el elemento #listaMedicos para manejar "Ver todo" y "Ver menos"
        $('#listaMedicos').off('click', '.ver-todo').on('click', '.ver-todo', function() {
            const isExpanded = $(this).hasClass('expanded');
            $(this).toggleClass('expanded');

            if (!isExpanded) {
                // Mostrar todos los exámenes
                const fullExamenesList = examenes.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(fullExamenesList + '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo expanded">Ver menos</p>');
            } else {
                // Volver a mostrar solo los exámenes limitados
                const limitedExamenesList = examenesLimitados.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(limitedExamenesList + '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo">Ver todo</p>');
            }
        });
    }

    async function obtenerPreparacionPrevia(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/domicilio/laboratorio/preparacionPrevia?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&codigoSolicitud=${ dataCita.ordenExterna.codigoSolicitud }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            //dataCita.facturacion = data.data;
            //mostrarInfo();
        }
    }

    function getWeekCurrent(){
        var onejan = new Date(currentDate.getFullYear(),0,1);
        var millisecsInDay = 86400000;
        return Math.ceil((((currentDate - onejan) /millisecsInDay) + onejan.getDay()+1)/7);
    }

    function getWeek(dateString) {
        var parts = dateString.split('/');
    
        // Asegurarse de que hay 3 partes (día, mes, año)
        if (parts.length !== 3) {
            throw new Error("Formato de fecha incorrecto. Debe ser dd/mm/yyyy");
        }
        
        // Convertir las partes en números enteros
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1; // Restar 1 al mes porque en JavaScript los meses van de 0 a 11
        var year = parseInt(parts[2], 10);
        
        // Crear y devolver el objeto Date
        let date = new Date(year, month, day);
        var onejan = new Date(date.getFullYear(),0,1);
        var millisecsInDay = 86400000;
        return Math.ceil((((date - onejan) /millisecsInDay) + onejan.getDay()+1)/7);
    }

    // consultar horas de motorizados
    async function consultarHorasMotorizados() {
        //let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war}/domicilio/laboratorio/disponibilidad?macAddress={{ $mac }}&canalOrigen=${_canalOrigen}&codigoSolicitud=${codigoSolicitud}&latitud=${latitud}&longitud=${longitud}&fecha=${$('.selected-day').attr("fechaSeleccionada-rel")}&codigoZona=${codigoZona}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        //args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";
        // args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log('consultarHorasMotorizados', data);
        
        if (data.code == 200){
            let elemento = '';
            let listaHorariosMedico = $('#listaHorariosMedico');
            listaHorariosMedico.empty();
            if(data.data.length > 0){
                data.data[0].horario.forEach((horario) => {
                    console.log("si hay fechas disponibles");
                    let params = {};
                    //params.medico = medico;
                    dataCita.horario = horario;
                    let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    let ruta = "/confirmacion-cita/" + "{{ $mac }}";
                    elemento += `<a href="${ruta}">
                        <div class="card card-horario card-body rounded-3 position-relative py-3 mb-2 btn-disponibilidad-medico" data-horario='${JSON.stringify(horario)}'>`;
                    
                    elemento += `<p class="fs-14 line-height-16 text-royal-blue text-center mb-0">${horario.rangoAtencion}</p>`;
                    
                    elemento += `</div>
                        </a>`;
                })
                // abrir modal de horarios
                $('#elegirHorarioModal').modal('show');
            } else {
                console.log("No hay fechas disponibles");
            }
            
            listaHorariosMedico.append(elemento);    
        } else if (data.code != 200){
            $('#mensajeError').html(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
        return data;
    }

    // guardarHorarioEnDataCitaExterna 
    function guardarHorarioEnDataCitaExterna(horario) {
        let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        dataCita.horario = horario;
        dataCita.fecha = fechaSeleccionada;
        localStorage.setItem('agendamiento', JSON.stringify(dataCita));
    }

</script>
<style>
	.label-info-agenda-multiple{
	    border: 1px solid var(--bg-vris-very-dark-blue-medium);
	    border-top-left-radius: 8px;
	    border-top-right-radius: 8px;
	    color: var(--bg-vris-very-dark-blue-medium);
	}
	.examenLista {
	    /*width: Hug (343px);
	    height: Hug (124px);*/
	    width: 343px;
	    {{-- height: 124px; --}}
	    height: auto;
	    padding: 12px;
	    border-radius: 8px;
	    gap: 8px;
	    box-shadow: 0px 4px 8px 0px #0000001A;
	    border: 1px solid #E7E9EC;
	    
	}
	.calendar-container {
	    color: white;
	    display: flex;
	    align-items: center;
	    justify-content: space-between;
	    max-height: 66px;
	}
	.calendar-content {
	    text-align: center;
	    flex-grow: 1;
	}
	.week-container {
	    display: flex;
	    gap: 0.25rem;
	    overflow: hidden;
	}
	.day {
	    border: 2px solid #E7E9EC;
	    background-color: white;
	    color: #13243F;
	    border-radius: 12px;
	    padding: 12px 8px !important;
	    text-align: center;
	    width: 62px;
	    cursor: pointer;
	    position: relative;
	    margin: 0 6px;
	}
	.day.selected-day {
	    background-color: #0071CE;
	    color: #fff;
	    /*font-weight: bold;*/
	}
	.today-label {
	  position: absolute;
	  top: -1.8rem; /* Ajusta el espacio para que se muestre encima */
	  left: 50%;
	  transform: translateX(-50%);
	  color: #fff; /* Color amarillo para destacar */
	  font-family: var(--font) !important;
	}
	.arrow {
	    color: white;
	    font-size: 1.25rem;
	    text-align: center;
	    width: 24px;
	    height: 24px;
	    cursor: pointer;
	}
	#pills-tab .active .badge-icon-selected path{
	    fill: #fff !important;
	}
	.picture-doctor{
	    width: 88px;
	    height: 88px;
        flex: 0 0 auto;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
	}
	.star-ico{
	    color: #FFC107;
	}
	.rate-label{
	    color: #13243F;
	}
	.bg-cita-atendida{
	    background: #B9F6CA;
	}
	.bg-fav-atendida{
	    background: #FBE9E7;
	}
	.bg-time-doctor{
	    background: #EAF0FD;
	}
	.bg-time-doctor-alt{
	    background: #A9C4F9;
	}
	.box-badge-discount-time {
	    top: 0px;
	    left: 0px;
	    height: 100%;
	    width: 44px;
	    background: #FFE5EF;
	    border-radius: 0px 0px 32px 0px;
	}
	.badge-discount-time {
	    position: absolute;
	    top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    height: 20px;
	    width: 80px;
	    margin: auto;
	    text-align: center;
	    color: #EF2E79;
	}
    #listaMedicos .badge-discount-time{
        width: 50px;
    }
    #listaMedicos .box-badge-discount-time{
        width: 50px;
    }
	.box-badge-discount-time-popup {
	    top: 0px;
	    left: 0px;
	    height: 25px;
	    width: 90px;
	    background: #FFE5EF;
	    border-radius: 0px 0px 32px 0px;
	}
	.box-badge-discount-time-popup-label {
	    bottom: 0px;
	    right: 0px;
	    height: 25px;
	    width: 125px;
	    background: #FFE5EF;
	    border-radius: 32px 0px 0px 0px;
	}
	#modalConsultaMismoDiaAgendaMultiple     {
	    z-index: 99999 !important;
	}
</style>
@endsection