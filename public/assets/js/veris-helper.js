let c_o = "KIO_CMV";
let cargandoConvenios = false;

if(!isMobile()){
    // c_o = "KIO_CMV"
}
// const _canalOrigen = "MVE_CMV";
const _canalOrigen = c_o;
const _plataforma = "WEB";
const _version = "7.8.0";
const _langDate = {
    firstDayOfWeek: 1,
    weekdays: {
        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
    }, 
    months: {
        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
        longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    }
}

document.addEventListener("DOMContentLoaded", async function () {
    $('body').on('click', '.view-cart', function(){
        // location.href = `/carrito/${mac}`;
        location.href = `/carrito/${mac}`;
    })

    $('body').on('click', '.btn-generar-turno', async function(){
        localStorage.setItem('tipoTurnoGenerar', 'demanda');
        location.href = `/turno/${mac}`;
    })

    $("a").on("click", function (e) {
        if ($(this).data("clicked")) {
            console.log("paralizar")
            e.preventDefault();
            return;
        }
        $(this).data("clicked", true);
        setTimeout(() => $(this).removeData("clicked"), 1200); // vuelve a habilitar
    });
})

async function call(args){
    if(args.showLoader || args.showLoader == true){
        showLoader();
    }
    
    let requestOptions = {
        method: args.method,
        redirect: 'follow',
        headers: []
    };
    
    let myHeaders = new Headers();
    myHeaders.append("Accept-Language", "es");
    if(args.bodyType == "json"){
        myHeaders.append("Content-Type", "application/json");
    }

    if(localStorage.getItem('flujo') === null || args.sendHeaders || localStorage.getItem('flujo') == "digiturno"){
        // console.log(7777)
        if(args.esLogin){
            // console.log(888)
            myHeaders.append("Authorization", "Basic " + args.basic);
            myHeaders.append("Application", _applicationLogin);
            myHeaders.append("IdOrganizacion", _idOrganizacionLogin);
        }else if(args.esLoginLider || args.esWSLider){
            if(args.esLoginLider){
                myHeaders.append("Authorization", "Basic " + args.basic);
            }else{
                myHeaders.append("Authorization","Bearer "+ args.token);
            }
            myHeaders.append("Application", _applicationLoginLider);
            myHeaders.append("IdOrganizacion", _idOrganizacion);
        }else{
            if(args.sendHeaders === undefined || args.sendHeaders){
                myHeaders.append("Authorization","Bearer "+ args.token);
                myHeaders.append("application", _application);
                myHeaders.append("idorganizacion", _idOrganizacion);
            }
        }
    }

    if(trackId != ''){
        myHeaders.append("trackId", trackId);
    }

    if (typeof trackIdTmp !== 'undefined') {
        myHeaders.append("trackId", trackIdTmp);
    }

    if(JSON.parse(localStorage.getItem('userVeris')) != null){
        myHeaders.append("usuarioSession", JSON.parse(localStorage.getItem('userVeris')).codigoUsuario);
    }

    /*if(args.token){
        console.log(_idOrganizacion)
        myHeaders.append("Authorization","Bearer "+ args.token);
        myHeaders.append("application", _application);
        myHeaders.append("idorganizacion", _idOrganizacion);
    }*/
    requestOptions.headers = myHeaders;
    // console.log(myHeaders);
    // console.log(requestOptions);
        
    // myHeaders.append("Application", _application);
    // myHeaders.append("IdOrganizacion", _idOrganizacion);
    // myHeaders.append("Authorization","Bearer "+ _token);

    if(args.method == "POST" || args.method == "PUT" || args.method == "DELETE" || args.method == "GET"){
        if(args.data){
            requestOptions.body = args.data;
        }
    }

    const url = new URL(args.endpoint, window.location.origin); // base por si endpoint es relativo
    url.searchParams.set("trackId", trackId); // genera uno si no viene
    const endpointWithTrackId = url.toString();
    // console.log(endpointWithTrackId)
    
    return fetch(endpointWithTrackId, requestOptions)
        .then((response) => {
            return response.json();
        }).then((data) => {
            if(args.showLoader || args.showLoader == true){
                if(!cargandoConvenios){
                    hideLoader();
                }else{
                    cargandoConvenios = false;
                }
            }
            if(!args.dismissAlert && data.code == 400 && localStorage.getItem('flujo') === null){
                // console.log(5555)
                toastr.clear();
                toastr.warning(data.message, `Ha ocurrido un error`, {
                    timeOut: 8000
                });
                return;
            }
            return data;
        }).catch(function(error) {
            // console.log("catch error call")
            if(args.showLoader || args.showLoader == true){
                hideLoader();
            }
            throw error;
            // toastr.error("Ha ocurrido un problema con la comunicación al servicio requerido, inténtelo en unos momentos.","ERROR");
            //console.log(error);
        });
}

