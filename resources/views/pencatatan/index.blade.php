@extends('template.master')

@section('title', 'Pencatatan')
    

@section('main-content')
<a href="{{ route('pencatatan.create') }}" class="mt-5 mb-3">
    <button class="btn btn-primary mb-3 btn-sm mt-5">Tambah Data</button>
</a>
<div class="card shadow">
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
        <table id="adminTable" class="table table-bordered dt-responsive" style="width: 100%">
            <thead>
                <tr>
                    <th>NO</th>
                    <th class="all">Nomor Surat</th>
                    <th>Berkunjung</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="actionz">
                @php
                $no=0;
                @endphp
                @if (!is_null($pencatatan))
                @foreach ($pencatatan as $data)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->jurusan->nama }}</td>
                    <td class="row justify-content-center" style="min-width: 120px">
                        <a href="{{ route('admin.konsentrasi.edit', $data->id) }}" class="mx-2">
                            <button class="btn btn-primary"><i class="fas fa-edit"></i></button>
                        </a>
                        <form action="{{ route('admin.konsentrasi.destroy', $data->id) }}" method="POST"
                            class="deleteData" data-extra="Akan Menghapus Mata Kuliah yg Berhubungan.">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('script')

@endsection