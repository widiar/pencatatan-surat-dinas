@extends('template.master')

@section('title', 'Laporan Dinas')
    

@section('main-content')
@can('create', App\Models\LaporanDinas::class)
<a href="{{ route('laporan-dinas.create') }}" class="mt-5 mb-3">
    <button class="btn btn-primary mb-3 btn-sm mt-5">Tambah Data</button>
</a>
@endcan
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
                    <th>Hasil Laporan</th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Dokumentasi</th>
                    @canany(['edit', 'delete'], App\Models\LaporanDinas::class)
                    <th class="text-center">Aksi</th>
                    @endcanany
                </tr>
            </thead>
            <tbody class="actionz">
                @php
                $no=0;
                @endphp
                @if (!is_null($laporan))
                @foreach ($laporan as $data)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->pencatatan->nomor_surat }}</td>
                    <td style="max-width: 170px">
                        {!! Str::limit(strip_tags($data->hasil_laporan), 170, '...') !!}
                        <a href="#" data-toggle="modal" data-target="#hasilModal" data-text="{{ $data->hasil_laporan }}">Detail</a>
                    </td>
                    <td>{{ date('d F Y h:i:s A', strtotime($data->created_at)) }}</td>
                    <td class="text-center"><button data-id="{{ $data->id }}" class="btn btn-sm btn-primary notabtn"><i class="fas fa-eye"></i></button></td>
                    <td class="text-center"><button data-id="{{ $data->id }}" class="btn btn-sm btn-primary dokumentasibtn"><i class="fas fa-eye"></i></button></td>
                    @canany(['edit', 'delete'], App\Models\LaporanDinas::class)
                    <td class="row justify-content-center" style="min-width: 120px; border: none !important;">
                        @can('edit', $data)
                        <a href="{{ route('laporan-dinas.edit', $data->id) }}" class="mx-2">
                            <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                        </a>
                        @endcan
                        @can('delete', $data)
                        <form action="{{ route('laporan-dinas.destroy', $data->id) }}" method="POST"
                            class="deleted">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                    </td>
                    @endcanany
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="hasilModal" tabindex="-1" role="dialog" aria-labelledby="hasilLaporanModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hasilLaporanModal">Hasil Laporan Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nota Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row nota">
                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
    let urlShow = `{{ route('laporan-dinas.show', '#id') }}`
    let urlNota = `{{ Storage::url('laporan-dinas/nota/') }}`
    let urlDokumentasi = `{{ Storage::url('laporan-dinas/dokumentasi/') }}`
    $('#hasilModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var html = button.data('text')
        var modal = $(this)
        modal.find('.modal-body').html(html)
    })

    $('body').on('click', '.notabtn', function(e){
        $('.nota').empty()
        let ul = urlShow.replace('#id', $(this).data('id'))
        $.ajax({
            url: ul,
            success: (res) => {
                res.nota.forEach(nota => {
                    let html = `<div class="col-12 my-2">
                                    <img src="${urlNota + nota.foto}" alt="" class="img-thumbnail">
                                </div>`
                    $('.nota').append(html)
                })
            }
        })
        $('#notaModal').modal('show')
    })

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