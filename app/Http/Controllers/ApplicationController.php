<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): Response
    {
        $applications = Application::all();

        return view('application.index', compact('applications'));
    }

    public function create(Request $request): Response
    {
        return view('application.create');
    }

    public function store(ApplicationStoreRequest $request): Response
    {
        $application = Application::create($request->validated());

        $request->session()->flash('application.id', $application->id);

        return redirect()->route('applications.index');
    }

    public function show(Request $request, Application $application): Response
    {
        return view('application.show', compact('application'));
    }

    public function edit(Request $request, Application $application): Response
    {
        return view('application.edit', compact('application'));
    }

    public function update(ApplicationUpdateRequest $request, Application $application): Response
    {
        $application->update($request->validated());

        $request->session()->flash('application.id', $application->id);

        return redirect()->route('applications.index');
    }

    public function destroy(Request $request, Application $application): Response
    {
        $application->delete();

        return redirect()->route('applications.index');
    }
}
