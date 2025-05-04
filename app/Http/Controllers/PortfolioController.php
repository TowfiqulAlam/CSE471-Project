<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;




class PortfolioController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // Fetch the portfolio data for the authenticated user
        $portfolio = DB::table('portfolios')->where('user_id', $user->id)->first();


        return view('portfolio.edit', compact('portfolio'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link' => 'nullable|url|max:500',
        ]);


        // Update or insert portfolio data
        DB::table('portfolios')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
            ]
        );


        return redirect('/dashboard')->with('success', 'Portfolio updated successfully.');
    }
   
   
}
