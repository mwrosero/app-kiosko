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
			<input type="text" id="numeroDocumento" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3">
		</div>
		<div class="col-6 offset-3 text-center mt-56 mb-40">
			<button disabled class="btn bg-silver text-silver-neutral-40 fs-18 line-height-24 py-3 rounded-16 w-100 fw-medium shadow-none" id="btn-ingresar">Ingresar</button>
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
	    margin: 24px !important;
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
</style>
<script src="https://unpkg.com/simple-keyboard@latest/build/index.js"></script>
<script>
	let tipo = localStorage.getItem('tipo');
	let tipoFiltro;
	document.addEventListener("DOMContentLoaded", async function () {
		const Keyboard = window.SimpleKeyboard.default;
		switch(tipo){
			case 'C':
				tipoFiltro = "CEDULA";
				$('#title').html(`Ingresa el número de cédula del paciente`);
				let keyboard = new Keyboard({
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
					keyboard.setInput(event.target.value);
				});
			break;
			case 'P':
				tipoFiltro = "PASAPORTE";
				$('#title').html(`Ingresa el número de pasaporte del paciente`);
			break;
			case 'N':
				tipoFiltro = "NOMBRES";
				$('#title').html(`Ingresa los nombres y apellidos del paciente`);
			break;
		}

		{{-- const myKeyboard = new Keyboard({
		 	onChange: input => onChange(input),
		  	onKeyPress: button => onKeyPress(button)
		}); --}}

		$('body').on('click', '#btn-ingresar', async function(){
			await buscarCliente();
		})

	})

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
        	localStorage.setItem("datosCliente", JSON.stringify(data.data[0]));
        	localStorage.setItem("trackId", data.trackId);
        	location.href = '/menu/{{ $mac }}'
        }
	}

	function onChange(input) {
		document.querySelector(".input").value = input;
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
        args["showLoader"] = true;
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