@php
    $promotion_banners = \App\Models\AdminPromotionalBanner::where('status', 1)->get();
    @endphp

    @if ($promotion_banners && count($promotion_banners) > 0)
    <section class="main-category overflow-hidden pt-30 pb-50">
        <div class="container">
            <div class="main-category-slider wl-theme owl-carousel">
                @if (count($promotion_banners) > 0)
                <div class="category-slide-item big-slide"
                    style="background: url('{{ asset('storage/' . $promotion_banners[0]->image) }}') no-repeat center center;">
                    <div>
                        <h2 class="title">{{ $promotion_banners[0]->title ?? '' }}</h2>
                        <div class="text">{{ $promotion_banners[0]->sub_title ?? '' }}</div>
                    </div>
                </div>
                @endif

                @for ($i = 1; $i < count($promotion_banners); $i++)
                    <div class="category-slide-item small-slide"
                    style="background: url('{{ asset('storage/' . $promotion_banners[$i]->image) }}') no-repeat center center;">
                    <div>
                        <h2 class="title">{{ $promotion_banners[$i]->title ?? '' }}</h2>
                        <div class="text">{{ $promotion_banners[$i]->sub_title ?? '' }}</div>
                    </div>
            </div>
            @endfor
        </div>
        </div>
    </section>
    @endif