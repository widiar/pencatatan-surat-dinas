@extends('template.master')

@section('title', 'Edit Perjalanan')
    
@section('main-content')
<div class="card shadow mt-5">
    <div class="card-body">
        <form action="{{ route('pencatatan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="text">Nomor Surat<span class="text-danger">*</span></label>
                <input type="text" required name="no_surat"
                    class="form-control  @error('no_surat') is-invalid @enderror"
                    value="{{ old('no_surat', @$data->nomor_surat) }}">
                @error('no_surat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Dinas Berkunjung<span class="text-danger">*</span></label>
                <input type="text" required name="dinas"
                    class="form-control  @error('dinas') is-invalid @enderror"
                    value="{{ old('dinas', @$data->dinas_berkunjung) }}">
                @error('dinas')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Tanggal Berkunjung<span class="text-danger">*</span></label>
                <input type="text" required name="tanggal"
                    class="form-control date @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', @$data->tanggal) }}">
                @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Foto Surat<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('foto_surat') is-invalid @enderror" name="foto_surat" accept="image/*">
                    <label class="custom-file-label">Select file</label>
                    @error('foto_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if(!is_null($data->foto_surat))
                <a href="{{ Storage::url('perjalanan/foto-surat/') . $data->foto_surat }}" target="_blank"><small class="text-info">Lihat Foto Surat</small></a>
                @endif
            </div>
            <div class="form-group">
                <label for="text">Status<span class="text-danger">*</span></label>
                <select name="status" required class="custom-select @error('status') is-invalid @enderror">
                    <option {{ old('status', $data->status) == "akan datang" ? "selected" : "" }} value="akan datang">Akan Datang</option>
                    <option {{ old('status', $data->status) == "berlangsung"? "selected" : "" }} value="berlangsung">Berlangsung</option>
                    <option {{ old('status', $data->status) == "selesai" ? "selected" : "" }} value="selesai">Selesai</option>
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