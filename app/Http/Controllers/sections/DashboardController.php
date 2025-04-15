<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $yamlconfig;
    protected $navbarconfig;

    public function __construct()
    {
        $this->yamlconfig = $this->getYamlConfig('/menu/sidebar');
        $this->navbarconfig = $this->getYamlConfig('/menu/navbar');
    }

    public function index()
    {
        $sidebar = $this->yamlconfig['menu'];
        $navbar = $this->navbarconfig['menu'];
        $user = Auth::user();
        $dashboard = $this->create();
        return view('layouts.main', compact('sidebar', 'navbar', 'user', 'dashboard'));
    }

    public function create(){
        $user = Auth::user();
        return view('sections.dashboard', compact('user'));
    }

    public function landing(){
        return view('auth.landing');
    }
}
