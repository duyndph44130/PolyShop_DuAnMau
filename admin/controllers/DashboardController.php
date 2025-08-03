<?php
require_once './models/DashboardModel.php';

class DashboardController {
    public $model;

    public function __construct() {
        $this->model = new DashboardModel();
    }

    public function index() {
        $stats = $this->model->getStats();
        $monthlySales = $this->model->getMonthlySales();
        $categories = $this->model->getTopCategories();
        $users = $this->model->getRecentUsers();
        $recentProducts = $this->model->getLatestProducts();
        $recentOrders = $this->model->getRecentOrders();
        $recentComments = $this->model->getRecentComments();

        require_once './views/home_admin.php';
    }
}
