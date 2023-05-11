@extends('layouts.app')

@section('title', "Create node")

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route("node.store") }}" method="POST">
            @csrf
            
            @include('node._form')

            <button type="submit" class="btn btn-success"><i class="fas fa-download"></i> Créer et installer la node</button>
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