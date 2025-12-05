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
					<tr class="text-center">
						<th scope="col">Fecha impresión</th>
						<th scope="col">Sucursal</th>
						<th scope="col">Nro. transacciones</th>
						<th scope="col">Copago</th>
						<th scope="col">Empresa</th>
						{{-- <th scope="col">Detalle</th> --}}
					</tr>
				</thead>
				<tbody id="dataStats">
				</tbody>

			</table>
		</div>
	</div>

</div>
<script>
	let sucursales = [	
		{
			"codigoSucursal": 27,
			"nombreSucursal": "VERIS -  LABORATORIO 18 DE SEPTIEMBRE"
		},
		{
			"codigoSucursal": 28,
			"nombreSucursal": "VERIS -  EXPRESS SAMANES"
		},
		{
			"codigoSucursal": 17,
			"nombreSucursal": "VERIS -  LABORATORIO SAN RAFAEL"
		},
		{
			"codigoSucursal": 18,
			"nombreSucursal": "VERIS -  LABORATORIO LA PRENSA"
		},
		{
			"codigoSucursal": 20,
			"nombreSucursal": "VERIS -  LABORATORIO CARCELEN"
		},
		{
			"codigoSucursal": 21,
			"nombreSucursal": "VERIS -  LABORATORIO CONDADO"
		},
		{
			"codigoSucursal": 24,
			"nombreSucursal": "VERIS -  LABORATORIO BLUE COAST"
		},
		{
			"codigoSucursal": 25,
			"nombreSucursal": "VERIS -  LABORATORIO LOS ALMENDROS"
		},
		{
			"codigoSucursal": 1,
			"nombreSucursal": "VERIS - KENNEDY"
		},
		{
			"codigoSucursal": 2,
			"nombreSucursal": "VERIS - MALL DEL SOL"
		},
		{
			"codigoSucursal": 3,
			"nombreSucursal": "VERIS - GUAYAQUIL SUR"
		},
		{
			"codigoSucursal": 5,
			"nombreSucursal": "VERIS - ITALIA"
		},
		{
			"codigoSucursal": 6,
			"nombreSucursal": "VERIS - SAN LUIS"
		},
		{
			"codigoSucursal": 7,
			"nombreSucursal": "VERIS - GRANADOS"
		},
		{
			"codigoSucursal": 9,
			"nombreSucursal": "VERIS - LA Y"
		},
		{
			"codigoSucursal": 10,
			"nombreSucursal": "VERIS - QUICENTRO SUR"
		},
		{
			"codigoSucursal": 11,
			"nombreSucursal": "VERIS - CUENCA"
		},
		{
			"codigoSucursal": 14,
			"nombreSucursal": "VERIS - ALBORADA"
		},
		{
			"codigoSucursal": 35,
			"nombreSucursal": "VERIS - MEGA Y"
		},
		{
			"codigoSucursal": 30,
			"nombreSucursal": "VERIS EXPRESS LUXEMBURGO"
		},
		{
			"codigoSucursal": 31,
			"nombreSucursal": "VERIS EXPRESS VILLA CLUB"
		},
		{
			"codigoSucursal": 33,
			"nombreSucursal": "VERIS - VIRTUAL"
		},
		{
			"codigoSucursal": 34,
			"nombreSucursal": "VERIS - EL DORADO"
		},
		{
			"codigoSucursal": 40,
			"nombreSucursal": "VERIS - LABORATORIO CENTRAL BICENTENARIO"
		},
		{
			"codigoSucursal": 41,
			"nombreSucursal": "VERIS - LABORATORIO AEROPUERTO GYE"
		},
		{
			"codigoSucursal": 16,
			"nombreSucursal": "VERIS -  LABORATORIO CARAPUNGO"
		},
		{
			"codigoSucursal": 22,
			"nombreSucursal": "VERIS -  LABORATORIO SAMBORONDON"
		},
		{
			"codigoSucursal": 13,
			"nombreSucursal": "EDIFICIO NOBIS"
		},
		{
			"codigoSucursal": 4,
			"nombreSucursal": "OFICINAS - QUITO"
		},
		{
			"codigoSucursal": 8,
			"nombreSucursal": "VERIS - VILLAFLORA"
		},
		{
			"codigoSucursal": 12,
			"nombreSucursal": "EDIFICIO VERIS"
		},
		{
			"codigoSucursal": 15,
			"nombreSucursal": "VERIS - TUMBACO"
		},
		{
			"codigoSucursal": 19,
			"nombreSucursal": "VERIS -  LABORATORIO GUAMANI"
		},
		{
			"codigoSucursal": 23,
			"nombreSucursal": "VERIS -  LABORATORIO URDESA"
		},
		{
			"codigoSucursal": 26,
			"nombreSucursal": "VERIS -  LABORATORIO LA AURORA"
		},
		{
			"codigoSucursal": 29,
			"nombreSucursal": "VERIS -  LABORATORIO ATARAZANA"
		},
		{
			"codigoSucursal": 39,
			"nombreSucursal": "VERIS - LOS CEIBOS"
		},
		{
			"codigoSucursal": 37,
			"nombreSucursal": "VERIS - 12 DE OCTUBRE"
		},
		{
			"codigoSucursal": 38,
			"nombreSucursal": "VERIS - LOS CHILLOS"
		},
		{
			"codigoSucursal": 42,
			"nombreSucursal": "PARAMI - DURAN"
		},
		{
			"codigoSucursal": 43,
			"nombreSucursal": "PARAMI - CARAPUNGO"
		},
		{
			"codigoSucursal": 44,
			"nombreSucursal": "PARAMI - COMITE DEL PUEBLO"
		},
		{
			"codigoSucursal": 45,
			"nombreSucursal": "PARAMI - DAULE"
		},
		{
			"codigoSucursal": 46,
			"nombreSucursal": "VERIS ATENCION PRIORITARIA"
		},
		{
			"codigoSucursal": 47,
			"nombreSucursal": "PARAMI - MALL DEL NORTE "
		},
		{
			"codigoSucursal": 48,
			"nombreSucursal": "VERIS JUAN TANCA MARENGO"
		},
		{
			"codigoSucursal": 49,
			"nombreSucursal": "PARAMI - EL RECREO "
		}
	]

	document.addEventListener("DOMContentLoaded", async function () {
		const hoy = new Date().toISOString().split('T')[0];
    	document.getElementById('fecha').value = hoy;
		await obtenerDatosGenerales();

		$('body').on('click', '#btn-datos', async function(){
			await obtenerDatosGenerales();
		})

		$('body').on('click', '.btn-detalle', async function(){
			let detalle = JSON.parse($(this).attr('data-rel'));
			await obtenerDatosPorCentral(detalle);
		})
	})

	async function obtenerDatosGenerales(){
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

        var elem = ``;
        if(data.code == 200){
        	if(data.data.length > 0){
        		let totalTrx = 0;
        		let totalCopago = 0;
        		let totalCliente = 0;
	        	$.each(data.data, function(key, value){
	        		let slug = value.nombreSucursal.replace(/\s/g, '_');
	        		elem += `<tr class="btn-detalle text-center"  data-rel='${JSON.stringify(value)}'
	        				data-bs-toggle="collapse" 
				            href="#row-${slug}-content"  
				            role="button" 
				            aria-expanded="false" 
				            aria-controls="row-${slug}-content">
	        			<td>${value.fechaImpresion}</td>
	    				<td>${value.nombreSucursal}</td>
	    				<td>${value.totalTransacciones}</td>
	    				<td>$${value.valorTotalCopago}</td>
	    				<td>$${value.valorTotalCliente}</td>
	        		</tr>`;
	        		elem += `<tr class="collapse-details collapse" id="row-${slug}-content">
	        			<td colspan="5" class="text-center table-responsive" style="background:#296bef"></td>
	        		</tr>`
	        		totalTrx += value.totalTransacciones;
					totalCopago += value.valorTotalCopago;
					totalCliente += value.valorTotalCliente;
	        	})
	        	elem += `<tr>
        			<td colspan="2"></td>
    				<td class="fw-medium">${totalTrx}</td>
    				<td class="fw-medium">$${totalCopago.toFixed(2)}</td>
    				<td class="fw-medium">$${totalCliente.toFixed(2)}</td>
	        		<td></td>
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

	async function obtenerCodigoPorNombre(sucursalesArray, nombreBuscado) {
	    // 1. Limpiar el string de búsqueda para asegurar una coincidencia (eliminar espacios extra)
	    const nombreLimpio = nombreBuscado.trim();
	    // 2. Usar el método find() para encontrar el primer objeto que coincide
	    const sucursalEncontrada = sucursalesArray.find(sucursal => 
	        // Se recomienda limpiar el nombre en el objeto también para coincidir mejor
	        sucursal.nombreSucursal.trim() === nombreLimpio
	    );
	    // 3. Retornar el código si se encontró la sucursal, o null en caso contrario
	    return sucursalEncontrada ? sucursalEncontrada.codigoSucursal : null;
	}

	async function obtenerDatosPorCentral(detalle){
		console.log(detalle);
		let codigoSucursal = await obtenerCodigoPorNombre(sucursales,detalle.nombreSucursal);
		
		let fecha = getInput('fecha')
		let partes = fecha.split("-"); 
		let fechaFormateada = partes[2] + "/" + partes[1] + "/" + partes[0];

		let mac = "C8-D3-FF-A8-28-74";
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war}/turnero/consulta_transacciones?macAddress=${ mac }&fechaInicio=${fechaFormateada}&fechaFin=${fechaFormateada}&tipo=POR_HOST&codigoSucursal=${codigoSucursal}`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        
        let slug = detalle.nombreSucursal.replace(/\s/g, '_');
        var elem = ``;
        if(data.code == 200){
        	if(data.data.length > 0){
        		let totalTrx = 0;
        		let totalCopago = 0;
        		let totalCliente = 0;
        		let elem_tr = ``;
	        	$.each(data.data, function(key, value){
	        		elem_tr += `<tr>
	    				<td>${value.kiosko}</td>
	    				<td>${value.fechaApertura}</td>
	    				<td>${ (value.fechaCierre !== null) ? value.fechaCierre : `` }</td>
	    				<td>${value.host}</td>
	    				<td>${value.totalTransacciones}</td>
	    				<td>$${value.valorTotalCopago}</td>
	    				<td>$${value.valorTotalCliente}</td>
	        		</tr>`;
	        		totalTrx += value.totalTransacciones;
					totalCopago += value.valorTotalCopago;
					totalCliente += value.valorTotalCliente;
	        	});
	        	console.log(elem_tr)
	        	elem += `<table class="table table-striped table-hover mb-0 bg-light">
	        		<thead>
						<tr>
							<th scope="col">Kiosko</th>
							<th scope="col">Apertura</th>
							<th scope="col">Cierre</th>
							<th scope="col">Host</th>
							<th scope="col">Nro. transacciones</th>
							<th scope="col">Copago</th>
							<th scope="col">Empresa</th>
						</tr>
					</thead>
					<tbody>
			        	${elem_tr}
					</tbody>
		        </table>`;
	    	}else{
		    	elem += `<span class="text-light">No existen datos que mostrar</span>`;
	    	}
        }else{
        	elem += `<span class="text-light">No existen datos que mostrar</span>`;
        }
        $(`#row-${slug}-content td`).html(elem);
	}

</script>
@endsection