<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\IamComponent;
use Validator;

class IamController extends Controller {

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
        //return (new IamComponent())->saveKeyPairLocally($request->keyname);
    }

//    public function describeInstances() {
//        return (new Ec2Component())->describeSecurityGroups();
//    }

    public function listGroups(Request $request) {
        $all_users = (new IamComponent())->listUsers()['Users'];
        $all_groups = (new IamComponent())->listGroups()['Groups'];
        $all_roles = (new IamComponent())->listRoles()['Roles'];
      //  echo '<pre>'; print_r($all_roles);
        return view('admin.admin_home', compact('all_users', 'all_groups','all_roles'));
    }

    public function getPolicy(Request $request) {
        $all_users = (new IamComponent())->getPolicy();
        return view('admin.admin_home');
    }

    public function showGroup(Request $request) {
        $group = (new IamComponent())->getGroup($request->groupname);
        if ($group) {
            $all_users = (new IamComponent())->listUsers()['Users'];
            $group_policies = (new IamComponent())->listAttachedGroupPolicies($request->groupname)['AttachedPolicies'];
            $group_inline_policies = (new IamComponent())->listGroupPolicies($request->groupname)['PolicyNames'];
            $all_users = array_column($all_users, 'UserName');
            $users_already_in_group = array_column($group['Users'], 'UserName');
            $other_users = array_diff($all_users, $users_already_in_group);
            return view('admin.group', compact('group', 'group_policies', 'group_inline_policies', 'other_users'));
        }
        return redirect('404');
    }

    public function getPolicyJson(Request $request) {


        $inline_policy = (new IamComponent())->getGroupPolicy($request->group_name, $request->policy_name)['PolicyDocument'];
        return "<pre>" . urldecode($inline_policy);
    }

    public function attachPolicyToGroup(Request $request) {
        $inline_policy = (new IamComponent())->putGroupPolicy($request->group_name, $request->policy_name, $request->policy);
        return $inline_policy;
    }
    public function addUserToGroup(Request $request) {
        $user = (new IamComponent())->addUserToGroup($request->group_name, $request->user_name);
        if($user){
            return redirect('/admin/group/'.$request->group_name);
        }
    }

    public function createUser(Request $request) {
        if ($request->method() == 'GET') {
            return view('admin.create-user');
        }
        $rules = [
            'username' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return \Redirect::back()->withErrors($validation)->withInput();
        }

        return (new IamComponent())->createUser($request->username);
    }

    public function createGroup(Request $request) {
        if ($request->method() == 'GET') {
            return view('admin.create-group');
        }
        $input = $request->all();
        $rules = [
            'groupname' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return \Redirect::back()->withErrors($validation)->withInput();
        }
        return (new IamComponent())->createGroup($request->groupname, $request->path);
    }
    public function createRole(Request $request) {
        if ($request->method() == 'GET') {
            return view('admin.create-role');
        }
        $input = $request->all();
        $rules = [
            'rolename' => 'required',
            'assume_role_policy' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return \Redirect::back()->withErrors($validation)->withInput();
        }
        return (new IamComponent())->createRole($request->rolename, $request->assume_role_policy, $request->description, $request->path);
    }
    public function deleteUser(Request $request) {
        dd($request->all());
        $delete = (new IamComponent())->deleteUser($request->username);
        if($delete){
            return redirect('/admin/groups');
        } 
    }
    public function deleteRole(Request $request) {
        $delete = (new IamComponent())->deleteRole($request->role_name);
        if($delete){
            return redirect('/admin/groups');
        } 
    }
    
    
}
