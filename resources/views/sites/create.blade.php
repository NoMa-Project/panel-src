@extends('layouts.app')

@section('title', "Create site")

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route("sites.store") }}" method="POST">
            @csrf
            
            @include('sites._form')

            <button type="submit" class="btn btn-success"><i class="fas fa-download"></i> Créer et installer le site</button>
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