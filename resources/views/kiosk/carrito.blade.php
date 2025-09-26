@extends('template.app-template')
@section('content')

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Carrito', 'showQtyBtn' => false])
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => ''])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central mt-0 pt-74" style="overflow-y: auto;">
				<div class="row mx-0">
					<div class="col-12 fs-18 line-height-24 px-8 py-4 bg-royal-blue-tint-90 border-silver mb-3">
						Revisa tu carrito
					</div>
					<div class="col-12 px-3" id="listadoItems">
						
					</div>
					<div class="col-12 d-flex justify-content-between align-items-center gap-3 mt-5 fs-16 line-height-20">
						<span class="text-dark-veris">Subtotal</span>
						<span class="text-royal-blue fw-medium subtotal"></span>
					</div>
					<div class="col-9 d-flex justify-content-center align-items-center gap-3 mt-32 mx-auto">
						<a href="/menu/{{ $mac }}" class="btn fw-medium py-3 text-royal-blue border-royal-blue rounded-8 fs-18 line-height-24 w-50">Agregar más servicios</a>
	                    <a href="/datos-facturacion/{{ $mac }}" class="btn disabled fw-medium py-3 bg-royal-blue text-white rounded-8 fs-18 line-height-24 w-50" id="btn-pagar">Pagar</a>
					</div>
	            </div>
			</div>
		</div>
	</main>

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

		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)

		await consultarCarrito();
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

		$('body').on('click', '.btn-eliminar-item', async function(){
			let idAgrupacion = $(this).attr('idAgrupacion-rel');
			await eliminarItemCarrito(idAgrupacion);
		});

	})

	async function eliminarItemCarrito(idAgrupacion){
		console.log(idAgrupacion)
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/eliminar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&idAgrupacion=${idAgrupacion}`;
        args["method"] = "DELETE";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	await consultarCarrito();
        }else{
        	$('#modalError').modal('show');
			$('.titleError').html(`Atención`);
			$('.msgError').html(data.message);
        }
	}

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

	function obtenerConvenio(beneficio){
		if(beneficio.paquetePromocional !== null){
			return ``;
			{{-- return `<p class="fs-14 line-height-16 mb-1 text-capitalize"><span class="text-royal-blue-shade-40">Convenio:</span> ${beneficio.paquetePromocional.nombrePaquete.toLowerCase()}</p>` --}}
		}else if(beneficio.convenio !== null){
			return `<p class="fs-14 line-height-16 mb-1 text-capitalize"><span class="text-royal-blue-shade-40">Convenio:</span> ${beneficio.convenio.nombreConvenio.toLowerCase()}</p>`
		}else{
			return ``;
		}
	}

	async function drawCartItems(){
		let elem = ``;
		let tipoServicio = ``;
		let totalItem = ``;
		let convenio = ``;
		let subtotal = 0;
		$.each(carrito, function(key, value){
			let prestaciones = ``;
			let idAgrupacion;
			$.each(value.agrupaciones, function(k, item){
				idAgrupacion = item.idAgrupacion
				tipoServicio = item.tipoOrdenTransaccion;
				totalItem = item.totalAgrupacion.paciente.valorTotal;
				subtotal += totalItem;
				convenio = obtenerConvenio(item.beneficio);
				let hideInfoPaquetes = (item.nemonicoTipoOrdenTransaccion == "PAQUETE_PROMOCIONAL") ? `d-none` : ``;
				if(item.beneficio.paquetePromocional !== null){
					tipoServicio = item.beneficio.paquetePromocional.nombrePaquete;
				}
				$.each(item.detallesAgrupacion, function(k1, v1){
					prestaciones += `<li class="p-3 d-flex justify-content-between align-items-center fs-14 line-height-16">
						<div class="col-7 text-capitalize">${v1.nombrePrestacion.toLowerCase()}</div>
						<div class="col-4 ${hideInfoPaquetes}">
							<div class="row fw-medium text-end">
								<div class="col-4">$${v1.valoresPaciente.valorTotal}</div>
								<div class="col-4">$${v1.valoresEmpresa.valorTotal}</div>
								<div class="col-4">$${v1.valoresVenta.valorTotal}</div>
							</div>
						</div>
						<div class="col-1 text-end ${hideInfoPaquetes}">
							<i class="fa-solid fa-circle-info text-red-dark"></i>
						</div>
					</li>`;
				})
			
				elem += `<div class="row d-flex justify-content-between align-items-center py-4 border-bottom-midnight-blue-tint-80">
					<div class="col-8">
						<p class="fs-16 line-height-20 fw-medium text-royal-blue mb-1 text-capitalize">${tipoServicio.toLowerCase()}</p>
						<p class="fs-14 line-height-16 mb-1 text-capitalize"><span class="text-royal-blue-shade-40">Paciente:</span> ${value.paciente.nombreCompleto.toLowerCase()}</p>
						<p class="fs-14 line-height-16 mb-1 d-none"><span class="text-royal-blue-shade-40">Orden Válida hasta:</span> 23/07/2025</p>
						${convenio}
						<p class="fs-14 line-height-16 mb-3 d-none"><span class="text-royal-blue-shade-40">Tratamiento:</span> Alergología | 20/07/2025</p>
						<div type="button" class="fs-14 line-height-16 fw-medium mt-3 text-royal-blue d-flex justify-content-start align-items-center box-action" type-rel='S'>
							Ver detalle
							<i class="fa-solid fa-chevron-down ms-2"></i>
						</div>
					</div>
					<div class="col-2 fs-16 fw-medium line-height-20 text-end">
						$${totalItem.toFixed(2)}
					</div>
					<div class="col-2 text-end">
						<i class="fa-regular fa-trash-can text-red-dark fs-28 line-height-28 btn-eliminar-item" idAgrupacion-rel='${idAgrupacion}'></i>
					</div>
					<div class="col-12 pt-40 box-detail d-none">
						<ul class="list-unstyled border-bottom-midnight-blue-tint-80 mx-40 my-0">
							${prestaciones}
						</ul>
					</div>
				</div>`
			})
		})
		$('.subtotal').html(`$${subtotal.toFixed(2)}`)
		if(subtotal == 0){
			$('#btn-pagar').addClass('disabled');
			elem = `<div class="row d-flex justify-content-between align-items-center py-4 border-bottom-midnight-blue-tint-80">
					<div class="col-12">
						<p class="fs-16 py-94 line-height-20 fw-medium text-royal-blue mb-1 text-center">No existen productos agregados al carrito</p>
					</div>
				</div>`;
		}else{
			$('#btn-pagar').removeClass('disabled');
		}
		$('#listadoItems').html(elem);
	}

</script>
@endsection