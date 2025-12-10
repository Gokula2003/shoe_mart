<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAfterCareController extends Controller
{
    public function index()
    {
        $reservations = DB::table('aftercare_reservations')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.aftercare.index', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        DB::table('aftercare_reservations')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.aftercare.index')->with('success', 'Reservation status updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('aftercare_reservations')
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.aftercare.index')->with('success', 'Reservation deleted successfully!');
    }
}
