@extends('layouts.app')

@section('title', 'Sites')
@section('desc', "nodes are a vital point of you'r system")

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route("sites.create") }}" class="btn btn-success"><i class="fas fa-plus"></i> Create a site</a>
</div>

<div class="row">
    @forelse ($sites as $site)
        <div class="col-md-2 col-xl-3 mb-3" style="min-width: 16rem;">
            <div class="card text-center">
                <div class="d-flex pt-3 px-3 justify-content-between">
                    <span class="badge badge-pill badge-info">ID: {{ $site->id }}</span>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex w-min p-3 justify-content-center">
                        <i class="fa-sharp fa-solid fa-laptop fa-6x p-3"></i>
                    </div>
                    <h3>{{ $site->name }}</h3>
                    <h5>{{ $site->desc }}</h5>
                    <input type="text" class="form-control mb-3 text-center" value="{{ getSiteType()[$site->type]->name}}" disabled>
                    <div class="d-grid">
                        @if ($site->installed)
                            <a href="{{ route("sites.show", $site) }}" class="btn btn-primary "><i class="fas fa-cog"></i> Manage node</a>
                        @else
                            <a href="{{ route("sites.edit", $site) }}" class="btn btn-warning "><i class="far fa-edit"></i> Edit node</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
                Any site <a href="{{ route("sites.create") }}">create one right now !</a>
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