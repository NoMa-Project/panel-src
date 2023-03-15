<section>
    <header>
        <h2 class="h5">{{ __('Update Password') }}</h2>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>
    
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
    
        <div class="mb-3">
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger" />
        </div>
    
        <div class="mb-3">
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger" />
        </div>
    
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger" />
        </div>
    
        <button type="submit" class="btn btn-primary mb-3">{{ __('Save') }}</button>
    </form>
</section>    