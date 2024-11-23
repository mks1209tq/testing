<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyStoreRequest;
use App\Http\Requests\VacancyUpdateRequest;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyController extends Controller
{
    public function index(Request $request): Response
    {
        $vacancies = Vacancy::all();

        return view('vacancy.index', compact('vacancies'));
    }

    public function create(Request $request): Response
    {
        return view('vacancy.create');
    }

    public function store(VacancyStoreRequest $request): Response
    {
        $vacancy = Vacancy::create($request->validated());

        $request->session()->flash('vacancy.id', $vacancy->id);

        return redirect()->route('vacancies.index');
    }

    public function show(Request $request, Vacancy $vacancy): Response
    {
        return view('vacancy.show', compact('vacancy'));
    }

    public function edit(Request $request, Vacancy $vacancy): Response
    {
        return view('vacancy.edit', compact('vacancy'));
    }

    public function update(VacancyUpdateRequest $request, Vacancy $vacancy): Response
    {
        $vacancy->update($request->validated());

        $request->session()->flash('vacancy.id', $vacancy->id);

        return redirect()->route('vacancies.index');
    }

    public function destroy(Request $request, Vacancy $vacancy): Response
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index');
    }
}
