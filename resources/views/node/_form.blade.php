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
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="port" class="form-label">SSH Port</label>
                    <input type="number" min="0" class="form-control" name="port" id="port" placeholder="22" value="{{ old("port", $node->port ?? "" ) }}">

                    @error("port")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="user" class="form-label">SSH User</label>
            <input type="text" class="form-control" name="user" id="user" placeholder="root" value="{{ old("user", $node->user ?? "" ) }}">
            
            @error("user")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">SSH Passwword</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="" value="{{ old("password", $node->pswd ?? "" ) }}">

            @error("password")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>