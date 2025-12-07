@extends('layouts.app')

@section('title', 'Edit Kriteria')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="fw-semibold mb-1">Edit Kriteria</h4>
        <p class="text-muted mb-0 small">
            Perbarui data kriteria: {{ $criterion->code }} - {{ $criterion->name }}
        </p>
    </div>
    <a href="{{ route('staff.criteria.index') }}" class="btn btn-secondary btn-sm">
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
        <form action="{{ route('staff.criteria.update', $criterion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Kode Kriteria</label>
                    <input type="text" name="code" class="form-control form-control-sm"
                           value="{{ old('code', $criterion->code) }}" required>
                </div>

                <div class="col-md-9">
                    <label class="form-label small">Nama Kriteria</label>
                    <input type="text" name="name" class="form-control form-control-sm"
                           value="{{ old('name', $criterion->name) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Jenis</label>
                    <select name="type" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="benefit" {{ old('type', $criterion->type) === 'benefit' ? 'selected' : '' }}>Benefit (semakin besar semakin baik)</option>
                        <option value="cost" {{ old('type', $criterion->type) === 'cost' ? 'selected' : '' }}>Cost (semakin kecil semakin baik)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Bobot (0 - 1)</label>
                    <input type="number" step="0.0001" min="0" max="1"
                           name="weight" class="form-control form-control-sm"
                           value="{{ old('weight', $criterion->weight) }}" required>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active"
                               name="is_active" {{ old('is_active', $criterion->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="is_active">
                            Aktif digunakan
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label small">Deskripsi / Catatan</label>
                    <textarea name="description" rows="3" class="form-control form-control-sm"
                              placeholder="Deskripsi kriteria">{{ old('description', $criterion->description) }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Update Kriteria
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
