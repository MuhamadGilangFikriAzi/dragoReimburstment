@extends('layouts.app')

@section('content')
<div class="container mt-2">
<div class="row justify-content-center">
    <div class="col-sm-12">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <label>Role : {{$role->name}}</label>
                <div class="header-elements float-right">
                    <a href="{{ route('role.index') }}" class=" btn-link" ><i class="fas fa-arrow-left"></i>&nbsp;Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="card col-sm-12">
                    <div class="card-header"><label>Permission</label></div>
                    <div class="card-body">
                        <div class="col-sm-6">
                            <div>
                                <table class="table">
                                    <tbody>
                                        <tr class="input-group-sm">
                                        @foreach ($permission as $key => $value)
                                            <td>{{$value}}</td>
                                            <td><input type="checkbox" name="permission" class="permission" value="{{$value}}" @if($role->hasPermissionTo($value)) checked @endif></td>
                                            @if($loop->iteration%6 == 0)
                                        </tr>
                                        <tr class="input-group-sm">
                                            @endif
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.permission').on('change',function(){
        id = {!! $role->id !!};
        checked = $(this).prop('checked');
        val = $(this).val();
        url = '{{route('role.hasPermission')}}';
        method = 'post';
	    dataSend = {
            "_token": "{{ csrf_token() }}",
            'id' : id,
            'checked' : checked,
            'permission':val
        };

        sendAjax(url, method, dataSend)
    });

    function sendAjax(url, method, dataSend){
        $.ajax({
	        url : url,
			method : method,
			dataType : 'JSON',
			data : dataSend,
			success : function(data){
                    alert(data.massage);
                }
            });
    }

</script>
@endsection
