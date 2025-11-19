@extends('template.app-template-external')
@section('content')
<div class="container px-0 d-flex flex-column min-vh-100" style="overflow-x: hidden;">
	<div class="row">
        <div class="col-12 col-lg-10 offset-lg-1 fs-28 line-height-32 text-royal-blue fw-medium text-center my-4">
        	Estadísticas Kioskos Veris
        </div>
    </div>
    <div class="row">
	    <div class="col-4">
	        <label for="fecha" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Fecha de búsqueda</label>
	        <input type="date" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-3 px-3" name="fecha" id="fecha" placeholder=""/>
	    </div>

	    <div class="col-4 d-flex align-items-end">
	        <button class="btn bg-royal-blue text-white fs-18 line-height-24 py-3 rounded-8 w-100 fw-medium shadow-none" id="btn-datos">
	            Obtener
	        </button>
	    </div>
	</div>

	<div class="row mt-3">
		<div class="col-12 table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col">Fecha impresión</th>
						<th scope="col">Sucursal</th>
						<th scope="col">Nro. transacciones</th>
						<th scope="col">Copago</th>
						<th scope="col">Empresa</th>
					</tr>
				</thead>
				<tbody id="dataStats">
				</tbody>

			</table>
		</div>
	</div>

</div>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		const hoy = new Date().toISOString().split('T')[0];
    	document.getElementById('fecha').value = hoy;
		await obtenerDatos();

		$('body').on('click', '#btn-datos', async function(){
			await obtenerDatos();
		})
	})

	async function obtenerDatos(){
		let fecha = getInput('fecha')
		let partes = fecha.split("-"); 
		let fechaFormateada = partes[2] + "/" + partes[1] + "/" + partes[0];

		let mac = "C8-D3-FF-A8-28-74";
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/consulta_transacciones?macAddress=${ mac }&fechaInicio=${fechaFormateada}&fechaFin=${fechaFormateada}&tipo=RESUMEN`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);

        var elem = ``;
        if(data.code == 200){
        	if(data.data.length > 0){
        		let totalTrx = 0;
        		let totalCopago = 0;
        		let totalCliente = 0;
	        	$.each(data.data, function(key, value){
	        		elem += `<tr>
	        			<td>${value.fechaImpresion}</td>
	    				<td>${value.nombreSucursal}</td>
	    				<td>${value.totalTransacciones}</td>
	    				<td>$${value.valorTotalCopago}</td>
	    				<td>$${value.valorTotalCliente}</td>
	        		</tr>`;
	        		totalTrx += value.totalTransacciones;
					totalCopago += value.valorTotalCopago;
					totalCliente += value.valorTotalCliente;
	        	})
	        	elem += `<tr>
        			<td colspan="2"></td>
    				<td class="fw-medium">${totalTrx}</td>
    				<td class="fw-medium">$${totalCopago.toFixed(2)}</td>
    				<td class="fw-medium">$${totalCliente.toFixed(2)}</td>
        		</tr>`;
	    	}else{
		    	elem += `<tr>
	        		<td colspan="5" class="text-center">No existen datos que mostrar</td>
	        	</tr>`	
	    	}
        }else{
        	elem += `<tr>
        		<td colspan="5" class="text-center">No existen datos que mostrar</td>
        	</tr>`
        }
        $('#dataStats').html(elem);
	}

</script>
@endsection