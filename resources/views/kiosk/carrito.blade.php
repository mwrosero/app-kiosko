@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Carrito'])
	<div class="row mx-0">
		<div class="col-2 pb-4">
			@include('components.access-bar', ['page' => ''])
		</div>
		<div class="col-10 px-3 py-40 h-100" style="overflow-y: auto; height: 70vh !important;">
			<div class="row mx-0">
				<div class="col-12 fs-18 line-height-24 px-8 py-4 bg-royal-blue-tint-90 border-silver">
					Revisa tu carrito
				</div>
            </div>
		</div>
	</div>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tipo = localStorage.getItem('tipo');
	trackId = localStorage.getItem('trackId');

	document.addEventListener("DOMContentLoaded", async function () {
		await consultarCarrito();

		$('body').on('change', '#tipoIdentificacion', function(){
			
		})

	})

	async function consultarCarrito(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/consultar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
	}

</script>
@endsection