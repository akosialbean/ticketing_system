<table class="table table-sm table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>Level</th>
            <th>Department</th>
            <th>User</th>
            <th>Local</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($locals as $local)
        <tr>
            <td>{{$local->l_level}}</td>
            <td>{{$local->d_code}}</td>
            <td>{{$local->fullname}}</td>
            <td>{{$local->l_number}}</td>
        </tr>
        @endforeach
    </tbody>
</table>