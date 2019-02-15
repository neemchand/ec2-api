<?php

namespace App\Components;

use Aws\Iam\IamClient;
use Aws\Exception\AwsException;
use Illuminate\Filesystem\Filesystem;

class IamComponent {

    private $client;

    public function __construct() {
        $options = [
            'region' => 'ap-south-1',
            'version' => 'latest',
            'signature_version' => 'v4',
        ];

        $this->client = new IamClient($options);
    }

    public function createUser($user_name) {
        return $this->client->createUser(array(
                'UserName' => $user_name,
        ));
    }
    public function deleteUser($user_name) {
        try {
            return $this->client->deleteUser(array(
                    'UserName' => $user_name,
            ));
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }
    public function deleteRole($role_name) {
        try {
            return $this->client->deleteUser(array(
                    'RoleName' => $role_name,
            ));
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }

    public function createGroup($group_name, $path='/') {
        $result = $this->client->createGroup([
            'GroupName' => $group_name, 
            'Path' => $path,
        ]);
    }
    public function addUserToGroup($group_name, $user_name) {
        return $this->client->addUserToGroup([
                'GroupName' => $group_name, 
                'UserName' => $user_name, 
        ]);
    }

    public function getGroup($group_name) {
        try {
            return $this->client->getGroup([
                    'GroupName' => $group_name,
            ]);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }
    public function getGroupPolicy($group_name, $policy_name) {
      return $this->client->getGroupPolicy([
             'GroupName' => $group_name, 
             'PolicyName' => $policy_name, 
        ]);
    }
    public function getPolicy($policy_arn) {
        return $this->client->getPolicy([
            'PolicyArn' => $policy_arn, 
        ]);
    }
    public function listAttachedGroupPolicies($group_name) {
        return $this->client->listAttachedGroupPolicies([
            'GroupName' => $group_name, 
        ]);
    }
      public function listGroupPolicies($group_name) {
        return $this->client->listGroupPolicies([
            'GroupName' => $group_name, 
        ]);
    }
    public function createPolicy($policy_name, $policy_json) {
        $myManagedPolicy = '{
                    "Version": "2012-10-17",
                    "Statement": [
                        {
                            "Effect": "Allow",
                            "Action": "logs:CreateLogGroup",
                            "Resource": "RESOURCE_ARN"
                        },
                        {
                            "Effect": "Allow",
                            "Action": [
                            "dynamodb:DeleteItem",
                            "dynamodb:GetItem",
                            "dynamodb:PutItem",
                            "dynamodb:Scan",
                            "dynamodb:UpdateItem"
                        ],
                            "Resource": "RESOURCE_ARN"
                        }
                    ]
                }';

        try {
            $result = $this->client->createPolicy(array(
                'PolicyName' => $policy_name,
                'PolicyDocument' => $policy_json
            ));
            var_dump($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }
    public function putGroupPolicy($group_name, $policy_name, $policy_json) {
         try {
            return $this->client->putGroupPolicy(array(
                'GroupName' => $group_name, // REQUIRED
                'PolicyName' => $policy_name,
                'PolicyDocument' => $policy_json
            ));
          
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    public function listUsers() {
        return $this->client->listUsers();
    }

    public function listGroups() {
        return $this->client->listGroups();
    }
    public function listRoles() {
        return $this->client->listRoles();
    }

    public function getUser($user_name) {
        return $this->client->getUser(array(
                'UserName' => $user_name,
        ));
    }
    public function createRole($role_name, $assume_role_policy, $role_description, $path='/') {
        return $this->client->createRole([
            'AssumeRolePolicyDocument' => $assume_role_policy, 
            'Description' => $role_description,
            'Path' => $path,
            'RoleName' => $role_name, 
        ]);
    }
    
}
