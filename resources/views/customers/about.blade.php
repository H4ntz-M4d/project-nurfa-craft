<x-customers.layout>
    <!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('customers-asset/images/bg-01.jpg') }}');">
		<h2 class="ltext-105 cl0 txt-center">
			About
		</h2>
	</section>


	<!-- Content page -->
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			@foreach ($about as $abouts)
				<div class="row p-b-148">
					@if ($loop->iteration % 2 == 1)
						<div class="col-md-7 col-lg-8">
							<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
								<h3 class="mtext-111 cl2 p-b-16">
									{{ $abouts->judul }}
								</h3>

								<p class="stext-113 cl6 p-b-26">
									{{ $abouts->deskripsi }}
								</p>
							</div>
						</div>

						<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
							<div class="how-bor1 ">
								<div class="hov-img0">
									<img src="{{ asset('storage/'. $abouts->gambar) }}" alt="IMG">
								</div>
							</div>
						</div>
					@else
						<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
							<div class="how-bor1 ">
								<div class="hov-img0">
									<img src="{{ asset('storage/'. $abouts->gambar) }}" alt="IMG">
								</div>
							</div>
						</div>
						<div class="col-md-7 col-lg-8">
							<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
								<h3 class="mtext-111 cl2 p-b-16">
									{{ $abouts->judul }}
								</h3>

								<p class="stext-113 cl6 p-b-26">
									{{ $abouts->deskripsi }}
								</p>
							</div>
						</div>
					@endif
				</div>
			@endforeach
		</div>
	</section>
</x-customers.layout>