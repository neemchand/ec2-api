
## Ec2-api

This app is created to list and create new Ec2 instances/IAM Roles/groups on aws by using aws php sdk 
so that developers do not need to login to aws console and learn about their service setup methods.
User can create new severs on aws ec2/IAM with click of a button.

IAM Groups,roles,users and apply different policies to restrict the access of aws services to certain groups,roles or users

## About Project

- Language: PHP (^7.1.3)
- Framework: Laravel ( 5.7.* )
- Database: PostgreSql

## How to install project on local
  
    Open CLI and run following commands to set up at local:
   - **Clone the project**
        > 
            git clone https://github.com/neemchand/ec2-api.git

   - **Set permissions**
       >
            sudo chmod -R 777 { project-storage-path }
            sudo chmod -R 777 { project-bootstrap-path }

   - **Go to project directory**
       >
            cd ec2-api       

 - **Install the dependencies**    
 >
           composer install
  


## Database installation
- **How to install postgresql ( Ubuntu )**
    >
        sudo apt-get install postgresql postgresql-contrib
- **Which UI being used to connect to DB**
    >
        pgadmin
- **Create  database**
    >
         1. login to pgsql
          sudo psql -h localhost -U postgres    
           2. create database utc-time;

## Post Installation steps
 - **Run database migrations**
    >
        php artisan migrate

- **Start server**
    >
        php artisan serve
        The API will be running on localhost:8000 now.


## **How it works**
**Steps to create EC2 Instances from platform**

1. User sign up 
  - User needs to sign up to the platform.

2. Create ec2 Instance 
  - Click on Ec2 Instances button in navigation.
    - You can see list of all current Instances
    - Click on create new instance button
    - Fill in the form and provide following details for your instance.

        a) Select key-pair name to login to server. 
           -If you do not have a key-pair click on the add keypair button and generate a new key pair
           -Download the {your-key}.pem file and keep it at safe place so that you can login to the server with this key later.  
        b) Select security group.
           -You can create your own customized security group too.
        c)Add Tags.
    
3. Connect to your server.  
     - Visit dashboard by clicking Home link from navigation.
     - Use folowing command to connect to your new server through ssh terminal. 
        > 
        ssh -i {key_name}.pem ubuntu@{Instance ip}
  
  In this way each user can create multiple ec2 instances easily and view the status and configurations for each of them. 


**Steps to set up new IAM Groups, Roles, Users :** 
  To know more about the groups, Roles, Users visit <a href="https://docs.aws.amazon.com/IAM/latest/UserGuide/id.html" target="_blank" >here</a> 
1.User sign up 
  - User needs to sign up to the platform.

2. Create IAM Groups 
  - Click on  'Iam groups' button in navigation.
        - List of current Groups,Roles and Users. 
  - Click on create new Group      
  - Fill in the form and provide following details for your group.
  - View Group, here you can see   
    - List of all policies attached ( Aws managed policies)  
    - List of All inline Policies  ( Inline policies created by user) 
        - click on view policy you will get the policy popup which will policy json 
        - Visit 'add policy popup'- You can add your custom policy
        - To create a policy you need to understand the term *policy* and format of policy <a href="https://docs.aws.amazon.com/IAM/latest/UserGuide/access_policies.html" target="_blank" >here</a>
        - You can generate your custom policy  <a href="https://awspolicygen.s3.amazonaws.com/policygen.html" target="_blank" >here</a>
            
    - List of All users in the group 
        - Visit 'add user popup' You can add more users from existing users
   
    - Similarly you can create new roles, and add users to the groups and roles. 
  
  In this way each user can create IAM Groups,roles,users and apply different policies to restrict the access of aws services to certain groups,roles or users. 