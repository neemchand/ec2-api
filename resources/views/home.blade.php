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
                    <h2>Your EC2 Instances</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Instance ID</th>
                                <th>State</th>
                                 <th>Instance IP</th>
                                <th>Type</th>
                                <th>Key-Pair name</th>
                                <th>Tag name</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($instance_reservations as $instance_reservation) 
                            @foreach($instance_reservation['Instances'] as $instance) 
                            
                           @php $tags =!empty($instance['Tags'])? implode(",", array_column($instance['Tags'], 'Value')):'';  @endphp
                            <tr>
                                <td>{{$instance['InstanceId']}}</td>
                                <td>{{$instance['State']['Name']}}</td>
                                <td>{{isset($instance['PrivateIpAddress'])?$instance['PrivateIpAddress']:''}}</td>
                                <td>{{$instance['InstanceType']}}</td>
                                <td>{{$instance['KeyName']}}</td>
                                <td>{{$tags}}</td>
                                
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
