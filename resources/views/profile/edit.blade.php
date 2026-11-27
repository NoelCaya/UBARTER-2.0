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
                <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 16px;">Your profile name and UB Mail are managed through your UB account.</p>

                <div style="margin-bottom:16px;">
                    <p style="font-size:0.75rem;font-weight:700;color:#374151;margin:0 0 8px;text-transform:uppercase;letter-spacing:0.05em;">Profile Picture</p>
                    <div style="display:flex;align-items:center;gap:14px;">
                        <img id="avatar-preview"
                             src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7b0f10&color=fff&bold=true&size=80' }}"
                             style="width:64px;height:64px;border-radius:50%;border:3px solid #f3f4f6;object-fit:cover;flex-shrink:0;"
                             alt="{{ $user->name }}">
                        <div>
                            <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                @method('patch')
                                <label style="display:inline-flex;align-items:center;gap:6px;background:#7b0f10;color:#fff;font-size:0.75rem;font-weight:700;padding:7px 14px;border-radius:8px;cursor:pointer;transition:background 0.15s;"
                                       onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                                    <i class="fas fa-camera" style="font-size:0.7rem;"></i> Change Photo
                                    <input type="file" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this); this.form.submit();">
                                </label>
                            </form>
                            <p style="font-size:0.68rem;color:#9ca3af;margin:5px 0 0;">JPG or PNG, max 2MB</p>
                        </div>
                    </div>
                    @error('avatar') <p style="color:#dc2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom:14px;">
                    <p style="font-size:0.75rem;font-weight:700;color:#374151;margin:0 0 5px;text-transform:uppercase;letter-spacing:0.05em;">Name</p>
                    <p style="font-size:0.85rem;color:#1a1209;margin:0;">{{ $user->name }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem;font-weight:700;color:#374151;margin:0 0 5px;text-transform:uppercase;letter-spacing:0.05em;">UB Mail</p>
                    <p style="font-size:0.85rem;color:#1a1209;margin:0;">{{ $user->email }}</p>
                </div>
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Quick Actions + Danger Zone -->
        <div style="display:flex;flex-direction:column;gap:16px;">

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
        </div>

    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
