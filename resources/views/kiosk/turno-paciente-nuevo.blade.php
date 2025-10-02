@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header', ['showSettingBtn' => false])
	<!-- Sub-header -->
	{{-- @include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/cita-elegir-paciente/'.$mac]) --}}
	<!-- Carrito -->
	{{-- @include('components.cart-bar', ['title' => 'Elige los datos de tu cita']) --}}
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			{{-- <div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'cita-medica'])
			</div> --}}
			<div class="col-6 offset-3 px-3 d-flex flex-column overflow-auto contenido-central justify-content-center align-items-center mt-0 pt-74" style="overflow-y: auto;">
				<p class="fs-32 line-height-40 mb-92 mb-3 w-100 text-center fw-bold d-none info-turno msg-turno"></p>
				<div class="fs-60 line-height-64 bg-primary-tint-60 text-secundary-00 p-32 rounded-200 fw-bold w-75 text-center info-turno d-none numero-turno">
					
				</div>
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tipoTurnoGenerar = localStorage.getItem('tipoTurnoGenerar');
	trackId = localStorage.getItem('trackId');
	
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
        
		let turno = await generarTurnoPacienteNuevo();
		if(turno.code !== 200){
			return;
		}
		
		$('.info-turno').removeClass('d-none')
		$('.msg-turno').html(`Tu turno es el:`)
		$('.numero-turno').html(turno.data.turno)
		
		setTimeout(function(){
			location.href = `/{{ $mac }}`;
		}, 3000);
	})

	async function generarTurnoPacienteNuevo(){
    	let args = [];
	    args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/generar_turno?macAddress=${mac}&idPaciente=`;
	    args["method"] = "POST";
	    args["showLoader"] = true;
	    args["token"] = accessToken;
	    args["bodyType"] = "json";
	    let payload = JSON.parse(localStorage.getItem('datosPacienteNuevo'))
		args["data"] = JSON.stringify(payload);
	    const data = await call(args);
	    console.log(data);
	    if(data.code == 200){
	        await printTurnoAPI(data.data)
	    }
	    return data;
    }
</script>
@endsection