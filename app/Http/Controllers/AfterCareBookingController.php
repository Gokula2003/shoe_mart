<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AfterCareBookingController extends Controller
{
    public function showBookingForm()
    {
        return view('aftercare.booking');
    }

    public function submitBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:10',
            'service_type' => 'required|string',
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        DB::table('aftercare_reservations')->insert([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'service_type' => $request->service_type,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'notes' => $request->notes,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('aftercare.booking')->with('success', 'Your reservation has been submitted successfully! We will contact you soon.');
    }
}
