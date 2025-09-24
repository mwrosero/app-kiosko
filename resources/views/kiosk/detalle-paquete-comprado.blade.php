@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/mis-paquetes/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Paquetes preventivos'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="info-tratamiento d-flex justify-content-start align-items-start gap-3 px-0 pt-32 pb-3">
		            <div class="col-5">
		                <div class="card border-0">
		                    <div class="card-body p-0 imagenPaquete">
		                    </div>
		                </div>
		            </div>
		            <div class="col-7">
		                <h2 class="text-royal-blue-shade-40 fw-medium fs-24 line-height-28 nombrePaquete"></h2>
		                <p class="fs-12 line-height-16 text-capitalize mb-1 text-capitalize nombrePaciente"></p>
                			<p class="fs-12 line-height-16 text-capitalize mb-0">Válida hasta: <span class="text-royal-blue fechaVigencia"></span></p>
		            </div>
				</div>
				<div class="w-100">
					<div class="col-12 bg-royal-blue-tint-90 mb-3 p-3 fs-18 line-height-24 fw-medium">
						Pendientes
					</div>
				</div>
				<div class="w-100" id="listadoOrdenes">
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let paquete = JSON.parse(localStorage.getItem('detalle-paquete-preventivo'));
	trackId = localStorage.getItem('trackId');
	
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		$('.imagenPaquete').html(`<img src="${paquete.urlImagen}" class="img-fluid rounded-3 w-100" />`);
		$('.nombrePaquete').html(paquete.nombreComercialPaquete);
		$('.nombrePaciente').html(datosCliente.nombreCompleto.toLowerCase());
		$('.fechaVigencia').html(paquete.fechaVigencia);
	})
</script>
@endsection