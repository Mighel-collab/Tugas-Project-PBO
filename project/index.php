<?php
session_start();
require_once "models/model_role.php";
require_once "models/model_barang.php";
require_once "models/model_user.php";

//create object role
$obj_role = new modelRole();
$obj_barang = new modelBarang();
$obj_user = new model_user();

if (isset($_GET['modul'])){
    $model = $_GET['modul'];
}else{
    $model = "dashboard";
}

switch ($model){
    case "dashboard":
            include 'views/kosong.php';
        break;
        case 'user':
            $fitur = isset($_GET['fitur']) ? $_GET['fitur'] : null;
        switch ($fitur){
            case "add":
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $username =$_POST['user_name'];
                    $password=$_POST['password'];
                    $role_name = $_POST['role_name'];
                    $role = $obj_role->getRoleByName($role_name);
                    $obj_user->addUser($username, $password, $role);
                    header(header: 'location: index.php?modul=user');
                }else{
                    $roles = $obj_role->getAllRoles();
                    include 'views/user_input.php';

                }
            default:
            $users = $obj_user->getUsers();
            // print_r($users);
            include 'views/user_list.php';
        }
            break;
    case "role":
        $fitur = isset($_GET['fitur']) ? $_GET['fitur'] : null;
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        switch ($fitur){
            case "add":
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                   $name = $_POST['role_name'];
                   $deskripsi = $_POST['role_description'];
                   $status = $_POST['role_status'];
                   $obj_role->addRole($name, $deskripsi, $status);
                   header(header: 'location: index.php?modul=role');
                }else{
                    include 'views/role_input.php';
                }
                break;
                case "delete":
                    $obj_role->deleteRole($id);
                    header(header: 'location: index.php?modul=role');
                    break;
                case "update":
                    $role = $obj_role->getRoleById($id);
                    include 'views/role_edit.php';
                    break;
                case "edit":
                    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                   $name = $_POST['role_name'];
                   $deskripsi = $_POST['role_description'];
                   $status = $_POST['role_status'];
                   $obj_role->updateRole($id, $name, $deskripsi, $status);
                   header('location: index.php?modul=role');
                    }else{
                        include 'views/role_list.php';
                    }
                    break;
            default:
            $roles = $obj_role->getAllRoles();
            include 'views/role_list.php';
            break;
         }

         case "barang":
        $fitur = isset($_GET['fitur']) ? $_GET['fitur'] : null;
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        switch ($fitur){
            case "add":
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                   $nama = $_POST['nama_barang'];
                   $harga = $_POST['harga_barang'];
                   $jumlah = $_POST['jumlah_barang'];
                   $obj_barang->addBarang($nama, $harga, $jumlah);
                   header(header: 'location: index.php?modul=barang');
                }else{
                    include 'views/barang_input.php';
                }
                break;
                case "delete":
                    $obj_barang->deleteBarang($id);
                    header(header: 'location: index.php?modul=barang');
                    break;
                case "update":
                    $barang = $obj_barang->getBarangById($id);
                    include 'views/barang_edit.php';
                    break;
                case "edit":
                    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                   $nama = $_POST['nama_barang'];
                   $harga = $_POST['harga_barang'];
                   $jumlah = $_POST['jumlah_barang'];
                   $obj_barang->updateBarang($id, $nama, $harga, $jumlah);
                   header('location: index.php?modul=barang');
                    }else{
                        include 'views/barang_list.php';
                    }
                    break;
            default:
            $barangs = $obj_barang->getAllBarangs();
            include 'views/barang_list.php';
            break;
         }
         

}
?>