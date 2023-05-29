@extends('layouts.app')

@section('title', "Edit site")

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route("sites.update", $site) }}" method="POST" class="mb-3">
            @csrf
            
            @method("patch")

            @include('sites._form')

            @if ($site->error)         
                <h6>Last error</h6>

                <div class="card mb-3">
                    <div class="card-body" style="background-color: #f7f7f9;">
                        {{ $site->error }}
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Mettre à jour la site</button>
        </form>

        <form method="POST" action="{{ route('sites.destroy', $site) }}">
            @csrf
            @method("DELETE")
            <button type="submit" href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Supprimer la site</button>
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