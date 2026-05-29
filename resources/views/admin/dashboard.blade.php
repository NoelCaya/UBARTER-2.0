@extends('layouts.master')

@section('title', 'CES Admin Dashboard')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:24px 16px;">

    <!-- Header -->
    <div style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#7b0f10;color:#fff;font-size:0.65rem;font-weight:800;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.08em;">CES ADMIN</span>
                <span style="font-size:0.72rem;color:#9ca3af;">Community Extension Services</span>
            </div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#1a1209;margin:0;">Admin Dashboard</h1>
            <p style="font-size:0.78rem;color:#9ca3af;margin:2px 0 0;">Review and approve item listings for the UBarter platform.</p>
        </div>
        <a href="{{ route('dashboard') }}" style="font-size:0.78rem;font-weight:600;color:#7b0f10;text-decoration:none;display:flex;align-items:center;gap:5px;">
            <i class="fas fa-arrow-left" style="font-size:0.7rem;"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;">
        <div style="background:#fff;border-radius:12px;padding:16px;border-left:4px solid #f97316;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Pending Approvals</p>
            <p style="font-size:1.8rem;font-weight:800;color:#1a1209;margin:4px 0 0;">{{ $totalPending }}</p>
            <p style="font-size:0.65rem;color:#f97316;font-weight:600;margin-top:2px;">Needs review</p>
        </div>
        <div style="background:#fff;border-radius:12px;padding:16px;border-left:4px solid #7b0f10;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Pending Barters</p>
            <p style="font-size:1.8rem;font-weight:800;color:#7b0f10;margin:4px 0 0;">{{ $pendingBarter->count() }}</p>
            <p style="font-size:0.65rem;color:#9ca3af;margin-top:2px;">Trade items</p>
        </div>
        <div style="background:#fff;border-radius:12px;padding:16px;border-left:4px solid #16a34a;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Pending Donations</p>
            <p style="font-size:1.8rem;font-weight:800;color:#16a34a;margin:4px 0 0;">{{ $pendingDonation->count() }}</p>
            <p style="font-size:0.65rem;color:#9ca3af;margin-top:2px;">Free items</p>
        </div>
        <div style="background:#fff;border-radius:12px;padding:16px;border-left:4px solid #3b82f6;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Active Items</p>
            <p style="font-size:1.8rem;font-weight:800;color:#3b82f6;margin:4px 0 0;">{{ $activeItems }}</p>
            <p style="font-size:0.65rem;color:#9ca3af;margin-top:2px;">Live on platform</p>
        </div>
    </div>

    <!-- Pending Barter Items -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;">
        <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;">
            <span style="background:#7b0f10;color:#fff;font-size:0.65rem;font-weight:800;padding:3px 8px;border-radius:4px;text-transform:uppercase;">BARTER</span>
            <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;">Pending Barter Items</h2>
            <span style="margin-left:auto;font-size:0.72rem;color:#9ca3af;">{{ $pendingBarter->count() }} item{{ $pendingBarter->count() !== 1 ? 's' : '' }} awaiting review</span>
        </div>

        @if($pendingBarter->count() > 0)
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#fafafa;border-bottom:1px solid #f3f4f6;">
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Item</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Category</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Condition</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Posted By</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Date</th>
                        <th style="padding:10px 16px;text-align:center;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingBarter as $item)
                    <tr style="border-bottom:1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                     style="width:44px;height:44px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
                                <div style="min-width:0;">
                                    <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $item->title }}</p>
                                    <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ Str::limit($item->description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:0.78rem;color:#4b5563;">{{ $item->category }}</td>
                        <td style="padding:12px 16px;">
                            <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:999px;background:#dbeafe;color:#1d4ed8;">{{ $item->condition }}</span>
                        </td>
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&size=28&bold=true"
                                     style="width:24px;height:24px;border-radius:50%;" alt="{{ $item->user->name }}">
                                <span style="font-size:0.75rem;color:#374151;font-weight:600;">{{ $item->user->name }}</span>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:0.72rem;color:#9ca3af;">{{ $item->posted_at->diffForHumans() }}</td>
                        <td style="padding:12px 16px;text-align:center;">
                            <div style="display:flex;justify-content:center;gap:6px;">
                                <form action="{{ route('admin.items.approve', $item) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                            style="background:#dcfce7;color:#166534;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:background 0.15s;"
                                            onmouseover="this.style.background='#16a34a';this.style.color='white'"
                                            onmouseout="this.style.background='#dcfce7';this.style.color='#166534'">
                                        <i class="fas fa-check mr-1"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.items.reject', $item) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                            style="background:#fee2e2;color:#991b1b;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:background 0.15s;"
                                            onmouseover="this.style.background='#dc2626';this.style.color='white'"
                                            onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
                                        <i class="fas fa-times mr-1"></i> Reject
                                    </button>
                                </form>
                                <a href="{{ route('items.show', $item) }}" target="_blank"
                                   style="background:#f3f4f6;color:#374151;border-radius:6px;padding:5px 10px;font-size:0.72rem;font-weight:600;text-decoration:none;transition:background 0.15s;"
                                   onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="padding:32px;text-align:center;color:#9ca3af;">
            <i class="fas fa-check-circle" style="font-size:2rem;color:#16a34a;margin-bottom:8px;display:block;"></i>
            <p style="font-size:0.82rem;font-weight:600;">All barter items have been reviewed!</p>
        </div>
        @endif
    </div>

    <!-- Pending Donation Items -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;">
        <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;">
            <span style="background:#16a34a;color:#fff;font-size:0.65rem;font-weight:800;padding:3px 8px;border-radius:4px;text-transform:uppercase;">DONATION</span>
            <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;">Pending Donation Items</h2>
            <span style="margin-left:auto;font-size:0.72rem;color:#9ca3af;">{{ $pendingDonation->count() }} item{{ $pendingDonation->count() !== 1 ? 's' : '' }} awaiting review</span>
        </div>

        @if($pendingDonation->count() > 0)
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#fafafa;border-bottom:1px solid #f3f4f6;">
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Item</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Category</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Condition</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Posted By</th>
                        <th style="padding:10px 16px;text-align:left;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Date</th>
                        <th style="padding:10px 16px;text-align:center;font-size:0.7rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingDonation as $item)
                    <tr style="border-bottom:1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                     style="width:44px;height:44px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
                                <div style="min-width:0;">
                                    <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $item->title }}</p>
                                    <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ Str::limit($item->description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:0.78rem;color:#4b5563;">{{ $item->category }}</td>
                        <td style="padding:12px 16px;">
                            <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:999px;background:#dcfce7;color:#166534;">{{ $item->condition }}</span>
                        </td>
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=16a34a&color=fff&size=28&bold=true"
                                     style="width:24px;height:24px;border-radius:50%;" alt="{{ $item->user->name }}">
                                <span style="font-size:0.75rem;color:#374151;font-weight:600;">{{ $item->user->name }}</span>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:0.72rem;color:#9ca3af;">{{ $item->posted_at->diffForHumans() }}</td>
                        <td style="padding:12px 16px;text-align:center;">
                            <div style="display:flex;justify-content:center;gap:6px;">
                                <form action="{{ route('admin.items.approve', $item) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                            style="background:#dcfce7;color:#166534;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:background 0.15s;"
                                            onmouseover="this.style.background='#16a34a';this.style.color='white'"
                                            onmouseout="this.style.background='#dcfce7';this.style.color='#166534'">
                                        <i class="fas fa-check mr-1"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.items.reject', $item) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                            style="background:#fee2e2;color:#991b1b;border:none;border-radius:6px;padding:5px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:background 0.15s;"
                                            onmouseover="this.style.background='#dc2626';this.style.color='white'"
                                            onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
                                        <i class="fas fa-times mr-1"></i> Reject
                                    </button>
                                </form>
                                <a href="{{ route('items.show', $item) }}" target="_blank"
                                   style="background:#f3f4f6;color:#374151;border-radius:6px;padding:5px 10px;font-size:0.72rem;font-weight:600;text-decoration:none;"
                                   onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="padding:32px;text-align:center;color:#9ca3af;">
            <i class="fas fa-check-circle" style="font-size:2rem;color:#16a34a;margin-bottom:8px;display:block;"></i>
            <p style="font-size:0.82rem;font-weight:600;">All donation items have been reviewed!</p>
        </div>
        @endif
    </div>

    <!-- Quick Stats Footer -->
    <div style="background:linear-gradient(135deg,#7b0f10,#5a0a0b);border-radius:14px;padding:16px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <p style="font-size:0.72rem;opacity:0.8;margin:0;">Logged in as</p>
            <p style="font-size:0.9rem;font-weight:800;margin:2px 0 0;">{{ auth()->user()->name }}</p>
        </div>
        <div style="display:flex;gap:20px;">
            <div style="text-align:center;">
                <p style="font-size:1.2rem;font-weight:800;margin:0;">{{ $activeItems }}</p>
                <p style="font-size:0.62rem;opacity:0.75;margin:0;">Active Items</p>
            </div>
            <div style="text-align:center;">
                <p style="font-size:1.2rem;font-weight:800;margin:0;">{{ $totalUsers }}</p>
                <p style="font-size:0.62rem;opacity:0.75;margin:0;">Users</p>
            </div>
            <div style="text-align:center;">
                <p style="font-size:1.2rem;font-weight:800;margin:0;">{{ $totalPending }}</p>
                <p style="font-size:0.62rem;opacity:0.75;margin:0;">Pending</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:8px;padding:7px 16px;font-size:0.78rem;font-weight:700;cursor:pointer;transition:background 0.15s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    </div>

</div>
@endsection
