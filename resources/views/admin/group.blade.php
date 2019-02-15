@extends('layouts.layout')

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
                    <h2>Group Information </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Group ID</th>
                                <th>Group Name</th>
                                <th>Arn</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @if(isset($group['Group']['GroupId'])) 
                            <tr>
                                <td>{{$group['Group']['GroupId']}}</td>
                                <td>{{$group['Group']['GroupName']}}</td>
                                <td>{{$group['Group']['Arn']}}</td>
                            </tr>
                            @else
                            <tr>
                                <td>{{'No group exists!!'}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <h2>All Attached Policies </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Policy Name </th>
                                <th>Policy Arn</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @php //print_r($group_policies); die(); @endphp
                            @forelse($group_policies as $policy) 

                            <tr>
                                <td>{{$policy['PolicyName']}}</td>

                                <td>{{$policy['PolicyArn']}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>{{'No Policy exists!!'}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <h2>All Inline Policies </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Policy Name </th>
                                <th>View Policy</th>
                                
                            </tr>
                        </thead>
                        <tbody> 
                            @forelse($group_inline_policies as $policy) 

                            <tr>
                                <td >{{$policy}}</td>
                                <td class="inline-policy btn btn-default " group_name="{{$group['Group']['GroupName']}}" policy_name="{{$policy}}"><button class="btn ">View Policy</button></td>
                               
                            </tr>
                            @empty
                            <tr>
                                <td>{{'No Policy exists!!'}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#attach_policy">Attach new policy</button>
                   
                    <h2>All Users </h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Path</th>
                                <th>User Name </th>
                                <th>Arn</th>

                            </tr>
                        </thead>
                        <tbody> 
                            @forelse($group['Users'] as $user) 
                            <tr>
                                <td>{{$user['UserId']}}</td>
                                <td>{{$user['Path']}}</td>
                                <td>{{$user['UserName']}}</td>

                                <td>{{$user['Arn']}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>{{'No user exists!!'}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_user_group">Add user to group</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="policy" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" style="text-align: right; display: block;">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
          <div class="json-code"></div>
      </div>
     </div>

  </div>
</div>
<div id="attach_policy" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" style="text-align: right; display: block;">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      
      </div>
      <div class="modal-body">
          <form method="POST" action="{{url('/admin/attach-policy-to-group')}}" >
              @csrf
               <div class="form-group">
                  <label for="policy_name">Policy Name:</label>
                  <input class="form-control" type="text" autocomplete="off" name="policy_name" id="policy_name" placeholder="Add policy name" value="">
              </div>
              <p>If you do not have Policy json ready, please generate new policy <a target="_blank" href="https://awspolicygen.s3.amazonaws.com/policygen.html">here</a> </p>
              <div class="form-group">
                  <label for="policy">Add Policy Json:</label>
                  <input type="hidden" name="group_name" value="{{$group['Group']['GroupName']}}">
                  <textarea class="form-control policy-textarea" type="text" autocomplete="off" name="policy" id="policy" placeholder="Please add Json format only" value="">
                  </textarea>
              </div>
             
              <button type="submit" class="btn btn-default">Submit</button> 
          </form>
      </div>
     </div>

  </div>
</div>
<div id="add_user_group" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" style="text-align: right; display: block;">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      
      </div>
      <div class="modal-body">
          <form method="POST" action="{{url('/admin/add-user-to-group')}}" >
              @csrf
              <div class="form-group">
                  <label for="policy">Add user to {{$group['Group']['GroupName']}} group:</label>
                  <input type="hidden" name="group_name" value="{{$group['Group']['GroupName']}}">
              </div>
              <select class="form-control" id="user_name" name="user_name">
                  @forelse($other_users as $user)
                  <option value="{{$user}}">{{$user}}</option>
                  @empty
                  <option value="">Please create a new user from groups page</option>
                  @endforelse
              </select>
              <br>
              <button type="submit" class="btn btn-default">Submit</button> 
          </form>
      </div>
     </div>

  </div>
</div>
@endsection



