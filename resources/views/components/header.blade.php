<header class="d-flex justify-content-center align-items-center p-3" style="height: 134px;">
	<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/logo-veris-2025.svg" alt="Veris Logo" height="70" class="my-3">
	<div class="position-absolute d-flex gap-3 align-items-center" style="top: 15px;right: 15px;">
		<button class="btn btn-sm">
			<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-configuracion.svg" alt="">
		</button>
	</div>
</header>