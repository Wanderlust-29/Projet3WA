<?php
use Carbon\Carbon;

class AdminController extends AbstractController
{
    // ADMIN
    public function admin()
    {
        $om = new OrderManager();
        $monthEarning = $om->getMonthlyEarning();
        $yearEarning = $om->getYearlyEarning();
        $pendingOrders = $om->getPendingOrdersTotal();

        $cm = new CommentManager();
        $pendingComments = $cm->getPendingCommentsTotal();

        $date = Carbon::now()->locale('fr_FR');


        $this->render("admin/admin.html.twig", [
            'monthEarning' => $monthEarning,
            'yearEarning' => $yearEarning,
            'pendingComments' => $pendingComments,
            'pendingOrders' => $pendingOrders,
            'currentMonth' => $date->monthName . ' ' . $date->year
        ]);
    }

}
