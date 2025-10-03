@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/carrito/'.$mac])
	{{-- @include('components.sub-header', ['showTurnoBtn' => true, 'url' => url()->previous() ]) --}}
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Revisa los datos de facturación'])
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => ''])
			</div>
			<div class="col-8 offset-1 px-3 d-flex flex-column overflow-auto contenido-central mt-0 pt-74" style="overflow-y: auto;">
				<div class="row mx-0">
					<div class="col-6">
	                    <label for="tipoIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Elige tu documento *</label>
	                    <select class="form-select input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3 text-capitalize" name="tipoIdentificacion" id="tipoIdentificacion" required>
	                        {{-- <option value="2">CÉDULA</option>
	                        <option value="1">RUC</option> --}}
	                    </select>
	                    <div class="invalid-feedback">
	                        Elegir el tipo de documento.
	                    </div>
	                </div>
	                <div class="col-6">
	                    <label for="numeroIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Número de documento *</label>
	                    <input type="number" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="" required readonly data-kb="numeric"/>
	                    <div class="invalid-feedback">
	                        Ingrese un número de identificacion.
	                    </div>
	                </div>
	                <div class="col-12 mt-3">
	                    <label for="nombresCompletos" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Nombres completos *</label>
	                    <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="nombresCompletos" id="nombresCompletos" placeholder="" required readonly/>
	                    <div class="invalid-feedback">
	                        Ingrese su nombres y apellidos.
	                    </div>
	                </div>
	                <div class="col-12 mt-3">
	                    <label for="mail" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Correo electrónico *</label>
	                    <input type="email" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="mail" id="mail" placeholder="" required readonly data-kb="full"/>
	                    <div class="valid-feedback">
	                        Ingrese un correo electronico.
	                    </div>
	                </div>
					<div class="col-8 offset-2 bg-silver rounded-8 mt-5">
	                    <ul class="list-group fs--1 bg-silver py-24 px-3">
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fw-medium fs-24 line-height-28 mb-3">
	                            Detalle de factura
	                        </li>
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
	                            Subtotal
	                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="subtotal"></span>
	                        </li>
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
	                            Crédito/convenio
	                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="creditoConvenio"></span>
	                        </li>
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
	                            Descuento aplicado
	                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="descuentoAplicado"></span>
	                        </li>
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
	                            IVA
	                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="iva"></span>
	                        </li>
	                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20 fw-bold">
	                            Total
	                            <span class="badge text-dark fs-20 line-height-20 fw-bold" id="total"></span>
	                        </li>
	                    </ul>
	                </div>
		            <div class="col-12 text-center mt-4">
		                <div class="form-check d-flex justify-content-md-center align-items-center">
		                    <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required style="width: 20px; height: 20px;">
		                    <label class="form-check-label fs-20 fw-medium line-height-24" for="">
		                        Acepto los <div type="button" class="text-decoration-underline text-royal-blue d-inline-block" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y condiciones</div> 
		                        <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span>
		                    </label>
		                    <div class="invalid-feedback">
		                        Debes aceptar antes de enviar
		                    </div>
		                </div>
		            </div>
		            <div class="col-12 mt-4 text-center">
		            	<button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-50 fw-medium shadow-none disabled" id="btn-validar-datos-factura">Pagar ahora</button>
		            </div>
	            </div>
			</div>
		</div>
	</main>
	<div class="w-100 bg-silver-light p-44 position-absolute bottom-0 start-0 d-none" id="box-simple-keyboard">
		<div class="simple-keyboard"></div>
	</div>
	{{-- <div class="row mx-0">
		<div class="col-10 offset-1 py-40 px-4 border mt-40">
			<div class="row">
				
				<div class="col-6">
                    <label for="tipoIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Elige tu documento *</label>
                    <select class="form-select input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3 text-capitalize" name="tipoIdentificacion" id="tipoIdentificacion" required>
                    </select>
                    <div class="invalid-feedback">
                        Elegir el tipo de documento.
                    </div>
                </div>
                <div class="col-6">
                    <label for="numeroIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Número de documento *</label>
                    <input type="number" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="" required />
                    <div class="invalid-feedback">
                        Ingrese un numero de identificacion.
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <label for="nombresCompletos" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Nombres completos *</label>
                    <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="nombresCompletos" id="nombresCompletos" placeholder="" required />
                    <div class="invalid-feedback">
                        Ingrese su nombres y apellidos.
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <label for="mail" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Correo electrónico *</label>
                    <input type="email" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="mail" id="mail" placeholder="" required />
                    <div class="valid-feedback">
                        Ingrese un correo electronico.
                    </div>
                </div>
				<div class="col-6 offset-3 bg-silver rounded-8 mt-5">
                    <ul class="list-group fs--1 bg-silver py-24 px-3">
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fw-medium fs-24 line-height-28 mb-3">
                            Detalle de factura
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            Subtotal
                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="subtotal"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            Crédito/convenio
                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="creditoConvenio"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            Descuento aplicado
                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="descuentoAplicado"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            IVA
                            <span class="badge text-dark fw-normal fs-20 line-height-20" id="iva"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20 fw-bold">
                            Total
                            <span class="badge text-dark fs-20 line-height-20 fw-bold" id="total"></span>
                        </li>
                    </ul>
                </div>
	            <div class="col-12 text-center mt-4">
	                <div class="form-check d-flex justify-content-md-center align-items-center">
	                    <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required style="width: 20px; height: 20px;">
	                    <label class="form-check-label fs-20 fw-medium line-height-24" for="">
	                        Acepto los <div type="button" class="text-decoration-underline text-royal-blue d-inline-block" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y condiciones</div> 
	                        <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span>
	                    </label>
	                    <div class="invalid-feedback">
	                        Debes aceptar antes de enviar
	                    </div>
	                </div>
	            </div>
	            <div class="col-12 mt-4 text-center">
	            	<button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-50 fw-medium shadow-none disabled" id="btn-validar-datos-factura">Pagar ahora</button>
	            </div>
            </div>
		</div>
		<div class="col-10 offset-1 mt-56 bg-silver-light p-44 d-none">
			<div class="simple-keyboard"></div>
		</div>
	</div> --}}
	@include('components.footer')
