<?php

class AdminShippingsController extends AbstractController
{
    /**
     * Renders the page with all shippings.
     */
    public function shippings(): void
    {
        $sm = new ShippingManager();
        $shippings = $sm->findAll();

        $this->render("admin/admin-shippings.html.twig", [
            'shippings' => $shippings,
        ]);
    }

    /**
     * Renders the page for a specific shipping.
     * 
     * @param int $id The ID of the shipping to display
     */
    public function shipping(int $id): void
    {
        $sm = new ShippingManager();
        $shipping = $sm->findOne($id);

        $this->render("admin/admin-shipping.html.twig", [
            'shipping' => $shipping
        ]);
    }

    /**
     * Renders the form for creating a new shipping.
     */
    public function newShipping()
    {
        $this->render("admin/admin-new-shipping.html.twig", []);
    }

    /**
     * Handles the form submission for adding a new shipping.
     */
    public function addShipping(): void
    {
        $url = url('newShipping');
        if (isset($_POST) && $_POST["name"] && $_POST["description"] && $_POST["price"] && $_POST["delivery_min"] && $_POST["delivery_max"]) {
            $s = new Shipping($_POST["name"], $_POST["description"], $_POST["price"], $_POST["delivery_min"], $_POST["delivery_max"]);
            $sm = new ShippingManager();

            $insert = $sm->insert($s);

            if (!$insert) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $url = url('shipping', ['id' => $insert]);
                $type = 'success';
                $text = "Le nouveau frais de port a bien été créé 😃";
            }
        } else {
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }
        $this->notify($text, $type);
        $this->redirect($url);
    }

    /**
     * Handles the form submission for updating an existing shipping.
     */
    public function updateShipping(): void
    {
        if (isset($_POST) && isset($_POST['id']) && $_POST["name"] && $_POST["description"] && $_POST["price"] && $_POST["delivery_min"] && $_POST["delivery_max"]) {
            $id = $_POST['id'];
            $s = new Shipping($_POST["name"], $_POST["description"], $_POST["price"], $_POST["delivery_min"], $_POST["delivery_max"]);
            $s->setId($id);
            $sm = new ShippingManager();
            $update = $sm->update($s);
            if (!$update) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $type = 'success';
                $text = "La mise à jour a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }

        $this->notify($text, $type);
        $this->redirect(url('shipping', ['id' => $id]));
    }
}
