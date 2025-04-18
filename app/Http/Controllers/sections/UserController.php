<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    protected $yamlconfig;

    public function __construct()
    {
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/users');
    }

    public function index()
    {
        $table = $this->yamlconfig['table'];
        return view('sections.users', compact('table'));
    }

    public function data(Request $request){
        $query = User::filter($request->all());
        
        // Paginación para DataTables
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage + 1;
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        // Formatear datos
        foreach ($data as $key => $value) {
            $data[$key]['firstname'] = $this->getAvatar($value['avatar'], $value['firstname'], $value['lastname']);
            $data[$key]['status_name']= $this->showStatus($data[$key]['status_name']);
            $data[$key]['actions'] = $this->getActions($this->yamlconfig['table']['actions'], [$value['id']]); // Puedes agregar más lógica aquí
        }

        return response()->json([
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }
    private function getAvatar($avatar, $firstname, $lastname)
    {
        return '<div class="d-flex justify-content-start align-items-center user-name">' .
                    '<div class="avatar-wrapper">' .
                        '<div class="avatar me-2">' .
                            '<img src="' . asset($avatar) . '" alt="Avatar" class="rounded-circle" width="40" height="40">' .
                        '</div>' .
                    '</div>' .
                    '<div class="d-flex flex-column">' .
                        '<span class="emp_name text-truncate h6 mb-0">'.$firstname .' '.$lastname.'</span>' .
                        '<small class="emp_post text-truncate">Cost Accountant</small>' .
                    '</div>' .
                '</div>';
    }
    

    public function add($id=0){
        $inputs = $this->yamlconfig['inputs'];
        $formdata = $this->yamlconfig['form'];
        $user = null;

        if ($id > 0) {
            $user = User::find($id);
            if ($user) {
                foreach ($inputs as &$input) {
                    if (isset($user->{$input['name']})) {
                        if($input['name'] === 'password'){
                            $input['value'] = '';
                        }else{
                            $input['value'] = $user->{$input['name']};
                        }
                    }
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'user'));
    }

    public function store(Request $request){
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
            'password' => $request->id == 0 ? 'required|string|min:8' : 'nullable|string|min:8',
        ]);
       
        try {
            if($request->id > 0){
                $user = User::find($request->id);
                if ($user) {
                    $data=[];
                    $data['firstname']= $request->firstname;
                    $data['lastname']= $request->lastname;
                    $data['email']= $request->email;
                    if($request->password != null){
                        $data['password']= Hash::make($request->password);
                    }
                    $user->update($data);
                    return redirect()->route('users.index')->with('success', __('user.user_updated'));
                }
            }else{
                User::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'avatar' => 'http://127.0.0.1:8000/storage/uploads/users/9bcDcCzzjy.png'
                ]);
    
                //return redirect()->route('users.index')->with('success', 'User created successfully!');
                return redirect()->route('users.index')->with('success', __('user.user_created'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('user.error_occurred'));
        }
    }
    
}
