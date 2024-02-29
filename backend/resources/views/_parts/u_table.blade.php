<table class="table table-sm table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Username</th>
            <th>Department</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->u_lname}}</td>
            <td>{{$user->u_fname}}</td>
            <td>{{$user->u_mname}}</td>
            <td>{{$user->u_username}}</td>
            <td>{{$user->d_description}}</td>
            <td>
                @if($user->u_role == 1)
                    Admin                            
                @else
                    User
                @endif
            </td>
            <td>
                @if($user->u_status == 1)
                    Active
                @else
                    Disabled
                @endif
            </td>
            <td>
                <a href="/user/{{$user->id}}" class="btn btn-sm btn-primary"><i class="bi bi-three-dots-vertical"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{$users->links()}}
</div>