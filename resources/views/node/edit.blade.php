@extends('layouts.app')

@section('title', "Edit node")

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route("node.update", $node) }}" method="POST" class="mb-3">
            @csrf
            
            @method("patch")

            @include('node._form')

            @if ($node->error)         
                <h6>Last error</h6>

                <div class="card mb-3">
                    <div class="card-body" style="background-color: #f7f7f9;">
                        {{ $node->error }}
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Mettre à jour la node</button>
        </form>

        <form method="POST" action="{{ route('node.destroy', $node) }}">
            @csrf
            @method("DELETE")
            <button type="submit" href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Supprimer la node</button>
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