</div>
<style>
	.box-icon-home{
		width: 150px;
		height: 120px;
	}
	.box-icon-home img{
		max-width: 80px;
		object-fit: cover;
	}
	.simple-keyboard{
		width: 100%;
		margin: auto;
		background: transparent !important;
	}
</style>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tipo = localStorage.getItem('tipo');
	trackId = localStorage.getItem('trackId');
	let infoCarrito;
	tecladoFlotante = true;
	
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)

		await consultarCarrito();
		await obtenerDatosFacturacion();

		$.customKeyboard.init('input[readonly]', '.simple-keyboard');

		$('body').on('change', 'input[type="text"], input[type="number"]', async function() {
			let currentInput = $(this);
			let input = $(this).val();
			let max = $(currentInput).attr("maxlength"); // obtiene el maxlength del input
		    if(max && input.length > max){
		    	input = input.substring(0, max); // corta el valor
		    }
			$(currentInput).val(input);
			console.log(input)

			if(currentInput.attr('id') === "numeroIdentificacion"){
				// Verifica que el tipo sea 2
				if(parseInt($('#tipoIdentificacion option:selected').val()) == 2){
				// Verifica longitud 10
					if(input.length == 10){

						if(!esValidaCedula(input)){
							$('#modalError').modal('show');
							$('.titleError').html(`Atención`);
							$('.msgError').html(`Número de cédula incorrecto.`);
						} else {
							await verificarDatosFacturacion();
						}

					}
				}else if(parseInt($('#tipoIdentificacion option:selected').val()) == 1){
					console.log(input)
					console.log(input.length)
					if(input.length == 13){
						await verificarDatosFacturacion();
					}
				}
			}
		})

		$(document).on('click', function(e) {
		    if ($('#box-simple-keyboard').is(':visible') && 
		    	!$(e.target).closest('#box-simple-keyboard').length && 
		    	!$(e.target).is('input')
    		){
		        $('#box-simple-keyboard').addClass('d-none');
    		}
		});

  		// Detectar qué input tiene el foco
		{{-- $("input").on("focus", function(){
			$('#box-simple-keyboard').removeClass('d-none');
			if (this.type === "checkbox") {
				return; // no hacer nada
			}
			currentInput = this;
			keyboardInit.setInput($(this).val());
		}); --}}

		$('body').on('change', '#tipoIdentificacion', function(){
			datosSeteados = false;
			$('#numeroIdentificacion').val('')
			$('#nombresCompletos').val('')
			$('#mail').val('')
			if(parseInt($(this).val()) == 3){
				$('#numeroIdentificacion').attr('type','text');
				$('#numeroIdentificacion').attr('maxlength','15');
			}else{
				if(parseInt($(this).val()) == 1){
					$('#numeroIdentificacion').attr('maxlength','13');
				}else{
					$('#numeroIdentificacion').attr('maxlength','10');
				}
				$('#numeroIdentificacion').attr('type','number');
			}
			setTimeout(function(){
				// $('#numeroIdentificacion').focus();
			},100)
		})

		{{-- $('body').on('blur', '#numeroIdentificacion', async function(){
			console.log(0)
			if(parseInt($('#tipoIdentificacion option:selected').val()) == 2){
				console.log(1)
				if($('#numeroIdentificacion').val().length == 10){
					console.log(2)
					if(!esValidaCedula($('#numeroIdentificacion').val())){
						console.log(3)
						$('#modalError').modal('show')
						$('.titleError').html(`Atención`)
						$('.msgError').html(`Número de cédula incorrecto.`);
					}else{
						console.log(4)
						await verificarDatosFacturacion();
					}
				}
			}
		}) --}}
		
		$('body').on('change', '#checkTerminosCondicion', function(){
            validateFields();
        });

		$('body').on('click', '#btn-validar-datos-factura', async function(){
			if(!datosSeteados){
				if($('#numeroIdentificacion').val().length > 0 && $('#nombresCompletos').val().length > 0 && $('#mail').val().length > 0){
					await setearDatosFactura();
				}else{
					$('#modalError').modal('show');
					$('.titleError').html(`Atención`);
					$('.msgError').html("Revise los campos obligatorios para la facturación.");
				}
			}else{
				if($('#numeroIdentificacion').val().length > 0 && $('#nombresCompletos').val().length > 0 && $('#mail').val().length > 0){
					let tieneSoloExentos = await tieneSoloExentosBool();
					if(tieneSoloExentos){
						await facturar();
					}else{
						location.href = `/metodos-pago/{{ $mac }}`
					}
				}else{
					$('#modalError').modal('show');
					$('.titleError').html(`Atención`);
					$('.msgError').html("Revise los campos obligatorios para la facturación.");
				}
			}
		})
	})

	async function tieneSoloExentosBool(){
		let subtotal = 0;
		$.each(infoCarrito, function(key, value){
			$.each(value.agrupaciones, function(k, item){
				subtotal += item.totalAgrupacion.paciente.valorTotal;
			})
		})
		if(subtotal == 0){
			return true;
		}else{
			return false;
		}
	}

	function validateFields(){
		if($('#checkTerminosCondicion').is(':checked')) {
			// validar datos llenos
            $('#btn-validar-datos-factura').removeClass('disabled');
        } else {
            $('#btn-validar-datos-factura').addClass('disabled');
        }
	}

	async function consultarCarrito(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/consultar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        infoCarrito = data.data;
	}

	function onChange(input) {
		document.querySelector(".input").value = input;
		console.log("Input changed", input);
	}
	 
	function onKeyPress(button) {
	  	console.log("Button pressed", button);
	}

	async function setearDatosFactura(){
		let agrupaciones = await obtenerAgrupaciones();
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/agregar_datos_factura?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
		  	"codigoTipoIdentificacion": parseInt($('#tipoIdentificacion option:selected').val()),
		  	"numeroIdentificacion": $('#numeroIdentificacion').val(),
		  	"nombreCompleto": $('#nombresCompletos').val(),
		  	"email": $('#mail').val(),
		  	"idAgrupacion": agrupaciones
		})
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	let tieneSoloExentos = await tieneSoloExentosBool();
			if(tieneSoloExentos){
				await facturar();
			}else{
				location.href = `/metodos-pago/{{ $mac }}`
			}
		}else{
			$('#modalError').modal('show');
			$('.titleError').html(`Atención`);
			$('.msgError').html(data.message);
		}
	}

	let datosSeteados = false;
	async function verificarDatosFacturacion(){
		let numeroIdentificacion = ($('#tipoIdentificacion option:selected').val() !== "3") ? $('#numeroIdentificacion').val() : $('#numeroIdentificacion').val().toUpperCase()
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/verificar_datos_factura?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
		  	"codigoTipoIdentificacion": parseInt($('#tipoIdentificacion option:selected').val()),
		  	"numeroIdentificacion": numeroIdentificacion
		})
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	datosSeteados = data.data.datosSeteados;
        	if(data.data.esMenorDeEdad){
        		$('#modalError').modal('show');
				$('.titleError').html(`Atención`);
				$('.msgError').html(`Número de cédula <b>${$('#numeroIdentificacion').val()}</b> pertenece a menor de edad.`);
	        	$('#numeroIdentificacion').val('')
	        	$('#nombresCompletos').val('')
				$('#mail').val('')
        	}else{
	        	$('#nombresCompletos').val(data.data.nombreCompleto)
				$('#mail').val(data.data.mail)
			}
        }else{
        	datosSeteados = false;
        	$('#nombresCompletos').val('')
			$('#mail').val('')
        }
	}

	let datosFacturacion;
	async function obtenerDatosFacturacion(){
		let agrupaciones = await obtenerAgrupaciones();
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/datos_facturacion?idAgrupacion=${agrupaciones.join(',')}&macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        datosFacturacion = data.data;
        if(data.code == 200){
        	let options = ``;
			$.each(data.data.tiposIdentificacion, function(key, value){
				options += `<option class="text-capitalize" value="${value.codigoTipoIdentificacion}">${value.nombreTipoIdentificacion.toLowerCase()}</option>`
			})
			$('#tipoIdentificacion').html(options);
			$('#subtotal').html(`$${datosFacturacion.totales.subtotalVenta.toFixed(2)}`);
			$('#creditoConvenio').html(`$${datosFacturacion.totales.valorTotalCliente.toFixed(2)}`);
			$('#descuentoAplicado').html(`$${datosFacturacion.totales.valorDescuento.toFixed(2)}`);
			$('#iva').html(`$${datosFacturacion.totales.valorIva.toFixed(2)}`);
			$('#total').html(`$${datosFacturacion.totales.valorTotalPaciente.toFixed(2)}`);
        	if(data.data.datosFactura !== null){
        		await fillFormDatosFactura();
        		datosSeteados = true;
        	}else{
        		// $('.simple-keyboard').parent().removeClass('d-none')
        	}
        }
	}

	async function fillFormDatosFactura(){

		$('#tipoIdentificacion').val(parseInt(datosFacturacion.datosFactura.codigoTipoIdentificacion));
		$('#numeroIdentificacion').val(datosFacturacion.datosFactura.numeroIdentificacion)
		$('#nombresCompletos').val(datosFacturacion.datosFactura.nombreCompleto)
		$('#mail').val(datosFacturacion.datosFactura.email)

		if(parseInt(datosFacturacion.datosFactura.codigoTipoIdentificacion) == 2){
			$('#numeroIdentificacion').attr('type','number');
			$('#numeroIdentificacion').attr('maxlength','10');
		}else{
			$('#numeroIdentificacion').attr('type','text');
			$('#numeroIdentificacion').attr('maxlength','15');
		}
		setTimeout(function(){
			// $('#numeroIdentificacion').focus();
			setTimeout(function(){
				// $('.simple-keyboard').parent().removeClass('d-none');
			},100)
		},100)
	}

	async function facturar(){
		let agrupacion = JSON.parse(localStorage.getItem("agrupacionFacturar"));
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/facturar?macAddress={{ $mac }}`;//&esPrueba=true
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
        	"idAgrupacion":agrupacion
        });
        args["dismissAlert"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	location.href = `/pago-realizado/{{ $mac }}`;
        }else{
			$('#modalError').modal('show')
			$('.titleError').html(`Ha ocurrido un error`)
			$('.msgError').html(data.message);
        }
	}
</script>
@endsection