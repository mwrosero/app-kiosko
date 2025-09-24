@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">
<div class="container-fluid px-0 d-flex flex-column min-vh-100">
	@include('components.header')
	<!-- Sub-header -->
	@include('components.sub-header', ['showTurnoBtn' => true, 'url' => '/menu/'.$mac])
	<!-- Carrito -->
	@include('components.cart-bar', ['title' => 'Paquetes preventivos'])
	<!-- Contenido principal -->
	<main class="flex-grow-1 d-flex flex-column">
		<div class="row g-3 flex-grow-1 mx-0 ">
			<div class="col-2 box-accesos-lateral">
				@include('components.access-bar', ['page' => 'paquetes-preventivos'])
			</div>
			<!-- pe-0 -->
			<div class="col-10 px-3 d-flex flex-column overflow-auto contenido-central" style="overflow-y: auto;">
				<div class="row border-bottom py-32">
					<div class="col-6 offset-3 border d-flex justify-content-between align-items-center border-silver rounded-6 p-1 mb-3">
						<button class="btn p-3 rounded-4 bg-royal-blue text-white fs-20 line-height-16 flex-fill">Comprar</button>
						<button class="btn p-3 rounded-4 fs-20 line-height-16 flex-fill">Agendar</button>
					</div>
					<div class="col-10 offset-1 py-4 d-flex justify-content-between align-items-center gap-2">
						<div class="input-group bg-beige-light border-midnight-blue-tint-80 search-box rounded-8">
		                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
		                    <input type="search" class="form-control bg-transparent fs-16 line-height-20 border-0 p-2 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Ejemplo: Exámenes de laboratorio" aria-describedby="search" style="outline: none;box-shadow: none;" readonly />
		                </div>
		                <button class="btn h-100 d-flex justify-content-between p-12 align-items-center fs-18 line-height-24 border-royal-blue text-royal-blue rounded-8" style="width: 175px;" data-bs-toggle="modal" data-bs-target="#modalCategorias">
		                	Filtrar por
		                	<img src="{{asset('assets/img/fa-filter.svg')}}" alt="Filtrar">
		                </button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 d-flex justify-content-start align-items-center gap-2 box-categorias-seleccionadas my-3">
						{{-- <div class="item-categoria bg-royal-blue-tint-90 d-flex justify-content-between align-items-center gap-2 py-10 rounded-8 fs-14 line-height-16 px-3">
							Mujeres <i class="fa-solid fa-xmark"></i>
						</div> --}}
					</div>
					<div class="col-12 mb-3">
						<div class="row" id="listado-paquetes">
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<div class="w-100 bg-silver-light p-44 position-absolute bottom-0 start-0 d-none" id="box-simple-keyboard">
		<div class="simple-keyboard"></div>
	</div>
	@include('components.footer')
</div>
<script src="https://unpkg.com/simple-keyboard@latest/build/index.js"></script>
<style>
	#lista-categorias .ico-categoria {
	  max-width: 36px;
	}

	#lista-categorias div {
	  border: 1px solid #CDD4DA;
	  border-radius: 8px;
	  padding: 12px;
	}

	.category-selected {
	  background: #E9F7FF;
	}

	/*.category-selected i:first-child {
	  color: #0071CE !important;
	}*/

	.btn-unselect {
	  color: #0A2240 !important;
	  display: none;
	}

	.category-selected .btn-unselect{
	  display: block;
	}

	.simple-keyboard{
		width: 100%;
		margin: auto;
		background: transparent !important;
	}
	.hg-button.hg-standardBtn,
	.hg-button.hg-functionBtn{
		font-size: 24px !important;
		line-height: 44px !important;
		padding: 5px 0px !important;
		height: auto !important;
		border: 1px solid #13243F;
		box-shadow: none !important;
		margin: 5px !important;
		border-radius: 8px !important;
	}

	.numeric-theme .hg-button[data-skbtnuid="default-r3b0"]{
		visibility: hidden;
	}

	.hg-button[data-skbtnuid="default-r1b10"]{
		border: none !important;
		background: var(--royalBlue) !important;
		font-size: 30px !important;
		color: #fff !important;
	}
	.hg-button[data-skbtn="{space}"] {
		flex: 8; /* ocupa el triple de espacio que una tecla normal */
	}
	.hg-button.hg-standardBtn, .hg-button.hg-functionBtn{
		width: 20px;
	}
	{{-- .hg-layout-numbers .hg-rows {
	    width: 70%;
	    margin: auto;
	} --}}
	.hg-layout-numbers .hg-button.hg-standardBtn,
	.hg-layout-numbers .hg-button.hg-functionBtn{
		font-size: 36px !important;
		margin: 12px !important;
		padding: 20px 0px !important;
	}

	.hg-layout-numbers .hg-button[data-skbtnuid="numbers-r3b2"]{
		border: none !important;
		background: transparent !important;
		font-size: 42px !important;
	}
