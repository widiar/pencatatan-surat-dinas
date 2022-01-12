@extends('template.master')

@section('title', 'Kunjungan')
    

@section('main-content')
<a href="{{ route('kunjungan.create') }}" class="mt-5 mb-3">
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
                    <th>Nama Dinas</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Dokumentasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="actionz">
                @php
                $no=0;
                @endphp
                @if (!is_null($datas))
                @foreach ($datas as $data)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->nomor_surat }}</td>
                    <td >{{ $data->nama_dinas }}</a>
                    </td>
                    <td>{{ date('d F Y h:i:s A', strtotime($data->tanggal)) }}</td>
                    <td class="text-center">{{ $data->tujuan }}</td>
                    <td class="text-center"><button data-id="{{ $data->id }}" class="btn btn-sm btn-primary dokumentasibtn"><i class="fas fa-eye"></i></button></td>
                    <td class="row justify-content-center" style="min-width: 120px; border: none !important;">
                        <a href="{{ route('kunjungan.edit', $data->id) }}" class="mx-2">
                            <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                        </a>
                        <form action="{{ route('kunjungan.destroy', $data->id) }}" method="POST"
                            class="deleted">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="dokumentasiModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dokumentasi Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body dokumentasi">
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let urlShow = `{{ route('kunjungan.show', '#id') }}`
    let urlDokumentasi = `{{ Storage::url('kunjungan/dokumentasi/') }}`

    $('body').on('click', '.dokumentasibtn', function(e){
        $('.dokumentasi').empty()
        let ul = urlShow.replace('#id', $(this).data('id'))
        $.ajax({
            url: ul,
            success: (res) => {
                res.dokumentasi.forEach(dok => {
                    let html = `<div class="col-12 my-2">
                                    <img src="${urlDokumentasi + dok.foto}" alt="" class="img-thumbnail">
                                </div>`
                    $('.dokumentasi').append(html)
                })
            }
        })
        $('#dokumentasiModal').modal('show')
    })
</script>
@endsection