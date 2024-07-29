<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Action\CreateRequest;
use App\Http\Requests\V1\Action\IndexRequest;
use App\Http\Requests\V1\Action\UpdateRequest;
use App\Models\Action;
use App\Models\User;
use App\Services\ActionService;
use Illuminate\Http\Request;

class ActionController extends Controller
{

    public function __construct(protected ActionService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $params = $request->all();
        $actions = $this->service->get($params);
        return response()->json($actions);
        return view('cabinet.application.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        return $this->service->create($request->validated());

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $action = $this->service->show($id);
        return response()->json($action);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->service->edit($request->validated(), $id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('application.index');
    }
}
