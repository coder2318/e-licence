<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Application\CreateRequest;
use App\Http\Requests\V1\Application\IndexRequest;
use App\Http\Requests\V1\Application\UpdateRequest;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    public function __construct(protected ApplicationService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cabinet.application.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cabinet.application.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->route('application.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $application = $this->service->show($id);
        return view('cabinet.application.show', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $this->service->edit($request->validated(), $id);
        return redirect()->route('application.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('cabinet.application.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->route('application.index');
    }
}
