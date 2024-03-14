
<div class="card mb-3">
    <div class="card-header">Resolution</div>
    <div class="card-body">
        <div class="mb-3">
            <form action="/resolve" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                <label for="t_resolution" class="form-label">Resolution</label>
                <textarea name="t_resolution" id="t_resolution" class="form-control" required></textarea>
                <div class="mt-3">
                    <button type="submit" class="btn btn-sm btn-success" onclick="disablebtn()">Resolve</button>
                </div>
            </form>
        </div>
    </div>
</div>