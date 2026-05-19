@extends('layouts.master')

@section('title', 'My Profile')

@section('content')
<div style="max-width:900px; margin:0 auto; padding:24px 16px;">

    <!-- Profile Header Card -->
    <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,0.08); margin-bottom:20px;">
        <!-- Cover Banner -->
        <div style="height:110px; background:linear-gradient(135deg,#7b0f10 0%,#5a0a0b 60%,#9b1a1b 100%); position:relative;">
            <div style="position:absolute; bottom:-36px; left:24px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f5c518&color=7b0f10&bold=true&size=80"
                     alt="{{ $user->name }}"
                     style="width:72px;height:72px;border-radius:50%;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            </div>
        </div>
        <!-- Info Row -->
        <div style="padding:48px 24px 18px; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <h1 style="font-size:1.3rem;font-weight:800;color:#1a1209;margin:0 0 3px;">{{ $user->name }}</h1>
                <p style="font-size:0.8rem;color:#9ca3af;margin:0 0 8px;">{{ $user->email }}</p>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <span style="background:#7b0f10;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:999px;text-transform:uppercase;">UB MAIN</span>
                    <span style="background:#dcfce7;color:#16a34a;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                        <i class="fas fa-check-circle" style="font-size:0.6rem;"></i> UBmail Verified
                    </span>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('items.create') }}"
                   style="background:#7b0f10;color:#fff;font-size:0.78rem;font-weight:700;padding:7px 14px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;"
                   onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                    <i class="fas fa-plus" style="font-size:0.7rem;"></i> Post Item
                </a>
            </div>
        </div>
        <!-- Stats Strip -->
        <div style="display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid #f3f4f6;text-align:center;">
            @foreach([['23','Trades'],['12','Items Posted'],['8','Donations'],['4.9','Trust Score']] as $s)
            <div style="padding:12px 8px;{{ !$loop->last ? 'border-right:1px solid #f3f4f6;' : '' }}">
                <p style="font-size:1.2rem;font-weight:800;color:#7b0f10;margin:0;">{{ $s[0] }}</p>
                <p style="font-size:0.68rem;color:#9ca3af;margin:2px 0 0;font-weight:600;">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('status') === 'profile-updated')
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> Profile updated successfully.
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> Password updated successfully.
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

        <!-- Left: Profile Info Form -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Update Profile Information -->
            <div style="background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 4px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-user" style="color:#7b0f10;font-size:0.85rem;"></i> Profile Information
                </h2>
                <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 16px;">Update your name and email address.</p>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div style="margin-bottom:14px;">
                        <label for="name" style="display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                               style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;color:#1a1209;outline:none;box-sizing:border-box;transition:border-color 0.15s;"
                               onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'">
                        @error('name')
                            <p style="color:#dc2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label for="email" style="display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;color:#1a1209;background:#f9fafb;outline:none;box-sizing:border-box;"
                               readonly>
                        <p style="font-size:0.7rem;color:#9ca3af;margin:4px 0 0;">Managed through your UB account</p>
                        @error('email')
                            <p style="color:#dc2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            style="background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:9px 20px;border-radius:8px;border:none;cursor:pointer;transition:background 0.15s;"
                            onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- About / Quick Info -->
            <div style="background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-info-circle" style="color:#7b0f10;font-size:0.85rem;"></i> Account Info
                </h2>
                <div style="display:flex;flex-direction:column;gap:9px;">
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-envelope" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-calendar" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>Member since {{ $user->created_at->format('F Y') }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-map-marker-alt" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>University of Batangas, Batangas City</span>
                    </div>
                </div>

                <!-- Verification -->
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid #f3f4f6;">
                    <p style="font-size:0.75rem;font-weight:700;color:#374151;margin:0 0 8px;text-transform:uppercase;letter-spacing:0.05em;">Verification Status</p>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:#16a34a;">
                            <i class="fas fa-check-circle"></i><span>Email Verified</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:#16a34a;">
                            <i class="fas fa-check-circle"></i><span>University ID Verified</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:#d1d5db;">
                            <i class="far fa-circle"></i><span style="color:#9ca3af;">Phone Not Verified</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Password + Danger Zone -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Update Password -->
            <div style="background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 4px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-lock" style="color:#7b0f10;font-size:0.85rem;"></i> Update Password
                </h2>
                <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 16px;">Use a long, random password to stay secure.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    @foreach([
                        ['update_password_current_password','current_password','Current Password','current-password'],
                        ['update_password_password','password','New Password','new-password'],
                        ['update_password_password_confirmation','password_confirmation','Confirm Password','new-password'],
                    ] as $f)
                    <div style="margin-bottom:14px;">
                        <label for="{{ $f[0] }}" style="display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">{{ $f[2] }}</label>
                        <input type="password" id="{{ $f[0] }}" name="{{ $f[1] }}" autocomplete="{{ $f[3] }}"
                               style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;color:#1a1209;outline:none;box-sizing:border-box;transition:border-color 0.15s;"
                               onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'">
                        @error($f[1], 'updatePassword')
                            <p style="color:#dc2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach

                    <button type="submit"
                            style="background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:9px 20px;border-radius:8px;border:none;cursor:pointer;transition:background 0.15s;"
                            onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div style="background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 12px;">Quick Actions</h2>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('trade-history') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:#f3f4f6;color:#374151;border-radius:8px;text-decoration:none;font-size:0.82rem;font-weight:600;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-history" style="color:#7b0f10;font-size:0.8rem;width:14px;"></i> Trade History
                    </a>
                    <a href="{{ route('wishlist') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:#f3f4f6;color:#374151;border-radius:8px;text-decoration:none;font-size:0.82rem;font-weight:600;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-heart" style="color:#ef4444;font-size:0.8rem;width:14px;"></i> My Wishlist
                    </a>
                    <a href="{{ route('reviews') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:#f3f4f6;color:#374151;border-radius:8px;text-decoration:none;font-size:0.82rem;font-weight:600;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-star" style="color:#f5c518;font-size:0.8rem;width:14px;"></i> My Reviews
                    </a>
                    <a href="{{ route('settings') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:#f3f4f6;color:#374151;border-radius:8px;text-decoration:none;font-size:0.82rem;font-weight:600;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-cog" style="color:#6b7280;font-size:0.8rem;width:14px;"></i> Settings
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div style="background:#fff5f5;border:1px solid #fecaca;border-radius:14px;padding:22px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#991b1b;margin:0 0 4px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-exclamation-triangle" style="font-size:0.85rem;"></i> Danger Zone
                </h2>
                <p style="font-size:0.75rem;color:#b91c1c;margin:0 0 14px;">Once deleted, all data is permanently removed.</p>

                <button onclick="document.getElementById('deleteModal').style.display='flex'"
                        style="background:#dc2626;color:#fff;font-size:0.82rem;font-weight:700;padding:9px 18px;border-radius:8px;border:none;cursor:pointer;transition:background 0.15s;"
                        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                    <i class="fas fa-trash mr-2" style="font-size:0.75rem;"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:28px;max-width:420px;width:90%;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 8px;">Delete Account?</h3>
        <p style="font-size:0.82rem;color:#6b7280;margin:0 0 18px;line-height:1.6;">
            This will permanently delete your account and all associated data. This action cannot be undone. Please enter your password to confirm.
        </p>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                       style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#e5e7eb'">
                @error('password', 'userDeletion')
                    <p style="color:#dc2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'"
                        style="background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:9px 18px;border-radius:8px;border:none;cursor:pointer;">
                    Cancel
                </button>
                <button type="submit"
                        style="background:#dc2626;color:#fff;font-size:0.82rem;font-weight:700;padding:9px 18px;border-radius:8px;border:none;cursor:pointer;">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
