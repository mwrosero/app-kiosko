<!-- Modal Confirmar Cita -->
<div class="modal modal-top fade" id="modalConsultorio" aria-labelledby="modalConsultorioLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-64 py-24 text-center">
                <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid" alt="">
                <p class="py-40 mb-0 fs-28 line-height-32">Tu consultorio es el</p>
                <h2 class="fs-64 fw-bold mb-40 nombreConsultorio">#</h2>
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

@include('components.modal-terminos-reultados')

<script>
    function showMessageModal(type, message){
        $('#modalErrorToast').modal('show');
        $('.msgErrorToast').html(message)
    }
</script>