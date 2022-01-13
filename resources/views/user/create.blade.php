@extends('template.master')

@section('title', 'Tambah User')
    
@section('main-content')
<div class="card shadow mt-5">
    <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" id="form-user">
            @csrf
            <div class="form-group">
                <label for="text">Nama Lengkap<span class="text-danger">*</span></label>
                <input type="text" name="nama"
                    class="form-control  @error('nama') is-invalid @enderror"
                    value="{{ old('nama', @$data->nama) }}">
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Username<span class="text-danger">*</span></label>
                <input type="text" name="username"
                    class="form-control  @error('username') is-invalid @enderror"
                    value="{{ old('username', @$data->nama) }}">
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Password<span class="text-danger">*</span></label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    value="{{ old('password', @$data->nama) }}">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Retype Password<span class="text-danger">*</span></label>
                <input type="password" name="retype_password"
                    class="form-control @error('retype_password') is-invalid @enderror"
                    value="{{ old('retype_password', @$data->nama) }}">
                @error('retype_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Avatar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="avatar" accept="image/*">
                    <label class="custom-file-label">Select file</label>
                </div>
                @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <hr>
            <table class="table table-bordered table-striped dtr-inline">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Permission</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h5>Pencatatan Surat</h5>
                        </td>
                        <td>
                            <ul class="list-inline">                                    
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Lihat Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="surat_view">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Tambah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="surat_add">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Ubah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="surat_edit">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Hapus Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="surat_delete">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Laporan Dinas</h5>
                        </td>
                        <td>
                            <ul class="list-inline">                                    
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Lihat Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="dinas_view">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Tambah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="dinas_add">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Ubah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="dinas_edit">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Hapus Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="dinas_delete">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Berkunjung</h5>
                        </td>
                        <td>
                            <ul class="list-inline">                                    
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Lihat Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="kunjungan_view">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Tambah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="kunjungan_add">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Ubah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="kunjungan_edit">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Hapus Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="kunjungan_delete">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>User Management</h5>
                        </td>
                        <td>
                            <ul class="list-inline">                                    
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Lihat Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="user_view">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Tambah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="user_add">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Ubah Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="user_edit">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-inline-item mr-2">
                                    <div class="card" style="max-width: 10rem">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item font-weight-bold">Hapus Data</li>
                                            <li class="list-group-item text-center">
                                                <input type="checkbox" name="permission[]" value="user_delete">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary float-right">Save</button>
        </form>
    </div>

</div>
@endsection

@section('script')
<script>
    $('#form-user').validate({
        rules: {
            nama: 'required',
            username: 'required',
            password: 'required',
            retype_password: {
                equalTo: '#password',
                required: true
            }
        }
    })
</script>
@endsection