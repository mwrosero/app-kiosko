<div class="row mt-40" id="listaPacientes">
</div>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		await grupoFamiliar();
	})

	async function grupoFamiliar(){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/pacientes/grupo_familiar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	let elem = ``;
        	$.each(data.data, function(key, value){
        		let backgroundClass = ( value.genero === "F" ) ? "bg-magenta" : "bg-royal-blue";

                elem += `<div class="col-6 mb-4">
                    <div class="card h-100 cursor-pointer p-3 text-center border-silver rounded-8 shadow-veris btn-asignar" data-rel='${JSON.stringify(value)}'>
                        <div class="card-body text-center px-3 py-2">
                           	<div class="d-flex ${backgroundClass} justify-content-center rounded-circle mx-auto align-items-center mb-3 fs-28 line-height-28 fw-medium text-white" style="width: 64px; height: 64px;">
                                ${value.primerNombre.charAt(0).toUpperCase()}
                            </div>
                            <p class="text-veris fw-medium fs-18 line-height-24 mb-2">${capitalizarElemento(value.primerNombre)} <br> ${capitalizarElemento(value.primerApellido)} ${capitalizarElemento(value.segundoApellido)}</p>
                            <p class="text-veris fs-16 line-height-20 mb-0 text-capitalize">${value.nombreTipoParentesco.toLowerCase()}</p>
                        </div>
                    </div>
                </div> `;
            })
            $('#listaPacientes').html(elem)
        }
	}
</script>