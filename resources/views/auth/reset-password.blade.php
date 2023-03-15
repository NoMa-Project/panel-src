@extends('layouts.guest')

@section('content')
<div class="card" style="width: 30rem;">
    <div class="card-body">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
        
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        
            <!-- Password -->
            <div class="form-group mt-4">
                <label for="password">Password</label>
                <input id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" required autocomplete="new-password" />
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        
            <!-- Confirm Password -->
            <div class="form-group mt-4">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
        
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
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