async function callInformes(args) {
    if (args.showLoader) {
        showLoader();
    }

    let requestOptions = {
        method: args.method,
        redirect: 'follow'
    };
    let myHeaders = new Headers();
    if (args.bodyType === "json") {
        myHeaders.append("Content-Type", "application/json");
        requestOptions.headers = myHeaders;
    }
    if (args.bodyType === "plain") {
        myHeaders.append("Content-Type", "text/plain");
        requestOptions.headers = myHeaders;
    }
    if (["POST", "PUT", "DELETE"].includes(args.method) && args.data) {
        requestOptions.body = args.data;
    }

    try {
        const response = await fetch(args.endpoint, requestOptions);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const blob = await response.blob();
        if (args.showLoader) {
            hideLoader();
        }

        return blob;
    } catch (error) {
        if (args.showLoader) {
            hideLoader();
        }

        // Construye un objeto de error para devolver información relevante
        let errorInfo = {
            status: error.message.includes('HTTP error') ? parseInt(error.message.replace(/\D/g, '')) : 500, // Extrae el código de estado del mensaje de error, o asume 500 si no es específico
            message: 'Ha ocurrido un problema con la comunicación al servicio requerido, inténtelo en unos momentos.'
        };

        

        return errorInfo;
    }
}


function removeLeadingZero(input, maxLength) {
    input.value = input.value.replace(/^0/, '');
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

function maxLengthNumber(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

function showMessage(type,title,message){
    toastr.clear();
	switch(type){
		case 'warning':
			toastr.warning(message,title);
		break;
		case 'success':
			toastr.success(message,title);
		break;
		case 'info':
			toastr.info(message,title);
		break;
		case 'error':
			toastr.error(message,title);
		break;
	}
}

function showLoader(){
	$.blockUI({
        //message: '<div class="spinner-border txt-veris" role="status"></div>',
        message: `<div class="custom-block-ui"><svg id="Capa_1" class="custom-loader" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 64"><defs><style>.cls-1{fill:#fff;}</style></defs><path class="cls-1" d="M52.89,17.68H36.47V44A7.54,7.54,0,1,1,21.4,44V17.68H5c-4.24,0-5.84,2.94-3.55,6.54l23.3,36.43c2.29,3.6,6.06,3.6,8.35,0l23.3-36.43C58.73,20.62,57.13,17.68,52.89,17.68Z"/><path class="cls-1" d="M28.94,15.57A7.58,7.58,0,1,0,21.4,8,7.54,7.54,0,0,0,28.94,15.57Z"/></svg></div>`,
        css: {
			backgroundColor: 'transparent',
			border: '0'
        },
        overlayCSS: {
        	opacity: 0.5
        }
    });
}

function hideLoader(){
	$.unblockUI();
}

function sonNumeros(str) {
    return /^\d+$/.test(str);
}

function getInput(idElem, type = 'input'){
    let valor;
    switch(type){
        case 'input':
        case 'select':
            valor = document.getElementById(idElem).value
        break;
        case 'radio':
            valor = $("input[name='"+idElem+"']:checked").val();
        break;
        case 'fecha':
            valor = document.getElementById(idElem)._flatpickr.getDate();
        break;
        case 'hora':
            valor = document.getElementById(idElem)._flatpickr.getDate();
        break;
        case 'select2':
            //console.log(value);
            valor = $('#'+idElem).val();
        break;
        case 'button':
            // console.log("."+idElem+".active");
            $("."+idElem+".active").attr("id-rel");
        break;
        case 'checkbox':
            // console.log('#'+idElem)
            valor = "I";
            if($('#'+idElem).is(":checked")){
                valor = "A";
            }
        break;
    }
    return valor;
}

function limitarCaracteres(input, maxCaracteres) {
    // Obtén el valor actual del campo de entrada
    var valor = input.value;

    // Limita la longitud del valor a `maxCaracteres`
    if (valor.length > maxCaracteres) {
        valor = valor.slice(0, maxCaracteres);
    }

    // Establece el valor limitado en el campo de entrada
    input.value = valor;
}

function validarNumero(event) {
    // Verifica si el carácter es un número
    if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        // Previene la entrada del carácter si no es un número
        event.preventDefault();
    }
}

function enmascararEmail(email) {
    // Dividir el correo electrónico en dos partes: nombre de usuario y dominio
    const partes = email.split('@');
    if (partes.length === 2) {
        const usuario = partes[0];
        const dominio = partes[1];

        // Enmascarar el nombre de usuario con asteriscos
        const enmascarado = usuario.charAt(0) + '*'.repeat(usuario.length - 1);

        // Reconstruir el correo electrónico enmascarado
        return enmascarado + '@' + dominio;
    }

    // Devolver el correo electrónico original si no se pudo enmascarar
    return email;
}

async function obtenerIdentificacion(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/tiposIdentificacion`;
    args["method"] = "GET";
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        $.each(data.data, function(key, value){
            $('#tipoIdentificacion').append(`<option value="${value.codigoTipoIdentificacion}">${value.nombreTipoIdentificacion}</option>`);
        })
    }
}

async function obtenerPaises(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/paises`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        // console.log('provincias', data);
        $('#pais').empty();
        $('#provincia').empty();
        $('#ciudad').empty();
        $.each(data.data, function(key, value){
            $('#pais').append(`<option esDefault-rel='${value.esDefault}' ${ (value.esDefault) ? 'selected' : '' } value="${value.codigoPais}">${value.nombrePais}</option>`);
        })
        
        return data.data;
    }

}

