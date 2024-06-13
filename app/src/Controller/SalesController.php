<?php

namespace App\Controller;

use App\Service\SalesService;

class SalesController extends BaseController
{
    /**
     * @var SalesService
     */
    private $salesService;

    public function __construct()
    {
        $this->salesService = new SalesService;
    }

    public function all()
    {
        $groupedSales = $this->salesService->getSales();
        include $this->view('sales');
    }
}