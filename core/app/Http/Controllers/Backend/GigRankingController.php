<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GigRankingAlgorithm;
use Illuminate\Http\Request;

class GigRankingController extends Controller
{
    public function index()
    {
        $algorithms = GigRankingAlgorithm::all();
        return view('backend.pages.gig-rankings.index', compact('algorithms'));
    }

    public function toggleStatus($id)
    {
        // Deactivate all algorithms first
        GigRankingAlgorithm::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected algorithm
        $algorithm = GigRankingAlgorithm::findOrFail($id);
        $algorithm->is_active = true;
        $algorithm->save();
    
        return redirect()->back()->with('success', 'Algorithm status updated. Only this algorithm is active now.');
    }
}
