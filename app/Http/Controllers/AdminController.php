<?php

namespace App\Http\Controllers;

use App\Models\Bhumidan;
use App\Models\BookingInquiry;
use App\Models\ContactMessage;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Overview
     */
    public function dashboard()
    {
        $stats = [
            'total_yards' => Bhumidan::sum('sq_yards'),
            'total_donation' => Bhumidan::sum('total_amount'),
            'total_donors' => Bhumidan::count(),
            'new_inquiries' => BookingInquiry::where('status', 'new')->count(),
            'total_inquiries' => BookingInquiry::count(),
            'total_members' => Member::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentDonations = Bhumidan::orderBy('id', 'desc')->take(5)->get();
        $recentInquiries = BookingInquiry::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentDonations', 'recentInquiries'));
    }

    /**
     * Manage Bhumidan Donors
     */
    public function bhumidans(Request $request)
    {
        $query = Bhumidan::orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('village', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bhumidans = $query->paginate(20);

        return view('admin.bhumidans', compact('bhumidans'));
    }

    /**
     * Update Bhumidan Status
     */
    public function updateBhumidanStatus(Request $request, $id)
    {
        $donation = Bhumidan::findOrFail($id);
        $donation->update([
            'status' => $request->input('status', 'verified'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->back()->with('success', 'દાતાની વિગતો સફળતાપૂર્વક અપડેટ થઈ ગઈ છે.');
    }

    /**
     * Manage Booking Inquiries
     */
    public function bookings(Request $request)
    {
        $query = BookingInquiry::orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(20);

        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Update Booking Inquiry Status
     */
    public function updateBookingStatus(Request $request, $id)
    {
        $booking = BookingInquiry::findOrFail($id);
        $booking->update([
            'status' => $request->input('status'),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return redirect()->back()->with('success', 'બુકિંગ ઇન્ક્વાયરી સ્ટેટસ અપડેટ થઈ ગયું છે.');
    }

    /**
     * Manage Members Directory
     */
    public function members(Request $request)
    {
        $query = Member::orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('native_village', 'like', "%{$search}%")
                    ->orWhere('member_code', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(20);

        return view('admin.members', compact('members'));
    }

    /**
     * Manage Contact Messages
     */
    public function messages()
    {
        $messages = ContactMessage::orderBy('id', 'desc')->paginate(20);
        ContactMessage::where('is_read', false)->update(['is_read' => true]);

        return view('admin.messages', compact('messages'));
    }
}
