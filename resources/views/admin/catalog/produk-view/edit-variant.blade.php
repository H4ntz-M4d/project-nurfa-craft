<x-admin.layout>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex flex-column align-items-start position-relative my-1">
                            <div class="table-responsive mb-5">
                                <table class="table align-middle table-rounded border border-gray-400 gy-7 gs-7">
                                    <thead >
                                        <tr>
                                            <th class="text-gray-600 fw-bold fs-6">Kategori: </th>
                                            <th class="text-gray-600 fw-bold fs-6">{{ $produk->kategori_produk->nama_kategori }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 fw-bold fs-6">Produk: </th>
                                            <th class="text-gray-600 fw-bold fs-6">{{ $produk->nama_produk }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div>
                                <h3 class="text-gray-800 fw-bold fs-5">Kelola Variasi Produk</h3>
                            </div>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <form action="{{ route('produk.variant.store', $produk->slug) }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table id="kt_produk_variant" class="table align-middle table-rounded table-bordered border-gray-400 fs-6 gy-5">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        @foreach ($attribute_names as $attr)
                                            <th>{{ ucfirst($attr) }}</th>
                                        @endforeach
                                        <th>Harga</th>
                                        <th>Kode Variasi</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @php $printed = $printFlags; @endphp

                                    @foreach ($combinations as $comboIndex => $combo)
                                        @php
                                            $comboValueIds = collect($combo)->pluck('id')->sort()->values()->toArray();
                                            $comboKey = implode('-', $comboValueIds);

                                            $hargaValue = $variantMap[$comboKey]['harga'] ?? '';
                                            $stokValue = $variantMap[$comboKey]['stok'] ?? '';
                                            $skuValue = $variantMap[$comboKey]['sku'] ?? '';
                                        @endphp
                                        <tr>
                                            @foreach ($attribute_names as $attrIndex => $attr)
                                                @php
                                                    $valueId = $combo[$attr]['id'];
                                                    $valueName = $combo[$attr]['nama'];
                                                @endphp

                                                @if ($attrIndex === 0)
                                                    @if (!isset($printed[$attr][$valueId]))
                                                        <td rowspan="{{ $rowspanData[$attr][$valueId] }}">{{ $valueName }}</td>
                                                        @php
                                                            $printed[$attr][$valueId] = true;
                                                        @endphp
                                                    @endif
                                                @else
                                                    <td>{{ $valueName }}</td>
                                                @endif

                                                <input type="hidden" name="variant_value_ids[{{ $comboIndex }}][]" value="{{ $valueId }}">
                                            @endforeach

                                            <td>
                                                <input type="number" name="harga[{{ $comboIndex }}]" class="form-control w-100px w-md-100" 
                                                min="0" onkeydown="return isNumberKey(event)" placeholder="Rp" value="{{ $hargaValue }}" />

                                                <input type="number" name="stok[{{ $comboIndex }}]" class="form-control w-100px w-md-100" 
                                                min="0" onkeydown="return isNumberKey(event)" placeholder="Rp" value="{{ $stokValue }}" hidden />
                                            </td>
                                            <td><input type="text" name="sku[{{ $comboIndex }}]" class="form-control w-100px w-md-100" value="{{ $skuValue }}" placeholder="Kode Variasi" /></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Variasi</button>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
    </div>
    
    @push('scripts')
        <script>
        function isNumberKey(evt) {
            const invalidKeys = ["e", "E", "+", "-", ".", ","];
            if (invalidKeys.includes(evt.key)) {
                evt.preventDefault();
                return false;
            }
        }
        </script>
        
    @endpush
</x-layout>
