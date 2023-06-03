@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')

@section('article')
active
@stop

@section('all-article')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.article')}}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.allarticle')}}</h3>
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
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
          @endif
        <div class="row">
            <div class="col-sm-12">
              <table class="table table-bordered data-table3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            <script type="text/javascript">
              $(function () {

                var table = $('.data-table3').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('article') }}",
                    columns: [
                        {data: 'name', name: 'name', width: "25%"},
                        {data: 'description', name: 'description', width: "25%"},
                        {data: 'publish_time', name: 'publish_time', width: "25%"},
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
