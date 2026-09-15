<section class="product brand" data-aos="fade-up">
    <div class="container">
        <div class="section-title">
            <h5>{{ __('Brand of Products') }}</h5>
        </div>
        <div class="brand-section">
            @foreach ($brands as $brand)
                <div class="product-wrapper">
                    <div class="wrapper-img">
                        <a href="{{ route('user.products') }}">
                            <img src="{{ Storage::url($brand->logo) }}" alt="img">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
