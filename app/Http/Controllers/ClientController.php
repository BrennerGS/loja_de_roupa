<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;


class ClientController extends Controller
{
    use SoftDeletes;
    
    public function __construct()
    {
        $this->middleware('permission:manage-clients');
    }

    public function index(Request $request)
    {
        $this->authorize('manage-clients');

        $query = Client::when($request->search, function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%")
              ->orWhere('cpf', 'like', "%{$request->search}%");
        });

        $clients = $query->orderBy('name')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $this->authorize('manage-clients');
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $this->authorize('manage-clients');

        Client::create($request->validated());
        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Client $client)
    {
        $this->authorize('manage-clients');

        $client->load(['sales' => function($query) {
            $query->latest()->take(10);
        }]);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $this->authorize('manage-clients');

        return view('clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        $this->authorize('manage-clients');

        try {
            DB::beginTransaction();

            // Atualiza os dados básicos
            $client->update($request->safe()->only([
                'name',
                'email',
                'phone',
                'address',
                'cpf',
                'birth_date'
            ]));

            // Atualiza campos adicionais se necessário
            if ($request->has('notes')) {
                $client->notes = $request->input('notes');
            }

            // Salva explicitamente para garantir
            if (!$client->save()) {
                throw new Exception('Falha ao salvar as alterações do cliente');
            }

            DB::commit();

            return redirect()
                ->route('clients.index')
                ->with('success', 'Cliente atualizado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client)
    {
        $this->authorize('manage-clients');
        
        try {
            $client->delete(); // Isso deve fazer soft delete
            
            return redirect()->route('clients.index')
                ->with('success', 'Cliente movido para a lixeira!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao mover para lixeira: '.$e->getMessage());
        }
    }
}
