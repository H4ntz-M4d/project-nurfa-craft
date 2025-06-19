@foreach ($data as $blog)
<div class="p-b-63">
    <a href="blog-detail/{{ $blog->id_blog }}" class="hov-img0 how-pos5-parent">
        <img height="400px" src="{{ asset('storage/'. $blog->gambar) }}" alt="IMG-BLOG">
        <div class="flex-col-c-m size-123 bg9 how-pos5">
            <span class="ltext-107 cl2 txt-center">{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span>
            <span class="stext-109 cl3 txt-center">{{ \Carbon\Carbon::parse($blog->created_at)->format('M Y') }}</span>
        </div>
    </a>

    <div class="p-t-32">
        <h4 class="p-b-15">
            <a href="blog-detail/{{ $blog->id_blog }}" class="ltext-108 cl2 hov-cl1 trans-04">{!! $blog->judul !!}</a>
        </h4>
        <p class="stext-117 cl6">{!! Str::words(strip_tags($blog->deskripsi), 30, '...') !!}</p>
        <div class="flex-w flex-sb-m p-t-18">
            <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                <span><span class="cl4">By</span> Admin <span class="cl12 m-l-4 m-r-6">|</span></span>
                <span>StreetStyle, Fashion, Couple <span class="cl12 m-l-4 m-r-6">|</span></span>
                <span>8 Comments</span>
            </span>

            @auth
                <a href="blog-detail/{{ $blog->id_blog }}" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                    Continue Reading <i class="fa fa-long-arrow-right m-l-9"></i>
                </a>
            @endauth

            @guest
                <a href="#" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10 modal-login">
                    Continue Reading <i class="fa fa-long-arrow-right m-l-9"></i>
                </a>
            @endguest
        </div>
    </div>
</div>
@endforeach

{{-- Ini juga perlu dimuat ulang --}}
@foreach ($data as $blog)
<!-- ... struktur blog tetap seperti sebelumnya ... -->
@endforeach

{{-- Custom pagination --}}
<div class="flex-l-m flex-w w-full p-t-10 m-lr--7 custom-pagination justify-center">
    @for ($i = 1; $i <= $data->lastPage(); $i++)
        <a href="#" data-page="{{ $i }}"
           class="flex-c-m how-pagination1 trans-04 m-all-7 {{ $data->currentPage() == $i ? 'active-pagination1' : '' }}">
            {{ $i }}
        </a>
    @endfor
</div>

