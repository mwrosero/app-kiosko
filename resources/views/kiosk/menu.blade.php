@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => false, 'url' => '/'.$mac])
	
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Inicio'])
	<!-- Contenido principal -->
	<main class="flex-fill overflow-auto px-3 py-4">
		<div class="text-center mb-4">
			<h4 class="fs-48 line-height-56 fw-medium">Hola, <span class="text-capitalize primerNombre"></span>.</h4>
			<p class="fs-32 line-height-40 fw-medium mb-5">¿Qué quieres hacer?</p>
		</div>

		<!-- Grid de opciones -->
		<div class="row g-3">
			<div class="col-6">
				<a href="/proximas-citas/{{ $mac }}" class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-proximas-citas.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Ver mis <br>próximas citas</div>
				</a>
			</div>
			<div class="col-6">
				<button class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-agendar-cita-medica.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Agendar <br>cita médica</div>
				</button>
			</div>
			<div class="col-6">
				<button class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-paquetes-preventivos.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Comprar paquetes <br>preventivos</div>
				</button>
			</div>
			<div class="col-6">
				<button class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-tratamientos.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Gestionar mi <br>tratamiento</div>
				</button>
			</div>
			<div class="col-6">
				<button class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-orden-externa.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Tengo una orden <br>externa</div>
				</button>
			</div>
			<div class="col-6">
				<button class="btn btn-light w-100 py-32 border rounded-4 h-100">
					<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-chequeos-ocupacionales.svg" alt="" class="mb-2" style="height:120px">
					<div class="fs-32 line-height-40 fw-medium">Gestionar chequeos <br>ocupacionales</div>
				</button>
			</div>
		</div>

		<!-- Botón principal -->
		<div class="mt-4 text-center">
			<button class="btn fs-32 line-height-40 border-royal-blue-tint-80 py-3 rounded-16 w-50 fw-medium shadow-veris">Generar turno</button>
		</div>
	</main>

	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	document.addEventListener("DOMContentLoaded", async function () {
		$('.primerNombre').html(datosCliente.primerNombre.toLowerCase());

		await iniciarCarrito();

		$('body').on('click','.item-servicio', async function(){
			$('.item-servicio').removeClass('bg-royal-blue text-white').addClass('border-royal-blue-tint-60 text-royal-blue');
			$(this).addClass('bg-royal-blue text-white')
			let tipoServicio = $(this).attr('tipoServicio-rel')
		});

		$('body').on('click', '.btn-consultorio', function(){
			$('#modalConsultorio').modal('show')
		})
	})

	async function iniciarCarrito(){
		if(localStorage.getItem('idPreTransaccion') !== null){
			return;
		}
		
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/iniciar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	localStorage.setItem("idPreTransaccion", data.data.idPreTransaccion);
        }
	}
</script>
@endsection