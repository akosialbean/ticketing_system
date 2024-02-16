<form action="/{{Auth::user()->u_department}}/tickets/search/ticketid/desc" method="post">
    @csrf
    @method('POST')
    <div class="input-group">
        <input type="text" class="form-control form-control-sm" placeholder="search ticket" name="searchitem" autofocus>
        <button type="submit" class="btn btn-sm btn-primary" type="button"><i class="bi bi-search"></i></button>
    </div>
</form>