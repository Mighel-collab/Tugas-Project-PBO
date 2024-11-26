<?php 
require_once 'nodes/node_barang.php';
class modelBarang
{
    private $barangs = [];
    private $nextId = 1;
 
    public function __construct(){
        if (isset($_SESSION['barangs'])){
            $this->barangs = unserialize($_SESSION['barangs']);
            $this->nextId = count($this->barangs) + 1;
        }else{
            $this->initiliazeDefaultBarang();
        }
    }

    public function initiliazeDefaultBarang(){
        $this->addBarang(nama_barang: "Sepatu", harga_barang: "100000", jumlah_barang: 1);
        $this->addBarang(nama_barang: "Kaos", harga_barang: "80000", jumlah_barang: 1);
        $this->addBarang(nama_barang: "Tas", harga_barang: "150000", jumlah_barang: 1);
        
        
    }
    
    public function addBarang($nama_barang, $harga_barang, $jumlah_barang){
        $peran = new \Barang($this->nextId++, $nama_barang, $harga_barang, $jumlah_barang);
        $this->barangs[] = $peran;
        $this->saveToSession();
    }
    
    private function saveToSession(){
        $_SESSION['barangs'] = serialize($this->barangs);
    }
    
    public function getAllBarangs(){
        return $this->barangs;
    }
       public function getBarangById($id_barang){
        foreach($this->barangs as $barang){
            if($barang->id_barang == $id_barang){
                return $barang;
            }
        }
        return null;
    }
    
    public function updateBarang($id_barang, $nama_barang, $harga_barang, $jumlah_barang){
        foreach($this->barangs as $barang){
            if ($barang->id_barang == $id_barang) {
                $barang->nama = $nama_barang;
                $barang->harga_barang = $harga_barang;
                $barang->jumlah_barang = $jumlah_barang;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }
    
    public function deleteBarang($id_barang){
        foreach($this->barangs as $key => $barang){
            if($barang->id_barang == $id_barang) {
                unset($this->barangs[$key]);
                $this->barangs = array_values($this->barangs); //Reindex array
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }
    
    public function getBarangByName($nama_barang){
        foreach($this->barangs as $barang){
            if ($barang->nama_barang == $nama_barang){
                return $barang;
            }
        }
    }
}
?>