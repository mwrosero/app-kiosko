@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/cita-elegir-paciente/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Elige los datos de tu cita'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'proximas-citas'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central mt-0 pt-74" style="overflow-y: auto;">
				<p class="fs-26 line-height-34 mt-40 mb-3 w-100">1. Elige la modalidad de la cita médica</p>
				<div class="d-flex justify-content-between align-items-center gap-4 w-100">
					<button class="btn bg-silver-light border-silver-3 text-silver-blue fs-24 line-height-28 p-4 rounded-12 flex-grow-1 fw-medium btn-modalidad" online-rel="N">Presencial</button>
					<button class="btn bg-silver-light border-silver-3 text-silver-blue fs-24 line-height-28 p-4 rounded-12 flex-grow-1 fw-medium btn-modalidad" online-rel="S">Virtual</button>
				</div>
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let dataCita = JSON.parse(localStorage.getItem('agendamiento'));
	trackId = localStorage.getItem('trackId');
	
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
        $('body').on('click', '.btn-modalidad', async function(){
        	$('.btn-modalidad').removeClass('btn bg-silver-light border-silver-3 text-silver-blue');
        	$(this).addClass('btn bg-royal-blue border-blue-veris-3 text-white');
        	let online = $(this).attr('online-rel');
        	dataCita.online = online;
        	localStorage.setItem("agendamiento", JSON.stringify(dataCita));
        	location.href = `/cita-elegir-datos/{{ $mac }}`
		})

	})
</script>
@endsection