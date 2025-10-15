<header class="d-flex justify-content-center align-items-center p-3" style="height: 134px;">
	@if(!isset($showExitBtn))
	<div class="position-absolute d-flex gap-3 align-items-center" style="top: 25px;left: 15px;">
		<a href="/{{ $mac }}">
			<i class="fa-solid fa-arrow-right-from-bracket fs-40 text-silver-dark"></i>
		</a>
	</div>
	@endif
	<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/logo-veris-2025.svg" alt="Veris Logo" height="70" class="my-3">
	@if(!isset($showSettingBtn))
	<div class="position-absolute d-flex gap-3 align-items-center" style="top: 15px;right: 15px;">
		<div class="dropdown">
			{{-- dropdown-toggle --}}
			<button class="btn btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-configuracion.svg" alt="">
			</button>
			<ul class="dropdown-menu rounded-8 p-0" aria-labelledby="dropdownMenuButton1">
				<li class="fs-16 line-height-20"><a class="dropdown-item px-3 py-2" href="/lider/{{ $mac }}">Lider de Caja</a></li>
				<li class="d-none fs-16 line-height-20 ingresar-host"><a class="dropdown-item px-3 py-2" href="/host/{{ $mac }}">Ingresar Host</a></li>
				<li class="fs-16 line-height-20 central-caja d-none"><div class="dropdown-item px-3 py-2 text-capitalize disabled" type="button"></div></li>
				<li class="d-none fs-16 line-height-20 cerrar-sesion label-username"><div class="dropdown-item px-3 py-2 disabled" type="button"></div></li>
				<li class="d-none fs-16 line-height-20 cerrar-sesion btn-logout"><div class="dropdown-item px-3 py-2 text-red-dark" type="button">Cerrar sesión</div></li>
			</ul>
		</div>

		{{-- <button class="btn btn-sm">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-configuracion.svg" alt="">
		</button> --}}
	</div>
	@endif
</header>