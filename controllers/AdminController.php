<?php

use Carbon\Carbon;

class AdminController extends AbstractController
{
    /**
     * Renders the admin dashboard with various statistics.
     */
    public function admin(): void
    {
        // Initialize OrderManager to fetch statistics
        $om = new OrderManager();
        $monthEarning = $om->getMonthlyEarning(); // Fetch monthly earnings
        $yearEarning = $om->getYearlyEarning();   // Fetch yearly earnings
        $pendingOrders = $om->getPendingOrdersTotal(); // Fetch total pending orders

        // Initialize CommentManager to fetch pending comments
        $cm = new CommentManager();
        $pendingComments = $cm->getPendingCommentsTotal(); // Fetch total pending comments

        // Get current date in French locale using Carbon library
        $date = Carbon::now()->locale('fr_FR');

        // Render the admin dashboard view with fetched data
        $this->render("admin/admin.html.twig", [
            'monthEarning' => $monthEarning,
            'yearEarning' => $yearEarning,
            'pendingComments' => $pendingComments,
            'pendingOrders' => $pendingOrders,
            'currentMonth' => $date->monthName . ' ' . $date->year // Current month and year
        ]);
    }
}
