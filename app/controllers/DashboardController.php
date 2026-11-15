<?php

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = $this->model('Dashboard');

        $data = [
            'title' => 'Dashboard - Stockify',

            'stats' => $dashboard->getStatistics(),

            'products' => $dashboard->getRecentProducts(),

            'lowStocks' => $dashboard->getLowStockProducts()
        ];

        $this->view('dashboard/index', $data);
    }
}