<?php

namespace App\Http\Controllers;

use App\Models\Bhumidan;
use App\Models\BookingInquiry;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Member;
use App\Models\Trustee;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the grand Home Page
     */
    public function index()
    {
        $totalYards = (int) Bhumidan::where('status', 'verified')->sum('sq_yards');
        $totalDonation = (float) Bhumidan::where('status', 'verified')->sum('total_amount');
        $totalDonorsCount = Bhumidan::where('status', 'verified')->count();

        $trustees = Trustee::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->take(6)
            ->get();

        $featuredDonors = Bhumidan::where('status', 'verified')
            ->orderBy('sq_yards', 'desc')
            ->take(6)
            ->get();

        $galleryItems = GalleryItem::orderBy('id', 'desc')
            ->take(6)
            ->get();

        $upcomingEvents = Event::where('is_active', true)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        return view('pages.home', compact(
            'totalYards',
            'totalDonation',
            'totalDonorsCount',
            'trustees',
            'featuredDonors',
            'galleryItems',
            'upcomingEvents'
        ));
    }

    /**
     * Display Samaj Events Page (Upcoming & Past Events)
     */
    public function events(Request $request): View
    {
        $category = $request->query('category');
        $query = Event::where('is_active', true)->orderBy('event_date', 'asc');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $upcomingEvents = (clone $query)->where('event_date', '>=', now()->toDateString())->paginate(9);
        $pastEvents = Event::where('is_active', true)
            ->where('event_date', '<', now()->toDateString())
            ->orderBy('event_date', 'desc')
            ->take(6)
            ->get();

        return view('pages.events', compact('upcomingEvents', 'pastEvents', 'category'));
    }

    /**
     * Display the Project & Sankalp page (Section-1 & Section-2 details)
     */
    public function sankalp()
    {
        return view('pages.sankalp');
    }

    /**
     * Display the Bhumidan (1 sq. yard = Rs. 2500) Page
     */
    public function bhumidan(Request $request)
    {
        $search = $request->query('search');

        $donorsQuery = Bhumidan::where('status', 'verified')->orderBy('id', 'desc');

        if ($search) {
            $donorsQuery->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                    ->orWhere('village', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100, 500])) {
            $perPage = 10;
        }

        $donors = $donorsQuery->paginate($perPage)->withQueryString();
        $totalYards = (int) Bhumidan::where('status', 'verified')->sum('sq_yards');
        $totalDonation = (float) Bhumidan::where('status', 'verified')->sum('total_amount');
        $totalDonors = Bhumidan::where('status', 'verified')->count();

        return view('pages.bhumidan', compact('donors', 'totalYards', 'totalDonation', 'totalDonors', 'search'));
    }

    /**
     * Store Bhumidan Pledge / Donation
     */
    public function storeBhumidan(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'village' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'sq_yards' => 'required|integer|min:1|max:1000',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:100',
            'payment_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'notes' => 'nullable|string|max:1000',
        ]);

        $receiptNumber = 'LPS-JND-'.date('Y').'-'.strtoupper(Str::random(5));
        $totalAmount = $validated['sq_yards'] * 2500;

        // Process optional payment screenshot upload
        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $file = $request->file('payment_screenshot');
            $fileName = 'bhumidan_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $destination = public_path('uploads/payment_screenshots');
            if (! file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            $screenshotPath = 'uploads/payment_screenshots/'.$fileName;
        }

        $donation = Bhumidan::create([
            'receipt_number' => $receiptNumber,
            'donor_name' => $validated['donor_name'],
            'donor_name_gujarati' => $validated['donor_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'village' => $validated['village'] ?? null,
            'city' => $validated['city'],
            'sq_yards' => $validated['sq_yards'],
            'rate_per_yard' => 2500,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_screenshot' => $screenshotPath,
            'status' => 'verified', // Pledged or verified
            'notes' => $validated['notes'] ?? null,
        ]);

        // Record Activity Log
        ActivityLogger::log(
            action: 'bhumidan_submitted',
            description: "શ્રી {$donation->donor_name} દ્વારા {$donation->sq_yards} વાર (₹ ".number_format($donation->total_amount).') નું ઓનલાઇન ભૂમિદાન સંકલ્પ ફોર્મ સબમિટ કરવામાં આવ્યું.',
            request: $request,
            extraPayload: [
                'receipt_number' => $donation->receipt_number,
                'donor_name' => $donation->donor_name,
                'phone' => $donation->phone,
                'city' => $donation->city,
                'sq_yards' => $donation->sq_yards,
                'total_amount' => (float) $donation->total_amount,
                'payment_method' => $donation->payment_method,
                'transaction_id' => $donation->transaction_id,
                'has_screenshot' => ! empty($screenshotPath),
            ],
            userType: 'public',
            userName: $donation->donor_name,
            userContact: $donation->phone
        );

        return redirect()->route('bhumidan')
            ->with('success', 'તમારા ભૂમિદાન સંકલ્પની નોંધણી સફળતાપૂર્વક થઈ ગઈ છે (સંકલ્પ ક્રમાંક: '.$donation->receipt_number.'). ટ્રસ્ટ કાર્યાલય દ્વારા ચકાસણી કરીને સત્તાવાર રસીદ આપને આપવામાં આવશે. આપનો હૃદયપૂર્વક આભાર!');
    }

    /**
     * View Digital Donation Receipt (Admin / Office view only)
     */
    public function receipt($receiptNumber)
    {
        if (! Auth::check()) {
            return redirect()->route('bhumidan')
                ->with('info', 'સત્તાવાર દાન રસીદ ફક્ત ટ્રસ્ટ કાર્યાલય / એડમિન દ્વારા આપવામાં આવે છે.');
        }

        $donation = Bhumidan::where('receipt_number', $receiptNumber)->firstOrFail();

        return view('pages.receipt', compact('donation'));
    }

    /**
     * Facility Booking Inquiry page
     */
    public function booking()
    {
        return view('pages.booking');
    }

    /**
     * Store Facility Booking Inquiry
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'city_or_village' => 'nullable|string|max:255',
            'section_type' => 'required|string',
            'facility_name' => 'required|string',
            'event_type' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'approx_guests' => 'required|integer|min:10',
            'required_rooms' => 'nullable|integer|min:0',
            'user_notes' => 'nullable|string|max:1000',
        ]);

        $inquiryNumber = 'INQ-'.date('Ymd').'-'.rand(100, 999);

        BookingInquiry::create([
            'inquiry_number' => $inquiryNumber,
            'applicant_name' => $validated['applicant_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'city_or_village' => $validated['city_or_village'] ?? null,
            'section_type' => $validated['section_type'],
            'facility_name' => $validated['facility_name'],
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'approx_guests' => $validated['approx_guests'],
            'required_rooms' => $validated['required_rooms'] ?? 0,
            'user_notes' => $validated['user_notes'] ?? null,
            'status' => 'new',
        ]);

        // Record Activity Log
        ActivityLogger::log(
            action: 'booking_inquiry_submitted',
            description: "શ્રી {$validated['applicant_name']} દ્વારા {$validated['facility_name']} ({$validated['section_type']}) માટે હોલ/પ્લોટ બુકિંગ ઇન્ક્વાયરી સબમિટ કરવામાં આવી.",
            request: $request,
            extraPayload: [
                'inquiry_number' => $inquiryNumber,
                'applicant_name' => $validated['applicant_name'],
                'phone' => $validated['phone'],
                'facility_name' => $validated['facility_name'],
                'section_type' => $validated['section_type'],
                'event_type' => $validated['event_type'],
                'event_date' => $validated['event_date'],
                'approx_guests' => $validated['approx_guests'],
            ],
            userType: 'public',
            userName: $validated['applicant_name'],
            userContact: $validated['phone']
        );

        return redirect()->back()->with('success', 'તમારી બુકિંગ ઇન્ક્વાયરી ('.$inquiryNumber.') નોંધાઈ ગઈ છે! ટ્રસ્ટ કાર્યાલય દ્વારા ટૂંક સમયમાં તમારો સંપર્ક કરવામાં આવશે.');
    }

    /**
     * Trustees and Committee Directory
     */
    public function trustees()
    {
        $trustees = Trustee::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->get();

        return view('pages.trustees', compact('trustees'));
    }

    /**
     * Photo & Video Gallery
     */
    public function gallery(Request $request)
    {
        $category = $request->query('category');
        $query = GalleryItem::orderBy('id', 'desc');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $items = $query->paginate(12);

        return view('pages.gallery', compact('items', 'category'));
    }

    /**
     * Community Membership Form
     */
    public function membership()
    {
        return view('pages.membership');
    }

    /**
     * Store Member Registration
     */
    public function storeMembership(Request $request)
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
        ]);

        $code = 'LPS-M-'.rand(1000, 9999);

        Member::create(array_merge($validated, [
            'member_code' => $code,
            'status' => 'approved',
        ]));

        // Record Activity Log
        ActivityLogger::log(
            action: 'membership_registered',
            description: "શ્રી {$validated['full_name']} દ્વારા સમાજ ડિરેક્ટરીમાં સભ્યપદ રજીસ્ટ્રેશન કરવામાં આવ્યું (સભ્ય ક્રમાંક: {$code}).",
            request: $request,
            extraPayload: [
                'member_code' => $code,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'native_village' => $validated['native_village'] ?? null,
                'family_members_count' => $validated['family_members_count'],
            ],
            userType: 'public',
            userName: $validated['full_name'],
            userContact: $validated['phone']
        );

        return redirect()->back()->with('success', 'સમાજ ડિરેક્ટરીમાં તમારું રજીસ્ટ્રેશન સફળ થયું છે! તમારો સભ્ય ક્રમાંક: '.$code);
    }

    /**
     * Contact and Location Page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Store Contact Message
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        // Record Activity Log
        ActivityLogger::log(
            action: 'contact_message_sent',
            description: "શ્રી {$validated['name']} તરફથી સંપર્ક સંદેશ મોકલવામાં આવ્યો: '{$validated['subject']}'.",
            request: $request,
            extraPayload: [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'subject' => $validated['subject'],
            ],
            userType: 'public',
            userName: $validated['name'],
            userContact: $validated['phone']
        );

        return redirect()->back()->with('success', 'તમારો સંદેશો સફળતાપૂર્વક મોકલાઈ ગયો છે. આભાર!');
    }
}
