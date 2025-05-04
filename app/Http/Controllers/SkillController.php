<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SkillController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $skills = DB::table('skills')->where('user_id', $user->id)->pluck('name')->toArray();
        return view('skills.edit', compact('skills'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
        ]);


        DB::table('skills')->where('user_id', $user->id)->delete();


        if ($request->skills) {
            foreach ($request->skills as $skill) {
                DB::table('skills')->insert([
                    'user_id' => $user->id,
                    'name' => $skill,
                ]);
            }
        }


        return redirect('/dashboard')->with('success', 'Skills updated successfully.');
    }
}
