@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/paquetes-preventivos/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Paquetes preventivos'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="row border-bottom py-32">
					<div class="col-6 offset-3 border d-flex justify-content-between align-items-center border-silver rounded-6 p-1 mb-3">
						<a href="/paquetes-preventivos/{{ $mac }}" class="btn p-3 rounded-4 fs-20 line-height-16 flex-fill">Comprar</a>
						<button class="btn p-3 rounded-4 bg-royal-blue text-white fs-20 line-height-16 flex-fill">Agendar</button>
					</div>
				</div>
				<div class="row">
					<div class="col-10 offset-1 py-4 d-none box-asignados">
						<p class="fs-20 line-height-16 fw-medium mt-4 mb-3">Te interesó:</p>
						<div id="paquetesAsignadosCarousel" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="4000">
							<div class="carousel-inner" id="listado-paquetes-asignados">
							</div>
							<!-- Bullets externos -->
							<div class="text-center mt-4" id="carouselBullets">
							</div>
						</div>
						{{-- <div class="row w-100" id="listado-paquetes-asignados">
						</div> --}}
					</div>
					<div class="col-10 offset-1 py-4 d-flex justify-content-between align-items-center gap-2">
						<div class="row w-100" id="listado-paquetes">
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let paquete = JSON.parse(localStorage.getItem('paquete'));
	trackId = localStorage.getItem('trackId');
	
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await obtenerPaquetesPorPagar();
		await obtenerMisPaquetesPreventivos();

		const carousel = document.getElementById('paquetesAsignadosCarousel');
		const bulletsContainer = document.getElementById('carouselBullets');
		const slides = carousel.querySelectorAll('.carousel-item');
		const indicators = bulletsContainer.querySelectorAll('.btn-indicator');
		carousel.addEventListener('slide.bs.carousel', function (e) {
			indicators.forEach(btn => btn.classList.remove('active'));
			indicators[e.to].classList.add('active');
		});

		$('body').on('click', '.btn-asignar', async function(){
			let detalle = JSON.parse($(this).attr('data-rel'));
			let datosPago = {
				"paquetesPromocionales": {
					"secuenciaPaquetePaciente": parseInt(detalle.secuenciaPaquetePaciente),
				}
			}
			await agregarItem(datosPago);
		})

		{{-- $('body').on('click', '.btn-comprar', function(){
        	let paquete = $(this).attr('data-rel');
        	console.log(paquete);
        	localStorage.setItem("origenPaquete", "asignado");
        	localStorage.setItem("paquete", paquete);
        	location.href = `/detalle-paquete/{{ $mac }}`;
        }) --}}

        $('body').on('click', '.btn-detalle-paquete', async function(){
        	localStorage.setItem('detalle-paquete-preventivo', $(this).attr('data-rel'))
			location.href = `/detalle-paquete-comprado/{{ $mac }}`;
		})

	})

	async function obtenerMisPaquetes(tipoGestion){
		let args = [];
		//tipoGestion: TODOS, FACTURADOS, ASIGNADOS
       	args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/paquetes?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}&tipoGestion=${tipoGestion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        return data;
	}

	async function obtenerPaquetesPorPagar(){
		const data = await obtenerMisPaquetes('ASIGNADOS')
        console.log(data);
        if (data.code == 200){
        	if(data.data.length > 0){
        		$('.box-asignados').removeClass('d-none');
        		let elem = ``;
        		let elemBullets = ``;
        		$.each(data.data, function(key, value){
                	let urlImagen = (value.urlImagen !== "") ? value.urlImagen : `{{asset('assets/img/img-default-paquete.png')}}`

                    let strDescuento = ``;
                    let strDescuentoFooter = ``;
                    let badgesImg = ``;
                    let isActiveClass = ``;
                    if(key == 0){
                    	isActiveClass = `active`
                    }
                    {{-- if(value.porcentajeDescuento > 0){
                        //strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">-${value.porcentajeDescuento}%</span>`;
                        if(value.esDescuentoExclusivo){
                           strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">Desct. exclusivo web</span>`;
                        }
                        strDescuentoFooter = `<div class="p-1 fs-12 line-height-16 box-discount fw-medium text-center d-inline-block mb-1">-${value.porcentajeDescuento}% dto.</div><p class="mb-0 text-muted fs-14 line-height-16">Antes <span class="text-decoration-line-through"> $${value.subtotalVenta.toFixed(2)}</span></p>`;
                    }
                    if(value.esPaqueteDomicilio){
                        badgesImg = `<div class="position-absolute bottom-0 p-2 m-1 d-flex justify-content-start align-items-center">
                            <div class="p-2 badge-domicilio text-primary fw-medium rounded-1 fs-12 line-height-16 d-flex justify-content-between"><img src="{{asset('assets/img/fa-icon-domicilio.svg')}}" style="width: 16px;margin-right: 4px;">A domicilio</div>
                        </div>`
                    } --}}
                    elem += `<div class="carousel-item w-100 ${isActiveClass}">
      					<div class="row w-100">
      						<div class="col-12">
		                        <div class="h-100 border-0 box-shadow-3 rounded-4 p-3 bg-royal-blue-tint-90 rounded-16 d-flex justify-content-between align-items-start gap-3">
		                            <div type="button" class="zoom-img btn-comprar position-relative rounded-3 overflow-hidden" data-rel='${JSON.stringify(value)}'>
		                                <img src="${urlImagen}" onerror="this.src='https://www.veris.com.ec/wp-content/themes/veris2025/img/veris.png'" class="card-img-top" alt="${value.nombrePaquete}" style="max-height: 200px;">
		                                ${strDescuento}
		                                ${badgesImg}
		                            </div>
		                            <div class="px-0 flex-grow-1 d-flex flex-column h-100">
		                                <h5 class="fs-20 line-height-24 fw-medium text-capitalize">${value.nombreComercialPaquete.toLowerCase()}</h5>
		                                <div>
		                                    ${strDescuentoFooter}
		                                    {{-- <h4 class="text-primary fs-28 line-height-36 fw-bold mb-0">$${value.valorTotal.toFixed(2)}</h4> --}}
		                                </div>
		                                <div class="text-end mt-auto pt-3">
		                    				<div type="button" data-rel='${JSON.stringify(value)}' class="btn btn-sm bg-royal-blue text-white fs-18 line-height-24 fw-medium me-auto btn-asignar rounded-8 py-3 px-4">Agregar al carrito</div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
                    	</div>
                	</div>`;
                	elemBullets += `<button type="button" class="btn-indicator ${isActiveClass}" data-bs-target="#paquetesAsignadosCarousel" data-bs-slide-to="${key}"></button>`
                })
        		$('#listado-paquetes-asignados').html(elem);
        		$('#carouselBullets').html(elemBullets);
        	}
		}else{
            $('#modalError').modal('show')
			$('.titleError').html(`Atención`)
			$('.msgError').html(data.message);
        }
	}

	async function obtenerMisPaquetesPreventivos(){
		const data = await obtenerMisPaquetes('FACTURADOS')
        console.log(data);
        if (data.code == 200){
        	let elem = ``;
            $.each(data.data, function(key, value){
            	let pathUrl = (value.urlImagen == "" || value.urlImagen === null) ? `{{asset('assets/img/paquete-default.png')}}` : value.urlImagen;
                elem += `<div class="col-md-6 mt-0 mb-3 item-promocion" id="promocion-${value.secuenciaPaquetePaciente}">
                    <div class="card m-1 mt-0 mb-0 border-royal-blue-tint-90 rounded-16 h-100">
                        <div class="card-header position-relative feature-img-promocion m-3 rounded-8 border-0" style="background: url(${pathUrl}) no-repeat center;">
                        </div>
                        <div class="card-body p-3 py-0">
                            <h2 class="line-height-24 fs-20 text-royal-blue fw-medium mb-1">${capitalizarPrimeraLetra(value.nombreComercialPaquete)}</h2>
                			<p class="fs-12 line-height-16 text-capitalize mb-1">${datosCliente.nombreCompleto.toLowerCase()}</p>
                			<p class="fs-12 line-height-16 text-capitalize mb-0">Válida hasta: <span class="text-royal-blue">${value.fechaCaducidadUsoPaquete}</span></p>
                        </div>
                        <div class="card-footer border-0 d-flex justify-content-end align-items-center p-3 pt-0 mt-4 bg-transparent">
                			<div class="btn bg-royal-blue text-white fs-14 line-height-16 px-3 py-2 btn-detalle-paquete" data-rel='${JSON.stringify(value)}'>Usar paquete</div>
                        </div>
                    </div>
                </div>`;
            })
            $('#listado-paquetes').html(elem);            
        }else{
            $('#modalError').modal('show')
			$('.titleError').html(`Atención`)
			$('.msgError').html(data.message);
        }
	}
</script>
<style>
	.feature-img-promocion{
		height: 230px;
	}
	.btn-indicator {
	    width: 12px;
	    height: 12px;
	    border-radius: 50%;
	    border: none;
	    background-color: #bbb;
	    margin: 0 5px;
	    transition: all 0.3s;
	    cursor: pointer;
	  }

	  .btn-indicator.active,
	  .btn-indicator:hover {
	    background-color: var(--royalBlue);
	  }
</style>
@endsection