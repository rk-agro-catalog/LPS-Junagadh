@extends('layouts.admin')

@section('title', 'સંપર્ક સંદેશાઓ')
@section('header_title', 'નાગરિકો / જ્ઞાતિજનોના સંપર્ક સંદેશાઓ')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">બધા સંદેશાઓ</h3>
            <p class="admin-card-desc">વેબસાઇટ પરથી આવેલી પૂછપરછ અને સૂચનો</p>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>તારીખ</th>
                    <th>નામ</th>
                    <th>મોબાઈલ</th>
                    <th>વિષય</th>
                    <th>સંદેશો</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td style="color: #64748b; font-size: 0.8rem; white-space: nowrap; font-family: var(--font-latin);">
                            {{ $msg->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="font-weight: 700; color: #0f172a; white-space: nowrap;">
                            {{ $msg->name }}
                        </td>
                        <td style="font-family: var(--font-latin); white-space: nowrap;">
                            <a href="tel:{{ $msg->phone }}" style="color: #475569; text-decoration: none; font-weight: 600;">
                                <i class="ri-phone-line" style="color: #0284c7; font-size: 0.85rem;"></i> {{ $msg->phone }}
                            </a>
                        </td>
                        <td style="font-weight: 600; color: #b45309;">
                            {{ $msg->subject }}
                        </td>
                        <td style="color: #334155; line-height: 1.5;">
                            {{ $msg->message }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2.5rem; text-align: center; color: #94a3b8;">
                            કોઈ સંદેશો નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $messages->links() }}
    </div>
</div>

@endsection
