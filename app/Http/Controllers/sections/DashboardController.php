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
        $widgets = DashboardWidget::where('user_id', $user->id, )->where('status', 1)->get();
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
        $widgets = DashboardWidget::where('user_id', $user->id, )->where('status', 1)->get();
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
    public function createWidget($name)
    {

        $user = Auth::user();
        // Verificar si el widget ya existe para el usuario
        $existingWidget = DashboardWidget::where('user_id', $user->id)->where('name', $name)->first();
        if ($existingWidget) {
            return redirect()->route('dashboard.create')->with('error',__('dashboard.widget_exists'));
        }
        DashboardWidget::create([
            'user_id' => $user->id,
            'name' => $name,
            'x' => 0, 
            'y' => 0, 
            'width' => 4, 
            'height' => 2, 
            'status' => 1,
        ]);

        return redirect()->route('dashboard.create')->with('success', __('dashboard.widget_created'));
    }

    public function deleteWidget($id){
        $user = Auth::user();
        $widget = DashboardWidget::where('id', $id)->where('user_id', $user->id)->first();
        if ($widget) {
            $widget->delete();
            return redirect()->route('dashboard.create')->with('success', __('dashboard.widget_deleted'));
        } else {
            return response()->json(['success' => false, 'message' => __('dashboard.widget_not_found')]);
        }
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
