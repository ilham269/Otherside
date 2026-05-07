<?php

namespace App\Http\Controllers;

use App\Services\WelcomeService;

class WelcomeController extends Controller
{
    public function __construct(private WelcomeService $service) {}

    public function index()
    {
        $featured    = $this->service->getFeaturedProduct();
        $bestSellers = $this->service->getBestSellers(6);
        $categories  = $this->service->getCategories();
        $newArrivals = $this->service->getNewArrivals(4);

        return view('welcome', compact('featured', 'bestSellers', 'categories', 'newArrivals'));
    }
}
