<?php
class AdminOrdersController extends AbstractController
{
    /**
     * Renders the page with all orders.
     */
    public function orders(): void
    {
        $om = new OrderManager();
        $orders = $om->findAll();

        $this->render("admin/admin-orders.html.twig", [
            'orders' => $orders,
        ]);
    }

    /**
     * Renders the page for a specific order.
     * 
     * @param int $id The ID of the order to display
     */
    public function order(int $id): void
    {
        $om = new OrderManager();
        $order = $om->findOne($id);
        $status = $om->statusArray;

        // Fetches shipping details associated with the order
        $shipping = $om->findShippingByOrderId($id);

        $this->render("admin/admin-order.html.twig", [
            'order' => $order,
            'status' => $status,
            'shipping' => $shipping
        ]);
    }

    /**
     * Updates the status of an order.
     */
    public function updateStatus(): void
    {
        $id = (int) $_POST['id'];
        $type = 'success';
        $text = '';

        if (isset($_POST) && isset($_POST['status'])) {
            $status = $_POST['status'];
            $om = new OrderManager();
            $update = $om->updateStatus($id, $status);
            if (!$update) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $text = "La mise à jour a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }

        $this->notify($text, $type);
        $this->redirect("/admin/orders/$id");
    }
}
