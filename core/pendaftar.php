<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once '../config/connection.php';
if (isset($_GET['method']) && $_GET['method'] !== '') {
    if ($_GET['method'] === "get") {
        get($conn);
    }
    if ($_GET['method'] === "create") {
        create($conn);
    }
    if ($_GET['method'] === "update") {
        update($conn);
    }
    if ($_GET['method'] === "delete") {
        delete($conn);
    }
}

function get($conn) {
    try {
        $columns = array( 
            0 =>'id',
            1 => 'nama_depan',
            2 =>'email',
            3 => 'username',
        );

        $sqlCounter = $conn->query("SELECT count(id) as countData FROM data_pendaftar");
        $fetchCounter = $sqlCounter->fetchAll();

        $totalData = $fetchCounter[0]['countData'];
        $totalFiltered = $totalData;

        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order'][0]['column']];
        $dir = $_POST['order'][0]['dir'];

        if(empty($_POST['search']['value']))
        {
            $sqlData = $conn->query("SELECT * FROM data_pendaftar order by $order $dir LIMIT $limit OFFSET $start");
            // $fetchData = $sqlData->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $searchValue = $_POST['search']['value'];
            
            $sqlData = $conn->query("SELECT * FROM data_pendaftar WHERE nama_depan LIKE '%$searchValue%' or nama_belakang LIKE '%$searchValue%' order by $order $dir LIMIT $limit OFFSET $start");
            // $fetchData = $sqlData->fetchAll(\PDO::FETCH_ASSOC);

            $sqlCounter = $conn->query("SELECT count(id) as countData FROM data_pendaftar WHERE nama_depan LIKE '%$searchValue%' or nama_belakang LIKE '%$searchValue%'");
            $fetchCounter = $sqlCounter->fetchAll();

            $totalFiltered = $fetchCounter[0]['countData'];
        }

        $data = array();
        if(!empty($sqlData))
        {
            $no = $start + 1;
            while ($r = $sqlData->fetch())
            {
                $nestedData['no'] = $no;
                $nestedData['nama'] = $r['nama_depan']." ".$r['nama_belakang'];;
                $nestedData['email'] = $r['email'];
                $nestedData['username'] = $r['username'];
                $nestedData['aksi'] = '<button class="btn btn-primary btn-sm" onclick="edit(\''.base64_encode(json_encode($r)).'\')">Ubah</button>&nbsp; <button class="btn btn-danger btn-sm" onclick="deleted(\''.$r['id'].'\')">Hapus</button>';
                $data[] = $nestedData;
                $no++;
            }
        }
           
        $json_data = array(
            "draw"            => intval($_POST['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data  
        );
             
        echo json_encode($json_data); 
    } catch(PDOException $ex) {
        die($ex->getMessage());
    }
}

function create($conn) {
    try {
        $nama_depan = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $data[] = $nama_depan;
        $data[] = $nama_belakang;
        $data[] = $email;
        $data[] = $username;
        $data[] = password_hash($password, PASSWORD_DEFAULT);
        
        
        $sql = 'INSERT INTO data_pendaftar (nama_depan, nama_belakang, email, username, password)VALUES (?,?,?,?,?)';
        $row = $conn->prepare($sql);
        $row->execute($data);
    
        echo json_encode(array("status"=>200, "message"=>"Data berhasil tersimpan"));
    } catch(PDOException $ex) {
        echo json_encode(array("status"=>500, "message"=>$ex->getMessage()));
    }
}

function update($conn) {
    try {
        $nama_depan = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $id = $_POST['id'];

        $data[] = $nama_depan;
        $data[] = $nama_belakang;
        $data[] = $email;
        $data[] = $username;
        $data[] = password_hash($password, PASSWORD_DEFAULT);
        $data[] = $id;
        
        $sql = 'UPDATE data_pendaftar SET nama_depan=?, nama_belakang=?, email=?, username=?, password=? WHERE id=?';
        $row = $conn->prepare($sql);
        $row->execute($data);
    
        echo json_encode(array("status"=>200, "message"=>"Data berhasil terubah"));
    } catch(PDOException $ex) {
        echo json_encode(array("status"=>500, "message"=>$ex->getMessage()));
    }
}

function delete($conn) {
    try {
        $id = $_POST['id'];
        $data[] = $id;
        
        $sql = 'DELETE FROM data_pendaftar WHERE id=?';
        $row = $conn->prepare($sql);
        $row->execute($data);
    
        echo json_encode(array("status"=>200, "message"=>"Data berhasil terhapus"));
    } catch(PDOException $ex) {
        echo json_encode(array("status"=>500, "message"=>$ex->getMessage()));
    }
}
?>