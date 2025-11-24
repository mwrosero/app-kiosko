<!-- Modal Busqueda Usuario -->
<div class="modal modal-top fade" id="modalUsuariosEncontrados" aria-labelledby="modalUsuariosEncontradosLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium my-32">Elige el paciente</h2>
                <div class="box-items-chequeo text-start p-4 border-silver mb-32 py-3 px-32" style="max-height: 700px; overflow-y: auto;">
                    <ul class="list-unstyled listado-coincidencias-pacientes">
                        {{-- <li type="button" class="p-3 border-bottom-midnight-blue-tint-80 fs-16 line-height-20 text-dark-veris">
                            <p class="mb-2">Maria Rosero Peralta</p>
                            <p class="mb-0">XXXXXX7895</p>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Turno para usuario nuevo --}}
<div class="modal modal-top fade" id="modalIngresarNombres" aria-labelledby="modalIngresarNombresLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body text-center p-3 px-32 pb-2">
                <h2 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium my-32">Veris</h2>
                <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgError" id="mensajeErrorUsuario"></h3>
                {{-- <div class="col-12 mt-3 text-start">
                    <label for="nombres" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Ingrese sus nombres *</label>
                    <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="nombres" id="nombres" placeholder="" required readonly/>
                    <div class="invalid-feedback">
                        Ingrese sus nombres.
                    </div>
                </div>
                <div class="col-12 mt-3 text-start">
                    <label for="nombres" class="form-label text-silver-neutral-40 form-label fs-18 line-height-24 mb-1">Ingrese sus apellidos *</label>
                    <input type="text" class="form-control input w-100 rounded-12 border-midnight-blue bg-white text-silver-dark fs-18 line-height-24 py-24 px-3" name="apellidos" id="apellidos" placeholder="" required readonly/>
                    <div class="invalid-feedback">
                        Ingrese sus apellidos.
                    </div>
                </div> --}}
                {{-- <div onclick="crearTurno();" class="btn bg-veris btn-crear-turno text-white mx-auto mb-5 rounded-8 my-5">CREAR TURNO</div> --}}
                <button class="btn py-24 my-32 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100 btn-paciente-nuevo">Generar turno</button>
                {{-- <div class="w-100 d-none d-md-block">
                    <div class="keyboardContainer w-100"></div>
                </div> --}}
            </div>
            {{-- <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn bg-veris btn-ingresar text-white mx-auto rounded-8 mt-3" data-bs-dismiss="modal">Entiendo</button>
            </div> --}}
        </div>
    </div>
</div>


<!-- Modal Confirmar Cita -->
<div class="modal modal-top fade" id="modalConsultorio" aria-labelledby="modalConsultorioLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-64 py-24 text-center">
                <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid" alt="">
                <p class="py-40 mb-0 fs-28 line-height-32">Tu consultorio es el</p>
                <h2 class="fs-64 fw-bold mb-40 nombreConsultorio text-capitalize"></h2>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div class="modal modal-top fade" id="modalError" aria-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32 titleError">Ha ocurrido un error</h2>
                <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgError"></h3>
                {{-- El usuario ingresado para los datos de facturación es menor de edad, para continuar, cambia los datos por los de un usuario mayor de edad --}}
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Categorías paquetes -->
<div class="modal modal-top fade" id="modalCategorias" aria-labelledby="modalCategoriasLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32">Filtrar por</h2>
                <div class="mb-3" id="lista-categorias">
                </div>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50 btnAplicarFiltroCategorias" data-bs-dismiss="modal">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terminos y Condiciones Pago -->
<div class="modal modal-top fade" id="modalTerminos" aria-labelledby="modalTerminosLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32">Términos y condiciones</h2>
                <div class="box-terminos text-start p-4 border-silver mb-32" style="height: 700px; overflow-y: auto;">
                    @include('components.terminos')
                </div>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Producto Agregado -->
