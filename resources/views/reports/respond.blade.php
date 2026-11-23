@extends('layouts.master')

@section('title', 'Report Response')

@section('content')
<div style="max-width:680px;margin:32px auto;padding:0 16px;">
    <div style="background:#fff;border-radius:16px;padding:24px;box-shadow:0 1px 5px rgba(0,0,0,0.08);">
        <h1 style="font-size:1.25rem;font-weight:800;color:#1a1209;margin:0 0 8px;">Respond to a Report</h1>
        <p style="font-size:0.84rem;color:#6b7280;margin:0 0 18px;line-height:1.6;">
            CES Admin received a report about your account. Share your response so it can be considered during review.
        </p>

        <div style="padding:14px;background:#f9fafb;border-radius:10px;margin-bottom:18px;">
            <p style="font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;margin:0 0 5px;">Report reason</p>
            <p style="font-size:0.85rem;font-weight:700;color:#374151;margin:0 0 10px;">{{ $report->reason }}</p>
            @if($report->details)
                <p style="font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;margin:0 0 5px;">Details provided</p>
                <p style="font-size:0.82rem;color:#4b5563;margin:0;white-space:pre-line;">{{ $report->details }}</p>
            @endif
            @if($report->reported_user_response)
                <p style="font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;margin:14px 0 5px;">Your previous response</p>
                <p style="font-size:0.82rem;color:#4b5563;margin:0;white-space:pre-line;">{{ $report->reported_user_response }}</p>
            @endif
        </div>

        @if($errors->any())
            <div style="color:#991b1b;background:#fef2f2;padding:10px 12px;border-radius:8px;font-size:0.8rem;margin-bottom:14px;">
                {{ $errors->first('reported_user_response') }}
            </div>
        @endif

        <form action="{{ route('reports.respond', $report) }}" method="POST">
            @csrf
            <label for="reported_user_response" style="display:block;font-size:0.76rem;font-weight:700;color:#374151;margin-bottom:6px;">
                Your response <span style="color:#dc2626;">*</span>
            </label>
            <textarea id="reported_user_response" name="reported_user_response" rows="6" maxlength="2000" required
                      placeholder="Explain what happened and why you believe the report should be dismissed."
                      style="width:100%;padding:11px 12px;border:1px solid #d1d5db;border-radius:9px;font-size:0.85rem;resize:vertical;">{{ old('reported_user_response', $report->reported_user_response) }}</textarea>
            <div style="display:flex;justify-content:flex-end;margin-top:14px;">
                <button type="submit" style="background:#7b0f10;color:#fff;border:0;border-radius:8px;padding:10px 16px;font-size:0.82rem;font-weight:700;cursor:pointer;">
                    Send Response to CES Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
