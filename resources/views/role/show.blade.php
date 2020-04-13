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
            <div class="card-header"><label>Show Role</label></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Role : {{$role->name}}</label>
                </div>

                <div class="card col-sm-6">
                    <div class="card-header"><label>Permission</label></div>
                    <div class="card-body">
                        <div class="col-sm-6">
                            <div>
                                <table class="table">
                                    <tbody>
                                        @foreach ($permission as $key => $value)
                                        <tr class="input-group-sm">
                                            <td>{{$value}}</td>
                                            <td><input type="checkbox" name="permission" class="permission" value="{{$value}}" @if($role->hasPermissionTo($value)) checked @endif></td>
                                        </tr>
                                        @endforeach
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

                }
            });
    }

</script>
@endsection
