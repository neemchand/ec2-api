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
                    <h3>Create New EC2 Instance</h3>
                    <form method="post" action="{{url('/create-instance')}}">
                        @csrf
                        <div class="form-group">
                            <label for="key_pair">Select key-pair Name:</label>
                            <select class="form-control" id="key_pair" name="key_pair">
                                @forelse($available_key_pairs as $key_pair)
                                <option value="{{$key_pair}}">{{$key_pair}}</option>
                                @empty
                                <option value="">Please create a new keypair</option>
                                @endforelse
                            </select>
                            <a href="{{url('create-keypair')}}">Create new key pair</a>
                        </div>
                        <div class="form-group">
                            <label for="security_group">Select security group:</label>
                            <select class="form-control" id="security_group" name="security_group">
                                <option value="">Choose</option>
                                @forelse($available_security_groups as $security_group)
                                <option value="{{$security_group}}">{{$security_group}}</option>
                                @empty
                                @endforelse
                            </select>
                             <a href="{{url('create-securitygroup')}}">Create new Security group</a>
                        </div>
                        <div class="form-group">
                            <label for="tags">Add Tags:</label>
                            <input class="form-control" type="text" autocomplete="off" name="tags" id="tags" placeholder="Add comma separated tag .eg key|value, key|value " value="">
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
