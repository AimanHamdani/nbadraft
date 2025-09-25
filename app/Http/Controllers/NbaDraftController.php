<?php

namespace App\Http\Controllers;

use App\Models\NBADraft; // <-- fix this
use Illuminate\Http\Request;

class NbaDraftController extends Controller
{
    // Display all NBA draft picks
    public function index() {
        $drafts = NBADraft::all(); // Always pass all draft picks
        return view('dashboard', compact('drafts'));
    }

    // Show form to edit a draft pick
    public function edit(NBADraft $nbaDraft) {
        $drafts = NBADraft::all(); // Pass full list for the table
        return view('dashboard', compact('drafts', 'nbaDraft'));
    }

    // Store a new draft pick
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'draft_year' => 'required|integer',
            'pick_number' => 'required|integer',
        ]);

        NBADraft::create($request->all());
        return redirect()->route('nba.index')->with('success', 'Player added!');
    }

    // Update an existing draft pick
    public function update(Request $request, NBADraft $nbaDraft) {
        $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'draft_year' => 'required|integer',
            'pick_number' => 'required|integer',
        ]);

        $nbaDraft->update($request->all());
        return redirect()->route('nba.index')->with('success', 'Player updated!');
    }

    // Delete a draft pick
    public function destroy(NBADraft $nbaDraft) {
        $nbaDraft->delete();
        return redirect()->route('nba.index')->with('success', 'Player deleted!');
    }
}
