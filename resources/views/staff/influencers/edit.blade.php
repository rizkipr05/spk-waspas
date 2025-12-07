@extends('layouts.app')

@section('title', 'Edit Influencer')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Edit Influencer</h4>

        <a href="{{ route('staff.influencers.index') }}" class="btn btn-secondary btn-sm mb-3">
            &larr; Kembali ke daftar
        </a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.influencers.update', $influencer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Influencer <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $influencer->name) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $influencer->username) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="platform" class="form-label">Platform <span class="text-danger">*</span></label>
                    <select name="platform" id="platform" class="form-select" required>
                        <option value="">-- Pilih Platform --</option>
                        <option value="Instagram" {{ old('platform', $influencer->platform) == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="TikTok" {{ old('platform', $influencer->platform) == 'TikTok' ? 'selected' : '' }}>TikTok</option>
                        <option value="YouTube" {{ old('platform', $influencer->platform) == 'YouTube' ? 'selected' : '' }}>YouTube</option>
                        <option value="Twitter" {{ old('platform', $influencer->platform) == 'Twitter' ? 'selected' : '' }}>Twitter</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="followers" class="form-label">Followers <span class="text-danger">*</span></label>
                    <input type="number" name="followers" id="followers" class="form-control" value="{{ old('followers', $influencer->followers) }}" required min="0">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="engagement_rate" class="form-label">Engagement Rate (%)</label>
                    <input type="number" step="0.01" name="engagement_rate" id="engagement_rate" class="form-control" value="{{ old('engagement_rate', $influencer->engagement_rate) }}" min="0" max="100">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="niche" class="form-label">Niche / Kategori</label>
                    <input type="text" name="niche" id="niche" class="form-control" value="{{ old('niche', $influencer->niche) }}" placeholder="Contoh: Fashion, Food, Tech">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $influencer->email) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $influencer->phone) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="profile_link" class="form-label">Link Profil</label>
                <input type="url" name="profile_link" id="profile_link" class="form-control" value="{{ old('profile_link', $influencer->profile_link) }}" placeholder="https://...">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Catatan Tambahan</label>
                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $influencer->notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui
            </button>
        </form>
    </div>
</div>
@endsection
