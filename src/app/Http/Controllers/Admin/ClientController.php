<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:list clients', ['only' => ['index', 'show']]);
        $this->middleware('can:create clients', ['only' => ['create', 'store']]);
        $this->middleware('can:edit clients', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete clients', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $clients = Client::orderByDesc("created_at")->paginate(10);
        return view("admin.clients.index", ['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreClientRequest $request): Redirector|RedirectResponse|Application
    {
        $localRequest = ['auth_type' => 'local', "password" => Str::random(32)];
        $client = Client::create($request->validated() + $localRequest);
        return redirect(route("admin.clients.show", ['client' => $client->id]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view("admin.clients.create");
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return Application|Factory|View
     */
    public function show(Client $client): Application|Factory|View
    {
        return view("admin.clients.show", ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\UpdateClientRequest $request
     * @param Client $client
     * @return Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
