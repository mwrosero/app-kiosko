@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	{{-- @include('components.cart-bar', ['title' => 'Próximas citas']) --}}
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-12 px-3 d-flex flex-column align-items-center justify-content-center overflow-auto contenido-central" style="overflow-y: auto;" id="contenido-agendamiento-multiple">
				
			</div>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let dataCita = JSON.parse(localStorage.getItem('agendamiento'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "cita");
	document.addEventListener("DOMContentLoaded", async function () {
		let elem = ``;
		if(dataCita.items.length == dataCita.detalle_multiple.length){
			elem += `<p class="m-0 mb-3 text-royal-blue fs-40 line-height-48 fw-bold page-title">¡Listo!</p>
				<p class="m-0 mb-3 text-royal-blue fs-32 line-height-40 fw-bold">${dataCita.detalle_pre_agendamiento.length} de ${dataCita.items.length}</p>
				<p class="fs-32 line-height-40 fw-medium mb-3">Terapías agendadas</p>
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/terapia.svg" class="w-50 my-5" alt="">
				<a href="/carrito/{{ $mac }}" id="btn-continuar" class="btn py-24 px-5 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-auto">Ir al carrito</a>`;
		}else{
			elem += `<p class="m-0 mb-3 text-royal-blue fs-40 line-height-48 fw-bold page-title">¡Listo!</p>
				<p class="m-0 mb-3 text-royal-blue fs-40 line-height-48 fw-bold page-title">${dataCita.detalle_pre_agendamiento.length} de ${dataCita.items.length}</p>
				<p class="fs-32 line-height-40 fw-medium mb-3">Elige tu siguiente cita</p>
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/terapia.svg" class="w-50 my-5" alt="">
				<a href="/citas-elegir-fecha-doctor/{{ $mac }}" id="btn-continuar" class="btn py-24 px-5 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-auto">Continuar agendando</a>`;
		}

		$('#contenido-agendamiento-multiple').html(elem);
	})
</script>
@endsection