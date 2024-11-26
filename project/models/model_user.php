<?php 
require_once 'nodes/node_user.php';
require_once 'nodes/node_role.php';

class model_User{
    private $users = [];
    private $nextId = 1;

    public function __construct(){
        if (isset($_SESSION['users'])){
            $this->users = unserialize($_SESSION['users']);
            $this->nextId = count($this->users) + 1;
        }else{
            $this->initiliazeDefaultUser();
        }
    }
    public function addUser($username, $password, $role){
        $user = new \User($this->nextId++, $username, $password, $role);
        $this->users[] = $user;
        $this->saveToSession();
    }
    
    private function saveToSession(){
        $_SESSION['users'] = serialize($this->users);
    }
    
    public function getUsers(){
        return $this->users;
    }
    private function initiliazeDefaultUser(){
        $obj_role1 = new \Role( role_id: 1, role_name: "admin", role_description: "administrator", role_status: 1);
        $obj_role2 = new \Role( role_id: 2, role_name: "kasir", role_description: "kasir", role_status: 1);
        $this->addUser( "bobang@gmail.com", "123", $obj_role1);
        $this->addUser(  "ucok@gmail.com",  "123", $obj_role2);
    }

    public function getUserById($user_id){
        foreach($this->users as $user){
            if($user->user_id == $user_id){
                return $user;
            }
       }
       return null; 
    }

    public function deleteUser($user_id){
        if ($iduser != null){
            $key = array_search($user_Id, $this->users);
            unset($this->users[$key]);
            $this->users = array_values($this->users);
            $this->saveToSession();
            return true;
        }
        return false;
    }

    public function updateUser($user_id, $username, $password, $role){
        $userlokal = $this->getUserById($user-id) ;
        if( $userlokal!= null){

        $userlokal->username = $username;
        $userlokal->password = $password;
        $userlokal->role = $role;
        return true;
        }
        return false;
        
    }

}
?>