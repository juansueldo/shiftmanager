<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DashboardWidget;
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
        $widgets = DashboardWidget::where('user_id', $user->id)->get();
        $dashboard = $this->create();
        return view('layouts.main', compact('sidebar', 'navbar', 'user', 'dashboard', 'widgets'));
    }

    public function navbar(){
        $navbar = $this->navbarconfig['menu'];
        $user = Auth::user();
        return view('layouts.partials.navbar', compact('navbar', 'user'));
    }

    public function create(){
        $user = Auth::user();
        $widgets = DashboardWidget::where('user_id', $user->id)->get();
        return view('sections.dashboard', compact('user', 'widgets'));
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
    public function updateWidgets(Request $request)
    {
        $user= Auth::user();
        $data = $request->input('widgets');
        foreach ($data as $widget) {
            DashboardWidget::where('id', $widget['id'])
                ->where('user_id', $user->id)
                ->update([
                    'x' => $widget['x'],
                    'y' => $widget['y'],
                    'width' => $widget['width'],
                    'height' => $widget['height'],
            ]);
    }

    return response()->json(['success' => true]);
    }
}
