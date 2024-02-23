<table class="table table-sm table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>Level</th>
            <th>Department</th>
            <th>User</th>
            <th>Local</th>
            @if(Auth::user()->u_department == 1)
                <th></th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($locals as $local)
        <tr>
            <td>{{$local->l_level}}</td>
            <td>{{$local->d_code}}</td>
            <td>{{$local->u_fname}} {{$local->u_lname}}</td>
            <td>{{$local->l_number}}</td>
            @if(Auth::user()->u_department == 1)
            <td>
                <button class="btn btn-sm btn-primary"></button>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center py-0 mt-3">
    {{$locals->links()}}
</div>