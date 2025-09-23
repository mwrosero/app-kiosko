@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => '¿Para quién es la cita?'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'cita-medica'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central mt-0" style="overflow-y: auto;">
				@include('components.grupo_familiar')
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "agendamiento");
	
	document.addEventListener("DOMContentLoaded", async function () {		
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
        $('body').on('click', '.btn-asignar', async function(){
        	let paciente = JSON.parse($(this).attr('data-rel'));
        	let dataCita = {}
        	dataCita.paciente = paciente;
        	localStorage.setItem("agendamiento", JSON.stringify(dataCita));
        	location.href = `/cita-elegir-modalidad/{{ $mac }}`
		})
	})
</script>
@endsection