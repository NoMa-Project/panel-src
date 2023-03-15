@extends('layouts.guest')

@section('content')
<div class="card" style="width: 30rem;">
    <div class="card-body">
        <h1>Verify you'r email</h1>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
        
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>
        
            <form method="POST" action="{{ route('logout') }}">
                @csrf
        
                <button type="submit" class="btn btn-link">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>        
    </div>
 </div>
@endsection

@push('scripts')
    
@endpush

@push('footer-scripts')
    
@endpush

@push('styles')
    
@endpush