async function obtenerProvincias(codigoPais = 1){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/provincias?codigoPais=${codigoPais}`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        console.log('provincias', data);
        $('#provincia').empty();
        let tieneProvincias = false;
        $.each(data.data, function(key, value){
            tieneProvincias = true;
            $('#provincia').append(`<option value="${value.codigoProvincia}" codigoRegion-rel="${value.codigoRegion}">${value.nombreProvincia}</option>`);
        })

        if(tieneProvincias){
            console.log('Tiene provincias');
            $('#provincia').attr('disabled',false);
            await obtenerCiudades(codigoPais,getInput('provincia'));
        }else{
            console.log('No tiene provincias');
            $('#provincia').attr('disabled',true)
            $('#ciudad').attr('disabled',true)
        }
        
        return data.data;
    }

}

async function obtenerCiudades(codigoPais = 1, codigoProvincia){

    console.log(codigoProvincia);
    let args = [];
    // args["endpoint"] = api_url + `/${api_war}/v1/seguridad/ciudades?codigoPais=1&codigoProvincia="+getInput('provincia');
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/ciudades?codigoPais=${codigoPais}&codigoProvincia=${codigoProvincia}`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        $('#ciudad').empty();
        let tieneCiudades = false;
        $.each(data.data, function(key, value){
            tieneCiudades = true;
            $('#ciudad').append(`<option value="${value.codigoCiudad}">${value.nombreCiudad}</option>`);
        })

        if(tieneCiudades){
            console.log('Tiene ciudades');
            $('#ciudad').attr('disabled',false);
        }else{
            console.log('No tiene ciudades');
            $('#ciudad').attr('disabled',true)
        }

        return data.data;
    }
}

function isValidEmailAddress(emailAddress) {
    let pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function esValidaCedula(cedula) {
    var cad = cedula.trim();
    var total = 0;
    var longitud = cad.length;
    var longcheck = longitud - 1;

    if (cad !== "" && longitud === 10){
        for(i = 0; i < longcheck; i++){
            if (i%2 === 0) {
                var aux = cad.charAt(i) * 2;
                if (aux > 9) aux -= 9;
                total += aux;
            } else {
                total += parseInt(cad.charAt(i)); // parseInt o concatenarÃ¡ en lugar de sumar
            }
        }

        total = total % 10 ? 10 - total % 10 : 0;

        if (cad.charAt(longitud-1) == total) {
            //document.getElementById("salida").innerHTML = ("Cedula VÃ¡lida");
            return true;
        }else{
            //document.getElementById("salida").innerHTML = ("Cedula InvÃ¡lida");
            return false;
        }
    }

    return false;
}

async function verificarCuenta() {
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?tipoIdentificacion=${getInput('tipoIdentificacion')}&numeroIdentificacion=${getInput('numeroIdentificacion')}`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    try {
        const data = await call(args);
        if ('code' in data && data.code == 200 && data.data != null) {
            return true;
        }
    } catch (error) {
        console.error("Error al verificar la cuenta:", error);
    }

    return false;
}

function actualizarMaxlength(select) {
    let numeroIdentificacionInput = document.getElementById('numeroIdentificacion');
    if (select.value == "3") {
        numeroIdentificacionInput.setAttribute('maxlength', '13');
        numeroIdentificacionInput.type = "text";
        numeroIdentificacionInput.onkeypress = function (event) {
        var charCode = event.charCode;
        // Permitir caracteres alfabéticos (letras) y numéricos (números)
        if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode >= 48 && charCode <= 57)) {
            return true;
        }
        // Permitir teclas de control (backspace, enter)
        if (charCode == 8 || charCode == 13) {
            return true;
        }
        // Restringir otros caracteres
        return false;
    };

    } else {
        numeroIdentificacionInput.setAttribute('maxlength', '10');
        numeroIdentificacionInput.type = "number";
        numeroIdentificacionInput.onkeypress = function (event) {
            return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57;
        };
    }
}

async function registrarCuenta(){
    let args = [];
    args["endpoint"] = api_url_digitales + `/${api_war_digitales}/seguridad/cuenta`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["sendHeaders"] = false;
    // let fechaParts = getInput('fechaNacimiento').split('-');
    // let fechaFormateada = fechaParts[2] + '/' + fechaParts[1] + '/' + fechaParts[0];

    let mail = '';
    if(dataTurno.paciente.mail !== null){
        mail = dataTurno.paciente.mail.toLowerCase()
    }

    let payload = {
        "tipoIdentificacion": dataTurno.paciente.codigoTipoIdentificacion,
        "numeroIdentificacion": dataTurno.paciente.numeroIdentificacion,
        "primerApellido": dataTurno.paciente.primerApellido,
        // "segundoApellido": dataTurno.paciente.segundoApellido,
        "primerNombre": dataTurno.paciente.primerNombre,
        "mail": mail.toLowerCase(),
        "fechaNacimiento": dataTurno.paciente.fechaNacimiento,
        "genero": dataTurno.paciente.genero,
        "telfMovil": dataTurno.paciente.telefonoMovil,
        // "codPais": parseInt(getInput('pais')),
        // "codigoProv": parseInt(getInput('provincia')),
        // "codigoCiudad": parseInt(getInput('ciudad')),
        // "pass": getInput('password'),
        "canalOrigenDigital": _canalOrigen
    }

    if(dataTurno.paciente.codigoTipoIdentificacion == 3){
        // payload.codPais = parseInt(getInput('pais'));
    }
    
    args["data"] = JSON.stringify(payload);

    const data = await call(args);
    if(data.code == 200){
        $('.col-agenda').removeClass('d-none');
    }
    return data;
}

