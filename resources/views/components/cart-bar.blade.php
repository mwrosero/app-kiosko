<div class="bg-white py-4 px-3 d-flex justify-content-between align-items-center border-bottom">
	<h2 class="m-0 text-royal-blue fs-40 line-height-48 fw-bold page-title">{{ $title }}</h2>
	<button class="btn bg-light-sky-blue-tint-90 btn-sm position-relative d-flex justify-content-between align-items-center rounded-16 p-3 view-cart" style="width: 132px;">
		<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-cart.svg" alt="" height="48">
		<span class="ms-3 fs-24 line-height-32">0</span>
	</button>
</div>