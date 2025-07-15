<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-settings');
    }

    public function index()
    {
        $company = Company::firstOrNew();
        return view('settings.index', compact('company'));
    }

    public function updateCompany(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'cnpj' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'social_media' => 'nullable|array'
        ]);

        $company = Company::firstOrNew();
        
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company', 'public');
        }

        $company->fill($data);
        $company->save();

        return back()->with('success', 'Dados da empresa atualizados com sucesso!');
    }

    public function users()
    {
        $users = User::with('permissions')->get();
        $permissions = Permission::all();
        return view('settings.users', compact('users', 'permissions'));
    }

    public function updateUserPermissions(Request $request, User $user)
    {
        $user->permissions()->sync($request->permissions);
        return back()->with('success', 'Permissões atualizadas com sucesso!');
    }
}
