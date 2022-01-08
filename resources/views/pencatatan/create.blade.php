@extends('template.master')

@section('title', 'Tambah Pencatatan')
    
@section('main-content')
<div class="card shadow mt-5">
    <div class="card-body">
        <form action="{{ route('pencatatan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="text">Nomor Surat<span class="text-danger">*</span></label>
                <input type="text" required name="no_surat"
                    class="form-control  @error('no_surat') is-invalid @enderror"
                    value="{{ old('no_surat', @$data->nama) }}">
                @error('no_surat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Dinas Berkunjung<span class="text-danger">*</span></label>
                <input type="text" required name="dinas"
                    class="form-control  @error('dinas') is-invalid @enderror"
                    value="{{ old('dinas', @$data->nama) }}">
                @error('dinas')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Tanggal Berkunjung<span class="text-danger">*</span></label>
                <input type="text" required name="tanggal"
                    class="form-control date @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', @$data->nama) }}">
                @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Status<span class="text-danger">*</span></label>
                <select name="status" required class="custom-select @error('status') is-invalid @enderror">
                    <option {{ old('status') == "akan datang" ? "selected" : "" }} value="akan datang">Akan Datang</option>
                    <option {{ old('status') == "berlangsung"? "selected" : "" }} value="berlangsung">Berlangsung</option>
                    <option {{ old('status') == "selesai" ? "selected" : "" }} value="selesai">Selesai</option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary float-right">Save</button>
        </form>
    </div>

</div>
@endsection

@section('script')

@endsection