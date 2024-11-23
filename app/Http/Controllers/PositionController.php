<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionStoreRequest;
use App\Http\Requests\PositionUpdateRequest;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(Request $request): Response
    {
        $positions = Position::all();

        return view('position.index', compact('positions'));
    }

    public function create(Request $request): Response
    {
        return view('position.create');
    }

    public function store(PositionStoreRequest $request): Response
    {
        $position = Position::create($request->validated());

        $request->session()->flash('position.id', $position->id);

        return redirect()->route('positions.index');
    }

    public function show(Request $request, Position $position): Response
    {
        return view('position.show', compact('position'));
    }

    public function edit(Request $request, Position $position): Response
    {
        return view('position.edit', compact('position'));
    }

    public function update(PositionUpdateRequest $request, Position $position): Response
    {
        $position->update($request->validated());

        $request->session()->flash('position.id', $position->id);

        return redirect()->route('positions.index');
    }

    public function destroy(Request $request, Position $position): Response
    {
        $position->delete();

        return redirect()->route('positions.index');
    }
}
