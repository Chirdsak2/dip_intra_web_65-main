<?php
namespace App\Controller;
class Home extends Manager {
    public function findProductName($request,$response){
        $productName = $request->getParesedBody('productname');
        $sql = "SELECT * FROM product WHERE name LIKE '%$productName%'";
        $result = $this->db->prepare($sql);
        $result->execute();
                        //unarray
        $data = $result->fetchAll(\PDO::FETCH_OBJ);
        echo json_encode($data);
    }
    public function showProduct(){
        $sql = "SELECT * FROM product";
        $result = $this->db->prepare($sql);
        $result->execute();
                        //array
        $data = $result->fetchAll(\PDO::FETCH_OBJ);
        $jdata = array('product'=>$data);
        echo json_encode($jdata);
    }

    public function showProid($request, $response){
        $id = $request->getAttribute('id');
        $sql = "SELECT * FROM product WHERE id = $id";
        $result = $this->db->prepare($sql);
        $result->execute();
                        //unarray
        $data = $result->fetch(\PDO::FETCH_OBJ);
        //echo json_encode($data);

        $vars['mypro'] = $data;

        return $this->view->render($response,'home.phtml',$vars);
    }
}

?>