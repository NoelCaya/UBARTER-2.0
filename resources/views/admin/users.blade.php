@extends('layouts.master')

@section('title', 'Manage Users - CES Admin')

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:24px 16px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#7b0f10;color:#fff;font-size:0.65rem;font-weight:800;padding:3px 10px;border-radius:999px;text-transform:uppercase;">CES ADMIN</span>
            </div>
            <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0;">Manage Users</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" style="font-size:0.78rem;font-weight:600;color:#7b0f10;text-decoration:none;display:flex;align-items:center;gap:5px;">
            <i class="fas fa-arrow-left" style="font-size:0.7rem;"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#fafafa;border-bottom:1px solid #f3f4f6;">
                        <th style="padding:12px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">User</th>
                        <th style="padding:12px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Email</th>
                        <th style="padding:12px 16px;text-align:center;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Items</th>
                        <th style="padding:12px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Joined</th>
                        <th style="padding:12px 16px;text-align:center;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Status</th>
                        <th style="padding:12px 16px;text-align:center;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="border-bottom:1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=7b0f10&color=fff&size=36&bold=true"
                                     style="width:36px;height:36px;border-radius:50%;flex-shrink:0;" alt="{{ $user->name }}">
                                <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:0.75rem;color:#6b7280;">{{ $user->email }}</td>
                        <td style="padding:12px 16px;text-align:center;font-size:0.82rem;font-weight:700;color:#374151;">{{ $user->items_count }}</td>
                        <td style="padding:12px 16px;font-size:0.72rem;color:#9ca3af;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="padding:12px 16px;text-align:center;">
                            <span style="font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;
                                         background:{{ $user->role === 'suspended' ? '#fee2e2' : '#dcfce7' }};
                                         color:{{ $user->role === 'suspended' ? '#991b1b' : '#166534' }};">
                                {{ $user->role === 'suspended' ? 'Suspended' : 'Active' }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;text-align:center;">
                            @if($user->role !== 'suspended')
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#fee2e2;color:#991b1b;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;"
                                        onmouseover="this.style.background='#dc2626';this.style.color='white'"
                                        onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'"
                                        onclick="return confirm('Suspend {{ addslashes($user->name) }}?')">
                                    <i class="fas fa-ban mr-1"></i> Suspend
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.users.reactivate', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#dcfce7;color:#166534;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;"
                                        onmouseover="this.style.background='#16a34a';this.style.color='white'"
                                        onmouseout="this.style.background='#dcfce7';this.style.color='#166534'">
                                    <i class="fas fa-check mr-1"></i> Reactivate
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div style="padding:12px 16px;border-top:1px solid #f3f4f6;">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
