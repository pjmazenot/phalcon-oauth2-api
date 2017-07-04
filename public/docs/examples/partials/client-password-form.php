<h2>Generate</h2>

<form class="oauth2-generate-token-form form-inline">

    <input type="hidden" name="grant_type" value="password" />
    <input type="hidden" name="scope" value="full_access" />

    <div class="form-group">
        <label class="sr-only" for="client_id">Client ID</label>
        <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Client ID"/>
    </div>
    <div class="form-group">
        <label class="sr-only" for="client_secret">Client Secret</label>
        <input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Client Secret"/>
    </div>

    <br/>
    <br/>

    <div class="form-group">
        <label class="sr-only" for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username"/>
    </div>
    <div class="form-group">
        <label class="sr-only" for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
    </div>

    <br/>
    <br/>

    <div class="form-group">
        <label class="sr-only" for="type">Type</label>
        <select name="type" class="form-control" id="type">
            <option value="plain">Plain</option>
            <option value="bearer">Bearer</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Generate
    </button>
</form>

Generated token: <strong id="generated-token">Fill out the form and click on the Generate button</strong>