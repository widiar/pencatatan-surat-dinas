@extends('template.master')

@section('title', 'Update Profile')
    
@section('main-content')
<div class="card shadow mt-5">
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon ti-check"></i> BERHASIL!</h5>
            {{session('success')}}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon ti-close"></i> GAGAL!</h5>
            {{session('error')}}
        </div>
        @endif
        <form action="" method="POST" enctype="multipart/form-data" id="form-user">
            @csrf
            <div class="form-group">
                <label for="text">Nama Lengkap<span class="text-danger">*</span></label>
                <input type="text" name="nama"
                    class="form-control  @error('nama') is-invalid @enderror"
                    value="{{ old('nama', @$data->name) }}">
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Username<span class="text-danger">*</span></label>
                <input type="text" name="username"
                    class="form-control  @error('username') is-invalid @enderror"
                    value="{{ old('username', @$data->username) }}">
                @error('username')
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
                @if($data->avatar)
                <small class="text-info"><a href="{{ Storage::url('profile/avatar/') . $data->avatar }}" target="_blank">Lihat Foto</a></small>
                @endif
            </div>
            <hr>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ubahpwModal">
                Ubah Password
            </button>
            <button class="btn btn-primary float-right">Save</button>
        </form>
    </div>

    <div class="modal fade" id="ubahpwModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('change.password') }}" method="POST" id="form-pw">
                @csrf
                <div class="modal-body">
                    @if(session('error-pw'))
                    <div class="alert alert-danger error-pw alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon ti-close"></i> GAGAL!</h5>
                        {{session('error-pw')}}
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="text">Old Password<span class="text-danger">*</span></label>
                        <input type="password" id="oldpassword" name="oldpassword"
                            class="form-control @error('oldpassword') is-invalid @enderror"
                            value="{{ old('oldpassword') }}">
                        @error('oldpassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="text">New Password<span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password') }}">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="text">Retype Password<span class="text-danger">*</span></label>
                        <input type="password" name="retype_password"
                            class="form-control @error('retype_password') is-invalid @enderror"
                            value="{{ old('retype_password') }}">
                        @error('retype_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
          </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    $('#form-user').validate({
        rules: {
            nama: 'required',
            username: 'required',
        }
    })
    $('#form-pw').validate({
        rules: {
            oldpassword: 'required',
            password: 'required',
            retype_password: {
                equalTo: '#password',
                required: true
            }
        }
    })
    $(document).ready(function(){
        if($('.error-pw').html() !== undefined) {
            $('#ubahpwModal').modal('show')
        }
    })
</script>
@endsection