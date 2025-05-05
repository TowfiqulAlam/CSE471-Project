<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Endorsement;


class EndorsementController extends Controller
{
    public function index()
    {
        $endorsements = Endorsement::whereHas('task', function ($query) {
            $query->where('job_seeker_id', auth()->id());
        })->orderBy('created_at', 'desc')->get();
    
        return view('endorsements.index', compact('endorsements'));
    }
}
