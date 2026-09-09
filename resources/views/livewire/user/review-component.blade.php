<div>
    @include('livewire.user.partials._alerts')
    @foreach ($user->reviews as $review)
        <div class="col-md-6">
            <div class="product-wrapper">
                <div class="product-img">
                    <img src="{{ Storage::url($review->product->image[0]->image) }}" alt="product-img">
                </div>
                <div class="product-info">
                    <div class="review-date">
                        <p>{{ $review->created_at->formatLocalized('%B %d, %Y,') }}</p>
                    </div>
                    <div class="ratings">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->rating)
                                <i class="fa-solid fa-star" style="color: #ffc400;"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="product-description">
                        <a href="product-sidebar.html" class="product-details">
                            {{ $review->product->name }}
                        </a>
                        <p>
                            <textarea class="form-control" placeholder="{{ __('You Reviewed:') }} {{ $review->review }}" wire:model="review"></textarea>
                            <select class="form-select mb-2 mt-2" wire:model="rating">
                                <option value="1">{{ __('1 Star') }}</option>
                                <option value="2">{{ __('2 Star') }}</option>
                                <option value="3">{{ __('3 Star') }}</option>
                                <option value="4">{{ __('4 Star') }}</option>
                                <option value="5">{{ __('5 Star') }}</option>
                            </select>
                            <button wire:click="updateReview({{ $review->id }})" class="btn btn-success">{{ __('Update Review') }}</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
