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
		let urlImagen = (paquete.urlImagen !== "") ? paquete.urlImagen : `{{asset('assets/img/img-default-paquete.png')}}`
		$('.imagenPaquete').html(`<img src="${urlImagen}" class="img-fluid rounded-3 w-100" />`);
		$('.nombrePaquete').html(paquete.nombreComercialPaquete);
		$('.nombrePaciente').html(datosCliente.nombreCompleto.toLowerCase());
		$('.fechaVigencia').html(paquete.fechaCaducidadUsoPaquete);

		await drawCardsItems();
	})

	function boxEstadoPago(esPagada){
		let elem = ``;
		if(esPagada){
			elem += `<div class="text-green-dark fs-12 line-height-16">
				<i class="fa-solid fa-circle fs-16 me-1"></i><span class="fs-12 line-height-16">Comprado</span>
			</div>`;
		}else{
			elem += `<div class="text-orange-dark fs-12 line-height-16">
				<i class="fa-solid fa-circle fs-16 me-1"></i><span class="fs-12 line-height-16">Por comprar</span>
			</div>`;
		}
		return elem;
	}

	async function drawCardsItems(){
		let elem = ``;
		$.each(paquete.detallesPaquete, function(key, value){
			let labelInfo = (!value.requiereAgendamientoPrevio && !value.esAgendable) ? `<p class="fs-14 line-height-16 mb-12 fw-normal">No requiere agendar cita, solo deben activarse.</p>` : ``;
			let nombrePrestacion = ``;
			if(value.nombreServicioN1 == "CONSULTA"){
				nombrePrestacion = value.nombreServicio.toLowerCase();
			}else{
				nombrePrestacion = value.nombrePrestacion.toLowerCase();
			}
		    elem += `<div class="col-12 px-32 py-4 fs-18 line-height-24 fw-medium d-flex justify-content-between align-items-center border-bottom-midnight-blue-tint-80">
				<img src="${value.imagenServicioNivel1}" alt="" width="56px">
				<div class="mx-3 flex-grow-1">
					<h2 class="text-royal-blue-shade-20 fw-medium fs-16 line-height-20 mb-1 text-capitalize">${nombrePrestacion}</h2>
					${labelInfo}
					${boxEstadoPago(paquete.estaPagado)}
				</div>
				${ drawBtnCardItem(value) }
			</div>`
		})
		
		$('#listadoOrdenes').html(elem);
	}

	function drawButtonItem(value){
		let elem = ``;
		elem += `<button item-rel='${JSON.stringify(value)}' class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 px-3 p-12 btn-detalle-orden" style="min-width: 150px !important;">Ver detalle</button>`;
		return elem;
	}

	function drawBtnCardItem(detalles){
        console.log(detalles);
        let tipoAgenda = detalles.tipoAgenda;
        // let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","IMAGENES","PROCEDIMIENTOS"];
        let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","TERAPIA_FISICA_AGRUPADA"];
        let titleBtn = `Ver detalle`;
        let tieneItemsSinAgendar = verificarItemsSinAgendar(detalles.detalles);
        let btnEnviaAgendarClass = `btn-detalle`;
        {{-- if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.esAgendable && tieneItemsSinAgendar){ --}}
        if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.esAgendable){
            titleBtn = `Agendar`;
            if((detalles.detalles.length == 1 && detalles.preparacionPrevia == null) || tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
                btnEnviaAgendarClass = `btn-agendar-item`;
            }
        }
        let esTerapiaAgrupada = false
        if(tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
            esTerapiaAgrupada = true;
        }
        return `<div class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 px-3 p-12 ${btnEnviaAgendarClass}" style="min-width: 150px !important;" esTerapiAgrupada-rel='${esTerapiaAgrupada}' promocion-rel='${JSON.stringify(detalles)}' data-rel='${JSON.stringify(detalles.detalles)}'>
                ${titleBtn}
            </div>`;
    }

    function verificarItemsSinAgendar(items){
        let tieneItems = false;
        $.each(items, function(key, value){
            if(value.detalleReserva == null){
                tieneItems = true;
            }
        })
        return tieneItems;
    }
</script>
@endsection