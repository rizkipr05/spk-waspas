@extends('layouts.app')

@section('title', 'Edit Influencer')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="fw-semibold mb-1">Edit Influencer</h4>
        <p class="text-muted mb-0 small">
            Perbarui data influencer: {{ $influencer->name }}
        </p>
    </div>
    <a href="{{ route('staff.influencers.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('staff.influencers.update', $influencer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Nama Influencer</label>
                    <input type="text" name="name" class="form-control form-control-sm"
                           value="{{ old('name', $influencer->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Username</label>
                    <input type="text" name="username" class="form-control form-control-sm"
                           value="{{ old('username', $influencer->username) }}" placeholder="@username">
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Platform</label>
                    <select name="platform" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Platform --</option>
                        @foreach (['Instagram', 'TikTok', 'YouTube', 'Twitter/X', 'Facebook', 'Lainnya'] as $platform)
                            <option value="{{ $platform }}"
                                {{ old('platform', $influencer->platform) === $platform ? 'selected' : '' }}>
                                {{ $platform }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Followers</label>
                    <input type="number" name="followers" class="form-control form-control-sm"
                           value="{{ old('followers', $influencer->followers) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Engagement Rate (%)</label>
                    <input type="number" step="0.01" name="engagement_rate"
                           class="form-control form-control-sm"
                           value="{{ old('engagement_rate', $influencer->engagement_rate) }}"
                           min="0" max="100"
                           placeholder="misal: 4.50">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Niche / Kategori</label>
                    <input type="text" name="niche" class="form-control form-control-sm"
                           value="{{ old('niche', $influencer->niche) }}" placeholder="fashion, tech, food, dll">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm"
                           value="{{ old('email', $influencer->email) }}" placeholder="optional">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="form-control form-control-sm"
                           value="{{ old('phone', $influencer->phone) }}" placeholder="optional">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Link Profil</label>
                    <input type="url" name="profile_link" class="form-control form-control-sm"
                           value="{{ old('profile_link', $influencer->profile_link) }}" placeholder="https://instagram.com/...">
                </div>

                <div class="col-12">
                    <label class="form-label small">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="form-control form-control-sm"
                              placeholder="Catatan tentang kualitas konten, kerjasama sebelumnya, dll.">{{ old('notes', $influencer->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Update Influencer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
