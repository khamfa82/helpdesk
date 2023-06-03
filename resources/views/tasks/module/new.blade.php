@extends('tasks.layout')

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ Lang::get('lang.new-module') }}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                <form action="/task-modules" method="post" style="padding: 15px !important">
                    @csrf
                    <div class="row">
                        
                        {{-- Name --}}
                        <div class="col col-md-6 form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        
                        {{-- Is Active --}}
                        <div class="col col-md-4 form-group">
                            <label for="is_active">Is Module Active?</label>
                            <br/>
                            Yes <input class="form-control" checked type="radio" value="1" name="is_active" id="is_active">
                            &emsp;No <input class="form-control" type="radio" value="0" name="is_active" id="is_active">
                        </div>
                        
                        <div class="col col-md-2 form-group">
                            <label for="">_</label>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection