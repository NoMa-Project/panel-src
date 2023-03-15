@extends('layouts.guest')

@section('content')
<div class="card" style="width: 30rem;">
    <div class="card-body">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
        
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
        
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
        
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
        
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
            </div>
        </form>        
    </div>
 </div>
@endsection

@push('scripts')
    
@endpush

@push('footer-scripts')
    
@endpush

@push('styles')
    
@endpush