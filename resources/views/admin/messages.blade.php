@extends('layouts.admin')

@section('title', 'સંપર્ક સંદેશાઓ')
@section('header_title', 'નાગરિકો / જ્ઞાતિજનોના સંપર્ક સંદેશાઓ')

@section('content')

<div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-maroon);">બધા સંદેશાઓ</h3>
        <p style="font-size: 0.85rem; color: var(--color-text-muted);">વેબસાઇટ પરથી આવેલી પૂછપરછ અને સૂચનો</p>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
            <thead>
                <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                    <th style="padding: 0.75rem 1rem;">તારીખ</th>
                    <th style="padding: 0.75rem 1rem;">નામ</th>
                    <th style="padding: 0.75rem 1rem;">મોબાઈલ</th>
                    <th style="padding: 0.75rem 1rem;">વિષય</th>
                    <th style="padding: 0.75rem 1rem;">સંદેશો</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 1rem; color: var(--color-text-muted); font-size: 0.8rem;">
                            {{ $msg->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700;">
                            {{ $msg->name }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin);">
                            <a href="tel:{{ $msg->phone }}">{{ $msg->phone }}</a>
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 600; color: var(--color-primary-light);">
                            {{ $msg->subject }}
                        </td>
                        <td style="padding: 0.75rem 1rem; color: var(--color-text-main);">
                            {{ $msg->message }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">
                            કોઈ સંદેશો નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $messages->links() }}
    </div>
</div>

@endsection
