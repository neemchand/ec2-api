<?php
namespace App\Components;
use Aws\Ec2\Ec2Client;
use Illuminate\Filesystem\Filesystem;
class Ec2Component {

    private $ec2Client;

    public function __construct() {
        $options = [
            'region' => 'ap-south-1',
            'version' => 'latest',
            'signature_version' => 'v4',
        ];

        $this->ec2Client = new Ec2Client($options);
     
    }

    public function createKeyPair() {
        $keyPairName = 'ec2-key-pair';
        $result = $ec2Client->createKeyPair(array(
            'test' => $keyPairName
        ));
    }

    public function saveKeyPairLocally( $keyPairName = 'ec2-key-neem') {
        $result = $this->ec2Client->createKeyPair(array(
            'KeyName' => $keyPairName,
        ));
        $saveKeyLocation = getenv('HOME') . "{$keyPairName}.pem";
        $content =  $result['KeyMaterial'];
        $fileName = "{$keyPairName}.pem";
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];
        return \Response::make($content, 200, $headers);
//        if (!\Storage::disk('public_upload')->put($saveKeyLocation, $result['KeyMaterial'])) {
//            return false;
//        }
//        chmod(\Storage::disk('public_upload')->path($saveKeyLocation), 0600);
    }

    public function describeInstances() {
        return $this->ec2Client->describeInstances();
    }
    public function describeKeyPairs() {
        return $this->ec2Client->describeKeyPairs()['KeyPairs'];
    }
    public function describeSecurityGroups() {
       return  $this->ec2Client->describeSecurityGroups()['SecurityGroups'];
    }
    
    public function createSecurityGroup($securityGroupName = 'my-security-group') {
        $result = $this->ec2Client->createSecurityGroup(array(
            'GroupName' => $securityGroupName,
            'Description' => 'Basic web server security'
        ));
        // Get the security group ID (optional)
        $securityGroupId = $result->get('GroupId');
        // Set ingress rules for the security group
        $this->ec2Client->authorizeSecurityGroupIngress(array(
            'GroupName' => $securityGroupName,
            'IpPermissions' => array(
                array(
                    'IpProtocol' => 'tcp',
                    'FromPort' => 80,
                    'ToPort' => 80,
                    'IpRanges' => array(
                        array('CidrIp' => '0.0.0.0/0')
                    ),
                ),
                array(
                    'IpProtocol' => 'tcp',
                    'FromPort' => 22,
                    'ToPort' => 22,
                    'IpRanges' => array(
                        array('CidrIp' => '0.0.0.0/0')
                    ),
                )
            )
        ));
    }
    public function LaunchNewInstantace($keyPairName, $securityGroupName,$tags_array ){
        try {
             $result = $this->ec2Client->runInstances(array(
            'ImageId' => 'ami-0d773a3b7bb2bb1c1',
            'MinCount' => 1,
            'MaxCount' => 1,
            'InstanceType' => 't2.micro',
            'KeyName' => $keyPairName,
            'SecurityGroups' => array($securityGroupName),
            'TagSpecifications' =>[
               ['ResourceType' => 'instance' ,
                'Tags'=> $tags_array ]
                
            ] 
        ));
        return $result;
        } catch (Exception $exc) {
            return;   echo $exc->getTraceAsString();
        }
  }
}
