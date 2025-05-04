<?php



namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AvailabilityController extends Controller
{
    public function edit()
    {
        $availability = DB::table('availability')
            ->where('user_id', Auth::id())
            ->get();


        return view('availability.edit', compact('availability'));
    }


    public function update(Request $request)
    {
        $userId = Auth::id();


        // Delete old availability
        DB::table('availability')->where('user_id', $userId)->delete();


        // Insert new availability from request
        if ($request->has('availability')) {
            foreach ($request->availability as $item) {
                DB::table('availability')->insert([
                    'user_id' => $userId,
                    'day_of_week' => $item['day_of_week'],
                    'start_time' => $item['start_time'],
                    'end_time' => $item['end_time'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return redirect('/dashboard')->with('success', 'Availability updated successfully.');
    }
}
