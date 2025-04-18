<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
class DashboardController extends Controller
{
    protected $yamlconfig;
    protected $navbarconfig;
//    protected  $currentLocale = App::getLocale();

    public function __construct()
    {
        parent::__construct();
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

    public function navbar(){
        $navbar = $this->navbarconfig['menu'];
        $user = Auth::user();
        return view('layouts.partials.navbar', compact('navbar', 'user'));
    }

    public function create(){
        $user = Auth::user();
        return view('sections.dashboard', compact('user'));
    }

    public function landing(){
        return view('auth.landing');
    }

    public function setLanguage($locale)
    {
        $currentuser = Auth::user();
        $user = User::find($currentuser->id);
        $data['language']= $locale;
        $user->update($data);
        return redirect()->back();
    }
}
