<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreUpdateClientRequest;

class ClientController extends Controller
{
    public function __construct(Client $repository)
    {
        $this->repository = $repository;
        $this->middleware(['auth', 'verified']);
        $this->title = 'Clientes';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'     => $this->title,
            'clients'   => auth()->user()->getClients()
        ];

        return view('clients.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'     => $this->title,
        ];

        return view('clients.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateClientRequest $request)
    {
        $data = $request->all();
        
        $client = Client::create([
            'owner_id'      => auth()->user()->id,
            'name'          => $data['name'],
            'email'         => $data['email'],
            'cpf_cnpj'      => $data['cpf_cnpj'],
            'postal_code'   => $data['postal_code'],
            'address'       => $data['address'],
            'city'          => $data['city'],
            'state'         => $data['state'],
            'phone'         => $data['phone'],
        ]);

        Alert::success(__('Success'), "The client was successfully added");
        
        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->repository->where('id', $id)->first();

        $data = [
            'title'     => $this->title,
            'client'    => $client,
            'readonly'  => true
        ];

        return view('clients.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title'     => $this->title,
            'client'    => $this->repository->find($id)
        ];

        return view('clients.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClientRequest $request, $id)
    {
        $client = $this->repository->where('id', $id)->first();

        $client->update($request->all());
        
        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
