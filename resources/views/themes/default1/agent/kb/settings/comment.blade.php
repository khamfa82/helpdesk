@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')
@section('PageHeader')
<h1>{!! Lang::get('lang.comments') !!}</h1>
@stop
@section('comment')
class="active"
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.comments-list')}}</h3>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered data-table">
                  <thead>
                      <tr>
                          <!-- <th>S/N</th> -->
                          <th>Details</th>
                          <th>Comment</th>
                          <th>Status</th>
                          <th width="100px">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>


              <script type="text/javascript">
                $(function () {

                  var table = $('.data-table').DataTable({
                      processing: true,
                      serverSide: true,
                      ajax: "{{ route('comment') }}",
                      columns: [
                          // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                          {data: 'details', name: 'details', width: "25%"},
                          {data: 'comment', name: 'comment', width: "25%"},
                          {data: 'status', name: 'status', width: "25%"},
                          {data: 'actions', name: 'actions', orderable: false, searchable: false, width: "25%"},
                      ]
                  });

                });
              </script>


            </div>
        </div>
    </div>
</div>

@stop