async function confirmarCuenta(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta/activacion`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
        "numeroIdentificacion": getInput('numeroIdentificacion'),
        "codigoActivacion": parseInt(getInput('codigoActivacion')),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}

async function sendCodeAgain(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/reenviarCodigoActivacion`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "tipoIdentificacion": tipoIdentificacion,
        "numeroIdentificacion": numeroIdentificacion,
        "canalOrigenDigital": _canalOrigen
    });
    console.log(args["endpoint"]);
    console.log(args["data"]);

    const data = await call(args);
    return data;
}

async function codigoReset(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/codigoreset`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
        "numeroIdentificacion": getInput('numeroIdentificacion'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}

async function recuperarContrasena(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta/clave`;
    args["method"] = "PUT";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "codigoUsuario": params.numeroIdentificacion,
        "codigoAutorizacion": parseInt(getInput('codigoAutorizacion')),
        "nuevaClave": getInput('password'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    if(data.code == 200){
        title = "Contraseña modificada";
        msg = "Tu contraseña ha sido modificada con éxito"
        $('#modalAlertButtonAccion').removeClass('w-50');
        $('#modalAlertButtonAccion').addClass('w-100');
        $('#modalAlertButtonAccion').attr('href','/login');
        $('#modalAlertButtonAccion').removeClass('d-none');
        
        $('#modalAlertButton').addClass('d-none');
        $('#modalAlertButtonAccion').html("Entendido");
        $('#modalAlertTitle').html(title);
        $('#modalAlertMessage').html(msg);
        $('#modalAlert').modal('show');
    }else{
        title = 'Veris';
        msg = `<span class="txt-alt">${recuperar.message}</span>`;
        $('#modalAlertButtonAccion').addClass('d-none');
        $('#modalAlertButton').removeClass('d-none');
        $('#modalAlertTitle').html(title);
        $('#modalAlertMessage').html(msg);
        $('#modalAlert').modal('show');
    }
    return data;
}


// funciones para el filtro pendientes, realizadas 

async function aplicarFiltros(contexto) {
    console.log("***********----------************")
    console.log('contexto', contexto);
    const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
    const parentesco = $('input[name="listGroupRadios"]:checked').attr('parentesco');
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';
    const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
    if (parentesco === 'YO') {

        esAdmin = 'S';
    }
    let estadoTratamiento;

    if ($('#pills-pendientes-tab').attr('aria-selected') === 'true') {
        estadoTratamiento = 'PENDIENTE';
    } else if ($('#pills-realizados-tab').attr('aria-selected') === 'true') {
        estadoTratamiento = 'REALIZADO';
    }

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await obtenerTratamientosId(pacienteSeleccionado, fechaDesde, fechaHasta, estadoTratamiento, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

async function aplicarFiltrosCitas(contexto) {
    const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
    console.log('pacientexx', pacienteSeleccionado);  
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';
    const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
    let estadoCitas;
    if (document.getElementById('pills-actuales-tab').getAttribute('aria-selected') === 'true') {
        estadoCitas = 'ACTUAL';
    } else if (document.getElementById('pills-historial-tab').getAttribute('aria-selected') === 'true') {
        estadoCitas = 'HISTORICO';
    }
    console.log(estadoCitas)

    console.log('estadoCitas', estadoCitas);    
    if (contexto === 'contextoAplicarFiltros') {
        if (estadoCitas === 'ACTUAL'){
            await obtenerCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
            obtenerHistorialCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
        }
        else if (estadoCitas === 'HISTORICO'){
            await obtenerHistorialCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
            obtenerCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
        }

    }
    $('#filtroTratamientos').offcanvas('hide');
    console.log("***********----------************")
}

// limpiar filtros
async function limpiarFiltros(contexto) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        let estado = document.getElementById('pills-pendientes-tab').getAttribute('aria-selected');
        if (estado === 'true') {
            await obtenerTratamientosId('', '', '', 'PENDIENTE');
            $('#filtroTratamientos').offcanvas('hide');
        } else {
            await obtenerTratamientosId('', '', '', 'REALIZADO');
            $('#filtroTratamientos').offcanvas('hide');
        }
    }
}

// aplicar filtros para resultados
async function aplicarFiltrosResultados(contexto, tipoServicio) {
    
    // capturar los datos de data-rel del input radio
    let datos = $('input[name="listGroupRadios"]:checked').attr('data-rel');
    datos = JSON.parse(datos);
    console.log('datosI8I',datos);
    let pacienteSeleccionado = datos.numeroIdentificacion;
    let tipoIdentificacion = datos.tipoIdentificacion;
    let esAdmin = datos.esAdmin;
    

    console.log('paciente',datos.tipoIdentificacion);
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await consultarResultadosPorTipo(pacienteSeleccionado, tipoIdentificacion, fechaDesde, fechaHasta, tipoServicio, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

// limpiar filtros para resultados
async function limpiarFiltrosResultados(contexto, tipoServicio) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        let pacienteSeleccionado = "{{ Session::get('userData')->numeroIdentificacion }}";
        let  tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        await consultarResultadosPorTipo(pacienteSeleccionado, tipoIdentificacion, '', '', tipoServicio, 'S');
    }
}


//aplicarfiltro ordenes externas
async function aplicarFiltrosOrdenesExternas(contexto) {
    
    // capturar los datos de data-rel del input radio
    let datos = $('input[name="listGroupRadios"]:checked').attr('data-rel');
    datos = JSON.parse(datos);
    console.log('datosI8I',datos.numeroIdentificacion);
    let pacienteSeleccionado = datos.numeroIdentificacion
    let tipoIdentificacion = datos.tipoIdentificacion;
    let esAdmin = datos.esAdmin;
    if (datos.parentesco === 'YO') {
        esAdmin = 'S';
    }

    console.log('paciente',datos.tipoIdentificacion);
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await consultarOrdenesExternasLaboratorio(pacienteSeleccionado, tipoIdentificacion, fechaDesde, fechaHasta, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

// limpiar filtros para ordenes externas

async function limpiarFiltrosOrdenesExternas(contexto, numeroIdentificacion, tipoIdentificacionn) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        
        let pacienteSeleccionado = numeroIdentificacion
        let  tipoIdentificacion = tipoIdentificacionn;
        await consultarOrdenesExternasLaboratorio(pacienteSeleccionado, tipoIdentificacion, '', '', 'S');
        $('#filtroTratamientos').offcanvas('hide');
    }

}


// formatear fecha
function formatearFecha(fecha) {
    if (!fecha) return '';

    const fechaObj = new Date(fecha);
    if (isNaN(fechaObj.getTime())) return '';

    const dia = fechaObj.getDate().toString().padStart(2, '0');
    const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
    const año = fechaObj.getFullYear();

    return `${dia}/${mes}/${año}`;
}


// mostrar lista de pacientes
function mostrarListaPacientesFiltro(){
    let data = familiar;
    let divContenedor = $('.listaPacientesFiltro');
    divContenedor.empty();
    data.forEach((Pacientes) => {
        let elemento = `<div class="position-relative">
                            <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} >
                            <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                            </label>
                        </div>`;
        divContenedor.append(elemento);
    });
}

async function verificarImagen(urlImagen) {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = function() {
            // La imagen se cargó exitosamente
            resolve(true);
        };
        img.onerror = function() {
            // Hubo un error al cargar la imagen
            resolve(false);
        };
        img.src = urlImagen;
    });
}


