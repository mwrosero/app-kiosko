@extends('template.app-template')
@section('content')
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/paquetes-preventivos/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => ''])
	<!-- Contenido principal -->
	<main class="flex-fill px-0 py-0">
		<div class="row g-3 d-flex justify-content-between align-items-start h-100 mx-0">
			<div class="col-2 pb-4">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			{{-- style="overflow-y: auto; max-height: 70vh !important;" --}}
			<div class="col-10 px-32 h-100">
				<div class="row">
					<div class="col-12 my-3">
						<img src="" class="img-fluid w-100 rounded-16 img-paquete" alt="">
					</div>
				</div>
				<div class="row box-price align-items-end">
				</div>
				<div class="row">
					<div class="col-12 my-3 p-3 bg-royal-blue-tint-90 rounded-8">
						<p class="fw-bold fs-16 line-height-20 mb-3">Detalle</p>
						<ul id="detallePaquete">
							{{-- <li class="fs-16 line-height-20 mb-1"></li> --}}
						</ul>
					</div>
					<div class="col-12 fs-16 line-height-20 px-0" id="descripcionPaquete">
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
		let urlImagen = (paquete.urlImagen !== "") ? paquete.urlImagen : `{{asset('assets/img/img-default-paquete.png')}}`
		$('.page-title').html(paquete.nombreComercialPaquete);
		$('.img-paquete').attr('src', urlImagen)
		$('#descripcionPaquete').html(paquete.descripcionPaquete)

		let strDescuento = ``;
        let strDescuentoFooter = ``;
        let badgesImg = ``;
        if(paquete.porcentajeDescuento > 0){
            //strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">-${paquete.porcentajeDescuento}%</span>`;
            if(!paquete.esDescuentoExclusivo){
               strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">Desct. exclusivo web</span>`;
            }
            strDescuentoFooter = `<div class="p-1 fs-12 line-height-16 box-discount fw-medium text-center d-inline-block mb-1">-${paquete.porcentajeDescuento}% dto.</div><p class="mb-0 text-muted fs-14 line-height-16">Antes <span class="text-decoration-line-through"> $${paquete.subtotalVenta.toFixed(2)}</span></p>`;
        }
        if(paquete.esDomicilio){
            badgesImg = `<div class="position-absolute bottom-0 p-2 m-1 d-flex justify-content-start align-items-center">
                <div class="p-2 badge-domicilio text-primary fw-medium rounded-1 font-gotham d-flex justify-content-between"><img src="{{asset('assets/img/fa-icon-domicilio.svg')}}" style="width: 16px;margin-right: 4px;">A domicilio</div>
            </div>`
        }

        $('.box-price').html(`<div class="col-8 my-3">
                ${strDescuentoFooter}
                <h4 class="text-primary fs-28 line-height-36 fw-bold mb-0">$${paquete.valorTotal.toFixed(2)}</h4>
            </div>
	        <div class="col-4 my-3 d-flex justify-content-end align-items-end gap-2">
	            {{-- <div type="button" data-rel='${JSON.stringify(paquete)}' class="btn border-royal-blue text-royal-blue fs-18 line-height-24 fw-medium ms-2 m-0 btn-add-to-cart rounded-8 p-3 flex-fill btn-pagar">Pagar ahora</div> --}}
	            <div type="button" data-rel='${JSON.stringify(paquete)}' class="btn bg-royal-blue text-white fs-18 line-height-24 fw-medium ms-2 m-0 btn-asignar rounded-8 p-3 flex-fill">Agregar al carrito</div>
    		</div>`)



		await obtenerDetallePaquete();

        {{-- $('body').on('click', '.btn-comprar', function(){
        	let paquete = $(this).attr('data-rel');
        	console.log(paquete);
        	localStorage.setItem("paquete", paquete);
        	location.href = `/detalle-paquete/{{ $mac }}`;
        }) --}}

        $('body').on('click', '.btn-asignar', async function(){
			location.href = `/asignar-paquete/{{ $mac }}`;
		})

	})

	async function agregarItem(datosPago){
		console.log(datosPago);
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/agregar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify(datosPago);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	location.href = '/datos-facturacion/{{ $mac }}';
        }else{
        	$('#modalError').modal('show');
			$('.titleError').html(`Atención`);
			$('.msgError').html(data.message);
        }
	}

	let servicios;
	async function obtenerDetallePaquete(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/paquetes/${paquete.codigoPaquete}/detalles?macAddress={{ $mac }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
        	let elem = ``;
            $.each(data.data.detalles, function(key, value){
                elem += `<li class="fs-16 line-height-20 mb-1 text-capitalize">${value.nombrePrestacion.toLowerCase()}</li>`;
            })
            $('#detallePaquete').append(elem);            
        }else{
            alert(data.message);
        }
	}
</script>
@endsection