@extends('template.app-template')
@section('content')

<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/print.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/print.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/html2canvas.min.js"></script>


{{-- Modal Pinpad --}}
<div class="modal modal-top fade" id="modalPinpad" tabindex="-1" aria-labelledby="modalPinpadLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-md modal-dialog-top modal-dialog-scrollable mx-auto">
        <form class="modal-content rounded-8 mt-5">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center">Inserta o desliza la tarjeta</h5
                >
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <img class="w-75 mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/payment.svg" alt="">
            </div>
        </form>
    </div>
</div>
{{-- Modal nuevo dato comprobante --}}
<div class="modal fade" id="modalInfoAction" tabindex="-1" aria-labelledby="modalInfoActionLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
        <form class="modal-content rounded-8 mt-5">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center">Atención</h5
                >
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <h2 class="text-start text-veris my-4 mensajeInformativo"></h2>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn fw-normal fs--16 badge bg-royal-blue text-white m-0 px-4 py-2 mx-auto fs-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal de datos de facturación --}}
<div class="modal modal-top fade" id="modalDatosFacturacion" tabindex="-1" aria-labelledby="modalDatosFacturacionLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    {{-- <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto"> --}}
    <div class="modal-dialog modal-lg modal-dialog-top modal-dialog-scrollable mx-auto">
        <form class="modal-content rounded-8 mt-5">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center">Datos de Facturación</h5
                >
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row box-datos-factura">
                    <div class="col-6 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="codigoTipoIdentificacion">Tipo de documento</label>
                        <select class="form-select p-1 rounded-8 fs-25 text-start" name="codigoTipoIdentificacion" id="codigoTipoIdentificacion">
                            <option value="2">Cédula</option>
                            <option value="1">Ruc</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="numeroIdentificacion">Número de documento</label>
                        <input autocomplete="off" class="form-control w-100 p-1 rounded-8 text-start fs-25 onlyNumber" type="number" name="numeroIdentificacion" id="numeroIdentificacion" readonly data-kb="numeric">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="nombreCompleto">Nombre completo</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-uppercase p-1 rounded-8 text-start fs-25 mb-2" type="text" name="nombreCompleto" id="nombreCompleto" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="email">Correo electrónico</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-lowercase p-1 rounded-8 text-start fs-25 mb-2" type="email" name="email" id="email" data-kioskboard-specialcharacters="true" readonly/>
                    </div>
                    <div class="col-12 mb-3 text-center">
                        <button type="button" class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-50 fw-medium shadow-none btn-disabled btn-continuar-factura">Actualizar datos de Factura</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container-fluid px-0 d-flex flex-column min-vh-100" style="overflow-x: hidden;">
    @include('components.header', ['showSettingBtn' => false, 'showExitBtn' => false])
    <!-- Sub-header -->
    @include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])
    <div class="row h-100">
        <div class="col-12 h-100 px-0 rounded-t-8">
            <ul class="nav nav-pills d-flex align-items-center justify-content-between bg-white gap-2 rounded-t-8 border-start-0 border-start-0 my-2" id="pills-tab-servicios" role="tablist">
                <li class="nav-item flex-fill border-silver-light-1 rounded-8" role="presentation">
                    <button tipo-rel="AV" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-16 line-height-20" id="pills-AV-tab" data-bs-toggle="pill" data-bs-target="#pills-AV" type="button" role="tab" aria-controls="pills-AV" aria-selected="true">
                    ANULACIÓN DE VOUCHER<br>SIN FACTURA
                    </button>
                </li>
                <li class="nav-item flex-fill border-silver-light-1 rounded-8" role="presentation">
                    <button tipo-rel="NC" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-16 line-height-20" id="pills-NC-tab" data-bs-toggle="pill" data-bs-target="#pills-NC" type="button" role="tab" aria-controls="pills-NC" aria-selected="false">
                        NOTA DE CRÉDITO CON<br>REVERSO DE VOUCHER
                    </button>
                </li>
                <li class="nav-item flex-fill border-silver-light-1 rounded-8" role="presentation">
                    <button tipo-rel="SF" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-16 line-height-20" id="pills-SF-tab" data-bs-toggle="pill" data-bs-target="#pills-NC" type="button" role="tab" aria-controls="pills-NC" aria-selected="false">
                        SALDO A FAVOR<br>DEL CLIENTE
                    </button>
                </li>
                <li class="nav-item flex-fill border-silver-light-1 rounded-8" role="presentation">
                    <button tipo-rel="CDF" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-16 line-height-20" id="pills-CDF-tab" data-bs-toggle="pill" data-bs-target="#pills-NC" type="button" role="tab" aria-controls="pills-NC" aria-selected="false">
                        CAMBIO DATOS<br>DE FACTURA
                    </button>
                </li>
            </ul>
            <div class="tab-content bg-transparent pt-2" id="pills-tabContent-servicios">
                <div class="tab-pane fade mt-3 px-3 show active" id="pills-AV" role="tabpanel" aria-labelledby="pills-AV-tab" tabindex="0">
                    <div class="row row-flex mb-3 pb-3">
                        <div class="col-12 mt-3 box-vouchers d-none">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Secuencia Voucher</th>
                                        <th scope="col">N°. Tarjeta</th>
                                        <th scope="col">N°. Voucher</th>
                                        <th scope="col">Usuario Cajero</th>
                                        <th scope="col">Tarjeta Habitante</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listVouchers">
                                    {{-- <tr>
                                        <td>2520534</td>
                                        <td>54519500XXXXX343</td>
                                        <td>000020</td>
                                        <td>KDORADO1</td>
                                        <td>PAYWAVE/VISA</td>
                                        <td>$40,00</td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <button class="bg-transparent border-0"><i class="fa-solid fa-eye mx-1 text-veris"></i></button>
                                            <button class="bg-transparent border-0"><i class="fa-solid fa-ban mx-1 text-danger"></i></button>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mt-3 px-3" id="pills-NC" role="tabpanel" aria-labelledby="pills-NC-tab" tabindex="0">
                    <div class="row row-flex mb-3 pb-3">
                        <div class="col-12 mt-3">
                            <p class="fs--2 fw-bold text-veris mt-3">Número de Factura</p>
                            <div class="d-flex mt-3 align-items-center justify-content-between">
                                <input type="text" maxlength="3" 
                                    class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2 keyboard-input " 
                                    oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                    onkeypress="return validarNumeros(event)" 
                                    onblur="completarConCeros(this)" 
                                    required 
                                    autocomplete="off"
                                    data-kioskboard-type="numpad"
                                    readonly
                                    disabled
                                    id="first-input">
                                <i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
                                <input type="text" maxlength="3" 
                                    class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2 keyboard-input " 
                                    oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                    onkeypress="return validarNumeros(event)" 
                                    onblur="completarConCeros(this)" 
                                    required 
                                    autocomplete="off"
                                    data-kioskboard-type="numpad"
                                    readonly
                                    disabled
                                    id="medium-input">
                                <i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
                                <input type="text" maxlength="9" 
                                    class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2"
                                    oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                    onkeypress="return validarNumeros(event)" 
                                    onblur="completarConCeros(this)" 
                                    required 
                                    autocomplete="off"
                                    readonly 
                                    data-kb="numeric"
                                    id="last-input">
                                <button class="m-0 mx-1 mx-md-3 bg-transparent border-0" id="btnSearch">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-6 box-info-factura d-none mt-3">
                            <p class="fs--2 fw-bold text-veris mt-3">Datos Paciente</p>
                            <div class="box-paciente"></div>
                        </div>
                        <div class="col-6 box-info-factura d-none mt-3">
                            <p class="fs--2 fw-bold text-veris mt-3">Datos Factura</p>
                            <div class="box-factura"></div>
                        </div>
                        <div class="col-12 box-info-factura d-none mt-3">
                            <table class="table">
                                <thead>
                                    <th>Cantidad</th>
                                    <th>Prestación/Servicio</th>
                                    <th>V. Empresa</th>
                                    <th>V. Paciente</th>
                                </thead>
                                <tbody id="listado-prestaciones"></tbody>
                            </table>
                        </div>
                        <div class="col-4 offset-4 box-info-factura d-none mt-5 text-center">
                            <button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-50 fw-medium shadow-none btn-action">Crear Nota de Crédito</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mt-3 px-3" id="pills-SF" role="tabpanel" aria-labelledby="pills-SF-tab" tabindex="0">
                    <div class="row row-flex mb-3 pb-3">
                        <div class="col-12 mt-3">
                            SF
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mt-3 px-3" id="pills-CDF" role="tabpanel" aria-labelledby="pills-CDF-tab" tabindex="0">
                    <div class="row row-flex mb-3 pb-3">
                        <div class="col-12 mt-3">
                            CDF
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="w-100 bg-silver-light p-44 position-absolute bottom-0 start-0 d-none" id="box-simple-keyboard" style="z-index: 9999999999;">
    <div class="simple-keyboard"></div>
</div>
{{-- <div class="wrapper">
    <!-- Header -->
    <header class="header p-3">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12 col-md-3 text-center text-md-start">
                    @if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
                    <img id="logo-digiturno" class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
                    @else
                    <img id="logo-digiturno" class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
                    @endif
                </div>
                <div class="col-9 col-md-9 d-md-flex justify-content-end align-items-center d-none d-md-block">
                    <div class="time-box badge bg-veris-dark text-center p-3 rounded-8" id="header-info">
                        <span class="fs-4">Fecha:</span><span class="ms-1 fs-5 text-veris-light" id="fecha"></span>
                        <span class="fs-5 ms-5 d-none">Hora:</span><span class="ms-1 fs-5 text-veris-light d-none" id="hora"></span>
                        <span class="fs-5 ms-5">Central:</span><span class="ms-1 fs-4 text-veris-light" id="central"></span>
                        <i class="fa-solid fa-arrow-right-from-bracket ms-2 text-warning fw-bold fs-20 exitAdmin"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div> --}}
<script>
    tecladoFlotante = true;

    // Valida que solo se puedan ingresar números
    function validarNumeros(event) {
        return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) 
            ? null 
            : event.charCode >= 48 && event.charCode <= 57;
    }

    function completarConCerosString(inputId, str) {
        let input = $(`#${inputId}`);
        const valor = input.value.trim(); // eliminamos espacios

        if (valor === '') {
            return; // no hacer nada si está vacío
        }


        const maxLength = parseInt(input.getAttribute('maxlength'), 10);
        if (input.value.length < maxLength) {
            input.value = input.value.padStart(maxLength, '0');
        }
    }

    // Completa con ceros a la izquierda hasta el maxlength definido
    function completarConCeros(input) {
        return;
        const valor = input.value.trim(); // eliminamos espacios

        if (valor === '') {
            return; // no hacer nada si está vacío
        }


        const maxLength = parseInt(input.getAttribute('maxlength'), 10);
        if (input.value.length < maxLength) {
            input.value = input.value.padStart(maxLength, '0');
        }
    }

    // Adicional: Limita caracteres a `maxlength` manualmente si es necesario (por redundancia)
    function limitarCaracteres(input, maxLength) {
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
        }
    }

    if(localStorage.getItem('dataAdmin') === null){
        location.href = `/{{ $mac }}`;
    }

    let dataAdmin = JSON.parse(localStorage.getItem('dataAdmin'));
    let dataParametrosGenerales = JSON.parse(localStorage.getItem('parametrosGenerales'));

    document.addEventListener('DOMContentLoaded', async function () {
        actualizarFechaHora()

        $.customKeyboard.init('input[readonly]', '.simple-keyboard');

        $(document).on('click', function(e) {
            if ($('#box-simple-keyboard').is(':visible') && 
                !$(e.target).closest('#box-simple-keyboard').length && 
                !$(e.target).is('input')
            ){
                $('#box-simple-keyboard').addClass('d-none');
            }
        });
        
        $('#first-input').val(dataParametrosGenerales.caja.numeroEstablecimientoSri);
        $('#medium-input').val(dataParametrosGenerales.caja.numeroPuntoEmisionSri);

        $('body').on('click', '.btn-volver-subheader', function(){
            localStorage.removeItem('dataAdmin');
            //location.reload();
        })

        $('body').on('click', '.btn-anular-voucher', async function(){
            let datosVoucher = JSON.parse($(this).attr('data-rel'));
            console.log(datosVoucher);
            await anularVoucher(datosVoucher);
        })

        $('body').on('click', '.btn-continuar-factura', async function(){
            let validacion = await validarDatosFactura();
            if(validacion){
                await setearDatosFactura();
            }
        })

        $('body').on('click', '.tipoServicio', async function(){
            let tipo = $('.tipoServicio.active').attr('tipo-rel')
            switch(tipo){
                case 'AV':
                    $('.box-vouchers').removeClass('d-none')
                    await getVouchers();
                default:
                    $('#last-input').val("");
                    $('.box-info-factura').addClass('d-none');
                    $('.box-paciente').empty();
                    $('.box-factura').empty();
                    $('#listado-prestaciones').empty();
                break;
            }
        })

        $('body').on('click', '#btnSearch', async function(){
            /**/
            let input = $('#first-input');
            const maxLength1 = parseInt(input.attr('maxlength'), 10);
            let valor = input.val().trim();

            if (valor.length < maxLength1) {
                input.val(valor.padStart(maxLength1, '0'));
            }

            input = $('#last-input');
            const maxLength3 = parseInt(input.attr('maxlength'), 10);
            valor = input.val().trim();

            if (valor.length < maxLength3) {
                input.val(valor.padStart(maxLength3, '0'));
            }


            /**/
            let tipo = $('.tipoServicio.active').attr('tipo-rel')
            console.log(tipo)
            $('.btn-action').attr(`tipo-rel`, tipo);
            
            let opcionMenu;
            switch(tipo){
                case 'NC':
                    $('.btn-action').html(`Crear Nota de Crédito`)
                    opcionMenu = 'NC_NORMAL'
                break;
                case 'SF':
                    $('.btn-action').html(`Saldo a Favor`);
                    opcionMenu = 'SALDO_FAVOR'
                break;
                case 'CDF':
                    $('.btn-action').html(`Cambiar Datos Factura`)
                    opcionMenu = 'CAMBIO_DATOS'
                break;
            }
            await obtenerInfoFactura(opcionMenu)
        })

        $('body').on('click', '.btn-action', async function(){
            let tipo = $(this).attr('tipo-rel');
            switch(tipo){
                case 'NC':
                    await crearNC()
                break;
                case 'SF':
                    await crearSaldoFavor()
                break;
                case 'CDF':
                    $('#modalDatosFacturacion').modal('show');
                break;
            }
        })

        let timeoutId;

        $('body').on('keyup change', '#numeroIdentificacion', function() {
            clearTimeout(timeoutId); // Limpia el timeout anterior
            timeoutId = setTimeout(async function() {
                let datosF = {
                    "numeroIdentificacion": $('#numeroIdentificacion').val(),
                    "codigoTipoIdentificacion": $('#codigoTipoIdentificacion option:selected').val()
                };
                if(parseInt($('#codigoTipoIdentificacion option:selected').val()) == 2){
                    if(esValidaCedula($('#numeroIdentificacion').val())){
                        await verificarDatosFactura(datosF);
                    }else{
                        if($('#numeroIdentificacion').val().length == 10){
                            toastr.warning("Cédula incorrecta", "Atención", {
                                timeOut: 5000
                            });
                            $('#nombreCompleto').val("");
                            $('#email').val("");
                        }
                    }
                }else{
                    if($('#numeroIdentificacion').val().length == 13){
                        await verificarDatosFactura(datosF);
                    }
                }
            }, 2000); // Espera 1 segundo después de la última entrada
        });

    })

    async function crearNC(){
        let infoFactura = JSON.parse($('.btn-action').attr('data-rel'));   
        let detalles = [];        
        $.each(infoFactura.detalles, function(k, v){
            detalles.push({
                "lineaDetalleOrden": v.lineaDetalleOrden,
                "lineaDetalleComprobante": v.lineaDetalleComprobante
            })
        })
        let pagos = [];
        $.each(infoFactura.pagos, function(k, v){
            pagos.push({
                "lineaDetallePago": v.lineaDetallePago,
                "valor": v.valor
            })
        })

        let obj = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "nemonicoCanalFacturacion": "KIOSKO",
            "codigoMotivo": 9,
            "caja": dataParametrosGenerales.caja,
            "numeroOrden": infoFactura.numeroOrden,
            "secuenciaComprobante": infoFactura.secuenciaComprobante,
            "detalles": detalles,
            "observacionMotivo": "SERVICIOS FACTURADOS NO BRINDADOS",
            "permitirAnularPago": false,
            "pagos": pagos,
            "secuenciaUsuarioAutorizacion": dataAdmin.secuenciaUsuario
        }
        
        await anularFactura(obj);
    }

    async function crearSaldoFavor(){
        let infoFactura = JSON.parse($('.btn-action').attr('data-rel'));   
        let detalles = [];        
        $.each(infoFactura.detalles, function(k, v){
            detalles.push({
                "lineaDetalleOrden": v.lineaDetalleOrden,
                "lineaDetalleComprobante": v.lineaDetalleComprobante
            })
        })
        let pagos = [];
        $.each(infoFactura.pagos, function(k, v){
            pagos.push({
                "lineaDetallePago": v.lineaDetallePago,
                "valor": v.valor
            }) 
        })

        let obj = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "nemonicoCanalFacturacion": "KIOSKO",
            "codigoMotivo": 16,
            "caja": dataParametrosGenerales.caja,
            "numeroOrden": infoFactura.numeroOrden,
            "secuenciaComprobante": infoFactura.secuenciaComprobante,
            "detalles": detalles,
            "observacionMotivo": "NC CON REFACTURACION - SALDO FAVOR",
            "permitirAnularPago": false,
            "pagos": pagos,
            "secuenciaUsuarioAutorizacion": dataAdmin.secuenciaUsuario
        }
        await anularFactura(obj);
    }

    async function anularFactura(obj){
        let tipo = $('.tipoServicio.active').attr('tipo-rel')
        let infoFactura = JSON.parse($('.btn-action').attr('data-rel'));
        let args = [];

        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/comprobantes/anulacion_paciente?codigoEmpresa=1&tipoAnulacion=AUTOMATICA`;
        args["method"] = "POST";
        args["dismissAlert"] = true;
        args["showLoader"] = true;
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(obj);
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            let numeroTransaccion = data.data.numeroTransaccion;
            if(tipo == "CDF"){
                numeroTransaccion = data.data.factura.numeroTransaccion;
            }
            await printFactura(numeroTransaccion);
            if(tipo == "CDF"){
                showMessage('success','Atención', `Datos de Factura modificados exitosamente. Comprobante generado: ${data.data.factura.numeroComprobante}`);
                $('#modalDatosFacturacion').modal('hide');
                $('.mensajeInformativo').html(`Datos de Factura modificados exitosamente, nuevo comprobante generado: <br>${data.data.factura.numeroComprobante}`);
                $('#modalInfoAction').modal('show');
                $('#numeroIdentificacion').val("");
                $('#nombreCompleto').val("");
                $('#email').val("");
            }else{
                if(tipo == "NC"){
                    showMessage('success','Atención', 'Factura anulada exitosamente')
                    if(infoFactura.permiteAnularVoucher){
                        let datosVoucher = {
                            "secuenciaDocumentoVoucher": infoFactura.pagos[0].secuenciaDocumentoVoucher
                        }
                        await anularVoucher(datosVoucher);
                    }
                }else{
                    showMessage('success','Atención', `Valor de $${infoFactura.totales.paciente.valorTotal} acumulado como Saldo a favor exitosamente al cliente: ${infoFactura.nombrePersonaFactura}`)
                    $('.mensajeInformativo').html(`Valor de $${infoFactura.totales.paciente.valorTotal} acumulado como Saldo a favor exitosamente al cliente: ${infoFactura.nombrePersonaFactura}`);
                    $('#modalInfoAction').modal('show');
                }

                if(infoFactura.permiteAnularValExt){
                    await anularAutorizacion(infoFactura);
                }
            }
            await registrarTracking('ANULAR_FACTURA_'+tipo.toUpperCase(), obj);
        }else{
            showMessage('error','Atención', data.message)
        }
    }

    async function anularAutorizacion(infoFactura){
        let transacciones = [];
        transacciones.push(infoFactura.secuenciaTransaccionValExt);
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/sync-convenios/v1/valorizacion_externa/anulacion_autorizacion?idCliente=${infoFactura.idCliente}&canalInvocacion=KIO`;
        args["method"] = "DELETE";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "transacciones": transacciones
        });
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            showMessage('success','Atención', 'Autorización anulada exitosamente')
        }else{
            showMessage('error','Atención', data.message)
        }
    }

    async function obtenerInfoFactura(opcionMenu){
        $('.box-info-factura').addClass('d-none');
        let numeroFactura = `${getInput('first-input')}${getInput('medium-input')}${getInput('last-input')}`
        let args = [];

        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/comprobantes/factura_paciente/kiosko/consulta_por_anulacion?codigoEmpresa=1&macAddress={{ $mac }}&criterioBusqueda=COMPROBANTE_CON_FACTURA&valorBusqueda=${numeroFactura}&idOpcionMenu=${opcionMenu}`;
        args["method"] = "GET";
        args["dismissAlert"] = true;
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        let info = data.data;
        if(data.code == 200){
            console.log(data);
            $('.box-info-factura').removeClass('d-none');
            
            let elemPaciente = `
                <p class="mb-1 fs-20 line-height-25">Nombre: <b>${info.nombrePaciente}</b></p>
                <p class="mb-1 fs-20 line-height-25">Nro. Identificación: <b>${info.numeroIdentificacionPaciente}</b></p>
            `;
            let elemFactura = `
                <p class="mb-1 fs-20 line-height-25">Nombre: <b>${info.nombrePersonaFactura}</b></p>
                <p class="mb-1 fs-20 line-height-25">Nro. Identificación: <b>${info.numeroIdentificacionPersonaFactura}</b></p>
            `;
            let elemPrestaciones = ``;

            $.each(info.detalles, function(key, value){
                elemPrestaciones += `<tr>
                    <td>${value.cantidad}</td>
                    <td>${value.nombrePrestacion}</td>
                    <td>$${value.valoresEmpresa.valorTotal.toFixed(2)}</td>
                    <td>$${value.valoresPaciente.valorTotal.toFixed(2)}</td>
                </tr>`;
            })

            $('#listado-prestaciones').html(elemPrestaciones);

            $('.btn-action').attr('data-rel',JSON.stringify(info));

            $('.box-paciente').html(elemPaciente);
            $('.box-factura').html(elemFactura);

        }else{
            showMessage('error','Atención',data.message);
        }
    }

    async function getVouchers(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pin_pad/consulta/vouchers_por_anular?usuarioIngreso=${dataParametrosGenerales.codigoUsuario}&codigoEmpresa=1`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["sendHeaders"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);

        if(data.code == 200){
            let elem = ``;

            $.each(data.data, function(key, value){
                elem += `<tr>
                    <td>${value.secuenciaDocumentoVoucher}</td>
                    <td>${value.numeroTarjeta}</td>
                    <td>${value.numeroVoucher}</td>
                    <td>${value.usuarioIngreso}</td>
                    <td>${value.nombreMarcaTc}</td>
                    <td>$${value.valorTotal}</td>
                    <td class="d-flex justify-content-center align-items-center">
                        <button data-rel='${JSON.stringify(value)}' class="bg-transparent border-0"><i class="fa-solid fa-eye mx-1 text-veris"></i></button>
                        <button data-rel='${JSON.stringify(value)}' class="bg-transparent border-0 btn-anular-voucher"><i class="fa-solid fa-ban mx-1 text-danger"></i></button>
                    </td>
                </tr>`;
            })

            $('#listVouchers').html(elem)

        }
    }

    async function anularVoucher(datosVoucher){
        $('#modalPinpad').modal('show');
        let tipo = $('.tipoServicio.active').attr('tipo-rel')
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pin_pad/anular_cobro/${datosVoucher.secuenciaDocumentoVoucher}?codigoEmpresa=1&codigoUsuario=${dataParametrosGenerales.codigoUsuario}&macAddress={{ $mac }}`;
        args["method"] = "DELETE";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify({});
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
        $('#modalPinpad').modal('hide');
        if(data.code == 200){
            showMessage('success','Atención','Voucher anulado exitosamente')
            await registrarTracking('VOUCHER_ANULADO', {"secuenciaDocumentoVoucher":datosVoucher.secuenciaDocumentoVoucher});
        }else{
            showMessage('error','Atención', data.message)
            if(tipo == "NC"){
                alert("Proceso de anulación de Voucher incompleto, debe realizarlo manualmente desde la opción ANULACIÓN DE VOUCHER SIN FACTURA");
            }
        }

    }

    let infoFacturaValidada;
    async function verificarDatosFactura(datos = null){
        console.log('-----------verificarDatosFactura------------')
        let numeroIdentificacion = $('#numeroIdentificacion').val();
        let codigoTipoIdentificacion = $('#codigoTipoIdentificacion option:selected').val();
        
        let args = [];
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/pacientes/verificar_datos_factura?numeroIdentificacion=${numeroIdentificacion}&codigoTipoIdentificacion=${codigoTipoIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        console.log(data);

        if(data.code = 200){
            infoFacturaValidada = data.data;
            $('#codigoTipoIdentificacion').val(infoFacturaValidada.codigoTipoIdentificacion);
            $('#numeroIdentificacion').val(infoFacturaValidada.numeroIdentificacion);
            $('#nombreCompleto').val(infoFacturaValidada.nombreCompleto);
            $('#email').val(infoFacturaValidada.mail);

            $('#codigoTipoIdentificacionV').val(infoFacturaValidada.codigoTipoIdentificacion);
            $('#numeroIdentificacionV').val(infoFacturaValidada.numeroIdentificacion);
            $('#nombreCompletoV').val(infoFacturaValidada.nombreCompleto);
            $('#emailV').val(infoFacturaValidada.mail);
        }
        return;
    }

    async function setearDatosFactura(){
        console.log("setear datos factura");
        let infoFactura = JSON.parse($('.btn-action').attr('data-rel'));   
        let detalles = [];        
        $.each(infoFactura.detalles, function(k, v){
            detalles.push({
                "lineaDetalleOrden": v.lineaDetalleOrden,
                "lineaDetalleComprobante": v.lineaDetalleComprobante
            })
        })
        let pagos = [];
        $.each(infoFactura.pagos, function(k, v){
            pagos.push({
                "lineaDetallePago": v.lineaDetallePago,
                "valor": v.valor
            })
        })

        let obj = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "nemonicoCanalFacturacion": "KIOSKO",
            "codigoMotivo": 12,
            "caja": dataParametrosGenerales.caja,
            "cajaFacturacion": dataParametrosGenerales.caja,
            "numeroOrden": infoFactura.numeroOrden,
            "secuenciaComprobante": infoFactura.secuenciaComprobante,
            "detalles": detalles,
            "observacionMotivo": "CAMBIO DE DATOS KIOSKO",
            "permitirAnularPago": false,
            "pagos": pagos,
            "datosFactura": {
                "codigoTipoIdentificacion": parseInt($('#codigoTipoIdentificacion option:selected').val()),
                "numeroIdentificacion": $('#numeroIdentificacion').val(),
                "nombreFactura": $('#nombreCompleto').val(),
                "correo": $('#email').val()
            },
            "secuenciaUsuarioAutorizacion": dataAdmin.secuenciaUsuario
        }
        
        await anularFactura(obj);
    }

    async function printFactura(numeroTransaccion){
        // $('#first-input').val("");
        // $('#medium-input').val("");
        $('#last-input').val("");
        $('.box-info-factura').addClass('d-none');
        $('.box-paciente').empty();
        $('.box-factura').empty();
        $('#listado-prestaciones').empty();
        showMessage('success','Atención','Imprimiendo documento');
        // return;
        // http://localhost:3001/printer-ticket/v1/printFile?url=https://api-phantomx.veris.com.ec/reportes/v1/facturacion/comprobante_paciente?format=text_plain%26codigoEmpresa=1%26numeroTransaccion=21479281%26codigoSucursalImpresion=1%26usuarioRealizaImpresion=true

        const apiUrl = `${api_url_digitales}/reportes/v1/facturacion/comprobante_paciente?format=text_plain&codigoEmpresa=1&numeroTransaccion=${numeroTransaccion}&codigoSucursalImpresion=${dataParametrosGenerales.caja.codigoSucursal}&usuarioRealizaImpresion=true`;
        const encodedUrl = encodeURIComponent(apiUrl);
        let args = [];
        args["endpoint"] = `http://localhost:3001/printer-ticket/v1/printFile?url=${encodedUrl}`;
        args["method"] = "GET";
        args["token"] = accessToken;
        const data = await call(args);
        if(data.code == 200){
            console.log(data)
        }
        return;
    }

    async function validarDatosFactura(){
        let msg = "";

        if($('#numeroIdentificacion').val() == ""){
            msg += "Debe ingresar un número de documento \n";
        }else{
            if(parseInt($('#codigoTipoIdentificacion option:selected').val()) == 2){
                if(!esValidaCedula($('#numeroIdentificacion').val())){
                    msg += "Debe ingresar una cédula válida \n";
                }
            }else{
                if($('#numeroIdentificacion').val().length != 13){
                    msg += "Debe ingresar un RUC válido \n";
                }
            }
        }

        if($('#nombreCompleto').val() == ""){
            msg += "Debe ingresar nombres completos \n";
        }

        if(!isValidEmailAddress($('#email').val())){
            msg += "Debe ingresar un email válido \n";
        }
        
        if(msg == ""){
            return true;
        }else{
            toastr.error(msg, 'Datos de Factura incorrectos', {
                timeOut: 8000
            });
            return false;
        }
    }
</script>
<style>
    .toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning{
        background-image: url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") !important;
    }
</style>
@endsection