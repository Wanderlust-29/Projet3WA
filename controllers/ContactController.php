<?php

class ContactController extends AbstractController
{
    public function contact() : void
    {
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render("contact/contact.html.twig", [
            "session"=>$session
        ]);
    }
}