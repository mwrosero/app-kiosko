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
				<div class="col-12 fs-18 line-height-24 px-8 py-4 bg-royal-blue-tint-90 border-silver mb-3">
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
							<div type="button" class="fs-14 line-height-16 fw-medium mt-3 text-royal-blue d-flex justify-content-start align-items-center box-action" type-rel='S'>
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
						<div class="col-12 pt-40 box-detail d-none">
							<ul class="list-unstyled border-bottom-midnight-blue-tint-80 mx-40 my-0">
								<li class="p-3 d-flex justify-content-between align-items-center fs-14 line-height-16">
									<div class="col-7">Pcr para coronavirus 2019-ncov (Covid-19)</div>
									<div class="col-4">
										<div class="row fw-medium text-end">
											<div class="col-4">$12.40</div>
											<div class="col-4">$12.40</div>
											<div class="col-4">$12.40</div>
										</div>
									</div>
									<div class="col-1 text-end">
										<i class="fa-solid fa-circle-info text-red-dark"></i>
									</div>
								</li>
								<li class="p-3 d-flex justify-content-between align-items-center fs-14 line-height-16">
									<div class="col-7">Biometría hemática</div>
									<div class="col-4">
										<div class="row fw-medium text-end">
											<div class="col-4">$12.40</div>
											<div class="col-4">$12.40</div>
											<div class="col-4">$12.40</div>
										</div>
									</div>
									<div class="col-1 text-end">
										<i class="fa-solid fa-circle-info text-red-dark"></i>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
            </div>
		</div>
	</div>
	@include('components.footer')
	{{-- Tootltip --}}
	{{-- https://codepen.io/sanjeevks121/pen/xQmErr --}}
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let tipo = localStorage.getItem('tipo');
	trackId = localStorage.getItem('trackId');
	let carrito;

	document.addEventListener("DOMContentLoaded", async function () {
		localStorage.removeItem("origen");
		localStorage.removeItem("itemAgregado");
		localStorage.removeItem("agendamiento");
		localStorage.removeItem("agrupacionFacturar");
		
		// await consultarCarrito();
		$('body').on('click', '.box-action', function(){
			let type = $(this).attr('type-rel');
			console.log(type);
			if(type == "S"){
				$(this).attr('type-rel','H');
				$(this).html(`Ocultar detalle <i class="fa-solid fa-chevron-up ms-2"></i>`);
		    	$(this).parent().siblings('.box-detail').removeClass('d-none'); 
		    }else{
		    	$(this).attr('type-rel','S');
		    	$(this).html(`Ver detalle <i class="fa-solid fa-chevron-down ms-2"></i>`);
		    	$(this).parent().siblings('.box-detail').addClass('d-none'); 
		    }
		});

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