// async function verificarImagen(urlImagen, callback) {
//     var img = new Image();
//         img.onload = function() {
//         // La imagen se cargó exitosamente
//         callback(true);
//     };

//     img.onerror = function() {
//         // Hubo un error al cargar la imagen
//         callback(false);
//     };
//     img.src = urlImagen;
// }

// Ejemplo de uso
/*var urlImagen = 'https://ejemplo.com/imagen.jpg';

verificarImagen(urlImagen, function(existeImagen) {
    if (existeImagen) {
        console.log('La imagen existe y es accesible.');
    } else {
        console.log('La imagen no existe o no es accesible.');
    }
});*/

function roundToDraw(porcentajeAvanceTratamiento){
    return ((porcentajeAvanceTratamiento % 10 >= 5) ? Math.ceil(porcentajeAvanceTratamiento / 10) * 10 : Math.floor(porcentajeAvanceTratamiento / 10) * 10);
}

// Función para capitalizar la primera letra
function capitalizarPrimeraLetra(texto) {
    // Verificar si el texto es null o undefined
    if (texto === null || texto === undefined) {
        return '';
    }

    try {
        // Intenta realizar la capitalización
        return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
    } catch (error) {
        // En caso de error, imprime el error en la consola y retorna una cadena vacía
        console.error("Error al capitalizar:", error);
        return '';
    }
}



function capitalizarCadaPalabra(texto) {
    return texto.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
}

function capitalizarPalabrasUnidasPorGuion(cadena) {
    return cadena
    .split('-')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
    .join('-');
}

