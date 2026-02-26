@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header', ['showSettingBtn' => false])
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])
	<div class="row rounded-24 bg-white py-40 mx-0" style="margin-top: 350px;">
		<div class="col-12 text-center my-3 pb-5">
			<h2 class="fw-bold fs-40 line-height-40" id="title">Logout Host</h2>
		</div>
		<div class="col-8 offset-2" id="box-input">
			<input type="text" autofocus id="user" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" placeholder="Usuario" readonly>			
		</div>

		<div class="col-6 offset-3 text-center mt-56 mb-40">
			<button class="btn bg-silver text-silver-neutral-40 fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-logout-action">Cerrar sesión</button>
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

	.simple-keyboard{
		width: 100%;
		margin: auto;
		background: transparent !important;
	}
</style>
<script>
	let tipo = localStorage.getItem('tipo');
	let tipoFiltro;
	
	callCounter = false;
	document.addEventListener("DOMContentLoaded", async function () {
		$.customKeyboard.init('input[readonly]', '.simple-keyboard');
			
		$('body').on('change', 'input', async function(){
			if(getInput('user') !== ""){
				$('#btn-logout-action').addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
			}else{
				$('#btn-logout-action').removeClass('bg-royal-blue text-white').addClass('bg-silver text-silver-neutral-40');
			}
		})

		$('body').on('click', '#btn-logout-action', async function(){
			let user = $('#user').val();
			let host = JSON.parse(localStorage.getItem('host'));
			console.log(host.codigoUsuario)
			if(user.toUpperCase() === host.codigoUsuario.toUpperCase()){
				await logoutHost();
			}else{
				showMessage('warning','Atención','El código de usuario no coincide con el del Host logueado');
			}
		})
	})

	async function loadKeyboardAlfanumerico(){
		$('.simple-keyboard').css('width','100%');
		keyboardInit = new Keyboard({
			onChange: input => {
				if(currentInput){
					$(currentInput).val(input);
					// $('#btn-logout-action').attr('disabled', false);
					$('#btn-logout-action').addClass('bg-royal-blue text-white').removeClass('bg-silver text-silver-neutral-40');
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
					"{shift} z x c v b n m - =",
					"{numbers} @ {space} . _ * + !"
				],
				shift: [
					"Q W E R T Y U I O P {backspace}",
					"A S D F G H J K L Ñ {ent}",
					"{shift} Z X C V B N M - =",
					"{numbers} @ {space} . _ * + !"
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

	async function logoutHost(){
        let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/seguridad/salir_host?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            localStorage.removeItem("host");
            location.href = '/{{ $mac }}'
        }else{
            showMessage('warning','Atención',data.message);
        }   
    }
</script>
@endsection