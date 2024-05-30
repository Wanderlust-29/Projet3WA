<?php
class AdminShippingsController extends AbstractController
{
    // all orders
    public function shippings()
    {
        $sm = new ShippingManager();
        $shippings = $sm->findAll();

        $this->render("admin/admin-shippings.html.twig", [
            'shippings' => $shippings,
        ]);
    }

    // Single order
    public function shipping(int $id){
        $sm = new ShippingManager();
        $shipping = $sm->findOne($id);

        $this->render("admin/admin-shipping.html.twig", [
            'shipping' => $shipping
        ]);
    }

    // Single order
    public function newShipping(){
        $this->render("admin/admin-new-shipping.html.twig", [
        ]);
    }
    

    // Insert
    public function addShipping(){
        $url = url('newShipping');
        if(isset($_POST) && $_POST["name"] && $_POST["description"] && $_POST["price"] && $_POST["delivery_min"] && $_POST["delivery_max"]){
            $s = new Shipping($_POST["name"], $_POST["description"], $_POST["price"], $_POST["delivery_min"], $_POST["delivery_max"]);
            $sm = new ShippingManager();
            
            $insert = $sm->insert($s);

            if(!$insert){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            }else{
                $url = url('shipping',['id'=>$insert]);
                $type = 'success';
                $text = "Le nouveau frais de port a bien été créé 😃";
            }
        }else{
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }
        $this->notify($text,$type);
        $this->redirect($url);
    }

    // Update
    public function updateShipping(){
        if(isset($_POST) && isset($_POST['id']) && $_POST["name"] && $_POST["description"] && $_POST["price"] && $_POST["delivery_min"] && $_POST["delivery_max"]){
            $id = $_POST['id'];
            $s = new Shipping($_POST["name"], $_POST["description"], $_POST["price"], $_POST["delivery_min"], $_POST["delivery_max"]);
            $s->setId($id);
            $sm = new ShippingManager();
            $update = $sm->update($s);
            if(!$update){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            }else{
                $type = 'success';
                $text = "La mise à jour a bien été effectuée 😃";
            }
        }else{
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }

        $this->notify($text,$type);
        $this->redirect(url('shipping',['id'=>$id]));
    }

}
