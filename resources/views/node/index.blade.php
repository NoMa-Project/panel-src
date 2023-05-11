@extends('layouts.app')

@section('title', 'Nodes')
@section('desc', "nodes are a vital point of you'r system")

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route("node.create") }}" class="btn btn-success"><i class="fas fa-plus"></i> Create a node</a>
</div>

<div class="row">
    @forelse ($nodes as $node)
        <div class="col-md-2 col-xl-3 mb-3" style="min-width: 16rem;">
            <div class="card text-center">
                <div class="d-flex pt-3 px-3 justify-content-between">
                    <span class="badge badge-pill badge-info">ID: {{ $node->id }}</span>
                    @if ($node->installed)
                        <span class="badge badge-pill badge-success" data-toggle="tooltip" data-placement="top" title="Alive 👍"><i class="fas fa-heartbeat"></i></span>
                    @else
                        <span class="badge badge-pill badge-danger" data-toggle="tooltip" data-placement="top" title="Reinstall pls ... "><i class="fa-solid fa-heart-crack"></i></span>
                    @endif
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex w-min p-3 justify-content-center">
                        <i class="fas fa-server fa-6x p-3"></i>
                    </div>
                    <h3>{{ $node->name }}</h3>
                    <input type="text" class="form-control mb-3 text-center" value="{{ $node->ip }}" disabled>
                    <div class="d-grid">
                        @if ($node->installed)
                            <a href="{{ route("node.show", $node) }}" class="btn btn-primary "><i class="fas fa-cog"></i> Manage node</a>
                        @else
                            <a href="{{ route("node.edit", $node) }}" class="btn btn-warning "><i class="far fa-edit"></i> Edit node</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
                Any node <a href="{{ route("node.create") }}">create one right now !</a>
            </div>
        </div>
    </div>
    @endforelse    
</div>

@endsection

@push('scripts')
    
@endpush

@push('footer-scripts')
    
@endpush

@push('styles')

@endpush