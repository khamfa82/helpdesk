@extends('tasks.layout')

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ Lang::get('lang.new-task') }}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                <form action="/tasks" method="post" style="padding: 15px !important">
                    @csrf
                    <div class="row">
                        {{-- Task Description --}}
                        <div class="col col-md-4 form-group">
                            <label for="description">Task Description</label>
                            <textarea style="resize: none" class="form-control" rows="9" name="description" id="description"></textarea>
                        </div>

                        {{-- Assigned --}}
                        <div class="col col-md-4 form-group">
                            <label for="assigned_to">Assigned To</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                <option value="">-- Select Assigned Agent ---</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name . " " . $user->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Module --}}
                        <div class="col col-md-4 form-group">
                            <label for="module">Module (Category)</label>
                            <select name="module" id="module" class="form-control">
                                <option value="">-- Select Task Module ---</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Priority --}}
                        <div class="col col-md-4 form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="">-- Select Task Priority ---</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col col-md-4 form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Select Task Status ---</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Due Date --}}
                        <div class="col col-md-4 form-group">
                            <label for="due_date">Due Date</label>
                            <input class="form-control" type="date" name="due_date" id="due_date">
                        </div>
                        
                        <div class="col col-md-4 form-group">
                            <label for="">_</label>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    
                    <div class="col col-12">
                        <p style="width: 40px; margin:auto; text-align: center; border: 1px solid green; height: 40px; padding-top: 10px; border-radius: 50%; background-color: lightgreen"> 
                            <strong> OR </strong>
                        </p>
                    </div>

                    <div style="padding: 15px !important">
                        <div class="col col-md-9 form-group">
                            <label for="tasks">Tasks Excel File <br>
                            <i>Must have following columns => [task_id, description], optional => [module, status, assigned_to]</i>
                            </label>
                            <input class="form-control" type="file" id="file_upload" accept=".xls,.xlsx" name="tasks" id="tasks">
                        </div>

                        <div class="col col-md-3 form-group">
                            <label for="">_<br>_</label>
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#staticBackdrop" id="upload_excel">Proceed to Upload <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vertically centered scrollable modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover table-stripped" id="import_table">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th>Assigned To</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody id="excel_content">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <form action="/tasks/import" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="import_json_data"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="import_btn" class="btn btn-primary"><i class="fa fa-upload"></i> Upload Now</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    {{-- <script defer src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script> --}}
    <script>
        var selected_file;
        var modal_heading = document.getElementById("staticBackdropLabel");
        var import_btn = document.getElementById("import_btn");
        var excel_content = document.getElementById("excel_content");
        var tbl_content = '';

        document
          .getElementById("file_upload")
          .addEventListener("change", function(event) {
            modal_heading.innerHTML = event.target.files[0].name;
            selected_file = event.target.files[0];
          });

        document
          .getElementById("upload_excel")
          .addEventListener("click", function() {
            import_btn.disabled = false;
            import_btn.type = "submit";
              
            if (selected_file) {
              var file_reader = new FileReader();
              file_reader.onload = function(event) {
                var data = event.target.result;
                
                const readOpts = {
                    cellText: false, 
                    cellDates: true,
                };      

                var workbook = XLSX.read(data, {
                  type: "binary"
                });

                workbook.SheetNames.forEach(sheet => {
                    let row_object = XLSX.utils.sheet_to_row_object_array(
                        workbook.Sheets[sheet]
                    );
                    
                    if ( $.fn.dataTable.isDataTable( '#import_table' ) )
                        dt_imports.destroy();

                    if(!columns_are_valid(row_object[0])) {
                        import_btn.disabled = true;
                        import_btn.type = "button";
                        excel_content.innerHTML = `<tr class="bg-danger text-center"><td colspan="7">Supported data are not found on this file.</td></tr>`;
                        return;
                    }
                    
                    tbl_content = '';
                    
                    row_object.forEach((row) => {
                        row.due_date = excel_date_to_js_date(row?.due_date);
                        tbl_content += `
                            <tr>
                                <td>${row?.task_id}</td>
                                <td>${row?.module}</td>
                                <td>${row?.description}</td>
                                <td>${row?.assigned_to ?? "Not Assigned"}</td>
                                <td>${row?.priority}</td>
                                <td>${row?.status}</td>
                                <td>${row?.due_date ?? "Not Set"}</td>
                            </tr>
                        `;
                    });

                    document.getElementById("excel_content").innerHTML = tbl_content;
                    
                    let json_object = JSON.stringify(row_object);
                    
                    document.getElementById("import_json_data").innerHTML = `<input type="hidden" name="import_data" value='${json_object}' />`;

                    dt_imports = $('#import_table').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                });
              };
              file_reader.readAsBinaryString(selected_file);
            }
          });

          function columns_are_valid(data) {
            var _status = (typeof data?.task_id == 'string' || typeof data?.task_id == 'number') && 
                typeof data?.description == 'string';
            
            console.log(data, _status, excel_date_to_js_date(data.due_date));
            
            return _status;
          }

          function excel_date_to_js_date(serial) {
            if (serial == "-")
                return "-";

            var utc_days  = Math.floor(serial - 25569);
            var utc_value = utc_days * 86400;                                        
            var date_info = new Date(utc_value * 1000);

            var fractional_day = serial - Math.floor(serial) + 0.0000001;

            var total_seconds = Math.floor(86400 * fractional_day);

            var seconds = total_seconds % 60;

            total_seconds -= seconds;

            var hours = Math.floor(total_seconds / (60 * 60));
            var minutes = Math.floor(total_seconds / 60) % 60;
            let month = (date_info.getMonth() * 1) + Number(1);
            return date_info.getFullYear() + "-" + month + "-" + date_info.getDate();
        }   
      </script>

@endsection