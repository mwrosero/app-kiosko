<!-- Modal Confirmar Cita -->
<div class="modal modal-top fade" id="modalConsultorio" aria-labelledby="modalConsultorioLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-32 py-24 text-center">
                <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/anime-doctor.svg" class="img-fluid" alt="">
                <p class="py-40 mb-0 fs-28 line-height-32">Tu consultorio es el</p>
                <h2 class="fs-64 fw-bold mb-40 nombreConsultorio">#</h2>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmar Cita -->
<div class="modal modal-top fade" id="modalError" aria-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-32 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32 titleError">Ha ocurrido un error</h2>
                <h3 class="fs-16 line-height-20 text-silver-dark mb-32 msgError">El usuario ingresado para los datos de facturación es menor de edad, para continuar, cambia los datos por los de un usuario mayor de edad.</h3>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Categorías paquetes -->
<div class="modal modal-top fade" id="modalCategorias" aria-labelledby="modalCategoriasLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-md modal-dialog-centered mx-auto my-0">
        <div class="modal-content rounded-8 rounded-24">
            <div class="modal-body px-32 py-24 text-center">
                <h2 class="fs-24 line-height-32 text-royal-blue fw-medium mb-32">Filtrar por</h2>
                <div class="mb-3" id="lista-categorias">
                </div>
                <button class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-100 btnAplicarFiltroCategorias" data-bs-dismiss="modal">Aplicar</button>
            </div>
        </div>
    </div>
</div>