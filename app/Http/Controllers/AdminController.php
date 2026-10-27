<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Bhumidan;
use App\Models\BookingInquiry;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Member;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Overview
     */
    public function dashboard(): View
    {
        $stats = [
            'total_yards' => (int) Bhumidan::sum('sq_yards'),
            'total_donation' => (float) Bhumidan::sum('total_amount'),
            'total_donors' => Bhumidan::count(),
            'new_inquiries' => BookingInquiry::where('status', 'new')->count(),
            'total_inquiries' => BookingInquiry::count(),
            'total_members' => Member::count(),
            'total_gallery' => GalleryItem::count(),
            'total_events' => Event::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentDonations = Bhumidan::orderBy('id', 'desc')->take(5)->get();
        $recentInquiries = BookingInquiry::orderBy('id', 'desc')->take(5)->get();
        $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())->orderBy('event_date', 'asc')->take(3)->get();

        return view('admin.dashboard', compact('stats', 'recentDonations', 'recentInquiries', 'upcomingEvents'));
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Bhumidan Donors CRUD
    |--------------------------------------------------------------------------
    */
    public function bhumidans(Request $request): View
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

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $bhumidans = $query->paginate($perPage)->withQueryString();

        return view('admin.bhumidans', compact('bhumidans'));
    }

    public function createBhumidan(): View
    {
        return view('admin.bhumidans_form', [
            'mode' => 'create',
            'bhumidan' => new Bhumidan(['sq_yards' => 1, 'rate_per_yard' => 2500, 'status' => 'verified', 'payment_method' => 'Cash']),
        ]);
    }

    public function storeBhumidan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'village' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'sq_yards' => 'required|integer|min:1|max:5000',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:100',
            'payment_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'status' => 'required|in:pending,verified,completed',
            'is_featured' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $file = $request->file('payment_screenshot');
            $filename = 'bhumidan_admin_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/payment_screenshots');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $screenshotPath = 'uploads/payment_screenshots/'.$filename;
        }

        $receiptNumber = 'LPS-JND-'.date('Y').'-'.strtoupper(Str::random(5));
        $rate = 2500;
        $totalAmount = $validated['sq_yards'] * $rate;

        $bhumidan = Bhumidan::create([
            'receipt_number' => $receiptNumber,
            'donor_name' => $validated['donor_name'],
            'donor_name_gujarati' => $validated['donor_name'],
            'phone' => $validated['phone'],
            'village' => $validated['village'] ?? null,
            'city' => $validated['city'],
            'sq_yards' => $validated['sq_yards'],
            'rate_per_yard' => $rate,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_screenshot' => $screenshotPath,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'notes' => $validated['notes'] ?? null,
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_bhumidan_created',
            description: "એડમિન દ્વારા નવા ભૂમિદાતા ઉમેરાયા: {$bhumidan->donor_name} ({$bhumidan->sq_yards} વાર - ₹".number_format($totalAmount).')',
            request: $request,
            extraPayload: [
                'receipt_number' => $receiptNumber,
                'donor_name' => $bhumidan->donor_name,
                'phone' => $bhumidan->phone,
                'sq_yards' => $bhumidan->sq_yards,
                'total_amount' => $totalAmount,
            ]
        );

        return redirect()->route('admin.bhumidans')->with('success', 'નવા ભૂમિદાતાની નોંધણી સફળતાપૂર્વક થઈ ગઈ છે! રસીદ નંબર: '.$receiptNumber);
    }

    public function editBhumidan($id): View
    {
        $bhumidan = Bhumidan::findOrFail($id);

        return view('admin.bhumidans_form', [
            'mode' => 'edit',
            'bhumidan' => $bhumidan,
        ]);
    }

    public function updateBhumidanRecord(Request $request, $id): RedirectResponse
    {
        $bhumidan = Bhumidan::findOrFail($id);

        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'village' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'sq_yards' => 'required|integer|min:1|max:5000',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:100',
            'payment_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'status' => 'required|in:pending,verified,completed',
            'is_featured' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $screenshotPath = $bhumidan->payment_screenshot;
        if ($request->hasFile('payment_screenshot')) {
            $file = $request->file('payment_screenshot');
            $filename = 'bhumidan_admin_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/payment_screenshots');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $screenshotPath = 'uploads/payment_screenshots/'.$filename;
        }

        $totalAmount = $validated['sq_yards'] * 2500;

        $bhumidan->update([
            'donor_name' => $validated['donor_name'],
            'donor_name_gujarati' => $validated['donor_name'],
            'phone' => $validated['phone'],
            'village' => $validated['village'] ?? null,
            'city' => $validated['city'],
            'sq_yards' => $validated['sq_yards'],
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_screenshot' => $screenshotPath,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'notes' => $validated['notes'] ?? null,
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_bhumidan_updated',
            description: "એડમિન દ્વારા દાતા વિગતો સુધારાઈ: {$bhumidan->donor_name} (રસીદ: {$bhumidan->receipt_number})",
            request: $request,
            extraPayload: ['receipt_number' => $bhumidan->receipt_number]
        );

        return redirect()->route('admin.bhumidans')->with('success', 'દાતાશ્રીની વિગતો સફળતાપૂર્વક સુધારાઈ ગઈ છે.');
    }

    public function updateBhumidanStatus(Request $request, $id): RedirectResponse
    {
        $donation = Bhumidan::findOrFail($id);
        $donation->update([
            'status' => $request->input('status', 'verified'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_bhumidan_status_changed',
            description: "દાતા સ્ટેટસ બદલાયું ({$donation->receipt_number}): {$donation->status}",
            request: $request,
            extraPayload: ['receipt_number' => $donation->receipt_number, 'status' => $donation->status]
        );

        return redirect()->back()->with('success', 'દાતાની વિગતો સફળતાપૂર્વક અપડેટ થઈ ગઈ છે.');
    }

    public function deleteBhumidan($id): RedirectResponse
    {
        $bhumidan = Bhumidan::findOrFail($id);
        $receipt = $bhumidan->receipt_number;
        $name = $bhumidan->donor_name;
        $bhumidan->delete();

        ActivityLogger::logAdmin(
            action: 'admin_bhumidan_deleted',
            description: "એડમિન દ્વારા દાતા રેકોર્ડ ડીલીટ કરાયો: {$name} ({$receipt})",
            extraPayload: ['receipt_number' => $receipt, 'donor_name' => $name]
        );

        return redirect()->route('admin.bhumidans')->with('success', 'ભૂમિદાન રસીદ ('.$receipt.') સફળતાપૂર્વક ડીલીટ કરવામાં આવી છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Hall & Plot Booking Inquiries CRUD
    |--------------------------------------------------------------------------
    */
    public function bookings(Request $request): View
    {
        $query = BookingInquiry::orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('inquiry_number', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $bookings = $query->paginate($perPage)->withQueryString();

        return view('admin.bookings', compact('bookings'));
    }

    public function createBooking(): View
    {
        return view('admin.bookings_form', [
            'mode' => 'create',
            'booking' => new BookingInquiry([
                'section_type' => 'વિભાગ-૧',
                'facility_name' => 'પાર્ટી પ્લોટ (૧૫૦૦ વ્યક્તિ માટે)',
                'event_type' => 'લગ્ન પ્રસંગ',
                'event_date' => now()->addDays(30)->toDateString(),
                'approx_guests' => 500,
                'required_rooms' => 5,
                'status' => 'confirmed',
            ]),
        ]);
    }

    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'city_or_village' => 'nullable|string|max:255',
            'section_type' => 'required|string',
            'facility_name' => 'required|string',
            'event_type' => 'required|string',
            'event_date' => 'required|date',
            'approx_guests' => 'required|integer|min:1',
            'required_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:new,in_review,confirmed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $inquiryNumber = 'INQ-'.date('Ymd').'-'.rand(100, 999);

        $booking = BookingInquiry::create(array_merge($validated, [
            'inquiry_number' => $inquiryNumber,
            'required_rooms' => $validated['required_rooms'] ?? 0,
        ]));

        ActivityLogger::logAdmin(
            action: 'admin_booking_created',
            description: "એડમિન દ્વારા નવું બુકિંગ ઉમેરાયું: {$booking->applicant_name} ({$booking->facility_name} - {$booking->event_type})",
            request: $request,
            extraPayload: [
                'inquiry_number' => $inquiryNumber,
                'applicant_name' => $booking->applicant_name,
                'phone' => $booking->phone,
                'facility_name' => $booking->facility_name,
                'event_date' => $booking->event_date,
            ]
        );

        return redirect()->route('admin.bookings')->with('success', 'નવું હોલ/પ્લોટ બુકિંગ સફળતાપૂર્વક નોંધાઈ ગયું છે! બુકિંગ નં: '.$inquiryNumber);
    }

    public function editBooking($id): View
    {
        $booking = BookingInquiry::findOrFail($id);

        return view('admin.bookings_form', [
            'mode' => 'edit',
            'booking' => $booking,
        ]);
    }

    public function updateBookingRecord(Request $request, $id): RedirectResponse
    {
        $booking = BookingInquiry::findOrFail($id);

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'city_or_village' => 'nullable|string|max:255',
            'section_type' => 'required|string',
            'facility_name' => 'required|string',
            'event_type' => 'required|string',
            'event_date' => 'required|date',
            'approx_guests' => 'required|integer|min:1',
            'required_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:new,in_review,confirmed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $booking->update($validated);

        ActivityLogger::logAdmin(
            action: 'admin_booking_updated',
            description: "એડમિન દ્વારા બુકિંગ વિગતો સુધારાઈ: {$booking->applicant_name} ({$booking->inquiry_number})",
            request: $request,
            extraPayload: ['inquiry_number' => $booking->inquiry_number]
        );

        return redirect()->route('admin.bookings')->with('success', 'બુકિંગ વિગતો સફળતાપૂર્વક સુધારાઈ ગઈ છે.');
    }

    public function updateBookingStatus(Request $request, $id): RedirectResponse
    {
        $booking = BookingInquiry::findOrFail($id);
        $booking->update([
            'status' => $request->input('status'),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_booking_status_changed',
            description: "બુકિંગ સ્ટેટસ બદલાયું ({$booking->inquiry_number}): {$booking->status}",
            request: $request,
            extraPayload: ['inquiry_number' => $booking->inquiry_number, 'status' => $booking->status]
        );

        return redirect()->back()->with('success', 'બુકિંગ ઇન્ક્વાયરી સ્ટેટસ અપડેટ થઈ ગયું છે.');
    }

    public function deleteBooking($id): RedirectResponse
    {
        $booking = BookingInquiry::findOrFail($id);
        $num = $booking->inquiry_number;
        $name = $booking->applicant_name;
        $booking->delete();

        ActivityLogger::logAdmin(
            action: 'admin_booking_deleted',
            description: "એડમિન દ્વારા બુકિંગ રેકોર્ડ ડીલીટ કરાયો: {$name} ({$num})",
            extraPayload: ['inquiry_number' => $num, 'applicant_name' => $name]
        );

        return redirect()->route('admin.bookings')->with('success', 'બુકિંગ રેકોર્ડ સફળતાપૂર્વક ડીલીટ થઈ ગયો છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Gyanti Sabhyo Directory (Members) CRUD
    |--------------------------------------------------------------------------
    */
    public function members(Request $request): View
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

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $members = $query->paginate($perPage)->withQueryString();

        return view('admin.members', compact('members'));
    }

    public function createMember(): View
    {
        return view('admin.members_form', [
            'mode' => 'create',
            'member' => new Member([
                'city' => 'જૂનાગઢ',
                'surname' => 'પટેલ',
                'gender' => 'male',
                'family_members_count' => 4,
                'status' => 'approved',
            ]),
        ]);
    }

    public function storeMember(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'father_or_husband_name' => 'nullable|string|max:255',
            'surname' => 'required|string|max:100',
            'gender' => 'required|string',
            'blood_group' => 'nullable|string|max:10',
            'native_village' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'family_members_count' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $code = 'LPS-M-'.rand(1000, 9999);

        $member = Member::create(array_merge($validated, [
            'member_code' => $code,
        ]));

        ActivityLogger::logAdmin(
            action: 'admin_member_created',
            description: "એડમિન દ્વારા નવા જ્ઞાતિ સભ્ય નોંધાયા: {$member->full_name} ({$code})",
            request: $request,
            extraPayload: ['member_code' => $code, 'full_name' => $member->full_name, 'phone' => $member->phone]
        );

        return redirect()->route('admin.members')->with('success', 'નવા જ્ઞાતિ સભ્યની નોંધણી સફળતાપૂર્વક થઈ ગઈ છે! સભ્ય કોડ: '.$code);
    }

    public function editMember($id): View
    {
        $member = Member::findOrFail($id);

        return view('admin.members_form', [
            'mode' => 'edit',
            'member' => $member,
        ]);
    }

    public function updateMemberRecord(Request $request, $id): RedirectResponse
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'father_or_husband_name' => 'nullable|string|max:255',
            'surname' => 'required|string|max:100',
            'gender' => 'required|string',
            'blood_group' => 'nullable|string|max:10',
            'native_village' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'family_members_count' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $member->update($validated);

        ActivityLogger::logAdmin(
            action: 'admin_member_updated',
            description: "એડમિન દ્વારા સભ્ય વિગતો સુધારાઈ: {$member->full_name} ({$member->member_code})",
            request: $request,
            extraPayload: ['member_code' => $member->member_code]
        );

        return redirect()->route('admin.members')->with('success', 'સભ્ય વિગતો સફળતાપૂર્વક સુધારાઈ ગઈ છે.');
    }

    public function deleteMember($id): RedirectResponse
    {
        $member = Member::findOrFail($id);
        $code = $member->member_code;
        $name = $member->full_name;
        $member->delete();

        ActivityLogger::logAdmin(
            action: 'admin_member_deleted',
            description: "એડમિન દ્વારા સભ્ય રેકોર્ડ ડીલીટ કરાયો: {$name} ({$code})",
            extraPayload: ['member_code' => $code, 'full_name' => $name]
        );

        return redirect()->route('admin.members')->with('success', 'સભ્ય રેકોર્ડ સફળતાપૂર્વક ડીલીટ થઈ ગયો છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Gallery Items Management CRUD
    |--------------------------------------------------------------------------
    */
    public function gallery(Request $request): View
    {
        $query = GalleryItem::orderBy('id', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $items = $query->paginate($perPage)->withQueryString();

        return view('admin.gallery', compact('items'));
    }

    public function createGallery(): View
    {
        return view('admin.gallery_form', [
            'mode' => 'create',
            'item' => new GalleryItem(['category' => 'events', 'media_type' => 'image', 'is_featured' => false]),
        ]);
    }

    public function storeGallery(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'media_type' => 'required|in:image,video,instagram_reel,youtube',
            'media_url' => 'required|string|max:1000',
            'thumbnail_url' => 'nullable|string|max:1000',
            'caption' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
        ]);

        $item = GalleryItem::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'media_type' => $validated['media_type'],
            'media_url' => $validated['media_url'],
            'thumbnail_url' => $validated['thumbnail_url'] ?? $validated['media_url'],
            'caption' => $validated['caption'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_gallery_created',
            description: "એડમિન દ્વારા ગેલેરી મીડિયા ઉમેરાયું: {$item->title} ({$item->media_type})",
            request: $request,
            extraPayload: ['title' => $item->title, 'category' => $item->category, 'media_type' => $item->media_type]
        );

        return redirect()->route('admin.gallery')->with('success', 'ગેલેરી આઇટમ સફળતાપૂર્વક ઉમેરાઈ ગઈ છે.');
    }

    public function editGallery($id): View
    {
        $item = GalleryItem::findOrFail($id);

        return view('admin.gallery_form', [
            'mode' => 'edit',
            'item' => $item,
        ]);
    }

    public function updateGallery(Request $request, $id): RedirectResponse
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'media_type' => 'required|in:image,video,instagram_reel,youtube',
            'media_url' => 'required|string|max:1000',
            'thumbnail_url' => 'nullable|string|max:1000',
            'caption' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
        ]);

        $item->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'media_type' => $validated['media_type'],
            'media_url' => $validated['media_url'],
            'thumbnail_url' => $validated['thumbnail_url'] ?? $validated['media_url'],
            'caption' => $validated['caption'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_gallery_updated',
            description: "એડમિન દ્વારા ગેલેરી વિગત સુધારાઈ: {$item->title}",
            request: $request,
            extraPayload: ['title' => $item->title]
        );

        return redirect()->route('admin.gallery')->with('success', 'ગેલેરી વિગતો સફળતાપૂર્વક સુધારાઈ ગઈ છે.');
    }

    public function deleteGallery($id): RedirectResponse
    {
        $item = GalleryItem::findOrFail($id);
        $title = $item->title;
        $item->delete();

        ActivityLogger::logAdmin(
            action: 'admin_gallery_deleted',
            description: "એડમિન દ્વારા ગેલેરી આઇટમ ડીલીટ કરાઈ: {$title}",
            extraPayload: ['title' => $title]
        );

        return redirect()->route('admin.gallery')->with('success', 'ગેલેરી આઇટમ સફળતાપૂર્વક ડીલીટ થઈ ગઈ છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 5. Events Management CRUD
    |--------------------------------------------------------------------------
    */
    public function events(Request $request): View
    {
        $query = Event::orderBy('event_date', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $events = $query->paginate($perPage)->withQueryString();

        return view('admin.events', compact('events'));
    }

    public function createEvent(): View
    {
        return view('admin.events_form', [
            'mode' => 'create',
            'event' => new Event([
                'category' => 'સામાજિક',
                'event_date' => now()->addDays(7)->toDateString(),
                'event_time' => 'સવારે ૯:૦૦ કલાકે',
                'venue' => 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ સંકુલ, ખલીલપુર ચોકડી પાસે, જૂનાગઢ',
                'organizer' => 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ',
                'contact_person' => 'ટ્રસ્ટ કાર્યાલય: 909 33 909 34',
                'is_featured' => true,
                'is_active' => true,
            ]),
        ]);
    }

    public function storeEvent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:100',
            'venue' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image_url' => 'nullable|string|max:1000',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']).'-'.rand(100, 999);

        $event = Event::create(array_merge($validated, [
            'slug' => $slug,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]));

        ActivityLogger::logAdmin(
            action: 'admin_event_created',
            description: "એડમિન દ્વારા નવો કાર્યક્રમ ઉમેરાયો: {$event->title} ({$event->category})",
            request: $request,
            extraPayload: ['title' => $event->title, 'category' => $event->category, 'event_date' => $event->event_date]
        );

        return redirect()->route('admin.events')->with('success', 'નવો કાર્યક્રમ (ઇવેન્ટ) સફળતાપૂર્વક ઉમેરાઈ ગયો છે!');
    }

    public function editEvent($id): View
    {
        $event = Event::findOrFail($id);

        return view('admin.events_form', [
            'mode' => 'edit',
            'event' => $event,
        ]);
    }

    public function updateEvent(Request $request, $id): RedirectResponse
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:100',
            'venue' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image_url' => 'nullable|string|max:1000',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $event->update(array_merge($validated, [
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]));

        ActivityLogger::logAdmin(
            action: 'admin_event_updated',
            description: "એડમિન દ્વારા કાર્યક્રમ વિગત સુધારાઈ: {$event->title}",
            request: $request,
            extraPayload: ['title' => $event->title]
        );

        return redirect()->route('admin.events')->with('success', 'કાર્યક્રમની વિગતો સફળતાપૂર્વક સુધારાઈ ગઈ છે.');
    }

    public function deleteEvent($id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $title = $event->title;
        $event->delete();

        ActivityLogger::logAdmin(
            action: 'admin_event_deleted',
            description: "એડમિન દ્વારા કાર્યક્રમ ડીલીટ કરાયો: {$title}",
            extraPayload: ['title' => $title]
        );

        return redirect()->route('admin.events')->with('success', 'કાર્યક્રમ સફળતાપૂર્વક ડીલીટ થઈ ગયો છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 6. Contact Messages
    |--------------------------------------------------------------------------
    */
    public function messages(Request $request): View
    {
        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $messages = ContactMessage::orderBy('id', 'desc')->paginate($perPage)->withQueryString();
        ContactMessage::where('is_read', false)->update(['is_read' => true]);

        return view('admin.messages', compact('messages'));
    }

    /*
    |--------------------------------------------------------------------------
    | 7. Admin Security & Password Settings
    |--------------------------------------------------------------------------
    */
    public function securitySettings(): View
    {
        return view('admin.security');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'હાલનો પાસવર્ડ દાખલ કરવો ફરજિયાત છે.',
            'current_password.current_password' => 'હાલનો પાસવર્ડ અમાન્ય છે.',
            'password.required' => 'નવો પાસવર્ડ દાખલ કરવો ફરજિયાત છે.',
            'password.min' => 'નવો પાસવર્ડ ઓછામાં ઓછો ૮ અક્ષરનો હોવો જોઈએ.',
            'password.confirmed' => 'નવા પાસવર્ડનું કન્ફર્મેશન મેળ ખાતું નથી.',
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLogger::logAdmin(
            action: 'admin_password_changed',
            description: 'એડમિન એકાઉન્ટ પાસવર્ડ સફળતાપૂર્વક બદલવામાં આવ્યો',
            request: $request
        );

        return redirect()->back()->with('success', 'એડમિન પાસવર્ડ સફળતાપૂર્વક બદલાઈ ગયો છે! આપનું એકાઉન્ટ સુરક્ષિત છે.');
    }

    /*
    |--------------------------------------------------------------------------
    | 8. Activity & Audit Logs
    |--------------------------------------------------------------------------
    */
    public function logs(Request $request): View
    {
        if (! Schema::hasTable('activity_logs')) {
            $stats = [
                'total' => 0,
                'today' => 0,
                'public' => 0,
                'admin' => 0,
                'mobile' => 0,
                'desktop' => 0,
            ];
            $logs = new LengthAwarePaginator([], 0, 10);

            return view('admin.logs', compact('logs', 'stats'));
        }

        $query = ActivityLog::orderBy('id', 'desc');

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->filled('device_type')) {
            $query->where('device_type', $request->device_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                    ->orWhere('user_contact', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        try {
            $stats = [
                'total' => ActivityLog::count(),
                'today' => ActivityLog::whereDate('created_at', now()->toDateString())->count(),
                'public' => ActivityLog::where('user_type', 'public')->count(),
                'admin' => ActivityLog::where('user_type', 'admin')->count(),
                'mobile' => ActivityLog::where('device_type', 'Mobile')->count(),
                'desktop' => ActivityLog::where('device_type', 'Desktop')->count(),
            ];
        } catch (\Throwable $e) {
            report($e);
            $stats = [
                'total' => 0,
                'today' => 0,
                'public' => 0,
                'admin' => 0,
                'mobile' => 0,
                'desktop' => 0,
            ];
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $logs = $query->paginate($perPage)->withQueryString();

        return view('admin.logs', compact('logs', 'stats'));
    }

    public function deleteLog($id): RedirectResponse
    {
        if (Schema::hasTable('activity_logs')) {
            $log = ActivityLog::find($id);
            if ($log) {
                $log->delete();
            }
        }

        return redirect()->back()->with('success', 'લૉગ રેકોર્ડ સફળતાપૂર્વક દૂર કરવામાં આવ્યો છે.');
    }

    public function clearOldLogs(): RedirectResponse
    {
        $deleted = 0;
        if (Schema::hasTable('activity_logs')) {
            $deleted = ActivityLog::where('created_at', '<=', now()->subDays(90))->delete();

            ActivityLogger::logAdmin(
                action: 'admin_logs_pruned',
                description: "૯૦ દિવસથી જૂના તમામ ({$deleted}) લૉગ રેકોર્ડ્સ સાફ કરવામાં આવ્યા.",
                extraPayload: ['deleted_count' => $deleted, 'retention_days' => 90]
            );
        }

        return redirect()->back()->with('success', "૯૦ દિવસથી જૂના તમામ ({$deleted}) લૉગ રેકોર્ડ્સ સફળતાપૂર્વક સાફ કરવામાં આવ્યા છે.");
    }
}
