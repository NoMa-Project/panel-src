@extends('layouts.app')

@section('title', "Manage node")

@section('content')
<a href="{{ route("node.edit", $node) }}" class="btn btn-warning"><i class="far fa-edit"></i> Edit Node</a>

@endsection

@push('scripts')
    
@endpush

@push('footer-scripts')
    
@endpush

@push('styles')

@endpush