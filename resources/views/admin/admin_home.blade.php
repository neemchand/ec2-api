@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>All Groups </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Group ID</th>
                                <th>Group Name</th>
                                <th>Arn</th>
                                <th>View</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @forelse($all_groups as $group ) 
                                <tr>
                                <td>{{$group['GroupId']}}</td>
                                <td>{{$group['GroupName']}}</td>
                                <td>{{$group['Arn']}}</td>
                                <td>  <a href="{{url('admin/group/'.$group['GroupName'])}}">{{$group['GroupName']}}</a></td>
                                </tr>
                            @empty
                              <tr>
                                <td>{{'No group exists!!'}}</td>
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{url('/admin/create-group')}}" type="button" class="btn btn-default" >Create new group</a>
                   <br><br>
                    <h2>All Users </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Path</th>
                                <th>User Name </th>
                                <th>Arn</th>
                                <th>Delete</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @forelse($all_users as $user) 
                            @php //$tags =!empty($user)?$user):'';  @endphp
                            <tr>
                                <td>{{$user['UserId']}}</td>
                                <td>{{$user['Path']}}</td>
                                <td>{{$user['UserName']}}</td>

                                <td>{{$user['Arn']}}</td>
                                <td>
                                    <a href="{{url('admin/delete-user/'.$user['UserName'])}}" >Delete</a></td>
                            </tr>
                            @empty
                              <tr>
                                <td>{{'No user exists!!'}}</td>
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{url('/admin/create-user')}}" type="button" class="btn btn-default" >Create new user</a>
                   <br><br>
                    <h2>All Roles </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Role ID</th>
                                <th>Path</th>
                                <th>Role Name </th>
                                <th>Arn</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @forelse($all_roles as $role) 
                            <tr>
                                <td>{{$role['RoleId']}}</td>
                                <td>{{$role['Path']}} </td>
                                <td>{{$role['RoleName']}}</td>
                                <td >{{$role['Arn']}}</td>
                            </tr>
                            @empty
                              <tr>
                                <td>{{'No user exists!!'}}</td>
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{url('/admin/create-role')}}" type="button" class="btn btn-default" >Create new role</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
