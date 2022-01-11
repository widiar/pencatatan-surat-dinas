@extends('template.master')

@section('title', 'Edit Laporan Dinas')

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
        <form action="{{ route('laporan-dinas.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="text">Nomor Surat<span class="text-danger">*</span></label>
                <select name="no_surat" required
                    class="custom-select form-control select2" style="width: 100%">
                </select>
                @error('no_surat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="hasil">Hasil Laporan<span class="text-danger">*</span></label>
                <textarea required name="hasil" id="hasil"
                    class="form-control @error('hasil') is-invalid @enderror">{{ old('hasil') }}</textarea>
                @error('hasil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="text">Nota<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input nota" name="nota[]" required accept="image/*" multiple>
                    <label class="custom-file-label label-nota">Select file</label>
                </div>
                @error('nota')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="row image-nota my-3">
                    
                </div>
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
    const initSurat = () => {
        let urlSurat = `{{ route('search.pencatatan') }}`;
        $(".select2").select2({
            theme: "bootstrap",
            minimumInputLength: 2,
            ajax: {
                url: urlSurat,
                dataType: 'json',
                delay: 1000,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    }
    let notaData
    let dokumentasiData
    CKEDITOR.replace('hasil');


    $('.nota').change(function(e){
        // console.log(e.target.files)
        notaData = Array.from(e.target.files)
        $('.image-nota').empty()
        let i = 0;
        Array.from(e.target.files).forEach(file => {
            // console.log(file)
            let url = URL.createObjectURL(file)
            let image = `
            <div class="col-3">
                <div class="img-frame">
                    <img src="${url}" alt="" class="img-responsive">
                    <div class="delete-image delete-nota" data-id="${i}"><strong>Delete Image</strong></div>
                </div>      
            </div>`
            $('.image-nota').append(image)
            i++;
        })
    })

    const checkLengthNotaData = () => {
        let length = 0
        notaData.forEach(elm => {
            if(elm !== null) length++
        })
        return length
    }

    const changeLabelNota = () => {
        if($('.nota').val() == '' || $('.nota').val() == null){
            $('.label-nota').text('Select file')
        }
        else {
            let textLabel = ''
            notaData.forEach(elm => {
                if(elm !== null) {
                    textLabel += `${elm.name}, `
                }
            })
            $('.label-nota').text(textLabel)
        }
    }

    $('body').on('click', '.delete-nota', function(e) {
        let id = $(this).data('id')
        notaData[id] = null
        $(this).parent().parent().remove()
        if(checkLengthNotaData() <= 0) $('.nota').val(null)
        changeLabelNota()
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
        notaData.forEach(file => {
            if(file !== null) {
                dataform.append('notafile[]', file)
            }
        })
        dokumentasiData.forEach(file => {
            if(file !== null) {
                dataform.append('dokfile[]', file)
            }
        })

        dataform.append('hasil', CKEDITOR.instances.hasil.getData())
        $.ajax({
            url: $(this).attr('action'),
            data: dataform,
            type: 'POST',
            contentType: false, 
            processData: false, 
            success: (res) => {
                if(res == 'Sukses') window.location.href = '{{ route("laporan-dinas.index") }}'
            }, 
            error: (err) => {
                console.log(err.responseJSON)
            }
        });
    })

    initSurat()
</script>
@endsection