<div class="modal modal-top fade" id="modalProductoAgregado" aria-labelledby="modalProductoAgregadoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            {{-- <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button> --}}
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-40 line-height-48 py-32 text-royal-blue fw-medium">Item agregado al carrito</h2>
                {{-- <h3 class="fs-16 line-height-20 text-silver-dark mb-32">El usuario ingresado para los datos de facturación es menor de edad, para continuar, cambia los datos por los de un usuario mayor de edad.</h3> --}}
                <div class="mb-32 pb-4">
                    <i class="fa-solid fa-circle-check fs-128 line-height-128 text-green-dark"></i>
                </div>
                <div class="box-actions d-flex justify-content-between align-items-center gap-3">
                    <a href="/menu/{{ $mac }}" class="btn py-24 text-royal-blue border-royal-blue rounded-12 fs-24 line-height-32 w-50">Seguir comprando</button>
                    <a href="/carrito/{{ $mac }}" class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50">Ir a pagar</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal Error modal --}}
<div class="modal modal-top fade" id="modalErrorToast" aria-labelledby="modalErrorToastLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32">Atención</h2>
                <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgErrorToast">El usuario ingresado para los datos de facturación es menor de edad, para continuar, cambia los datos por los de un usuario mayor de edad.</h3>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Activar Chequeo -->
<div class="modal modal-top fade" id="modalActivarChequeo" aria-labelledby="modalActivarChequeoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium my-32">¿Estás seguro de querer activar tu orden?</h2>
                <p class="text-dark-veris fs-16 line-height-20 mt-32 mb-4">Debes activar tu orden cuando estés listo para realizar la toma de muestra.</p>
                <div class="box-items-chequeo text-start p-4 border-silver mb-32 py-3 px-32" style="max-height: 700px; overflow-y: auto;">
                    <ul class="list-unstyled listado-items-chequeo">
                        {{-- <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li>
                        <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li> --}}
                    </ul>
                </div>
                <div class="checkbox checkbox-primary fs-18 line-height-22 d-flex justify-content-center align-items-start mb-32 box-aceptacion d-none">
                    <input id="autorizacion" class="me-4" type="checkbox" style="height:25px; width: 25px;">
                    <label for="">
                        Acepto <span class="text-veris fw-bold" data-bs-toggle="modal" data-bs-target="#modalAceptacionResultados">los términos y condiciones</span> que los resultados <br> serán entregados a la Empresa.
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <button class="btn py-24 border-royal-blue text-royal-blue rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Ahora no</button>
                    <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50 btn-activar" data-bs-dismiss="modal">Sí, quiero activar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle Chequeo -->
<div class="modal modal-top fade" id="modalDetalleChequeo" aria-labelledby="modalDetalleChequeoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue-shade-20 fw-medium my-32 title-detalle-chequeo text-capitalize"></h2>
                {{-- <p class="text-dark-veris fs-16 line-height-20 mt-32 mb-4 subtitle-detalle-chequeo"></p> --}}
                <div class="box-items-chequeo-detalle text-start p-4 border-silver mb-32 py-3 px-32" style="max-height: 700px; overflow-y: auto;">
                    <ul class="list-unstyled listado-items-chequeo-detalle">
                        {{-- <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li>
                        <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li> --}}
                    </ul>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle Chequeo -->
