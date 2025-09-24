<div class="row align-items-stretch border-end h-100">
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'proximas-citas' ? 'active-item-menu' : '' }}">
		<a href="/proximas-citas/{{ $mac }}" class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-proximas-citas.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Ver mis <br>próximas citas</div>
		</a>
	</div>
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'cita-medica' ? 'active-item-menu' : '' }}">
		<a href="/cita-elegir-paciente/{{ $mac }}" class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-agendar-cita-medica.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Agendar <br>cita médica</div>
		</a>
	</div>
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'paquetes-preventivos' ? 'active-item-menu' : '' }}">
		<a href="/paquetes-preventivos/{{ $mac }}" class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-paquetes-preventivos.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Comprar paquetes <br>preventivos</div>
		</a>
	</div>
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'tratamientos' ? 'active-item-menu' : '' }}">
		<a href="/tratamientos/{{ $mac }}" class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-tratamientos.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Gestionar mi <br>tratamiento</div>
		</a>
	</div>
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'orden-externa' ? 'active-item-menu' : '' }}">
		<button class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-orden-externa.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Tengo una orden <br>externa</div>
		</button>
	</div>
	<div class="col-12 d-flex align-items-stretch px-0 {{ $page == 'chequeos' ? 'active-item-menu' : '' }}">
		<a href="/chequeos/{{ $mac }}" class="btn w-100 py-24 d-flex flex-column justify-content-center h-100">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-chequeos-ocupacionales.svg" alt="" class="mb-2" style="height:80px">
			<div class="fs-14 line-height-16 fw-medium">Gestionar chequeos <br>ocupacionales</div>
		</a>
	</div>
</div>