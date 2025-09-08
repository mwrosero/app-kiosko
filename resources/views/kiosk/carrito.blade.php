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
				<div class="col-12 px-3 py-4 border-bottom-midnight-blue-tint-80">
					<div class="row d-flex justify-content-between align-items-center">
						<div class="col-8">
							<p class="fs-16 line-height-20 fw-medium text-royal-blue mb-1">Laboratorio</p>
							<p class="fs-14 line-height-16 mb-1"><span class="text-royal-blue-shade-40">Paciente:</span> Michael Washington Rosero Peralta</p>
							<p class="fs-14 line-height-16 mb-1"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> 23/07/2025</p>
							<p class="fs-14 line-height-16 mb-1"><span class="text-royal-blue-shade-40">Convenio:</span> Saludsa- práctico 5d</p>
							<p class="fs-14 line-height-16 mb-3"><span class="text-royal-blue-shade-40">Tratamiento:</span> Alergología | 20/07/2025</p>
							<div type="button" class="fs-14 line-height-16 fw-medium mb-0 text-royal-blue d-flex justify-content-start align-items-center">
								Ver detalle
								<i class="fa-solid fa-chevron-down ms-2"></i>
							</div>
						</div>
						<div class="col-2 fs-16 fw-medium line-height-20 text-end">
							$20.40
						</div>
						<div class="col-2 text-end">
							<i class="fa-regular fa-trash-can text-red-dark fs-28 line-height-28"></i>
						</div>
					</div>
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
	let carrito;

	document.addEventListener("DOMContentLoaded", async function () {
		// await consultarCarrito();

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
        if(data.code == 200){
        	carrito = data.data;
        	await drawCartItems();
        }else{
        	$('#modalError').modal('show');
			$('.titleError').html(`Atención`);
			$('.msgError').html(data.message);
        }
	}

	async function drawCartItems(){
		$.each(carrito, function(key, value){
			console.log(value.nombreCompleto)
			$.each(value.agrupaciones, function(k, item){
				console.log(item.tipoOrdenTransaccion)
			})
		})
	}

</script>
@endsection