@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'showVolverBtn' => false, 'url' => '/datos-facturacion/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Pago'])
	<div class="row mx-0">
		<div class="col-6 mx-auto px-3 h-100" style="height: 70vh !important;">
			<div class="row flex-column h-100 justify-content-center align-items-center text-center">
				<p class="mt-4 text-secundary-00 fs-32 line-height-40 fw-bold text-center mb-40">Pago exitoso</p>
				<p class="mt-4 text-secundary-00 fs-24 line-height-32 fw-bold text-center mb-40">Nos vemos pronto.</p>
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/pago-exitoso.svg" class="m-2 img-fluid" alt="">
				<p class="mt-3 text-silver-dark fs-16 line-height-32 detalleComprobante"></p>
				<div class="mt-56 d-flex justify-content-between align-items-center g-2">
					<a href="/{{ $mac }}" class="btn w-50 me-2 fs-16 line-height-20 text-royal-blue border-royal-blue rounded-8 p-12 px-3">Cerrar</a>
					<a href="#" class="btn w-50 btn-redirect ms-2 fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3"></a>
				</div>
			</div>
		</div>
	</div>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let datosFacturados = JSON.parse(localStorage.getItem('datosFacturados'));
	let origen = localStorage.getItem('origen');
	trackId = localStorage.getItem('trackId');
	
	document.addEventListener("DOMContentLoaded", async function () {
		switch(origen){
			case 'cita':
				$('.btn-redirect').attr('href',`/proximas-citas/{{ $mac }}`);
				$('.btn-redirect').html(`Ver mi cita`);
			break;
			case 'paquete':
				$('.btn-redirect').attr('href',`/paquetes-preventivos/{{ $mac }}`);
				$('.btn-redirect').html(`Ver paquete preventivo`);
			break;
		}

		if(datosFacturados.factura.transacciones.length == 1){
			$('.detalleComprobante').html(`Tu número de comprobante es el ${datosFacturados.factura.transacciones[0].numeroComprobante}, llegará <br> con tu factura al correo electrónico.`)
		}else{
			let comprobantesArr = [];
			$.each(datosFacturados.factura.transacciones, function(key, value){
				comprobantesArr.push(value.numeroComprobante);
			})
			$('.detalleComprobante').html(`Tus comprobantes son: ${comprobantesArr.join(', ')}, llegarán <br> con tus facturas al correo electrónico.`)
		}
	})
</script>
@endsection