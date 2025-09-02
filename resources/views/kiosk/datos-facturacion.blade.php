@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Revisa los datos de facturación'])
	<div class="row mx-0">
		<div class="col-10 offset-1 py-40 px-4 border mt-40">
			<div class="row">
				{{-- <div class="col-6">
					<label class="text-silver-neutral-40 form-label" for="tipoIdentificacion">Tipo de identificación</label>
					<input type="text" class="form-control input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" name="tipoIdentificacion" id="tipoIdentificacion">
				</div>
				<div class="col-6">
					<label class="text-silver-neutral-40 form-label" for="numeroIdentificacion">Número de identificación</label>
					<input type="text" class="form-control input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" name="numeroIdentificacion" id="numeroIdentificacion">
				</div> --}}
				<div class="col-6">
                    <label for="tipoIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Elige tu documento *</label>
                    <select class="form-select input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3 text-capitalize" name="tipoIdentificacion" id="tipoIdentificacion" required>
                        {{-- <option value="2">CÉDULA</option>
                        <option value="1">RUC</option> --}}
                    </select>
                    <div class="invalid-feedback">
                        Elegir el tipo de documento.
                    </div>
                </div>
                <div class="col-6">
                    <label for="numeroIdentificacion" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Número de documento *</label>
                    <input type="number" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
                    <div class="invalid-feedback">
                        Ingrese un numero de identificacion.
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <label for="nombresCompletos" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Nombres completos *</label>
                    <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" name="nombresCompletos" id="nombresCompletos" placeholder="" required />
                    <div class="invalid-feedback">
                        Ingrese su nombres y apellidos.
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <label for="mail" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Correo electrónico *</label>
                    <input type="email" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
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
                            <span class="badge text-dark fw-normal" id="subtotal"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            Crédito/convenio
                            <span class="badge text-dark fw-normal" id="creditoConvenio"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            Descuento aplicado
                            <span class="badge text-dark fw-normal" id="descuentoAplicado"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20">
                            IVA
                            <span class="badge text-dark fw-normal" id="iva"></span>
                        </li>
                        <li class="bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fs-20 mb-2 line-height-20 fw-bold">
                            Total
                            <span class="badge text-dark fw-bold" id="total"></span>
                        </li>
                    </ul>
                </div>
	            <div class="col-12 text-center mt-4">
	                <div class="form-check d-flex justify-content-md-center align-items-center">
	                    <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required>
	                    <label class="form-check-label fs--1 fw-medium line-height-16" for="checkTerminosCondicion">
	                        Acepto los <a href="https://www.veris.com.ec/terminos-y-condiciones/" target="_blank" class="">Términos y condiciones</a> 
	                        <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span>
	                    </label>
	                    <div class="invalid-feedback">
	                        Debes aceptar antes de enviar
	                    </div>
	                </div>
	            </div>
	            <div class="col-12 mt-4 text-center">
	            	<button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-validar-datos-factura">Pagar ahora</button>
	            </div>
            </div>
		</div>
		<div class="col-10 offset-1 mt-56 bg-silver-light p-44">
			<div class="simple-keyboard"></div>
		</div>
	</div>
	@include('components.footer')
</div>
<script src="https://unpkg.com/simple-keyboard@latest/build/index.js"></script>
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
	.hg-button.hg-standardBtn,
	.hg-button.hg-functionBtn{
		font-size: 24px !important;
		line-height: 44px !important;
		padding: 5px 0px !important;
		height: auto !important;
		border: 1px solid #13243F;
		box-shadow: none !important;
		margin: 5px !important;
		border-radius: 8px !important;
	}

	.numeric-theme .hg-button[data-skbtnuid="default-r3b0"]{
		visibility: hidden;
	}

	.hg-button[data-skbtnuid="default-r1b10"]{
		border: none !important;
		background: var(--royalBlue) !important;
		font-size: 30px !important;
		color: #fff !important;
	}
	.hg-button[data-skbtn="{space}"] {
		flex: 8; /* ocupa el triple de espacio que una tecla normal */
	}
	.hg-button.hg-standardBtn, .hg-button.hg-functionBtn{
		width: 20px;
	}
	{{-- .hg-layout-numbers .hg-rows {
	    width: 70%;
	    margin: auto;
	} --}}
	.hg-layout-numbers .hg-button.hg-standardBtn,
	.hg-layout-numbers .hg-button.hg-functionBtn{
		font-size: 36px !important;
		margin: 12px !important;
		padding: 20px 0px !important;
	}

	.hg-layout-numbers .hg-button[data-skbtnuid="numbers-r3b2"]{
		border: none !important;
		background: transparent !important;
		font-size: 42px !important;
	}

	{{-- .hg-layout-numbers .hg-button.hg-standardBtn,
	.hg-layout-numbers .hg-button.hg-functionBtn{
	    font-size: 36px !important;
	    line-height: 44px !important;
	    padding: 10px 0px !important;
	    height: auto !important;
	    border: 1px solid #13243F;
	    box-shadow: none !important;
	    margin: 10px !important;
	    border-radius: 8px !important;
	}

	.hg-layout-numbers .hg-button[data-skbtnuid="default-r3b0"]{
		visibility: hidden;
	}

	.hg-layout-numbers .hg-button[data-skbtnuid="default-r3b2"]{
		border: none !important;
		background: transparent !important;
		font-size: 42px !important;
	} --}}
