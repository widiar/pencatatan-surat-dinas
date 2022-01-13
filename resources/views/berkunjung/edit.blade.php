@extends('template.master')

@section('title', 'Edit Kunjungan')

@section('css')
    <style>
        .img-frame {
            position: relative;
        }

        .img-frame:hover .delete-image {
            display: block;
        }

        .delete-image {
            position: absolute;
            bottom: 0;
            font-size: 18px;
            background: rgb(71, 71, 71);
            opacity: 0.8;
            width: 100%;
            text-align: center;
            height: 30px;
            color: #fff;
            cursor: pointer;
            display: none;
        }
    </style>
@endsection
    
@section('main-content')
<div class="card shadow mt-5">
    <div class="card-body">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon ti-close"></i> GAGAL!</h5>
            {{session('error')}}
        </div>
        @endif
        <form action="{{ route('kunjungan.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="form">
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
                <label for="text">Nama Dinas<span class="text-danger">*</span></label>
                <input type="text" required name="dinas"
                    class="form-control  @error('dinas') is-invalid @enderror"
                    value="{{ old('dinas', @$data->nama_dinas) }}">
                @error('dinas')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Tanggal Berkunjung<span class="text-danger">*</span></label>
                <input type="text" required name="tanggal"
                    class="form-control dateNow @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', @$data->tanggal) }}">
                @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Tujuan<span class="text-danger">*</span></label>
                <input type="text" required name="tujuan"
                    class="form-control  @error('tujuan') is-invalid @enderror"
                    value="{{ old('tujuan', @$data->tujuan) }}">
                @error('tujuan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Dokumentasi<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input dokumentasi" name="dokumentasi[]" accept="image/*" multiple>
                    <label class="custom-file-label label-dokumentasi">Select file</label>
                </div>
                @error('dokumentasi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="row my-3">
                    @foreach ($data->dokumentasi as $dokumentasi)
                    <div class="col-3">
                        <div class="img-frame">
                            <img src="{{ Storage::url('kunjungan/dokumentasi/') . $dokumentasi->foto }}" alt="" class="img-responsive">
                            <div class="delete-image hapus-dokumentasi" data-id="{{ $dokumentasi->id }}"><strong>Delete Image</strong></div>
                        </div> 
                    </div>
                    @endforeach
                    <div class="image-dokumentasi row my-3">

                    </div>
                </div>
            </div>
            <hr>
            <button class="btn btn-primary float-right">Save</button>
        </form>
    </div>

</div>
@endsection

@section('script')
<script>
   
    let dokumentasiData

    $('.dateNow').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
        endDate: "today"
    })

    $('.dokumentasi').change(function(e){
        dokumentasiData = Array.from(e.target.files)
        $('.image-dokumentasi').empty()
        let i = 0;
        Array.from(e.target.files).forEach(file => {
            let url = URL.createObjectURL(file)
            let image = `
            <div class="col-3">
                <div class="img-frame">
                    <img src="${url}" alt="" class="img-responsive">
                    <div class="delete-image delete-dokumentasi" data-id="${i}"><strong>Delete Image</strong></div>
                </div>      
            </div>`
            $('.image-dokumentasi').append(image)
            i++;
        })
    })

    const changeLabelDokumentasi = () => {
        if($('.dokumentasi').val() == '' || $('.dokumentasi').val() == null){
            $('.label-dokumentasi').text('Select file')
        }
        else {
            let textLabel = ''
            dokumentasiData.forEach(elm => {
                if(elm !== null) {
                    textLabel += `${elm.name}, `
                }
            })
            $('.label-dokumentasi').text(textLabel)
        }
    }

    $('body').on('click', '.delete-dokumentasi', function(e) {
        let id = $(this).data('id')
        dokumentasiData[id] = null
        $(this).parent().parent().remove()
        changeLabelDokumentasi()
    })

    $('#form').submit(function(e){
        e.preventDefault()

        let dataform = new FormData(this)
        if(dokumentasiData !== undefined)
            dokumentasiData.forEach(file => {
                if(file !== null) {
                    dataform.append('dokfile[]', file)
                }
            })

        $.ajax({
            url: $(this).attr('action'),
            data: dataform,
            type: 'POST',
            contentType: false, 
            processData: false, 
            success: (res) => {
                if(res == 'Sukses') window.location.href = '{{ route("kunjungan.index") }}'
                else window.location.href = ''
            }, 
            error: (err) => {
                console.log(err.responseJSON)
            }
        });
    })

    $('body').on('click', '.hapus-dokumentasi', function(e) {
        let id = $(this).data('id')
        let button = $(this)
        Swal.fire({
            title: 'Loading',
            timer: 20000,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
                Swal.stopTimer()
                $.ajax({
                    url: `{{ route('delete-dokumentasi-kunjungan') }}`,
                    method: 'DELETE',
                    data: {
                        id: id
                    },
                    success: (res) => {
                        button.parent().parent().remove()
                    },
                    complete: () => {
                        Swal.close()
                    },

                })
            }
        })
    })
</script>
@endsection