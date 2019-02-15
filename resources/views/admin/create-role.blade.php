@extends('layouts.app')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <h3>Create New Role</h3>
                    <form method="post" action="{{url('admin/create-role')}}">
                        @csrf
                        <div class="form-group">
                            <label for="rolename">Add Role name:</label>
                            <input class="form-control" type="text" autocomplete="off" name="rolename" id="rolename" placeholder="Add group name" value="">
                        </div>
                         <div class="form-group">
                            <label for="policy">Add Role description:</label>
                            <textarea class="form-control policy-textarea" type="text" autocomplete="off" name="description" id="description" placeholder="Please add description" value="">
                            </textarea>
                        </div>
                       <div class="form-group">
                            <label for="assume_role_policy">Add Assume Policy Json for any aws entity:</label>
                            <textarea class="form-control policy-textarea" type="text" autocomplete="off" name="assume_role_policy" id="assume_role_policy" placeholder='Format: {"Version":"2012-10-17","Statement":[{"Effect":"Allow","Principal":{"Service":["ec2.amazonaws.com"]},"Action":["sts:AssumeRole"]}]}' value="">
                            </textarea>
                       <p>If you do not have Assume policy Json ready, please check these sample request for reference <a target="_blank" href="https://docs.aws.amazon.com/IAM/latest/APIReference/API_CreateRole.html">here</a>. </p>
                       </div>
             
                        <div class="form-group">
                            <label for="path">Add Path:</label>
                            <input class="form-control" type="text" autocomplete="off" name="path" id="path" placeholder="Add role path (optional)" value="">
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