</style>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tipo = localStorage.getItem('tipo');
	let currentInput = null;
	trackId = localStorage.getItem('trackId');

	document.addEventListener("DOMContentLoaded", async function () {
		const Keyboard = window.SimpleKeyboard.default;

		let keyboard = new Keyboard({
			onChange: input => {
				if(currentInput){
					$(currentInput).val(input);
				}
			},
			onKeyPress: button => {
				if(button === "{bksp}" && currentInput){
					let val = $(currentInput).val();
					$(currentInput).val(val.slice(0, -1));
					keyboard.setInput($(currentInput).val());
				}

    			// 👉 Aquí manejamos los cambios de layout
				if(button === "{shift}" || button === "{lock}"){
					handleShift();
				}

				if(button === "{numbers}"){
					keyboard.setOptions({
						layoutName: "numbers"
					});
				}

				if(button === "{abc}"){
					keyboard.setOptions({
						layoutName: "default"
					});
				}
			},
			mergeDisplay: true,
			layoutName: "default",
			layout: {
				default: [
					"q w e r t y u i o p {backspace}",
					"a s d f g h j k l ñ {ent}",
					"{shift} z x c v b n m -",
					"{numbers} @ {space} . _"
				],
				shift: [
					"Q W E R T Y U I O P {backspace}",
					"A S D F G H J K L Ñ {ent}",
					"{shift} Z X C V B N M -",
					"{numbers} @ {space} . _"
				],
				numbers: [
					"1 2 3",
					"4 5 6",
					"7 8 9",
					"{abc} 0 {backspace}"
				]
			},
			display: {
				"{numbers}": "123",
				"{ent}": "<i class='fa-solid fa-arrow-right'></i>",
				"{escape}": "esc ⎋",
				"{tab}": "tab ⇥",
				"{backspace}": "<i class='fa fa-backspace'></i>",
				"{capslock}": "caps ⇪",
				"{shift}": "⇧",
				"{abc}": "ABC"
			}
		});

		$("input").on("focus", function () {
		  currentInput = this;

		  // Si el input tiene clase "numeric", mostramos el teclado numérico
		  if ($(this).hasClass("numeric")) {
		    keyboard.setOptions({
		      layoutName: "numbers"
		    });
		  } else {
		    // Para los demás, dejamos el teclado por defecto (letras)
		    keyboard.setOptions({
		      layoutName: "default"
		    });
		  }

		  // Sincronizamos valor actual del input con el teclado
		  keyboard.setInput($(this).val());
		});

		// función auxiliar para shift
		function handleShift(){
			let currentLayout = keyboard.options.layoutName;
			let shiftToggle = currentLayout === "default" ? "shift" : "default";
			keyboard.setOptions({
				layoutName: shiftToggle
			});
		}


  		// Detectar qué input tiene el foco
		$("input").on("focus", function(){
			currentInput = this;
			keyboard.setInput($(this).val());
		});

		$('body').on('click', '#btn-validar-datos-factura', function(){
			location.href = `/metodos-pago/{{ $mac }}`
		})

		// await consultarCarrito();
		await obtenerDatosFacturacion();
	})

	async function consultarCarrito(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/consultar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
	}

	function onChange(input) {
		document.querySelector(".input").value = input;
		console.log("Input changed", input);
	}
	 
	function onKeyPress(button) {
	  	console.log("Button pressed", button);
	}

	async function verificarDatosFacturacion(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/verificar_datos_factura?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
	}

	let datosFacturacion;
	async function obtenerDatosFacturacion(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/datos_facturacion?macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        datosFacturacion = data.data;
        if(data.code == 200){
        	fillFormDatosFactura();
        }
	}

	function fillFormDatosFactura(){
		$('#subtotal').html(`$${datosFacturacion.totales.subtotalVenta}`)
		$('#creditoConvenio').html(`$${datosFacturacion.totales.valorTotalCliente}`)
		$('#descuentoAplicado').html(`$${datosFacturacion.totales.valorDescuento}`)
		$('#iva').html(`$${datosFacturacion.totales.valorIva}`)
		$('#total').html(`$${datosFacturacion.totales.valorTotalPaciente}`)

		let options = ``;
		$.each(datosFacturacion.tiposIdentificacion, function(key, value){
			options += `<option class="text-capitalize" value="${value.codigoTipoIdentificacion}">${value.nombreTipoIdentificacion.toLowerCase()}</option>`
		})
		$('#tipoIdentificacion').html(options);
		$('#tipoIdentificacion').val(parseInt(datosFacturacion.datosFactura.codigoTipoIdentificacion));
		$('#numeroIdentificacion').val(datosFacturacion.datosFactura.numeroIdentificacion)
		$('#nombresCompletos').val(datosFacturacion.datosFactura.nombreCompleto)
	}
</script>
@endsection