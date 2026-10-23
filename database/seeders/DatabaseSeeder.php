<?php

namespace Database\Seeders;

use App\Models\Bhumidan;
use App\Models\BookingInquiry;
use App\Models\GalleryItem;
use App\Models\Member;
use App\Models\Trustee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@lpsjunagadh.com'],
            [
                'name' => 'LPS Junagadh Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // Seed Trustees (from the official pamphlet)
        $trustees = [
            [
                'name' => 'શ્રી જયંતિભાઈ વઘાસીયા',
                'designation' => 'ટ્રસ્ટી / મુખ્ય દાતાશ્રી',
                'company_or_business' => 'મધુરમ કન્સ્ટ્રક્શન ઈન્ડિયા પ્રા.લી., જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'photo' => null,
                'display_order' => 1,
            ],
            [
                'name' => 'શ્રી પ્રવિણભાઈ સાવલીયા',
                'designation' => 'ટ્રસ્ટીશ્રી',
                'company_or_business' => 'ફાઈવસ્ટાર હોન્ડા, જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'photo' => null,
                'display_order' => 2,
            ],
            [
                'name' => 'શ્રી ગોપાલભાઈ રૂપપરા',
                'designation' => 'ટ્રસ્ટીશ્રી',
                'company_or_business' => 'ઓમ હ્યુન્ડાય, જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'photo' => null,
                'display_order' => 3,
            ],
            [
                'name' => 'શ્રી પરેશભાઈ ડોબરીયા',
                'designation' => 'ટ્રસ્ટીશ્રી',
                'company_or_business' => 'શિવમ્ પાર્ટી પ્લોટ, જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'photo' => null,
                'display_order' => 4,
            ],
            [
                'name' => 'શ્રી મનસુખભાઈ કચાડા',
                'designation' => 'ટ્રસ્ટીશ્રી',
                'company_or_business' => 'મેટ્રો ઓફસેટ, જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'display_order' => 5,
            ],
            [
                'name' => 'પ્રો. હરેશભાઈ કાવાણી',
                'designation' => 'વક્તા-એનાઉન્સર / માર્ગદર્શક',
                'company_or_business' => 'શિક્ષણવિદ્ & સામાજિક અગ્રણી, જૂનાગઢ',
                'city' => 'જૂનાગઢ',
                'phone' => '909 33 909 34',
                'display_order' => 6,
            ],
        ];

        foreach ($trustees as $trustee) {
            Trustee::firstOrCreate(['name' => $trustee['name']], $trustee);
        }

        // Seed Bhumidan Donors (₹2500 per sq yard)
        $donations = [
            [
                'receipt_number' => 'LPS-JND-2026-001',
                'donor_name' => 'શ્રી રમેશભાઈ હરિભાઈ પટેલ',
                'donor_name_gujarati' => 'શ્રી રમેશભાઈ હરિભાઈ પટેલ',
                'phone' => '9825012345',
                'village' => 'વંથલી',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 100,
                'rate_per_yard' => 2500,
                'total_amount' => 250000,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 'AXIS9834710294',
                'status' => 'verified',
                'is_featured' => true,
                'notes' => 'સંકલ્પ વિભાગ-૧ ના ભવ્ય નિર્માણ હેતુ',
            ],
            [
                'receipt_number' => 'LPS-JND-2026-002',
                'donor_name' => 'શ્રી બાબુભાઈ મનજીભાઈ સાવલીયા',
                'donor_name_gujarati' => 'શ્રી બાબુભાઈ મનજીભાઈ સાવલીયા',
                'phone' => '9426098765',
                'village' => 'કેશોદ',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 40,
                'rate_per_yard' => 2500,
                'total_amount' => 100000,
                'payment_method' => 'UPI',
                'transaction_id' => 'UPI492019482',
                'status' => 'verified',
                'is_featured' => true,
                'notes' => 'માઁ ખોડલના આશીર્વાદ સાથે ભૂમિદાન',
            ],
            [
                'receipt_number' => 'LPS-JND-2026-003',
                'donor_name' => 'શ્રી કાળુભાઈ પરસોત્તમભાઈ ડોબરીયા',
                'donor_name_gujarati' => 'શ્રી કાળુભાઈ પરસોત્તમભાઈ ડોબરીયા',
                'phone' => '9909988776',
                'village' => 'વિસાવદર',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 20,
                'rate_per_yard' => 2500,
                'total_amount' => 50000,
                'payment_method' => 'UPI',
                'transaction_id' => 'UPI773910382',
                'status' => 'verified',
                'is_featured' => true,
                'notes' => 'વિશેષ સેવા સંકલ્પ હેતુ',
            ],
            [
                'receipt_number' => 'LPS-JND-2026-004',
                'donor_name' => 'શ્રી ભરતભાઈ કાનજીભાઈ વઘાસીયા',
                'donor_name_gujarati' => 'શ્રી ભરતભાઈ કાનજીભાઈ વઘાસીયા',
                'phone' => '9724011223',
                'village' => 'મેંદરડા',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 10,
                'rate_per_yard' => 2500,
                'total_amount' => 25000,
                'payment_method' => 'Cheque',
                'transaction_id' => 'CHQ-883019',
                'status' => 'verified',
                'is_featured' => false,
                'notes' => 'ભૂમિદાન સંકલ્પ',
            ],
            [
                'receipt_number' => 'LPS-JND-2026-005',
                'donor_name' => 'શ્રી અલ્પેશભાઈ પ્રવીણભાઈ ભાલોડીયા',
                'donor_name_gujarati' => 'શ્રી અલ્પેશભાઈ પ્રવીણભાઈ ભાલોડીયા',
                'phone' => '9898012390',
                'village' => 'માળિયા હાટીના',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 5,
                'rate_per_yard' => 2500,
                'total_amount' => 12500,
                'payment_method' => 'UPI',
                'transaction_id' => 'UPI991823019',
                'status' => 'verified',
                'is_featured' => false,
                'notes' => 'પરિવાર વતી ભૂમિદાન',
            ],
            [
                'receipt_number' => 'LPS-JND-2026-006',
                'donor_name' => 'શ્રી હરેશભાઈ વલ્લભભાઈ રાદડિયા',
                'donor_name_gujarati' => 'શ્રી હરેશભાઈ વલ્લભભાઈ રાદડિયા',
                'phone' => '9979055443',
                'village' => 'ભેંસાણ',
                'city' => 'જૂનાગઢ',
                'sq_yards' => 2,
                'rate_per_yard' => 2500,
                'total_amount' => 5000,
                'payment_method' => 'UPI',
                'transaction_id' => 'UPI118274910',
                'status' => 'verified',
                'is_featured' => false,
                'notes' => 'ભૂમિદાન',
            ],
        ];

        foreach ($donations as $donation) {
            Bhumidan::firstOrCreate(['receipt_number' => $donation['receipt_number']], $donation);
        }

        // Seed Gallery Items
        $gallery = [
            [
                'title' => 'સંકલ્પ સંમેલન & ભૂમિપૂજન ઉત્સવ',
                'category' => 'bhumipujan',
                'media_type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=1200&q=80',
                'caption' => 'જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે સોનરખ નદીના કાંઠે સંકુલ ભૂમિપૂજન કાર્યક્રમ',
                'is_featured' => true,
            ],
            [
                'title' => 'ખોડલધામ યુવા સમિતિ જૂનાગઢ - જ્ઞાતિ સંગઠન કાર્યક્રમ',
                'category' => 'events',
                'media_type' => 'instagram_reel',
                'media_url' => 'https://www.instagram.com/reel/DeaWR2ft4JS/',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
                'caption' => 'લેઉવા પટેલ ટ્રસ્ટ જૂનાગઢ દ્વારા આયોજિત ભવ્ય યુવા સંગઠન બેઠક અને સંકલ્પ યાત્રા',
                'is_featured' => true,
            ],
            [
                'title' => 'વિભાગ-૧ & ૨ આર્કિટેક્ચર મોડેલ પ્રદર્શન',
                'category' => 'construction',
                'media_type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80',
                'caption' => 'આધુનિક બેન્કવેટ હોલ, પાર્ટી પ્લોટ અને અતિથિ ભવન 3D પ્લાન દર્શન',
                'is_featured' => true,
            ],
            [
                'title' => 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ રક્તદાન શિબિર',
                'category' => 'events',
                'media_type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1579208575657-c595a05383b7?auto=format&fit=crop&w=1200&q=80',
                'caption' => 'સેવા એ જ સંકલ્પ - જ્ઞાતિજનો દ્વારા વિશાળ રક્તદાન કેમ્પ',
                'is_featured' => false,
            ],
            [
                'title' => 'શ્રી સરદાર વલ્લભભાઈ પટેલ જન્મ જયંતિ વંદના',
                'category' => 'social',
                'media_type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?auto=format&fit=crop&w=1200&q=80',
                'caption' => 'લોખંડી પુરુષ સરદાર પટેલની વિચારધારાને વંદન કાર્યક્રમ',
                'is_featured' => false,
            ],
        ];

        foreach ($gallery as $item) {
            GalleryItem::firstOrCreate(['title' => $item['title']], $item);
        }

        // Seed Sample Booking Inquiry
        BookingInquiry::firstOrCreate(
            ['inquiry_number' => 'INQ-2026-101'],
            [
                'applicant_name' => 'શ્રી ઘનશ્યામભાઈ પટેલ',
                'phone' => '9879512340',
                'email' => 'ghanshyam.patel@example.com',
                'city_or_village' => 'જૂનાગઢ',
                'section_type' => 'વિભાગ-૧ (૧૫૦૦ વ્યક્તિ)',
                'facility_name' => 'પાર્ટી પ્લોટ & બેન્કવેટ હોલ',
                'event_type' => 'લગ્ન પ્રસંગ',
                'event_date' => now()->addMonths(2)->format('Y-m-d'),
                'approx_guests' => 1200,
                'required_rooms' => 15,
                'status' => 'new',
                'user_notes' => 'દિકરાના લગ્ન પ્રસંગ માટે વિભાગ-૧ પાર્ટી પ્લોટ અને ૧૫ રૂમની જરૂર છે.',
            ]
        );

        // Seed Sample Samaj Member
        Member::firstOrCreate(
            ['member_code' => 'LPS-M-1001'],
            [
                'full_name' => 'વિરેન્દ્રભાઈ કાનજીભાઈ સાવલીયા',
                'father_or_husband_name' => 'કાનજીભાઈ',
                'surname' => 'સાવલીયા',
                'gender' => 'male',
                'blood_group' => 'B+',
                'native_village' => 'બિલખા',
                'current_address' => 'પ્લોટ નં. ૨૪, સરદાર પટેલ સોસાયટી, મોતીબાગ રોડ',
                'city' => 'જૂનાગઢ',
                'pincode' => '362001',
                'phone' => '9825590934',
                'whatsapp' => '9825590934',
                'occupation' => 'વેપાર (એગ્રો બિઝનેસ)',
                'family_members_count' => 4,
                'status' => 'approved',
            ]
        );
    }
}
