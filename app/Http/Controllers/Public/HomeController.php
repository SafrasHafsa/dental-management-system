<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)
            ->select('name', 'category', 'description', 'base_price', 'duration_minutes')
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('public.home', compact('services'));
    }

    public function services(): View
    {
        $services = Service::where('is_active', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('public.services', compact('services'));
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function contact(): View
    {
        return view('public.contact');
    }
}
