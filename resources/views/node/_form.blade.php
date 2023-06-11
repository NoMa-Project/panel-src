<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Node Name</label>
            <input type="text"class="form-control" name="name" id="name" aria-describedby="name" placeholder="Name" value="{{ old("name", $node->name ?? "" ) }}">

            @error("name")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ip" class="form-label">IP (IP v4)</label>
                    <input type="text" class="form-control" name="ip" id="ip" placeholder="0.0.0.0.0" value="{{ old("ip", $node->ip ?? "" ) }}">

                    @error("ip")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>