</style>
<script>
	let datosCliente = JSON.parse(localStorage.getItem('datosCliente'));
	trackId = localStorage.getItem('trackId');
	let page = 1;
    let perPage = 12;
    let cargandoContenido = false;
    let isFiltered = false;
	const Keyboard = window.SimpleKeyboard.default;
    let keyboardInit;

    let currentInput = null;
	document.addEventListener("DOMContentLoaded", async function () {
		$('.contenido-central').css('max-height',`${$('.box-accesos-lateral').height()}px`)
		window.addEventListener("beforeunload", () => {
			console.log("Destroy Keyboard");
			keyboardInit.destroy()
		});

		await obtenerPaquetesPromocionales();

		keyboardInit = new Keyboard({
			onChange: async input => {
				if(currentInput){
					$(currentInput).val(input);
					console.log(input)

					if(input.length > 3){
						page = 1;
	                    $('#listado-paquetes').empty();
	                    cargandoContenido = true;
	                    await obtenerPaquetesPromocionales();
					}else if(input.length == 0){
		                page = 1;
		                $('#listado-paquetes').empty();
		                cargandoContenido = false;
		                await obtenerPaquetesPromocionales();
            		}
				}
			},
			onKeyPress: async button => {
				if(button === "{bksp}" && currentInput){
					let val = $(currentInput).val();
					$(currentInput).val(val.slice(0, -1));
					keyboardInit.setInput($(currentInput).val());
				}

    			// 👉 Aquí manejamos los cambios de layout
				if(button === "{shift}" || button === "{lock}"){
					handleShift();
				}

				if(button === "{numbers}"){
					keyboardInit.setOptions({
						layoutName: "numbers"
					});
				}

				if(button === "{abc}"){
					keyboardInit.setOptions({
						layoutName: "default"
					});
				}

				if (button === "{close}") {
					$('#box-simple-keyboard').addClass('d-none');
				}

				if(button === "{ent}" && currentInput){
					if(currentInput.id === "numeroIdentificacion"){
						let valor = $(currentInput).val();
						if(parseInt($('#tipoIdentificacion option:selected').val()) == 3 && valor.length > 5){
							await verificarDatosFacturacion();
						}
					}
				}
			},
			onFocus: async button => {
				console.log(0)
			},
			mergeDisplay: true,
			layoutName: "default",
			layout: {
				default: [
					"q w e r t y u i o p {bksp}",
					"a s d f g h j k l ñ {ent}",
					"{shift} z x c v b n m -",
					"{numbers} @ {space} . {close}"
				],
				shift: [
					"Q W E R T Y U I O P {bksp}",
					"A S D F G H J K L Ñ {ent}",
					"{shift} Z X C V B N M -",
					"{numbers} @ {space} . {close}"
				],
				numbers: [
					"1 2 3",
					"4 5 6",
					"7 8 9",
					"{abc} 0 {bksp}"
				]
			},
			display: {
				"{numbers}": "123",
				"{ent}": "<i class='fa-solid fa-arrow-right'></i>",
				"{escape}": "esc ⎋",
				"{tab}": "tab ⇥",
				"{bksp}": "<i class='fa fa-backspace'></i>",
				"{capslock}": "caps ⇪",
				"{shift}": "⇧",
				"{abc}": "ABC",
				"{close}": "<i class='fa-regular fa-circle-xmark'></i>"
			}
		});

		$(document).on('click', function(e) {
		    if ($('#box-simple-keyboard').is(':visible') && 
		    	!$(e.target).closest('#box-simple-keyboard').length && 
		    	!$(e.target).is('input')
    		){
		        $('#box-simple-keyboard').addClass('d-none');
    		}
		});

		$("input").on("focus", function () {
			$('#box-simple-keyboard').removeClass('d-none');
			if (this.type === "checkbox") {
				return; // no hacer nada
			}
		  	currentInput = this;

		  	const isNumeric =
		    	this.type === "number" ||
		    	$(this).attr("inputmode") === "numeric";


		  	keyboardInit.setOptions({ layoutName: isNumeric ? "numbers" : "default" });

		  	// Sincronizamos valor actual del input con el teclado
		  	keyboardInit.setInput($(this).val() || "");
		  	//keyboardInit.setInput($(this).val());
		});

		// función auxiliar para shift
		function handleShift(){
			let currentLayout = keyboardInit.options.layoutName;
			let shiftToggle = currentLayout === "default" ? "shift" : "default";
			keyboardInit.setOptions({
				layoutName: shiftToggle
			});
		}

  		// Detectar qué input tiene el foco
		$("input").on("focus", function(){
			currentInput = this;
			keyboardInit.setInput($(this).val());
		});

		$('body').on('click', '.btnEliminarCategoria', async function(){
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').removeClass('category-selected');
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-unselected').removeClass('d-none')
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-selected').addClass('d-none')
            $('.btnAplicarFiltroCategorias').click();
        })

        $('body').on('click', '.btnAplicarFiltroCategorias', async function(){
            let categorias = await obtenerCategoriasSeleccionadas("texto-valor");
            let elem = ``;
            $.each(categorias, function(key, value){
                let label = value.split("-");
                elem += `<div class="item-categoria bg-royal-blue-tint-90 d-flex justify-content-between align-items-center gap-2 py-10 rounded-8 fs-14 line-height-16 px-3 text-capitalize">
							${label[1].toLowerCase()} <i class="fa-solid fa-xmark btnEliminarCategoria" categoria-rel="${label[0]}"></i>
						</div>`;
            })
            $('.box-categorias-seleccionadas').html(elem);
            categorias.join(',')
            page = 1;
            $('#listado-paquetes').empty();
            cargandoContenido = false;
            isFiltered = true;
            await obtenerPaquetesPromocionales();
            isFiltered = false;
        })

        $('body').on('click', '.category-item', function(){
            if($(this).hasClass('category-selected')){
                $(this).find('.ico-unselected').removeClass('d-none')
                $(this).find('.ico-selected').addClass('d-none')
                $(this).removeClass('category-selected');
            }else{
                $(this).find('.ico-selected').removeClass('d-none')
                $(this).find('.ico-unselected').addClass('d-none')
                $(this).addClass('category-selected');
            }
        })

        $('body').on('click', '.btn-comprar', function(){
        	let paquete = $(this).attr('data-rel');
        	console.log(paquete);
        	localStorage.setItem("paquete", paquete);
        	location.href = `/detalle-paquete/{{ $mac }}`;
        })

        {{-- $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll); --}}

        async function onScroll(){
            console.log('onScroll');
            
            if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 100 > $(document).height()) {
                cargandoContenido = true;
                console.log("near bottom!");
                await obtenerPaquetesPromocionales();
            }else{
            	console.log(1)
            }
        } 

        let startY = 0;

		$(document).on('touchstart', function(e) {
		    startY = e.originalEvent.touches[0].clientY;
		});

		$(document).on('touchend', function(e) {
		    let endY = e.originalEvent.changedTouches[0].clientY;
		    if (endY < startY) {
		        console.log("Swipe hacia arriba");
		        onScroll();
		    } else if (endY > startY) {
		        console.log("Swipe hacia abajo");
		        onScroll();
		    }
		});


        var typingTimer; // Timer identifier
        var doneTypingInterval = 750; // Tiempo de pausa en milisegundos (0.5 segundos)

        // Evento de escritura en el input
        $('#buscarPorPromocion').on('keyup', async function() {
            clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se escribe

            var searchText = $(this).val();
            if (searchText.length >= 3) { // Solo realizar la búsqueda si hay al menos 3 caracteres
                typingTimer = setTimeout(async function() {
                    page = 1;
                    $('#listado-paquetes').empty();
                    cargandoContenido = true;
                    await obtenerPaquetesPromocionales(); // Llamar a la función de búsqueda después de la pausa
                }, doneTypingInterval);
            }else if(searchText.length == 0){
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                await obtenerPaquetesPromocionales();
            }
        });

        $('#buscarPorPromocion').on('search', function() {
            if ($(this).val().length === 0) {
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
        });

		await obtenerCategorias();
	})

	async function obtenerCategorias(){
        let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/paquetes/categorias_paquete?macAddress={{ $mac }}`;
        args["method"] = "GET";
        //args["sendHeaders"] = false;
        args["token"] = "{{ $accessToken }}";
        args["showLoader"] = false;
        const data = await call(args);
        
        if(data.code == 200){
            let elem = `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute;right: 15px;top: 15px;"></button>`;
            $.each(data.data, function(key, categoria){
                elem += `<div nombreCategoria-rel="${capitalizarCadaPalabra(categoria.nombreCategoria)}" categoria-rel="${categoria.nemonicoCategoria}" class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                        <img height="36px" src="${categoria.urlImagenCategoria}" class="ico-categoria me-3 ico-unselected"/>
                        <img height="36px" src="${categoria.urlImagenCategoriaSel}" class="ico-categoria me-3 ico-selected d-none"/>
                        <span class="fs-16 line-height-20 me-3 text-veris text-capitalize">${categoria.nombreCategoria.toLowerCase()}</span>
                        <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                    </div>`
            })
            $('#lista-categorias').html(elem)
        }
    }

    async function obtenerCategoriasSeleccionadas(type){
        var itemsSeleccionados = [];
        $('.category-item').each(function() {
            if ($(this).hasClass('category-selected')) {
                if(type == "valor"){
                    itemsSeleccionados.push($(this).attr('categoria-rel'))
                }else{
                    itemsSeleccionados.push($(this).attr('categoria-rel')+'-'+$(this).attr('nombreCategoria-rel'))
                }
            }
        });
        return itemsSeleccionados;
    }

    async function obtenerNemonicosCategoriasSeleccionadas(){
        var itemsSeleccionados = [];
        $('.category-item').each(function() {
            if ($(this).hasClass('category-selected')) {
                itemsSeleccionados.push($(this).attr('categoria-rel'))
            }
        });
        return itemsSeleccionados;
    }

	async function agregarItem(datosPago){
		console.log(datosPago);
		let args = [];
        args["endpoint"] = `${api_url_digitales}/${api_war}/carrito/${localStorage.getItem("idPreTransaccion")}/agregar?macAddress={{ $mac }}&idPaciente=${datosCliente.idPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        {{-- args["sendHeaders"] = false; --}}
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify(datosPago);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	location.href = '/datos-facturacion/{{ $mac }}';
        }
	}

	let servicios;
	async function obtenerPaquetesPromocionales(){
		let nemonicos = await obtenerNemonicosCategoriasSeleccionadas();

		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war}/paquetes?macAddress={{ $mac }}&page=${page}&perPage=${perPage}&nemonicoGrupoPaciente=${nemonicos.join(',')}&busqueda=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
        args["method"] = "GET";
        args["showLoader"] = (getInput('buscarPorPromocion') == "") ? true : false;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
            let elem = ``;
            if(data.data.rows.length == 0){
                cargandoContenido = true;
            }else{
                cargandoContenido = false;  
            }
            if(data.data.rows.length > 0){
                $.each(data.data.rows, function(key, value){
                	let urlImagen = (value.urlImagen !== "") ? value.urlImagen : `{{asset('assets/img/img-default-paquete.png')}}`

                    let strDescuento = ``;
                    let strDescuentoFooter = ``;
                    let badgesImg = ``;
                    if(value.porcentajeDescuento > 0){
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
                    }
                    elem += `<div class="col-12 col-md-6 mb-4">
                        <div class="card h-100 border-0 box-shadow-3 rounded-4 p-3 border-silver rounded-16">
                            <div type="button" class="zoom-img btn-comprar position-relative rounded-3 overflow-hidden" data-rel='${JSON.stringify(value)}'>
                                <img src="${urlImagen}" onerror="this.src='https://www.veris.com.ec/wp-content/themes/veris2025/img/veris.png'" class="card-img-top" alt="${value.nombrePaquete}">
                                ${strDescuento}
                                ${badgesImg}
                            </div>
                            <div class="card-body px-0">
                                <h5 class="card-title fs--4 text-capitalize text-primary">${value.nombreComercialPaquete.toLowerCase()}</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    ${strDescuentoFooter}
                                    <h4 class="text-primary fs-28 line-height-36 fw-bold mb-0">$${value.valorTotal.toFixed(2)}</h4>
                                </div>
                                <div type="button" data-rel='${JSON.stringify(value)}' class="btn btn-sm bg-royal-blue text-white fs-14 line-height-16 fw-medium ms-2 m-0 btn-comprar rounded-4 py-8 px-3">Ver paquete</div>
                            </div>
                        </div>
                    </div>`;
                })
                page++;
            }else{
                if(page == 1){
                    $('#listado-paquetes').empty();
                    elem += `<p class="fs--16 line-height-20 text-center mt-5 mb-4">No se encontraron coincidencias para tu búsqueda</p>`;
                }
            }
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
	}
</script>
@endsection