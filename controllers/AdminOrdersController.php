<?php
class AdminOrdersController extends AbstractController
{
    // all orders
    public function orders()
    {
        $om = new OrderManager();
        $orders = $om->findAll();

        $this->render("admin/admin-orders.html.twig", [
            'orders' => $orders,
        ]);
    }

    // Single order
    public function order(int $id){
        $om = new OrderManager();
        $order = $om->findOne($id);
        $status = $om->statusArray;
        // Récupération du mode de livraison
        $sm = new ShippingManager();
        $shipping = $sm->findOneByOrderId($id);

        $this->render("admin/admin-order.html.twig", [
            'order' => $order,
            'status' => $status,
            'shipping' => $shipping
        ]);
    }

    // Single order
    public function updateStatus(){
        $id = (int) $_POST['id'];
        $type = 'success';
        $text = '';
        if(isset($_POST) && isset($_POST['status'])){
            $status = $_POST['status'];
            $om = new OrderManager();
            $update = $om->updateStatus($id, $status);
            if(!$update){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            }else{
                $text = "La mise à jour a bien été effectuée 😃";
            }
        }else{
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }

        $this->notify($text,$type);
        $this->redirect("/admin/orders/$id");
    }

}
