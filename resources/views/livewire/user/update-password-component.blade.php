<div>
    @include('livewire.user.partials._alerts')
    <form wire:submit.prevent="updatePassword">
        <div class="currentpass form-item">
            <label for="current_password" class="form-label ">{{ __('Current Password*') }}</label>
            <input type="password"
                class="form-control @error('current_password') is-invalid @enderror"
                id="current_password" placeholder="******" wire:model="current_password">
            @error('current_password')
                <span class="invalid-feedback"> {{ $message }}</span>
            @enderror
        </div>
        <div class="password form-item">
            <label for="new_password" class="form-label">{{ __('Password*') }}</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                placeholder="******" wire:model="new_password">
                @error('new_password')
                <span class="invalid-feedback"> {{ $message }}</span>
            @enderror
        </div>
        <div class="re-password form-item">
            <label for="confirm_password" class="form-label">{{ __('Re-enter Password*') }}</label>
            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password"
                placeholder="******" wire:model="confirm_password">
                @error('confirm_password')
                <span class="invalid-feedback"> {{ $message }}</span>
            @enderror
        </div>
        <div class="form-btn">
            <button class="shop-btn" type="submit">{{ __('Upldate Password') }}</button>
        </div>
    </form>
</div>