function agregarEspacios(cadena) {
    return cadena.replace(/\//g, ' / ');
}

function beforeUnloadHandler(event){
    // const beforeUnloadHandler = (event) => {
    // Recommended
    event.preventDefault();
    // Included for legacy support, e.g. Chrome/Edge < 119
    event.returnValue = true;
};

function formatearNumero(numero) {
    return numero.toFixed(2);
}

function truncateText(text, maxLength) {
    return text.length > maxLength ? text.slice(0, maxLength - 3) + '...' : text;
}

function determinarMeridiano(horaInicio){
    let partesHora = horaInicio.split(':');
    let hora = parseInt(partesHora[0]);
    let meridiano = "AM";
    if (hora >= 12) {
        meridiano = "PM";
    }
    return meridiano;
}

function determinarValoresNull(valor){
    if(valor == null){
        return '';
    }
    else{
        return valor;
    }
}

const determinarFechaCaducidadEncabezado = (datos, datosTratamiento) => {
    let dataFechas;
    
    if (Object.keys(datosTratamiento.datosConvenio).length > 0) {
        if (datos.estado == "PENDIENTE_AGENDAR" || datos.estado == null) {
            
            if (datos.esCaducado == "S") {
                if(datos.fechaCaducidad == null){
                    dataFechas = ``;
                } else {
                    dataFechas = `<p class="fs-14 line-height-16 mb-12 fw-normal">Orden expirada: <span class="fecha-cita text-red-dark me-2 text-capitalize">${determinarValoresNull(datos.fechaCaducidad).toLowerCase()}</span></p>`;
                }
            } else {
                // orden valida
                if(datos.fechaCaducidad == null){
                    
                    dataFechas = ``;
                    
                } else {
                    dataFechas = `<p class="fs-14 line-height-16 mb-12 fw-normal">Orden válida hasta: <span class="fecha-cita me-2 text-capitalize">${determinarValoresNull(datos.fechaCaducidad).toLowerCase()}</span></p>`;
            
                }
            }
        }
        else {
            dataFechas = ``;
        }
    } else {
        dataFechas = ``;
    }
    
    return dataFechas;
};

async function obtenerPreparacionPrevia(codigoSolicitud){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/preparacionPrevia?canalOrigen=${_canalOrigen}&codigoSolicitud=${ codigoSolicitud }`;
    args["method"] = "GET";
    args["showLoader"] = true;
    const data = await call(args);
    console.log(data);

    if (data.code == 200){
        let elem = ``;
        if(data.data !== null && data.data.length > 0){
            $.each(data.data, function(key, value){
                elem += `<p class="text-veris text-start fw-medium fs--2 mb-0">${capitalizarElemento(value.examenes)}</p>`;
                if(value.preparacionPrevia !== null && value.preparacionPrevia.length > 0){
                    $.each(value.preparacionPrevia, function(k,v){
                        elem += `<p class="fw-light text-start fs--2 line-height-16 mb-1">${v.charAt(0).toUpperCase() + v.slice(1).toLowerCase()}</p>`
                    })
                }
                elem += `<hr class="mb-2 mt-2">`
            })
        }else{
            elem += `<p class="text-veris text-center fw-medium fs--1 mt-5 mb-5">No existe preparación previa para estos exámenes.</p>`
        }
        $('.items-preparacion').html(elem);
        $('#modalPreparacionPrevia').modal("show")
    }
}

async function obtenerDatosReserva(codigoReserva){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/agenda/reserva/${codigoReserva}?canalOrigen=${_canalOrigen}`;
    
    args["method"] = "GET";
    args["showLoader"] = true;
    const data = await call(args);
    return data;
}

function capitalizarElemento(elemento) {
    try {
        
        if (!elemento) return "";
        const texto = elemento.trim().toLowerCase();
        
        const palabras = texto.split(/\s+/);

        for (let i = 0; i < palabras.length; i++) {
            const palabra = palabras[i];
            const primeraLetraMayuscula = palabra.charAt(0).toUpperCase();
            palabras[i] = primeraLetraMayuscula + palabra.substring(1);
            
        }

        const textoCapitalizado = palabras.join(" ");
        return textoCapitalizado;
    } catch (error) {
        console.error("Error en capitalizarElemento:", error); // Log de errores
        return elemento;
    }
}

function obtenerFechaHoraEnCurso(){
    const date = new Date();

    // Configurar el formateador para UTC-5
    const options = { timeZone: 'America/Bogota', hour12: false };
    const dateFormatter = new Intl.DateTimeFormat('es-EC', { ...options, year: 'numeric', month: '2-digit', day: '2-digit' });
    const timeFormatter = new Intl.DateTimeFormat('es-EC', { ...options, hour: '2-digit', minute: '2-digit' });

    // Formatear fecha y hora
    return dateFormatter.format(date) + " " +timeFormatter.format(date);
}

function actualizarFechaHora() {
    // Crear la fecha actual
    const date = new Date();

    // Configurar el formateador para UTC-5
    const options = { timeZone: 'America/Bogota', hour12: false };
    const dateFormatter = new Intl.DateTimeFormat('es-EC', { ...options, year: 'numeric', month: '2-digit', day: '2-digit' });
    const timeFormatter = new Intl.DateTimeFormat('es-EC', { ...options, hour: '2-digit', minute: '2-digit' });

    // Formatear fecha y hora
    const formattedDate = dateFormatter.format(date); // Ejemplo: 27/11/2024
    const formattedTime = timeFormatter.format(date); // Ejemplo: 15:45

    // console.log(formattedDate)
    // console.log(formattedTime)

    // Actualizar los elementos con jQuery
    $('#fecha').text(formattedDate);
    $('#hora').text(formattedTime);
}

function iniciarCountdownDesdeAtributos() {
    // Seleccionamos todos los elementos con la clase 'countdown'
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(countdown => {
        // Obtener la fecha de inicio desde el atributo data-rel (formato "dd/mm/yyyy hh:mm")
        const fechaLimite = countdown.getAttribute('data-rel'); // Ejemplo: "28/11/2024 07:00"

        // Parsear la fecha desde el formato "dd/mm/yyyy hh:mm"
        const [day, month, year, hour, minute] = fechaLimite.split(/[\/\s:]/);

        // Crear un objeto Intl.DateTimeFormat para la zona horaria UTC-5
        const dateFormatter = new Intl.DateTimeFormat('en-US', {
            timeZone: 'America/Bogota',  // Zona horaria UTC-5
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
        });

        // Crear la fecha límite en formato "yyyy-mm-dd hh:mm:ss" para usarlo en un nuevo Date
        const fechaLimiteString = `${month}/${day}/${year} ${hour}:${minute}:00`;
        const fechaLimiteUTC5 = new Date(dateFormatter.format(new Date(fechaLimiteString)));

        // Función para actualizar el contador
        const actualizarCountdown = () => {
            // Obtener la fecha actual en UTC-5
            const fechaActual = new Date();
            const fechaActualUTC5 = new Date(fechaActual.toLocaleString('en-US', { timeZone: 'America/Bogota' }));

            // Calcular la diferencia entre la fecha límite y la fecha actual en UTC-5
            let diff = fechaLimiteUTC5 - fechaActualUTC5;

            if (diff <= 0) {
                countdown.textContent = "Tiempo agotado";
            } else {
                // Calcular horas, minutos y segundos restantes
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                // Formatear las horas, minutos y segundos para que siempre tengan 2 dígitos
                const formattedHours = String(hours).padStart(2, '0');
                const formattedMinutes = String(minutes).padStart(2, '0');
                const formattedSeconds = String(seconds).padStart(2, '0');

                // Formatear el tiempo restante
                countdown.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
            }
        };

        // Inicializar el contador al cargar la página
        actualizarCountdown();

        // Actualizar el countdown cada segundo
        setInterval(actualizarCountdown, 1000);
    });
}

function tieneTiempo(fechaLimite) {
    // Obtener la fecha de inicio desde el atributo data-rel (formato "dd/mm/yyyy hh:mm")

    // Parsear la fecha desde el formato "dd/mm/yyyy hh:mm"
    const [day, month, year, hour, minute] = fechaLimite.split(/[\/\s:]/);

    // Crear un objeto Intl.DateTimeFormat para la zona horaria UTC-5
    const dateFormatter = new Intl.DateTimeFormat('en-US', {
        timeZone: 'America/Bogota',  // Zona horaria UTC-5
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });

    // Crear la fecha límite en formato "yyyy-mm-dd hh:mm:ss" para usarlo en un nuevo Date
    const fechaLimiteString = `${month}/${day}/${year} ${hour}:${minute}:00`;
    const fechaLimiteUTC5 = new Date(dateFormatter.format(new Date(fechaLimiteString)));
    const fechaActual = new Date();
    const fechaActualUTC5 = new Date(fechaActual.toLocaleString('en-US', { timeZone: 'America/Bogota' }));

    // Calcular la diferencia entre la fecha límite y la fecha actual en UTC-5
    let diff = fechaLimiteUTC5 - fechaActualUTC5;

    if (diff <= 0) {
        return false;
    }

    return true;
}

function obtenerDiferenciaDiasIntl(fechaStr) {
  const options = { timeZone: 'America/Bogota', hour12: false };
  const dateFormatter = new Intl.DateTimeFormat('es-EC', { ...options, year: 'numeric', month: '2-digit', day: '2-digit' });

  // Descomponer la fecha dada (formato dd/mm/yyyy)
  const [dia, mes, anio] = fechaStr.split('/').map(Number);

  // Crear el objeto Date con la zona horaria especificada para la fecha ingresada
  const fechaIngresada = new Date(Date.UTC(anio, mes - 1, dia));
  const fechaActual = new Date();

  // Formatear la fecha actual para asegurarse de respetar la zona horaria
  const fechaActualFormat = dateFormatter.format(fechaActual);
  const [diaActual, mesActual, anioActual] = fechaActualFormat.split('/').map(Number);

  const fechaActualUTC = new Date(Date.UTC(anioActual, mesActual - 1, diaActual));

  // Calcular la diferencia en milisegundos y convertirla a días
  const diferenciaMilisegundos = fechaIngresada - fechaActualUTC;
  const diferenciaDias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));

  return diferenciaDias;
}

