@extends('layouts.admin')

@section('title', 'Edit Master Shift')

@section('content')
<!-- Header -->
<div class="mb-4">
    <a href="{{ route('master_shift.index') }}" class="btn btn-light" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px;" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="form-container" style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 30px; margin: 0 auto; max-width: 800px;">
    <h6 class="text-uppercase fw-bold mb-4" style="font-size:12px; color: #1a5ca6; letter-spacing:0.5px;">Edit Master Shift</h6>
    
    <form action="{{ route('master_shift.update', $shift->id_master_shift) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Shift <span class="text-danger">*</span></label>
            <input type="text" name="nama_shift" class="form-control" value="{{ $shift->nama_shift }}" required style="border-radius: 8px; border: 1px solid #d1d5db; padding: 10px 15px; font-size: 14px;">
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Jam Mulai <span class="text-danger">*</span></label>
                <input type="time" name="jam_mulai" class="form-control" value="{{ $shift->jam_mulai }}" required style="border-radius: 8px; border: 1px solid #d1d5db; padding: 10px 15px; font-size: 14px;">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Jam Selesai <span class="text-danger">*</span></label>
                <input type="time" name="jam_selesai" class="form-control" value="{{ $shift->jam_selesai }}" required style="border-radius: 8px; border: 1px solid #d1d5db; padding: 10px 15px; font-size: 14px;">
            </div>
        </div>

        <hr class="my-4" style="border-color: #f3f4f6;">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('master_shift.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
