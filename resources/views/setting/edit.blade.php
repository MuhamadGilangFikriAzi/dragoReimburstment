@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">


            <div class="card col-sm-12">
                <div class="card-header">
                    {{$pageTitle}}
                    <div class="header-elements float-right">
                        <a href="{{ route($urlIndex) }}" class=" btn-link" ><i class="fas fa-arrow-left"></i>&nbsp;Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="card col-sm-5 mr-1 ml-1">
                            <div class="card-header bg-light">
                                @if ($data->nama == 'langsung' || $data->nama == 'transfer')
                                    Asal dana :
                                @endif
                                {{$data->nama}}
                                <a href="#" class="btn btn-sm btn-link float-right" id="tambah"><i class="fas fa-plus"></i>&nbsp;Tambah</a>
                            </div>
                            <div class="card-body">
                                <form action="{{route($urlUpdate,$data->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input" id="input">
                                    @foreach (json_decode($data->value) as $key => $value)
                                    <div class="d-flex mt-1 mb-1">
                                        <input type="text" name="nama[]" class="form-control nama " placeholder="Masukan disini" value="{{$value}}">
                                        <button type="button" class="btn btn-xs btn-danger btn-remove ml-1 col-sm-1"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></button>
                                    </div>
                                    @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-info form-control">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


    </div>
</section>
<script>
    $(document).ready(function() {
        $('#input').on('click', '.btn-remove', function(e){
            e.preventDefault();
            $(this).parent().remove();
        });

        $('#tambah').click(function(e){
          e.preventDefault();

          $('#input').append(
            '<div class="d-flex mt-1 mb-1">\
                <input type="text" name="nama[]" class="form-control nama " placeholder="Masukan disini">\
                <button class="btn btn-xs btn-danger btn-remove ml-1 col-sm-1"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></button>\
            </div>'
          );

            $('#input').on('click', '.btn-remove', function(e){
                e.preventDefault();
                $(this).parent().remove();
            });

        });
      });

</script>

@endsection