function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function formatearFechaMesDia(horaInicio) {
    // Crear un objeto Date a partir de la cadena
    const fecha = new Date(horaInicio.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3'));

    // Definir los nombres abreviados de los meses
    const meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"];

    // Obtener los componentes de la fecha
    const mes = meses[fecha.getMonth()]; // Mes abreviado
    const dia = fecha.getDate(); // Día
    const anio = fecha.getFullYear(); // Año
    let horas = fecha.getHours(); // Horas
    const minutos = String(fecha.getMinutes()).padStart(2, '0'); // Minutos con dos dígitos

    // Determinar AM/PM y ajustar la hora
    const periodo = fecha.getHours() >= 12 ? "PM" : "AM";

    // Formatear la fecha final
    return `${mes} ${dia}, ${anio}|${horas}:${minutos} ${periodo}`;
}

function esDiaEnCurso(horaInicio) {
    // Convertir la fecha de "dd/MM/yyyy HH:mm" a un objeto Date
    const [fecha, hora] = horaInicio.split(" ");
    const [dia, mes, anio] = fecha.split("/").map(Number);
    const [horas, minutos] = hora.split(":").map(Number);

    // Crear objeto Date en UTC y ajustarlo a la zona horaria de Guayaquil
    const fechaInicio = new Date(Date.UTC(anio, mes - 1, dia, horas, minutos));

    // Obtener la fecha actual en la zona horaria de Guayaquil
    const formatter = new Intl.DateTimeFormat("es-EC", { timeZone: "America/Guayaquil", year: "numeric", month: "2-digit", day: "2-digit" });
    const hoy = new Date();
    
    // Obtener la fecha actual en Guayaquil sin la hora
    const fechaHoyStr = formatter.format(hoy);
    const [diaHoy, mesHoy, anioHoy] = fechaHoyStr.split("/").map(Number);

    // Comparar si pertenece al día en curso
    return anio === anioHoy && mes === mesHoy && dia === diaHoy;
}

function generateUUIDv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        const r = (Math.random() * 16) | 0; // Genera un número aleatorio entre 0 y 15
        const v = c === 'x' ? r : (r & 0x3) | 0x8; // Asegura que el formato cumple con UUID v4
        return v.toString(16); // Convierte el número a hexadecimal
    });
}

