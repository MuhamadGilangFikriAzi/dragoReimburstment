@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Date Result</b></div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ url('result') }}" method="get">
                       <table class="table table-striped">
                           <tr>
                               <td>Dari tanggal</td>
                               <td><input type="date" name="date1" class="form-control"></td>
                           </tr>
                           <tr>
                               <td>Sampai tanggal</td>
                               <td><input type="date" name="date2" class="form-control"></td>
                           </tr>
                       </table>
                       <button type="submit" class="btn btn-primary float-left">Submit</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection
