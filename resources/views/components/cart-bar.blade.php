<div class="bg-white py-4 px-32 d-flex justify-content-between align-items-center border-bottom">
	<h2 class="m-0 text-royal-blue fs-40 line-height-48 fw-bold page-title">{{ $title }}</h2>
	@if(!isset($showQtyBtn))
	<button class="btn bg-light-sky-blue-tint-90 btn-sm position-relative d-flex justify-content-between align-items-center rounded-16 p-3 view-cart" style="min-width: 115px;">
		<img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/images/icon-cart.svg" alt="" height="48">
		<span class="ms-2 fs-24 line-height-32 qtyCart fw-medium"></span>
	</button>
	@endif
</div>