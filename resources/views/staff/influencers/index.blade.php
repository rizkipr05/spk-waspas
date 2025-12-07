@extends('layouts.app')

@section('title', 'Daftar Influencer')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Daftar Influencer</h4>
            <a href="{{ route('staff.influencers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Influencer
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('staff.influencers.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari nama, username, platform..." value="{{ request('q') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Platform</th>
                        <th>Followers</th>
                        <th>Engagement</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($influencers as $influencer)
                    <tr>
                        <td>{{ $loop->iteration + $influencers->firstItem() - 1 }}</td>
                        <td>{{ $influencer->name ?? '-' }}</td>
                        <td>{{ $influencer->username ?? '-' }}</td>
                        <td>{{ $influencer->platform ?? '-' }}</td>
                        <td>{{ number_format($influencer->followers ?? 0) }}</td>
                        <td>{{ $influencer->engagement_rate ?? 0 }}%</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('staff.influencers.edit', $influencer->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('staff.influencers.destroy', $influencer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus influencer ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data influencer.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $influencers->links() }}
        </div>
    </div>
</div>
@endsection
