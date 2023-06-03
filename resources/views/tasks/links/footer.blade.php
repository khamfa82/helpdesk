<script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"  type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>

<!-- iCheck -->
<script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
<!-- jquery ui -->
<script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

<!-- <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>-->

    <!-- <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script> -->
<!-- Page Script -->
<script src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}" type="text/javascript" ></script>

<script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"></script>


<script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>



<!-- full calendar-->
<script src="{{asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('lb-faveo/plugins/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>

<script>
            $(function() {
            // Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
                    if (clicks) {
            //Uncheck all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
            } else {
            //Check all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
            }
            $(this).data("clicks", !clicks);
            });
                    //Handle starring for glyphicon and font awesome
                    $(".mailbox-star").click(function(e) {
            e.preventDefault();
                    //detect type
                    var $this = $(this).find("a > i");
                    var glyph = $this.hasClass("glyphicon");
                    var fa = $this.hasClass("fa");
                    //Switch states
                    if (glyph) {
            $this.toggleClass("glyphicon-star");
                    $this.toggleClass("glyphicon-star-empty");
            }
            if (fa) {
            $this.toggleClass("fa-star");
                    $this.toggleClass("fa-star-o");
            }
            });
            });</script>

<script src="{{asset("lb-faveo/js/tabby.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/languagechanger.js")}}" type="text/javascript"></script>
<!-- <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script> -->

<script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
            $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });</script>
<script type="text/javascript">
            function clickDashboard(e) {
            if (e.ctrlKey === true) {
            window.open('{{URL::route("dashboard")}}', '_blank');
            } else {
            window.location = "{{URL::route('dashboard')}}";
            }
            }

    function clickReport(e) {
    if (e.ctrlKey === true) {
    window.open('{{URL::route("report.index")}}', '_blank');
    } else {
    window.location = "{{URL::route('report.index')}}";
    }
    }
</script>

<script>
    $(function() {


        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]:not(.not-apply)').iCheck({
            radioClass: 'iradio_flat-blue'
        });

    });
</script>

<script>
    $(function () {
        $('#tasks_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

<?php Event::dispatch('show.calendar.script', array()); ?>
<?php Event::dispatch('load-calendar-scripts', array()); ?>