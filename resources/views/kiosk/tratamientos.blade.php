@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Tratamientos'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'tratamientos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="container box-fecha px-0">
					<div class="row pb-32 cards-items d-flex justify-content-between align-items-start" id="content-area">
					</div>
				</div>
			</div>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "cita");
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		await cargarMisTratamientos();

		$('body').on('click', '.btn-ver-orden', async function(){
			let detalle = JSON.parse($(this).parent().attr('data-rel'));
			localStorage.setItem('tratamiento', JSON.stringify(detalle))
			location.href = `/detalle-tratamiento/{{ $mac }}`;
		})
	})

	let tratamientos;
	async function cargarMisTratamientos(showLoader = true){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/mis_tratamientos?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        if(data.data.length == 0){
        	//Empty space
        	$('#content-area').html(`<div class="text-center mt-5 pt-5">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid mt-5" alt="">
					<p class="text-center py-40 mb-0 fs-28 line-height-32">No tienes tratamientos <br> agendados</p>
					<a href="/cita-elegir-paciente/{{ $mac }}" class="d-none btn bg-royal-blue text-white fs-24 line-height-32 py-3 rounded-16 w-50 fw-medium shadow-none" id="btn-ingresar">Agendar nueva cita</a>
				</div>`);
        }else{
        	tratamientos = data.data
       		await drawCardsServicio();
        }
	}

	async function drawCardsServicio(){
		let elem = ``;
		$.each(tratamientos, function(key, value){
			let cards = ``;
		    $.each(value, function(k, v){
		        $.each(v, function(k1, v1){
		            cards += drawCardItem(v1)
		        })
				elem += `<div class="row box-dia pt-40">
					<div class="col-12 fs-18 line-height-24 fw-medium">
						<span class="text-royal-blue">Enviado:</span> ${capitalizarPrimeraLetra(k)}
					</div>
				</div>
				<div class="row pt-32 cards-items d-flex justify-content-between align-items-start">
					${cards}
				</div>`
		    })
		})
		
		$('#content-area').html(elem);
	}

	function mostrarConvenio(detalle){
		let elem = ``
		if(detalle.nombreConvenio !== null){
			elem += `<p class="fs-14 line-height-16 fw-medium mb-1"><span class="text-royal-blue-shade-20 me-1">Convenio:</span> ${detalle.nombreConvenio}</p>`
		}
		return elem;
	}

	function drawCardItem(detalle){
		return `<div class="col-6 col-md-6 box-agenda">
				<div class="rounded-16 border-royal-blue-tint-60 border-inside p-12 d-flex justify-content-between align-items-stretch">
				    <div class="box-icon bg-royal-blue-tint-90 me-2 d-flex align-items-center justify-content-center rounded-8">
				        <img src="${detalle.urlImagenEspecialidad}" class="m-2 img-fluid" width="56px" alt="">
				    </div>
				    <div class="box-info-agendamiento flex-grow-1">
				        <h3 class="fs-20 line-height-24 text-royal-blue fw-medium mb-2 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</h3>
				        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1">Profesional:</span> ${detalle.nombreMedico.toLowerCase()}</p>
				        <p class="fs-14 line-height-16 fw-medium mb-1 text-capitalize"><span class="text-royal-blue-shade-20 me-1 text-capitalize">Central médica:</span> </p>
				        ${ mostrarConvenio(detalle) }
				        <div class="box-action pt-32 pb-2 pb-0 d-flex justify-content-end align-items-center gap-2" data-rel='${JSON.stringify(detalle)}'>
							<button class="btn fs-16 line-height-20 bg-royal-blue text-white rounded-8 p-12 px-3 btn-ver-orden">Ver órdenes</button>
				        </div>
				    </div>
				</div>
			</div>`
	}
</script>
@endsection