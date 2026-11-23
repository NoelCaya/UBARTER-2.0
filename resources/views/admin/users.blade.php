@extends('layouts.master')
@section('title', 'User Management')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
.adm-table{width:100%;border-collapse:collapse;}
.adm-table thead tr{background:#fafafa;border-bottom:1px solid #f3f4f6;}
.adm-table th{padding:10px 16px;text-align:left;font-size:0.65rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;}
.adm-table tbody tr{border-bottom:1px solid #f9fafb;transition:background 0.12s;}
.adm-table tbody tr:hover{background:#fafafa;}
.adm-table td{padding:11px 16px;vertical-align:middle;}
.btn-suspend{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#fee2e2;color:#991b1b;transition:all 0.15s;}
.btn-suspend:hover{background:#dc2626;color:#fff;}
.btn-reactivate{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#dcfce7;color:#166534;transition:all 0.15s;}
.btn-reactivate:hover{background:#16a34a;color:#fff;}
.search-bar{display:flex;align-items:center;gap:8px;padding:12px 16px;border-bottom:1px solid #f3f4f6;background:#fafafa;}
.search-bar input{flex:1;padding:8px 14px;border:1.5px solid #e5e7eb;border-radius:9px;font-size:0.82rem;outline:none;transition:border-color 0.15s;background:#fff;}
.search-bar input:focus{border-color:#7b0f10;}
.search-bar button{padding:8px 16px;background:#7b0f10;color:#fff;border:none;border-radius:9px;font-size:0.78rem;font-weight:700;cursor:pointer;transition:background 0.15s;}
.search-bar button:hover{background:#5a0a0b;}
</style>

<div class="aw">
  <div style="margin-bottom:4px;">
    <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 2px;">Admin Control Panel</h1>
  </div>

  
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- Stats strip --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px;">
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #8b5cf6;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Total Users</p>
      <p style="font-size:2rem;font-weight:900;color:#8b5cf6;margin:0;line-height:1;">{{ $totalUsers }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #10b981;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Active</p>
      <p style="font-size:2rem;font-weight:900;color:#10b981;margin:0;line-height:1;">{{ $totalUsers - $suspended }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #ef4444;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Restricted</p>
      <p style="font-size:2rem;font-weight:900;color:#ef4444;margin:0;line-height:1;">{{ $suspended }}</p>
    </div>
  </div>

  {{-- 8.2 Search + 8.1 Table --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#8b5cf6;">8.1 / 8.2</span>
      <h2>Manage &amp; Search User Accounts <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D1 Users)</span></h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $users->total() }} accounts</span>
    </div>

    {{-- Search bar --}}
    <div class="search-bar">
      <form method="GET" action="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:8px;width:100%;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or email…">
        <button type="submit"><i class="fas fa-search" style="margin-right:4px;"></i> Search</button>
        @if(request('q'))
          <a href="{{ route('admin.users') }}" style="padding:8px 14px;background:#f3f4f6;color:#374151;border-radius:9px;font-size:0.75rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-times"></i> Clear
          </a>
        @endif
      </form>
    </div>

    <div style="overflow-x:auto;">
      <table class="adm-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Email</th>
            <th style="text-align:center;">Items</th>
            <th>Joined</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Account Restriction</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:9px;">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=7b0f10&color=fff&size=32&bold=true"
                       style="width:32px;height:32px;border-radius:50%;flex-shrink:0;">
                  <span style="font-size:0.8rem;font-weight:700;color:#1a1209;">{{ $user->name }}</span>
                </div>
              </td>
              <td style="font-size:0.75rem;color:#6b7280;">{{ $user->email }}</td>
              <td style="text-align:center;font-size:0.8rem;font-weight:700;color:#374151;">{{ $user->items_count ?? 0 }}</td>
              <td style="font-size:0.68rem;color:#9ca3af;">{{ $user->created_at->format('M d, Y') }}</td>
              <td style="text-align:center;">
                <span style="font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;
                             background:{{ $user->role==='suspended'?'#fee2e2':'#dcfce7' }};
                             color:{{ $user->role==='suspended'?'#991b1b':'#166534' }};">
                  {{ $user->role==='suspended'?'Restricted':'Active' }}
                </span>
              </td>
              <td style="text-align:center;">
                @if($user->role !== 'suspended')
                  <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-suspend"
                            onclick="return confirm('Restrict {{ addslashes($user->name) }}?')">
                      <i class="fas fa-ban"></i> Restrict
                    </button>
                  </form>
                @else
                  <form action="{{ route('admin.users.reactivate', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-reactivate">
                      <i class="fas fa-check"></i> Restore
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center;padding:32px;color:#9ca3af;font-size:0.85rem;">
                @if(request('q'))
                  No users found matching "{{ request('q') }}"
                @else
                  No users found.
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($users->hasPages())
      <div style="padding:14px 20px;border-top:1px solid #f3f4f6;">
        {{ $users->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