<div class="modal modal-top fade" id="modalDetalleOrdenTratamiento" aria-labelledby="modalDetalleOrdenTratamientoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3 fw-bold" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1;"></button>
            <div class="modal-body px-64 py-24">
                <h2 class="fs-24 line-height-32 fw-medium my-32 text-center title-modal-detalle-orden">Revisa el detalle de tu orden</h2>
                {{-- <p class="text-dark-veris fs-16 line-height-20 mt-32 mb-4 subtitle-detalle-chequeo"></p> --}}
                <div class="header-orden my-3"></div>
                <hr>
                <div class="excerpt d-none">
                    <p class="mb-2 fs-18 line-height-24 fw-medium text-royal-blue">Detalle</p>
                    <p class="fs-12 line-height-16 mb-0 text-dark-veris">A continuación se  muestra la prestación y los valores después de aplicado el crédito de la aseguradora, mientras la orden se encuentra vigente.</p>
                </div>
                <div class="row mt-24 mb-2 px-3 th-details-prestaciones">
                    <p class="col-5 mb-0 fs-16 line-height-20 fw-medium d-flex justify-content-start align-items-center">
                        <input type="checkbox" checked class="me-2 border-midnight-blue-tint-80" id="all-checkbox">
                        Prestación
                    </p>
                    <p class="col-2 mb-0 fs-16 line-height-20 fw-medium text-center">PVP.</p>
                    <p class="col-2 mb-0 fs-16 line-height-20 fw-medium text-center">Crédito</p>
                    <p class="col-2 mb-0 fs-16 line-height-20 fw-medium text-center">Total</p>
                    <p class="col-1 mb-0 fs-16 line-height-20 fw-medium text-center"></p>
                </div>
                <div class="text-start border-silver mb-2 py-0 px-3" style="max-height: 700px; overflow-y: auto;">
                    <ul class="listado-items-orden-detalle list-unstyled">
                        {{-- <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li>
                        <li class="p-3 border-bottom-midnight-blue-tint-80">asdasdlist-unstyled</li> --}}
                    </ul>
                </div>
                <div class="row mt-24 mb-32 px-3 totalesDetalleOrden th-details-prestaciones">
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3 box-actions-detalle-orden">
                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales desde Mi Veris --}}

<!-- Modal infomracion de la cita -->
<div class="modal fade" id="informacionCitaModal" tabindex="-1" aria-labelledby="informacionCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs--20 line-height-24 my-3" id="tituloModalInformacionCita">{{ __('Información') }}</h1>
                <p class="fs--1 fw-normal mb-0 text-veris" id = "mensajeInformacionCita"></p>
            </div>
            <div id="footerInformacionCita">
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Permite Cambio -->
<div class="modal fade" id="modalPermiteCambiar" tabindex="-1" aria-labelledby="modalPermiteCambiarLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                <p class="fs--1 fw-normal mb-0 text-veris" id="mensajeNoPermiteCambiar"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal embarazo -->
<div class="modal fade" id="modalEmbarazo" tabindex="-1" aria-labelledby="modalEmbarazoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3">
                <div class="text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="fa-solid fa-info fs-2"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información solicitada por tu aseguradora</h1>
                    <p class="fs--1 fw-normal text-veris mb-3 mx-3 line-height-16">¿Esta cita es por control de <b>embarazo</b>?</p>
                    <input type="hidden" id="datosGen">
                </div>
                <div class="d-flex">
                    <div respuesta-rel="S" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 me-3 btn-respuesta-embarazo">SI</div>
                    <div respuesta-rel="N" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 btn-respuesta-embarazo">NO</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal confirmar diferido -->
<div class="modal fade" id="modalDiferido" tabindex="-1" aria-labelledby="modalDiferidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3">
                <div class="text-center">
                    <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32 titleError">Información del pago</h2>
                    <h3 class="fs-16 line-height-20 text-silver-dark mb-32 label-diferido-cuotas"></h3>
                    <input type="hidden" id="datosDiferido">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div respuesta-rel="N" data-bs-dismiss="modal" class="btn -royal-blue border-royal-blue w-50 m-0 px-4 py-3">Cancelar</div>
                    <div respuesta-rel="S" class="btn bg-royal-blue text-white w-50 m-0 px-4 py-3 me-3 btn-pagar-diferido">Pagar</div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal-terminos-reultados')

<script>
    function showMessageModal(type, message){
        $('#modalErrorToast').modal('show');
        $('.msgErrorToast').html(message)
    }
</script>