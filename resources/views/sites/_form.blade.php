<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">Site Name</label>
            <input type="text"class="form-control" name="name" id="name" aria-describedby="name" placeholder="Name" value="{{ old("name", $site->name ?? "" ) }}">

            @error("name")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Desc</label>
            <textarea type="text" class="form-control" name="desc" id="desc">{{ old("desc", $site->desc ?? "" ) }}</textarea>

            @error("desc")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fqnd" class="form-label">FQND <i class="fa-solid fa-circle-question" data-toggle="tooltip" data-placement="top" title="Fully Qualified Domain Name"></i></label>
                    
                    <input type="text" class="form-control" name="fqnd" id="fqnd" placeholder="example.noma.fr" value="{{ old("fqnd", $site->fqnd ?? "" ) }}">
                    
                    @error("fqnd")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>

                    <select class="custom-select" name="type" id="type">
                        <option disabled selected>Select an option</option>

                        @foreach(getSiteType() as $type)
                            <option value="{{ $type->id }}" @selected(old("type", $site->type ?? "") == $type->id)>{{ $type->name . " | " . $type->version }}</option>                            
                        @endforeach
                    </select>

                    @error("type")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="custom-control custom-switch mb-3">
                        <input class="custom-control-input" type="checkbox" name="ssl" id="ssl" @checked(old("ssl", $site->ssl ?? false ))>
                        <label class="custom-control-label" for="ssl">Use SSL</label>
                    </div>
        
                    @error("ssl")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
               
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
       $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@endpush