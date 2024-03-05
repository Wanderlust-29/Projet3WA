<?php

class InfosController extends AbstractController
{
    public function conditions() : void
    {
        $this->render("infos/conditions.html.twig", [
        ]);
    }
    public function legal() : void
    {
        $this->render("infos/legal.html.twig", [
        ]);
    }
    public function privacy() : void
    {
        $this->render("infos/privacy.html.twig", [
        ]);
    }
    public function refund() : void
    {
        $this->render("infos/refund.html.twig", [
        ]);
    }
}