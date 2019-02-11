<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Ec2Component;
use Validator;
class Ec2Controller extends Controller {
    public function getDownload(Request $request) {
        // prepare content
        $logs = Log::all();
        $content = "Logs \n";
        foreach ($logs as $log) {
            $content .= $logs->id;
            $content .= "\n";
        }

        // file name that will be used in the download
        $fileName = "logs.txt";

        // use headers in order to generate the download
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => sizeof($content)
        ];

        // make a response, with the content, a 200 response code and the headers
        return Response::make($content, 200, $headers);
    }

    public function saveKeyPair(Request $request) {
        if ($request->method() == 'GET') {
             return view('ec2.create-keypair');
        }
        $input = $request->all();
        $rules = [
            'keyname' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return \Redirect::back()->withErrors($validation)->withInput();
        }
        return (new Ec2Component())->saveKeyPairLocally($request->keyname);
    }

    public function describeInstances() {
       return (new Ec2Component())->describeSecurityGroups();
    }
    public function createInstance() {
       return (new Ec2Component())->describeInstances();
    }
    public function createSecurityGroup() {
       return (new Ec2Component())->createSecurityGroup();
    }
    public function LaunchNewInstantace(Request $request) {
        $ec2 = new Ec2Component();
        if ($request->method() == 'GET') {
            $available_key_pairs = !empty($ec2->describeKeyPairs())? array_column($ec2->describeKeyPairs(), 'KeyName'):[];
            $available_security_groups = !empty($ec2->describeSecurityGroups())? array_column($ec2->describeSecurityGroups(), 'GroupName'):[];
            return view('ec2.create-instance', compact('available_key_pairs','available_security_groups'));
        }
        
        $input=$request->all();
        $rules = [
          'key_pair'=>'required',
           'security_group'=>'required'
        ];
       $validation = Validator::make($request->all(),$rules);
       if($validation->fails()){
          return \Redirect::back()->withErrors($validation)->withInput();
        }
        
        $tags = explode(',', $request->tags);
        $tags_array = [];
        if (count($tags)) {
            $tags = explode(',', $request->tags);
              foreach ($tags as $key => $value) {
                $_tag = explode('|', $value);
                $tags_array[] = ['Key' => $_tag[0], 'Value' => $_tag[1]];
            }
        } else {
            $_tag = explode('|', $value);
            $tags_array[] = ['Key' => $_tag[0], 'Value' => $_tag[1]];
        }
         $instance = (new Ec2Component())->LaunchNewInstantace($request->key_pair, $request->security_group,$tags_array);
        if($instance){
            return view('home'); 
        }
         
    }

}
