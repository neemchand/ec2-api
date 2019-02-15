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
                    <h3>Create New Group</h3>
                    <form method="post" action="{{url('admin/create-group')}}">
                        @csrf
                        <div class="form-group">
                            <label for="groupname">Add Username:</label>
                            <input class="form-control" type="text" autocomplete="off" name="groupname" id="groupname" placeholder="Add group name" value="">
                        </div>
                        <div class="form-group">
                            <label for="groupname">Add Path:</label>
                            <input class="form-control" type="text" autocomplete="off" name="path" id="path" placeholder="Add group path" value="">
                        </div>
                        
                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
