<x-customers.layout>
    	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
				Men
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Lightweight Jacket
			</span>
		</div>
	</div>
		

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3">
							<div class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="{{ asset('storage/'. $pro_detail->gambar) }}">
									<div class="wrap-pic-s pos-relative">
										<img src="{{ asset('storage/'. $pro_detail->gambar) }}" style="object-fit: cover; height: 500px;" alt="IMG-PRODUCT">
	
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset('storage/'. $pro_detail->gambar) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
	
								@foreach ($produk_img as $item) 
									<div class="item-slick3" data-thumb="{{ asset('storage/'. $item->gambar) }}">
										<div class="wrap-pic-s pos-relative">
											<img src="{{ asset('storage/'. $item->gambar) }}" style="object-fit: cover; height: 500px;" alt="IMG-PRODUCT">
	
											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset('storage/'. $item->gambar) }}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								@endforeach
	
							</div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
							<div class="wrap-slick3-dots"></div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							{{ $pro_detail->nama_produk }}
						</h4>

						<span id="variant-harga" class="ltext-102 cl2">
							{{ $pro_detail->formatted_harga }}
						</span>

						<h4 class="mtext-102 cl3 p-t-23">
							Stok : <span id="variant-stok">{!! $pro_detail->stok ?? '-' !!}</span>
						</h4>

						@if ($pro_detail->is_out_of_stock)
							<div class="alert alert-warning d-flex align-items-center p-5">
								<i class="ki-duotone ki-warning fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-warning">Stok Habis!</h4>
									<span>Produk ini sedang tidak tersedia saat ini. Silakan cek kembali nanti.</span>
								</div>
							</div>
						@endif
						<div id="stok-warning" class="alert alert-warning d-none mt-3"></div>


						
						<!--  -->
						<form id="form-cart">
   							@csrf
							<div class="p-t-33">
								<input type="hidden" name="id_master_produk" value="{{ $pro_detail->id_master_produk }}">

								@foreach ($variantAttributes as $attributeName => $attributeData)
									<div class="flex-w flex-r-m p-b-10">
										<div class="size-203 flex-c-m respon6">
											{{ ucfirst($attributeName) }}
										</div>
										<div class="size-204 respon6-next">
											<div class="rs1-select2 bor8 bg0">
												<select class="js-select2" name="variant_values[]">
													<option value="">Choose an option</option>
													@foreach ($attributeData['values'] as $id => $value)
														<option value="{{ $id }}">{{ $value }}</option>
													@endforeach
												</select>
												<div class="dropDownSelect2"></div>
											</div>
										</div>
									</div>
								@endforeach
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-product-deacrese cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>
											<input class="mtext-104 cl3 txt-center num-product" type="number" name="jumlah" value="1">
											<div class="btn-product-increase cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
										<button id="btn-tambah-keranjang" type="button" data-url="{{ route('produk-shop.cart-add') }}"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											+Keranjang
										</button>
									</div>
								</div>
							</div>
						</form>

						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
						</li>

						{{-- <li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
						</li> --}}
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- - -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
									{!! $pro_detail->deskripsi !!}
								</p>
							</div>
						</div>

						<!-- - -->
						{{-- <div class="tab-pane fade" id="information" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<ul class="p-lr-28 p-lr-15-sm">
										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Weight
											</span>

											<span class="stext-102 cl6 size-206">
												0.79 kg
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Dimensions
											</span>

											<span class="stext-102 cl6 size-206">
												110 x 33 x 100 cm
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Materials
											</span>

											<span class="stext-102 cl6 size-206">
												60% cotton
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Color
											</span>

											<span class="stext-102 cl6 size-206">
												Black, Blue, Grey, Green, Red, White
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Size
											</span>

											<span class="stext-102 cl6 size-206">
												XL, L, M, S
											</span>
										</li>
									</ul>
								</div>
							</div>
						</div> --}}

						<!-- - -->
						{{-- <div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm">
										<!-- Review -->
										<div class="flex-w flex-t p-b-68">
											<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
												<img src="images/avatar-01.jpg" alt="AVATAR">
											</div>

											<div class="size-207">
												<div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														Ariana Grande
													</span>

													<span class="fs-18 cl11">
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star-half"></i>
													</span>
												</div>

												<p class="stext-102 cl6">
													Quod autem in homine praestantissimum atque optimum est, id deseruit. Apud ceteros autem philosophos
												</p>
											</div>
										</div>
										
										<!-- Add review -->
										<form class="w-full">
											<h5 class="mtext-108 cl2 p-b-7">
												Add a review
											</h5>

											<p class="stext-102 cl6">
												Your email address will not be published. Required fields are marked *
											</p>

											<div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Your Rating
												</span>

												<span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating">
												</span>
											</div>

											<div class="row p-b-25">
												<div class="col-12 p-b-5">
													<label class="stext-102 cl3" for="review">Your review</label>
													<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="name">Name</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="email">Email</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
												</div>
											</div>

											<button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
												Submit
											</button>
										</form>
									</div>
								</div>
							</div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				SKU: {{ $pro_detail->sku }}
			</span>

			<span class="stext-107 cl6 p-lr-25">
				Categories: {{ $pro_detail->kategori_produk->nama_kategori }}
			</span>
		</div>
	</section>

	@push('scripts')
		<script>
			$(document).ready(function () {
				function getSelectedVariants() {
					let values = [];
					$('select[name="variant_values[]"]').each(function () {
						let val = $(this).val();
						if (val) {
							values.push(parseInt(val));
						}
					});
					return values;
				}

				$('select[name="variant_values[]"]').on('change', function () {
					const variantValues = getSelectedVariants();

					// Hanya jalankan kalau semua varian dipilih
					if (variantValues.length === $('select[name="variant_values[]"]').length) {
						$.ajax({
							url: '{{ route("produk-shop.check-variant") }}',
							method: 'POST',
							data: {
								_token: '{{ csrf_token() }}',
								variant_values: variantValues,
								id_master_produk: '{{ $pro_detail->id_master_produk }}'
							},
							success: function (res) {
								$('#variant-harga').text('Rp' + new Intl.NumberFormat('id-ID').format(res.harga));
								$('#variant-stok').text(res.stok);

								if (res.out_of_stock) {
									$('#stok-warning').removeClass('d-none').text('Stok untuk kombinasi varian ini kosong!');
								} else {
									$('#stok-warning').addClass('d-none').text('');
								}
							},

							error: function () {
								$('#variant-harga').text('Rp0');
								$('#variant-stok').text('-');
							}
						});
					} else {
						$('#variant-harga').html();
						$('#variant-stok').html()

					}
				});
			});
		</script>

	@endpush
</x-customers.layout>