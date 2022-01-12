@extends('template.master')

@section('title', 'Tambah Kunjungan')

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
        <form action="{{ route('kunjungan.store') }}" method="POST" enctype="multipart/form-data" id="form">
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
                <label for="text">Nama Dinas<span class="text-danger">*</span></label>
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
                    class="form-control dateNow @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', @$data->nama) }}">
                @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Tujuan<span class="text-danger">*</span></label>
                <input type="text" required name="tujuan"
                    class="form-control  @error('tujuan') is-invalid @enderror"
                    value="{{ old('tujuan', @$data->nama) }}">
                @error('tujuan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Dokumentasi<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input dokumentasi" name="dokumentasi[]" required accept="image/*" multiple>
                    <label class="custom-file-label label-dokumentasi">Select file</label>
                </div>
                @error('dokumentasi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="row image-dokumentasi my-3">
                    
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

    const checkLengthDokumentasiData = () => {
        let length = 0
        dokumentasiData.forEach(elm => {
            if(elm !== null) length++
        })
        return length
    }

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
        if(checkLengthDokumentasiData() <= 0) $('.dokumentasi').val(null)
        changeLabelDokumentasi()
    })

    $('#form').submit(function(e){
        e.preventDefault()

        let dataform = new FormData(this)
        dokumentasiData.forEach(file => {
            if(file !== null) {
                dataform.append('dokfile[]', file)
            }
        })

        // dataform.append('hasil', CKEDITOR.instances.hasil.getData())
        $.ajax({
            url: $(this).attr('action'),
            data: dataform,
            type: 'POST',
            contentType: false, 
            processData: false, 
            success: (res) => {
                if(res == 'Sukses') window.location.href = '{{ route("kunjungan.index") }}'
            }, 
            error: (err) => {
                console.log(err.responseJSON)
            }
        });
    })
</script>
@endsection