<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-settings');
    }

    public function index()
    {
        $this->authorize('manage-settings');

        $company = Company::firstOrNew();
        return view('settings.index', compact('company'));
    }

    public function updateCompany(Request $request)
    {

        $this->authorize('manage-settings');

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
        
        // Forçar a criação se não existir
        if (!$company->exists) {
            $company->save();
        }

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company', 'public');
        }

        // Atualização que disparará o Observer
        $company->update($data);

        return back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function users()
    {
        $this->authorize('manage-settings');

        $users = User::with('permissions')->get();
        $permissions = Permission::all();
        return view('settings.users', compact('users', 'permissions'));
    }

    public function updateUserPermissions(Request $request, User $user)
    {
        $this->authorize('manage-settings');

        $oldPermissions = $user->permissions->pluck('id')->toArray();
        $newPermissions = $request->permissions ?? [];
        
        // Identificar mudanças específicas
        $added = array_diff($newPermissions, $oldPermissions);
        $removed = array_diff($oldPermissions, $newPermissions);
        
        $changes = [
            'permissions' => [
                'old' => $oldPermissions,
                'new' => $newPermissions,
                'added' => array_values($added),
                'removed' => array_values($removed)
            ]
        ];
        
        $user->permissions()->sync($newPermissions);
        
        // Registrar no log de atividades com detalhes específicos
        ActivityLogger::log(
            event: 'permissions_updated',
            model: $user,
            oldData: ['permissions' => $oldPermissions],
            newData: ['permissions' => $newPermissions],
            description: $this->generatePermissionChangeDescription($user, $added, $removed)
        );
        
        return back()->with('success', 'Permissões atualizadas com sucesso!');
    }

    protected function generatePermissionChangeDescription(User $user, array $added, array $removed): string
    {
        $this->authorize('manage-settings');
        
        $description = "Permissões do usuário {$user->name} atualizadas. ";
        
        if (!empty($added)) {
            $addedNames = Permission::whereIn('id', $added)->pluck('name')->implode(', ');
            $description .= "Adicionadas: {$addedNames}. ";
        }
        
        if (!empty($removed)) {
            $removedNames = Permission::whereIn('id', $removed)->pluck('name')->implode(', ');
            $description .= "Removidas: {$removedNames}.";
        }
        
        return trim($description);
    }
}
