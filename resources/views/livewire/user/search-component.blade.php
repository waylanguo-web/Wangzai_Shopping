<div>
    <div class="modal-main">
        <div class="wrapper-close-btn" onclick="modalAction('.search')">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </span>
        </div>
        <div class="wrapper-main">
            <div class="search-section">
                <input type="text" wire:model.live="search" placeholder="{{ __('Search Products....') }}">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center ">
        <ul>
            @foreach ($searchResults as $searchResult)
                <li>
                    <a href="javascript:;"
                        wire:click="productDetails({{ $searchResult->id }},'{{ $searchResult->slug }}','{{ $searchResult->category_id }}')"
                        class="product-details">
                        <div class="d-flex align-items-center">
                            @if ($searchResult->image && $searchResult->image->isNotEmpty())
                                <img src="{{ Storage::url($searchResult->image->first()->image) }}" alt="{{ $searchResult->name }}" width="40px"
                                    height="40px" class="rounded">
                            @else
                                <span class="rounded" style="width:40px;height:40px;display:inline-flex;align-items:center;justify-content:center;background:#f0f0f0;"><i class="fa-regular fa-image"></i></span>
                            @endif
                            <p class="m-4">{{ $searchResult->name }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
