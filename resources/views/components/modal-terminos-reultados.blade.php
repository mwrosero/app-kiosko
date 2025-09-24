@php
    use Carbon\Carbon;
    $now = Carbon::now('America/Guayaquil');
@endphp
<div class="modal fade" id="modalAceptacionResultados" aria-labelledby="modalAceptacionResultadosLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal-fullscreen pt-5">        
        <div class="modal-content" style="max-height: 90vh;overflow-y: auto;width: 95%;margin: auto;padding: 30px;">
            <div class="w-100 position-relative">
                <h5 class="fs-20 line-height-24 mt-3 mb-3 text-center">Autorización para el Tratamiento de Datos Personales</h5
            >
                <button type="button" class="fw-medium btn-close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="box-terminos mt-3">
                <div class="version shadow mb-3 p-3">
                    VERIS S.A <br>
                    Apoyo Diagnóstico <br>
                    Código: FO-303.01.10 <br>
                    Versión: 1 Fecha: 27-Ene.-2025 <br>
                    Autorización
                </div>
                <p>Yo, <span class="fw-bold text-royal-blue" id="nombreAceptacion"></span>, mayor de edad, con C.C., No: <span class="fw-bold text-royal-blue" id="cedulaAceptacion"></span>, en mi calidad de titular de la información proporcionada a VERIS S.A. (en adelante “VERIS”), DOY MI CONSENTIMIENTO expreso, libre, voluntario, específico, informado e inequívoco para el tratamiento de mi información personal, incluyendo datos de contacto, domicilio, sensibles y datos de salud (“Información Personal”) con el propósito de ser recopilados y tratados por VERIS a través de cualquiera de sus marcas VERIS®, ParaMí®, y/o aliados estratégicos, dentro de las siguientes finalidades:</p>
                <div class="w-50 mx-auto my-3">
                    <table class="table table-bordered">
                        <tr>
                            <td class="nombreTipoContratoLabel" id="preChequeoAceptacion"></td>
                            <td>Inicio (Pre-ocupacional)</td>
                        </tr>
                        <tr>
                            <td class="nombreTipoContratoLabel" id="ocupacionalChequeoAceptacion"></td>
                            <td>Periódico (Ocupacional)</td>
                        </tr>
                        <tr>
                            <td class="nombreTipoContratoLabel" id="postChequeoAceptacion"></td>
                            <td>Retiro(Post-ocupacionales)</td>
                        </tr>
                    </table>
                </div>
                <p>i) Gestión documental, de custodia y archivo de las historias clínicas e información de salud.</p>
                <p>ii) Gestión de procesos de calidad y evaluación de los servicios provistos por VERIS.</p>
                <p>iii) Seguimiento para consultas, citas y comunicación en general derivada del servicio proporcionado.</p>
                <p>iv) Compartir información personal a las empresas que conforman su grupo económico y a proveedores con quienes VERIS mantiene una relación comercial y/o contractual, para la prestación de servicios médicos y la prestación de otros servicios acordados.</p>
                <p>v) Cumplimiento de las obligaciones legales y contractuales de VERIS.</p>
                <p class="mt-3">Este tratamiento se realiza a solicitud de la empresa <span class="fw-bold text-royal-blue" id="empresaAceptacion"></span> “empresa solicitante”.</p>
                <p>Reconozco y comprendo que VERIS utilizará mi Información Personal exclusivamente con el propósito de llevar a cabo las finalidades mencionadas anteriormente. En este sentido, VERIS se compromete a gestionar mi Información Personal dentro de los plazos establecidos por la ley, tanto para su conservación como para cualquier otro requerimiento legal pertinente.</p>
                <p>Declaro expresamente que toda la información proporcionada y que proporcionaré es correcta, completa, veraz y actualizada. Asumo la responsabilidad de informar a VERIS de cualquier cambio o actualización que afecte a mi Información Personal.</p>
                <p>Autorizo que los resultados, incluyendo los exámenes de imagen, sean entregados de manera directa al profesional médico y/o responsable que realizará el examen ocupacional, así como al Responsable que trate mis datos personales de acuerdo con la Política de Tratamiento y Protección de Datos Personales de VERIS. Así también autorizo entregar la información necesaria a la “empresa solicitante” por el cumplimiento del servicio médico ocupacional.</p>
                <p>Autorizo a VERIS para registrar, consultar, compartir, procesar, reportar, transferir y tratar mi información confidencial, incluyendo datos sensibles, con su matriz, filiales, subsidiarias; y, empresas aliadas conforme a los artículos 33 y 36 de la Ley Orgánica de Protección de Datos Personales. En dicha transferencia siempre se mantendrá y precautelará la confidencialidad de mis datos personales.</p>
                <p>Este consentimiento se otorga en pleno ejercicio de mis derechos y bajo la comprensión de las implicaciones que conlleva el tratamiento de mi Información Personal por parte VERIS, en cumplimiento con las leyes y regulaciones de protección de datos aplicables. Además, reconozco que VERIS me ha informado sobre mi derecho a ejercer mis derechos de protección de datos, tal como lo estipula la Ley Orgánica de Protección de Datos (LOPD) y su Reglamento (RLOPD), así como lo establecido en la Política de Protección de Datos de [https://www.veris.com.ec/politica-de-privacidad/]. Para ello, puedo utilizar el siguiente canal: [datos.personales@veris.com.ec]</p>
                <p>En caso de ser necesario estoy dispuesto a reconocer firma y rúbrica de esta autorización de Protección de datos personales y autorización de entrega de información.</p>
                <p>Fecha: <span class="fw-bold text-royal-blue" id="fechaAceptacion">{{ $now->format('d/m/Y') }}</span></p>
            </div>
            <div class="w-100 text-center">
                <button type="button" class="btn py-24 bg-royal-blue text-white rounded-12 fs-24 line-height-32 w-50" data-bs-dismiss="modal">Entiendo</button>
            </div>
        </div>
    </div>
</div>
<style>
    {{-- .modal-dialog.modal-fullscreen{
        max-width: 100% !important;
    }
    .btn-cerrar-modal {
        position: absolute;
        right: 10px;
        top: 0px;
    }
    .modal-backdrop.show:nth-of-type(2) {
        z-index: 1060;
    }
    .modal.show:nth-of-type(2) {
        z-index: 1065;
    } --}}

</style>