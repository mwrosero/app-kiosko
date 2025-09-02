<div class="bg-royal-blue-tint-90 py-2 px-3 d-flex justify-content-between align-items-center py-3">
	@php
		$visibilityClass = "visible";
	@endphp
	@if(isset($showVolverBtn))
	@php
		$visibilityClass = "invisible";
	@endphp
	@endif
	<a href="{{ $url }}" class="text-decoration-none back d-flex align-items-center justify-content-start {{ $visibilityClass }}">
		<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-back.svg" alt="">
		<span class="ms-3 fs-24 line-height-32 fw-bold">Volver</span>
	</a>
	@if(isset($showTurnoBtn) && $showTurnoBtn)
	<button class="btn bg-white rounded-8 text-royal-blue border-royal-blue p-3">Generar turno</button>
	@endif
</div>