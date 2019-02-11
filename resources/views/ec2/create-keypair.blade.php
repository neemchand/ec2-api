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
                    <h3>Create New Key Pair</h3>
                    <form method="post" action="{{url('/create-keypair')}}">
                        @csrf
                        <div class="form-group">
                            <label for="keyname">Add Key:</label>
                            <input class="form-control" type="text" autocomplete="off" name="keyname" id="keyname" placeholder="Add key name" value="">
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
