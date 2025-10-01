@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])
	<div class="row rounded-24 bg-white py-40 mx-0" style="margin-top: 350px;">
		<div class="col-12 text-center my-3 pb-5">
			<h2 class="fw-bold fs-40 line-height-40" id="title"></h2>
		</div>
		<div class="col-8 offset-2" id="box-input">
			
		</div>
		<div class="col-6 offset-3 text-center mt-56 mb-40">
			<button disabled class="btn bg-silver text-silver-neutral-40 fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-ingresar">Ingresar</button>
		</div>
		<div class="col-10 offset-1 mt-56 bg-silver-light p-44">
			<div class="simple-keyboard"></div>
		</div>
	</div>
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
		width: 75%;
		margin: auto;
		background: transparent !important;
	}
	.numeric-theme .hg-button.hg-standardBtn,
	.numeric-theme .hg-button.hg-functionBtn{
	    font-size: 36px !important;
	    line-height: 44px !important;
	    padding: 20px 0px !important;
	    height: auto !important;
	    border: 1px solid #13243F;
	    box-shadow: none !important;
	    margin: 12px !important;
	    border-radius: 8px !important;
	}

	.numeric-theme .hg-button[data-skbtnuid="default-r3b0"]{
		visibility: hidden;
	}

	.numeric-theme .hg-button[data-skbtnuid="default-r3b2"]{
		border: none !important;
		background: transparent !important;
		font-size: 42px !important;
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
	.hg-button.hg-standardBtn, .hg-button.hg-functionBtn{
		width: 20px;
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
</style>
<script src="https://unpkg.com/simple-keyboard@latest/build/index.js"></script>
<script>
	let tipo = localStorage.getItem('tipo');
	let tipoFiltro;
	let currentInput = null;
	const Keyboard = window.SimpleKeyboard.default;
	let keyboardInit;
	callCounter = false;
	
	let activeInput = null;
	document.addEventListener("focusin", (e) => {
	    if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
	    	console.log(6)
	        activeInput = e.target; // actualizamos el input activo
	    }
	});

	function pressKey(char) {
		console.log(7)
	    if (!activeInput) return; // si no hay input activo, no hace nada

	    // Momentáneamente quitar readonly para poder escribir
	    activeInput.readOnly = false;
	    activeInput.value += char;
	    activeInput.dispatchEvent(new Event("input", { bubbles: true }));
	    activeInput.readOnly = true;
	}

	// Asignar el evento a todas las teclas del teclado virtual
	document.querySelectorAll(".key").forEach(btn => {
	    btn.addEventListener("click", () => {
	        pressKey(btn.dataset.char);
	    });
	});

	document.addEventListener("DOMContentLoaded", async function () {

		window.addEventListener("beforeunload", () => {
			console.log("Destroy Keyboard");
			keyboardInit.destroy()
		});

		switch(tipo){
			case 'C':
				$('#box-input').html(`<input type="text" autofocus id="numeroDocumento" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" readonly>`);
				tipoFiltro = "CEDULA";
				$('#title').html(`Ingresa el número de cédula del paciente`);

				keyboardInit = new Keyboard({
					onChange: input => onChange(input),
					onKeyPress: button => onKeyPress(button),
					layout: {
						default: ["1 2 3", "4 5 6", "7 8 9", " 0 {bksp}"]
					},
					display: {
						"{bksp}": "<i class='fa fa-backspace'></i>",
					},
					theme: "hg-theme-default hg-layout-numeric numeric-theme"
				});

				/**
				 * Update simple-keyboard when input is changed directly
				 */
				document.querySelector(".input").addEventListener("input", event => {
					console.log(0);
					keyboardInit.setInput(event.target.value);
				});
			break;
			case 'P':
				$('#box-input').html(`<input type="text" autofocus id="numeroDocumento" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" readonly>`);
				tipoFiltro = "PASAPORTE";
				$('#title').html(`Ingresa el número de pasaporte del paciente`);
				loadKeyboardAlfanumerico()
			break;
			case 'N':
				$('#box-input').html(`<input type="text" autofocus id="numeroDocumento" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" placeholder="Nombres y Apellidos" readonly>`);
				tipoFiltro = "NOMBRES";
				$('#title').html(`Ingresa los nombres y apellidos del paciente`);
				loadKeyboardAlfanumerico()
			break;
		}

		{{-- const myKeyboard = new Keyboard({
		 	onChange: input => onChange(input),
		  	onKeyPress: button => onKeyPress(button)
		}); --}}

		$('body').on('click', '#btn-ingresar', async function(){
			await buscarCliente();
		})

		$('body').on('click', '.btn-acceder-user', async function(){
			let paciente = $(this).attr('data-rel')
			localStorage.setItem("datosCliente", paciente);
        	await verificarUsuarioDigital();
        	location.href = '/menu/{{ $mac }}'
		})

	})

	async function loadKeyboardAlfanumerico(){
		$('.simple-keyboard').css('width','100%');
		keyboardInit = new Keyboard({
			onChange: input => {
				if(currentInput){
					$(currentInput).val(input);
					$('#btn-ingresar').attr('disabled', false);
					$('#btn-ingresar').addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
				}
			},
			onKeyPress: button => {
				if(button === "{bksp}" && currentInput){
					let val = $(currentInput).val();
					$(currentInput).val(val.slice(0, -1));
					keyboardInit.setInput($(currentInput).val());
				}

    			// 👉 Aquí manejamos los cambios de layout
				if(button === "{shift}" || button === "{lock}"){
					handleShift();
				}

				if(button === "{numbers}"){
					keyboardInit.setOptions({
						layoutName: "numbers"
					});
				}

				if(button === "{abc}"){
					keyboardInit.setOptions({
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

		// función auxiliar para shift
		function handleShift(){
			let currentLayout = keyboardInit.options.layoutName;
			let shiftToggle = currentLayout === "default" ? "shift" : "default";
			keyboardInit.setOptions({
				layoutName: shiftToggle
			});
		}


  		// Detectar qué input tiene el foco
		$("input").on("focus", function(){
			currentInput = this;
			keyboardInit.setInput($(this).val());
		});
	}

	async function buscarCliente(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/validar_datos?macAddress={{ $mac }}&tipoFiltro=${tipoFiltro}&valorFiltro=${getInput('numeroDocumento')}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
	        localStorage.setItem("trackId", data.trackId);
        	if(tipoFiltro == "NOMBRES"){
        		if(data.data.length == 0){
        			$('#modalError').modal('show');
					$('.titleError').html(`Atención`);
					$('.msgError').html(`No se encontraron coincidencias para la búsqueda del paciente.`);
        		}else{
        			let elem = ``;
        			$.each(data.data, function(key, value){
	        			elem += `<li data-rel='${JSON.stringify(value)}' type="button" class="p-3 border-bottom-midnight-blue-tint-80 fs-16 line-height-20 text-dark-veris btn-acceder-user" data-bs-dismiss="modal">
	                            <p class="mb-2 text-capitalize">${value.nombreCompleto.toLowerCase()}</p>
	                            <p class="mb-0">${enmascarar(value.numeroIdentificacion)}</p>
	                        </li>`
	                })
	                $('.listado-coincidencias-pacientes').html(elem);
	                $('#modalUsuariosEncontrados').modal('show')
        		}
        	}else{
        		if(data.data.length == 0){
        			$('#modalError').modal('show');
					$('.titleError').html(`Atención`);
					$('.msgError').html(`No se encontraron coincidencias para la búsqueda del paciente.`);
        		}else{
		        	localStorage.setItem("datosCliente", JSON.stringify(data.data[0]));
		        	await verificarUsuarioDigital();
		        	location.href = '/menu/{{ $mac }}'
		        }
	        }
        }
	}

	function enmascarar(str) {
		return str.replace(/.(?=.{4})/g, 'X');
	}

	async function verificarUsuarioDigital(){
		let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
		trackId = localStorage.getItem('trackId');
		await cargarParametros();
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/validar_cuenta_digital?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	localStorage.setItem("usuarioDigital", JSON.stringify(data.data));
        }
	}

	function onChange(input) {
		document.querySelector(".input").value = input;
		console.log(input)
		// console.log("Input changed", input);
		switch(tipo){
			case 'C':
				if(esValidaCedula(input)){
					$('#btn-ingresar').attr('disabled', false);
					$('#btn-ingresar').addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
				}else{
					$('#btn-ingresar').attr('disabled', true);
					$('#btn-ingresar').addClass('bg-silver text-silver-neutral-40').removeClass('bg-royal-blue text-white');
				}
			break;
		}

	}
	 
	function onKeyPress(button) {
	  	// console.log("Button pressed", button);
	}

	async function cargarParametros(){
		if(localStorage.getItem('parametrosGenerales') !== null){
			return;
		}
		
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/parametros?macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	localStorage.setItem("parametrosGenerales",JSON.stringify(data.data));
        }
	}
</script>
@endsection