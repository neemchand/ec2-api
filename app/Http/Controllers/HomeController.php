<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Ec2Component;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $instance_reservations= (new Ec2Component())->describeInstances()['Reservations'];
       // echo"<pre>";  print_r($instance_reservations);        die();
        return view('home', compact('instance_reservations'));
    }
}