function isKiosk() {
    let isPC = /(win|mac|linux)/i.test(navigator.platform);
    let isTablet = navigator.userAgent.toLowerCase().match(/(ipad|android(?!.*mobi)|tablet|playbook|silk)/i);
    if(isTablet !== null && !isPC){
        return false;
    }
    if (window.matchMedia("(orientation: portrait)").matches) {
        return true;
        console.log("El monitor está en modo Portrait");
    } else {
        console.log("El monitor está en modo Landscape");
        return false;
    }
}

function limitarCaracteres(input, maxCaracteres) {
    // Obtén el valor actual del campo de entrada
    var valor = input.value;

    // Limita la longitud del valor a `maxCaracteres`
    if (valor.length > maxCaracteres) {
        valor = valor.slice(0, maxCaracteres);
    }

    // Establece el valor limitado en el campo de entrada
    input.value = valor;
}

async function agregarItem(datosPago, pagoUnico = false, onlyReturn = false){
    //console.log(datosPago);
    let args = [];
    args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/agregar?macAddress=${mac}&idPaciente=${datosCliente.idPaciente}`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["token"] = accessToken;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify(datosPago);
    const data = await call(args);
    console.log(data);
    if(data.code == 200){
        // Para no pasar proceso de facturacion ni pago, y manejarlo dentro de la misma vista
        if(pagoUnico){
            localStorage.setItem("itemAgregado", JSON.stringify(data.data));
            if(onlyReturn){
                return data;
            }
            location.href = `/datos-facturacion/${mac}`;
        }else{
            location.href = `/carrito/${mac}`;
        }
    }else{
        $('#modalError').modal('show');
        $('.titleError').html(`Atención`);
        $('.msgError').html(data.message);
    }
}

async function obtenerAgrupaciones(){
    let esPagoUnico = (localStorage.getItem("itemAgregado") !== null) ? true : false;
    let agrupacionesArr = []
    if(esPagoUnico){
        let detalle = JSON.parse(localStorage.getItem("itemAgregado"));
        agrupacionesArr.push(detalle[0].idAgrupacion);
    }else{
        $.each(infoCarrito, function(key, value){
            $.each(value.agrupaciones, function(k,v){
                agrupacionesArr.push(v.idAgrupacion)
            })
        })
    }
    console.table(agrupacionesArr)
    localStorage.setItem("agrupacionFacturar", JSON.stringify(agrupacionesArr));
    return agrupacionesArr
}

async function generarTurno(){
    //localStorage.getItem("idPreTransaccion")
    let args = [];
    args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/generar_turno?macAddress=${mac}&idPaciente=${datosCliente.idPaciente}`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["token"] = accessToken;
    args["bodyType"] = "json";
    let payload = {
        "tipoIdentificacion": datosCliente.nombreTipoIdentificacion,
        "numeroIdentificacion": datosCliente.numeroIdentificacion,
        "nombreCompleto": datosCliente.nombreCompleto
    }
    if(localStorage.getItem('tipoTurnoGenerar') !== "demanda"){
        payload.idPreTransaccion = parseInt(localStorage.getItem('idPreTransaccion'))
    }
    args["data"] = JSON.stringify(payload);
    const data = await call(args);
    console.log(data);
    if(data.code == 200){
        await printTurnoAPI(data.data)
    }
    return data;
}

async function printTurnoAPI(detalle){
    let args = [];
    args["endpoint"] = `http://localhost:3002/printer-ticket/v1/turnero?turno=${detalle.turno}&sucursal=${detalle.nombreSucursalTurnero.toUpperCase()}&paciente=${detalle.nombreCompleo}&fechaTicket=${detalle.fechaEmision}&nombreMuestraTurnero=${detalle.nombreMuestraTurnero}`;
    args["method"] = "GET";
    const data = await call(args);
    if(data.code == 200){
        // console.log(data)
    }
    return;
}