@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header', ['showSettingBtn' => false])
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])
	<div class="row rounded-24 bg-white py-40 mx-0" style="margin-top: 350px;">
		<div class="col-12 text-center my-3 pb-5">
			<h2 class="fw-bold fs-40 line-height-40" id="title">Ingresar Host</h2>
		</div>
		<div class="col-8 offset-2" id="box-input">
			<input type="text" autofocus id="user" class="input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" placeholder="Usuario" readonly>			
			
			<div class="mt-32 d-flex justify-columns-between align-items-center gap-2">
				<input type="password" class="form-control input w-100 rounded-8 border-midnight-blue bg-white text-silver-dark fs-24 line-height-28 py-24 px-3" id="password" placeholder="Contraseña" readonly>
				<button class="btn border-midnight-blue h-100 rounded-8" type="button" id="togglePasswordVisibility">
					<i class="bi bi-eye"></i> <!-- Bootstrap Icons eye icon -->
				</button>
			</div>
		</div>

		<div class="col-6 offset-3 text-center mt-56 mb-40">
			<button class="btn bg-silver text-silver-neutral-40 fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-ingresar">Acceder</button>
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
	document.addEventListener("DOMContentLoaded", async function () {

		window.addEventListener("beforeunload", () => {
			console.log("Destroy Keyboard");
			keyboardInit.destroy()
		});

		loadKeyboardAlfanumerico();

		const togglePasswordVisibility = document.getElementById('togglePasswordVisibility');
		const passwordInput = document.getElementById('password');
		const eyeIcon = togglePasswordVisibility.querySelector('i');

		togglePasswordVisibility.addEventListener('click', function() {
			// Toggle the type attribute
			const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
			passwordInput.setAttribute('type', type);

			// Toggle the eye icon
			eyeIcon.classList.toggle('bi-eye');
			eyeIcon.classList.toggle('bi-eye-slash');
		});

		
		{{-- const myKeyboard = new Keyboard({
		 	onChange: input => onChange(input),
		  	onKeyPress: button => onKeyPress(button)
		}); --}}

		$('body').on('click', '#btn-ingresar', async function(){
			await loginHost();
		})
	})

	async function loadKeyboardAlfanumerico(){
		$('.simple-keyboard').css('width','100%');
		keyboardInit = new Keyboard({
			onChange: input => {
				if(currentInput){
					$(currentInput).val(input);
					// $('#btn-ingresar').attr('disabled', false);
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

	function b64EncodeUnicode(str) {
	    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
	    	return String.fromCharCode(parseInt(p1,16))
	    }));
	}

	async function loginHost(){
		let user = $('#user').val();
		let password = $('#password').val();
		if(user == "" || password == "" ){
			alert("Debe ingresar sus credenciales");
			return;
		}
		let basicData = b64EncodeUnicode(user.toUpperCase()+":"+password);
		console.log(basicData);
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war}/seguridad/iniciar_host?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["esLogin"] = true;
        args["basic"] = basicData//btoa("lzuÃ±iga:Andres34.*");//btoa(user.toUpperCase()+":"+password);
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		localStorage.setItem('host', JSON.stringify(data.data))
      		location.href = '/{{ $mac }}'
      	}else{
      		alert(data.message)
      	}	
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