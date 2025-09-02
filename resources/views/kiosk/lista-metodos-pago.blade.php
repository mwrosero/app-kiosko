@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">

<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/datos-facturacion/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Escoge el método de pago'])
	<div class="row mx-0">
		<div class="col-6 mx-auto px-3 h-100 box-steps box-metodos" style="height: 70vh !important;">
			<div class="row flex-column h-100 justify-content-center align-items-center text-center">
				<div type="button" metodo-rel="TC" class="btn-payment-type d-flex justify-content-center align-items-center text-secundary-00 fs-32 line-height-40 fw-bold rounded-32">Tarjeta de débito o <br>crédito</div>
				<div type="button" metodo-rel="CAJA" class="btn-payment-type d-flex justify-content-center align-items-center text-secundary-00 fs-32 line-height-40 fw-bold rounded-32">Pago en caja</div>
			</div>
		</div>
		<div class="col-6 mx-auto px-3 h-100 box-steps box-pasarela d-none" style="height: 70vh !important;">
			<div class="row flex-column h-100 justify-content-center align-items-center text-center">
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/pasarela.svg" class="m-2 img-fluid" alt="">
				<p class="mt-4 text-secundary-00 fs-32 line-height-40 fw-bold text-center">Sigue las instrucciones en <br> el lector de tarjetas</p>
			</div>
		</div>
		<div class="col-6 mx-auto px-3 h-100 box-steps box-procesando d-none" style="height: 70vh !important;">
			<div class="row flex-column h-100 justify-content-center align-items-center text-center">
				<div class="d-flex justify-content-center">
					<div class="spinner-border text-primary" role="status" style="width: 70px;height: 70px; border-width: 15px;">
				    	<span class="visually-hidden">Procesando...</span>
				  	</div>
				</div>
				<p class="mt-4 text-secundary-00 fs-32 line-height-40 fw-bold text-center">Estamos procesando tu <br> pago...</p>
			</div>
		</div>
	</div>
	@include('components.footer')
</div>
<style>
	.btn-payment-type{
		height: 175px;
		border: 4px solid #D0D3D9;
		box-shadow: 0px 0px 4px 0px #0000000D;
		margin: 75px 0px;
	}
	.btn-payment-type:hover{
		background: var(--royalBlue) !important;
		color: #fff !important;
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		$('body').on('click', '.btn-payment-type', async function(){
			let metodo = $(this).attr('metodo-rel')
			if(metodo == "TC"){
				$('.page-title').html(`Pagar`);
				$('.box-steps').addClass('d-none');
				$('.box-pasarela').removeClass('d-none');
				await facturar();
			}
		})
	})
	async function facturar(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/facturar?macAddress={{ $mac }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	$('.box-steps').addClass('d-none');
			$('.box-procesando').removeClass('d-none');
        	localStorage.setItem("datosFacturados", JSON.stringify(data.data));
        	setTimeout(function(){
        		alert('Pago exitoso, nos vemos pronto')
        		location.href = `/pago-realizado/{{ $mac }}`;
        	}, 1000);
        }else{
        	// alert(data.message);
        	$('.page-title').html(`Escoge el método de pago`);
			$('.box-steps').addClass('d-none');
			$('.box-metodos').removeClass('d-none');

			$('#modalError').modal('show')
			$('.titleError').html(`Ha ocurrido un error`)
			$('.msgError').html(${data.message});
        }
	}
</script>
@endsection