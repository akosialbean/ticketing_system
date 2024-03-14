<form action="/locals/search" method="post">
    @csrf
    @method('POST')
    <div class="input-group">
        <input type="text" class="form-control form-control-sm" placeholder="search local" name="searchitem">
        <button type="submit" class="btn btn-sm btn-primary" type="button" onclick="disablebtn()">Search</button>
    </div>
</form>