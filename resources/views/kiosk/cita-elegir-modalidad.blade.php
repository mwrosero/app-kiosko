@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/cita-elegir-paciente/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Elige los datos de tu cita'])
	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row g-3 d-flex justify-content-center align-items-start h-100 mx-0">
			{{-- <div class="col-2 pb-4">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div> --}}
			{{-- style="overflow-y: auto; max-height: 70vh !important;" --}}
			<div class="col-7 px-32 h-100 d-flex flex-column justify-content-center align-items-center" style="overflow-y: auto; height: 70vh !important;">
				<p class="fs-26 line-height-34 mb-3 w-100">1. Elige la modalidad de la cita médica</p>
				<div class="d-flex justify-content-between align-items-center gap-4 w-100">
					<button class="btn bg-royal-blue border-blue-veris-3 text-white fs-24 line-height-28 p-4 rounded-12 flex-grow-1 fw-medium btn-modalidad" online-rel="N">Presencial</button>
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
        $('body').on('click', '.btn-modalidad', async function(){
        	let online = $(this).attr('online-rel');
        	dataCita.online = online;
        	localStorage.setItem("agendamiento", JSON.stringify(dataCita));
        	location.href = `/cita-elegir-datos/{{ $mac }}`
		})
	})
</script>
@endsection