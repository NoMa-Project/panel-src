@extends('layouts.app')

@section('title', "Profile")

@section('content')
<div class="card mb-3">
    <div class="card-body">
        @include('profile.partials.update-profile-information-form')
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
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