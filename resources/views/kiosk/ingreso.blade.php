@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])

	<div class="row rounded-24 bg-white py-40 mx-0 box-ingresar" style="margin-top: 350px;">
		<div class="col-12 text-center my-3 pb-5">
			<h2 class="fw-bold fs-40 line-height-40" id="title"></h2>
		</div>
		<div class="col-8 offset-2" id="box-input">
			<input type="text" autofocus id="numeroDocumento" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" readonly>			
		</div>
		<div class="col-6 offset-3 text-center mt-56 mb-40">
			<button disabled class="btn bg-silver text-silver-neutral-40 fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-ingresar">Ingresar</button>
		</div>
	</div>

	<div class="row rounded-24 bg-white py-40 mx-0 d-none box-paciente-nuevo" style="margin-top: 350px;">
		<div class="col-8 offset-2 text-center my-3 pb-5">
			<h2 class="fw-bold fs-40 line-height-40" id="mensajeErrorUsuarioNoEncontrado"></h2>
		</div>
		<div class="col-8 offset-2 mt-3 text-start">
            <label for="nombres" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Ingrese sus nombres y apellidos *</label>
            <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="nombres" id="nombres" placeholder="" required readonly/>
            <div class="invalid-feedback">
                Ingrese sus nombres y apellidos.
            </div>
        </div>
        <div class="col-6 offset-3 text-center mt-56 mb-40">
			<button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-generar-turno-paciente">Generar</button>
		</div>
	</div>
	<div class="row px-0 mx-0">
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
		{{-- width: 75%; --}}
		margin: auto;
		background: transparent !important;
	}
</style>

<script>
	let tipo = localStorage.getItem('tipo');
	let tipoFiltro;
	let esPacienteNuevo = false;
	document.addEventListener("DOMContentLoaded", async function () {
		switch(tipo){
			case 'C':
				tipoFiltro = "CEDULA";
				$('#numeroDocumento').attr('data-kb','numeric');
				$('#title').html(`Ingresa el número de cédula del paciente`);
			break;
			case 'P':
				tipoFiltro = "PASAPORTE";
				$('#numeroDocumento').attr('data-kb','alphanumeric');
				$('#title').html(`Ingresa el número de pasaporte del paciente`);
			break;
			case 'N':
				tipoFiltro = "NOMBRES";
				$('#numeroDocumento').attr('data-kb','alphabet');
				$('#title').html(`Ingresa los nombres y apellidos del paciente`);
			break;
		}

		$.customKeyboard.init('input[readonly]', '.simple-keyboard');

		$('body').on('click', '#btn-ingresar', async function(){
			await buscarCliente();
		})

		$('body').on('change', '#numeroDocumento', function(){
			handleBtnIngresar($(this).val());
		})

		$('body').on('click', '#btn-generar-turno-paciente', async function(){
			if(getInput('nombres').length > 0){
				let datosPacienteNuevo = {
			        "tipoIdentificacion": tipoFiltro,
			        "numeroIdentificacion": getInput('numeroDocumento'),
			        "nombreCompleto": getInput('nombres')
			    }

			    localStorage.setItem('datosPacienteNuevo', JSON.stringify(datosPacienteNuevo));
			    location.href = '/turno-paciente-nuevo/{{ $mac }}';
			}else{
				$('#modalError').modal('show');
				$('.titleError').html(`Atención`);
				$('.msgError').html(`Los campos solicitados son obligatorios.`);
			}
		})

		$('body').on('click', '.btn-acceder-user', async function(){
			let paciente = $(this).attr('data-rel')
			localStorage.setItem("datosCliente", paciente);
        	await verificarUsuarioDigital();
        	location.href = '/menu/{{ $mac }}'
		})

	})

	function handleBtnIngresar(input){
	    if(tipo === "C"){
	        if(esValidaCedula(input)){
	            $('#btn-ingresar').prop('disabled', false).addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
	        } else {
	            $('#btn-ingresar').prop('disabled', true).addClass('bg-silver text-silver-neutral-40').removeClass('bg-royal-blue text-white');
	        }
	    } else {
	    	if(input.length > 5){
	    		$('#btn-ingresar').prop('disabled', false).addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
	    	}else{
	    		$('#btn-ingresar').prop('disabled', true).addClass('bg-silver text-silver-neutral-40').removeClass('bg-royal-blue text-white');
	    	}
	    }
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
	        if(data.data.length === 0){
	        	$('#mensajeErrorUsuarioNoEncontrado').html(`Paciente no encontrado. Por favor, ingrese sus datos a continuación para generar un turno.`)
	        	$('.box-ingresar').addClass('d-none');
	        	$('.box-paciente-nuevo').removeClass('d-none');
	        	esPacienteNuevo = true;
	        	return;
	        }
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
		// document.querySelector(".input").value = input;
		console.log(input)
		if (activeInput) {
	        activeInput.value = input;
	    }

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