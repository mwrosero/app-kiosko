<!-- Modal PPD 2-->
<!-- Modal PPD 2-->
<div class="modal fade" id="modalPPD2" tabindex="-1" aria-labelledby="modalPPD2Label" data-bs-backdrop="static" data-bs-keyboard="false">
    <!-- 1. Agregada la clase modal-dialog-scrollable -->
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            
            <!-- 2. CUERPO: Con el contenido que scrollea -->
            <div class="modal-body p-3 py-4 text-start">
                <div class="resumen-consentimiento mt-3"></div>
                <div class="full-consentimiento d-none mt-3"></div>

                {{-- <p class="text-decoration-underline fs--2 line-height-16 my-3 text-veris-ai link-mostrar-todo-ppd2 cursor-pointer">
                    Ver política y consentimiento de datos personales.
                </p> --}}
            </div>

            <!-- 3. PIE: Botones fijos abajo (fuera del scroll) -->
            <div class="modal-footer border-0 justify-content-center p-3 pt-0 mt-4">
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3 w-100">
                    <button type="button" id="btnAceptarPPD2" class="btn btn-lg btn-primary-veris fw-medium px-5 py-3 btn-custom-width text-decoration-none text-white bg-royal-blue p-2 px-4 fw-medium fs-24 line-height-32 rounded-8 border-0">
                        Aceptar todo
                    </button>
                    <button type="button" id="btnGuardarPPD2" class="btn btn-lg btn-outline-primary-veris btn-ppd-disabled px-5 py-3 btn-custom-width d-none" data-bs-dismiss="modal">
                        Guardar
                    </button>
                    <button type="button" id="btnRechazarPPD2" class="btn btn-lg shadow-none text-Secundario-Midnight-blue-Tint-40 fw-medium px-5 py-3 btn-custom-width d-none">
                        Rechazar todo
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --verisAi: #296BEF;
        --bg-vris-strong-red: #D84315;
    }

    #modalPPD2 .modal-dialog {
        transition: max-width 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    /* Control de altura general del modal para evitar que se desborde del viewport */
    #modalPPD2 .modal-content {
        max-height: 85vh;
    }

    /* Permitir scroll solo cuando se despliegue full-consentimiento */
    .full-consentimiento:not(.d-none) {
        max-height: 50vh;
        {{-- overflow-y: auto; --}}
        padding-right: 5px; /* Evita que la barra de scroll tape el contenido */
    }

    .btn-custom-width {
        min-width: 220px;
        max-width: 100%;
    }
    /* Estado INACTIVO general para ambos botones */
    .consentimiento-group .btn {
        padding: 8px !important;
        border-color: var(--Secundario-Midnight-blue-Tint-80) !important;
        background-color: transparent !important;
    }

    .consentimiento-group .btn .consent-label-text {
        color: var(--Secundario-Midnight-blue-Tint-80);
    }

    .consentimiento-group .btn .custom-check-box {
        border: 1.5px solid var(--Secundario-Midnight-blue-Tint-80);
        background-color: #ffffff;
    }

    /* -------------------------------------------------------------
       ESTADO ACTIVO: ACEPTAR (Azul / --verisAi)
    ------------------------------------------------------------- */
    .consentimiento-group .consent-input-accept:checked + .btn-consent-accept {
        border-color: var(--verisAi) !important;
    }

    .consentimiento-group .consent-input-accept:checked + .btn-consent-accept .consent-label-text {
        color: var(--verisAi);
        font-weight: 300;
    }

    .consentimiento-group .consent-input-accept:checked + .btn-consent-accept .custom-check-box {
        background-color: var(--verisAi) !important;
        border-color: var(--verisAi) !important;
    }

    /* -------------------------------------------------------------
       ESTADO ACTIVO: NO ACEPTAR (Rojo / --bg-vris-strong-red)
    ------------------------------------------------------------- */
    .consentimiento-group .consent-input-reject:checked + .btn-consent-reject {
        border-color: var(--bg-vris-strong-red) !important;
    }

    .consentimiento-group .consent-input-reject:checked + .btn-consent-reject .consent-label-text {
        color: var(--bg-vris-strong-red);
        font-weight: 300;
    }

    .consentimiento-group .consent-input-reject:checked + .btn-consent-reject .custom-check-box {
        background-color: var(--bg-vris-strong-red) !important;
        border-color: var(--bg-vris-strong-red) !important;
    }

    /* Mostrar el icono FontAwesome en cualquier opción seleccionada */
    .consentimiento-group .btn-check:checked + .btn .custom-check-box .fa-check {
        display: inline-block !important;
    }

    /* Limita el texto a máximo 4 líneas cuando tiene la clase */
    /* Reemplaza .text-clamp-4 con esto */
    .text-clamp-4 {
        display: block; /* Cambiamos -webkit-box por block */
        max-height: 4.8em; /* Ajusta según el line-height (~4 líneas) */
        line-height: 1.2em;
        overflow: hidden;
        transition: max-height 0.25s ease;
    }

    /* Agrega esta clase para cuando expandas el texto desde JavaScript */
    .text-clamp-4.expanded {
        max-height: 2000px; /* Permite desplegar todo el contenido sin saltos */
    }

    .btn-ppd-disabled{
        border: 1px solid #9EA7B3 !important;
        background: #E7E9EC !important;
        color: #9EA7B3 !important;
        pointer-events: none;
    }
    .btn-outline-primary-veris {
      color: var(--bg-vris-blue) !important;
      border-color: var(--bg-vris-blue) !important;
      background: transparent;
    }
</style>