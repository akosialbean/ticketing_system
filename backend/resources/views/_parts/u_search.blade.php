<form action="/users/search" method="post">
    @csrf
    @method('POST')
    <div class="input-group">
        <input type="text" class="form-control form-control-sm" placeholder="search user" name="searchitem">
        <button type="submit" class="btn btn-sm btn-primary" type="button" onclick="disablebtn()"><i class="bi bi-search"></i></button>
    </div>
</form>