@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/detalle-paquete/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => '¿Para quién es el paquete?'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'detalle-paquete'])
			</div>
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central mt-0" style="overflow-y: auto;">
				@include('components.grupo_familiar')
			</div>
		</div>
	</main>
	@include('components.footer')
</div>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	let paquete = JSON.parse(localStorage.getItem('paquete'));
	trackId = localStorage.getItem('trackId');
	localStorage.setItem("origen", "paquete");
	
	document.addEventListener("DOMContentLoaded", async function () {		
        $('body').on('click', '.btn-asignar', async function(){
        	let paciente = JSON.parse($(this).attr('data-rel'));
        	if(paciente.genero == paquete.genero || paquete.genero == "A"){
				let datosPago = {
					"paquetesPromocionales": {
						"codigoPaquete": paquete.codigoPaquete,
						"idPaciente": paciente.pacPacNumero
					}
				}
				await agregarItem(datosPago);
			}else{
				let generoPaquete = (paquete.genero == "F") ? `Femenino` : `Masculino`
				$('#modalError').modal('show');
				$('.titleError').html(`Lo sentimos`);
				$('.msgError').html(`Este paquete está diseñado exclusivamente para pacientes de sexo [${generoPaquete}]. Por favor, selecciona otro paquete o cambia el paciente seleccionado.`);
			}
		})
	})
</script>
@endsection