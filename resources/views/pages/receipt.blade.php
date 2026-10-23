@extends('layouts.app')

@section('title', 'ડિજિટલ દાન રસીદ | ' . $donation->receipt_number)

@push('styles')
<style>
@media print {
    .topbar, .main-header, .main-footer, .floating-actions, .no-print {
        display: none !important;
    }
    body {
        background: #fff !important;
    }
    .receipt-container {
        border: 2px solid #b45309 !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 2rem !important;
    }
}
</style>
@endpush

@section('content')

<div class="container section-padding">
    <div class="no-print" style="max-width: 800px; margin: 0 auto 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('bhumidan') }}" class="btn btn-outline-gold">
            <i class="ri-arrow-left-line"></i> દાતા યાદી પર પાછા જાઓ
        </a>
        <button onclick="printReceipt()" class="btn btn-primary">
            <i class="ri-printer-line"></i> રસીદ પ્રિન્ટ / PDF સેવ કરો
        </button>
    </div>

    <!-- Printable Official Receipt Card -->
    <div class="receipt-container" style="max-width: 800px; margin: 0 auto; background: #fff; border: 3px double var(--color-primary-light); border-radius: var(--radius-lg); padding: 3rem; box-shadow: var(--shadow-xl); position: relative;">
        <!-- Watermark -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-25deg); font-size: 5rem; font-weight: 900; color: rgba(180, 83, 9, 0.04); pointer-events: none; white-space: nowrap;">
            LPS JUNAGADH
        </div>

        <!-- Receipt Header -->
        <div style="text-align: center; border-bottom: 2px solid var(--color-primary-subtle); padding-bottom: 1.5rem; margin-bottom: 2rem;">
            <div style="color: var(--color-primary-light); font-weight: 800; font-size: 0.95rem; margin-bottom: 0.25rem;">॥ જય સરદાર - જય માઁ ખોડલ ॥</div>
            <h2 style="font-size: 1.85rem; font-weight: 900; color: var(--color-maroon); line-height: 1.25;">
                શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ
            </h2>
            <div style="font-size: 0.95rem; font-weight:700; color: var(--color-primary-light); margin-top: 0.2rem;">
                SHREE SAMAST LEUVA PATEL SAMAJ TRUST - JUNAGADH (LPS)
            </div>
            <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.35rem;">
                જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ, ગુજરાત. • હેલ્પલાઇન: 909 33 909 34
            </div>
            <div style="display: inline-block; background: var(--color-primary-subtle); color: var(--color-primary-dark); font-weight: 800; font-size: 0.88rem; padding: 0.3rem 1.25rem; border-radius: var(--radius-pill); margin-top: 0.85rem; border: 1px solid var(--color-gold);">
                સત્તાવાર ભૂમિદાન સહયોગ રસીદ (Digital Receipt)
            </div>
        </div>

        <!-- Meta info -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span style="font-size: 0.9rem; color: var(--color-text-muted);">રસીદ નંબર:</span>
                <strong style="font-family: var(--font-latin); font-size: 1.1rem; color: var(--color-maroon); display: block;">
                    {{ $donation->receipt_number }}
                </strong>
            </div>

            <div style="text-align: right;">
                <span style="font-size: 0.9rem; color: var(--color-text-muted);">તારીખ:</span>
                <strong style="font-family: var(--font-latin); font-size: 1.05rem; display: block;">
                    {{ $donation->created_at->format('d/m/Y') }}
                </strong>
            </div>
        </div>

        <!-- Receipt Body Table -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
            <tbody>
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; width: 35%; color: var(--color-text-muted); font-weight: 600;">સન્માનિત દાતાશ્રીનું નામ:</td>
                    <td style="padding: 0.85rem 0; font-size: 1.15rem; font-weight: 800; color: var(--color-text-main);">
                        {{ $donation->donor_name }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; color: var(--color-text-muted); font-weight: 600;">ગામ / શહેર:</td>
                    <td style="padding: 0.85rem 0; font-weight: 700;">
                        {{ $donation->village ? $donation->village . ', ' : '' }}{{ $donation->city }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; color: var(--color-text-muted); font-weight: 600;">સંપર્ક નંબર:</td>
                    <td style="padding: 0.85rem 0; font-family: var(--font-latin); font-weight: 700;">
                        {{ $donation->phone }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; color: var(--color-text-muted); font-weight: 600;">સમર્પિત ભૂમિદાન વિસ્તાર:</td>
                    <td style="padding: 0.85rem 0; font-size: 1.05rem; font-weight: 800; color: var(--color-primary-light);">
                        {{ $donation->sq_yards }} ચોરસ વાર (રૂા. ૨,૫૦૦/- પ્રતિ વાર લેખે)
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; color: var(--color-text-muted); font-weight: 600;">ચુકવણી માધ્યમ:</td>
                    <td style="padding: 0.85rem 0; font-weight: 700;">
                        {{ $donation->payment_method }} {{ $donation->transaction_id ? '(' . $donation->transaction_id . ')' : '' }}
                    </td>
                </tr>
                @if($donation->notes)
                <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                    <td style="padding: 0.85rem 0; color: var(--color-text-muted); font-weight: 600;">સંકલ્પ નોંધ:</td>
                    <td style="padding: 0.85rem 0; font-style: italic;">
                        {{ $donation->notes }}
                    </td>
                </tr>
                @endif
                <tr style="background: var(--color-surface);">
                    <td style="padding: 1.25rem 1rem; font-size: 1.15rem; font-weight: 800; color: var(--color-maroon);">
                        કુલ સહયોગ રાશિ :
                    </td>
                    <td style="padding: 1.25rem 1rem; font-size: 1.6rem; font-weight: 900; color: var(--color-maroon);">
                        ₹ {{ number_format($donation->total_amount) }}/-
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures & Blessing Footer -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 3.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--color-border);">
            <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                <p><strong>નોંધ:</strong> આ કોમ્પ્યુટર જનરેટેડ ડિજિટલ રસીદ છે.</p>
                <p>આપના અમૂલ્ય સહયોગ બદલ સમસ્ત સમાજ આપનો આભાર વ્યક્ત કરે છે.</p>
            </div>

            <div style="text-align: center;">
                <div style="height: 45px; display: flex; align-items: center; justify-content: center; color: var(--color-maroon); font-weight: 800; font-size: 1.1rem; border-bottom: 1.5px solid #1c1917; padding-bottom: 5px;">
                    LPS Trust Junagadh
                </div>
                <div style="font-size: 0.85rem; font-weight: 700; margin-top: 0.35rem; color: var(--color-text-main);">
                    અધિકૃત મંત્રીશ્રી / ટ્રસ્ટીશ્રી
                </div>
                <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                    શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
