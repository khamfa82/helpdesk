<script type="text/javascript">
    var $dept_list = $("#departments-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($dept_list);
            @if (array_key_exists('departments', $inputs))
            addFilters($dept_list, '<?= json_encode($inputs["departments"]) ?>');
            @endif

            var $sla_list = $("#sla-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($sla_list);
            @if (array_key_exists('sla', $inputs))
            addFilters($sla_list, '<?= json_encode($inputs["sla"]) ?>');
            @endif

            var $priority_list = $("#priority-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($priority_list);
            @if (array_key_exists('priority', $inputs))
            addFilters($priority_list, '<?= json_encode($inputs["priority"]) ?>');
            @endif

            var $labels_list = $("#labels-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($labels_list);
            @if (array_key_exists('labels', $inputs))
            addFilters($labels_list, '<?= json_encode($inputs["labels"]) ?>');
            @endif

            var $tags_list = $("#tags-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($tags_list);
            @if (array_key_exists('tags', $inputs))
            addFilters($tags_list, '<?= json_encode($inputs["tags"]) ?>');
            @endif

            var $owner_list = $("#owner-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($owner_list);
            @if (array_key_exists('created-by', $inputs))
            @endif

            // var select_assigen_list = $("#select-assign-agent").addSelectlist({maximumSelectionLength : 1});
            // valueSelected(select_assigen_list);
            var $assignee_list = $("#assigned-to-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($assignee_list);
            @if (array_key_exists('assigned-to', $inputs))
            @endif

            var $status_list = $("#status-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($status_list);
            @if (array_key_exists('status', $inputs))
            addFilters($status_list, '<?= json_encode($inputs["status"]) ?>');
            @endif

            var $source_list = $("#source-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($source_list);
            @if (array_key_exists('source', $inputs))
            addFilters($source_list, '<?= json_encode($inputs["source"]) ?>');
            @endif

            var $type_list = $("#type-filter").addSelectlist({maximumSelectionLength : 5});
            valueSelected($type_list);
            @if (array_key_exists('types', $inputs))
            addFilters($type_list, '<?= json_encode($inputs["types"]) ?>');
            @endif

            var $number_list = $("#ticket-number").addSelectlist({maximumSelectionLength : 5});
            valueSelected($number_list);
            @if (array_key_exists('ticket-number', $inputs))
            var input = JSON.parse('<?= json_encode($inputs["ticket-number"]) ?>');
            var $request = $.ajax({
            url: "{{URL::route('get-filtered-ticket-numbers')}}",
                    dataType: 'html',
                    data: {name:input},
                    type: "GET",
            });
            $request.then(function (data) {
            data = JSON.parse(data);
                    // This assumes that the data comes back as an array of data objects
                    // The idea is that you are using the same callback as the old `initSelection`
                    for (var d = 0; d < data.length; d++) {
            var item = data[d];
                    // Create the DOM option that is pre-selected by default
                    var option = new Option(item.text, item.id, true, true);
                    // Append it to the select
                    $number_list.append(option);
            }
            // Update the selected options that are displayed
            $number_list.trigger('change');
            });
            @endif

            var $help_topic_list = $('#help-topic-filter').addSelectlist({maximumSelectionLength : 5});
            valueSelected($help_topic_list);
            @if (array_key_exists('help-topic', $inputs))
            addFilters($help_topic_list, '<?= json_encode($inputs["help-topic"]) ?>');
            @endif

            function addFilters($element, $data){
            var obj = JSON.parse($data);
                    if (obj.length > 0) {
            for (var d = 0; d < obj.length; d++) {
            var option = new Option(obj[d], obj[d], true, true);
                    $element.append(option);
            }
            $element.trigger('change');
            }
            }

    function clearfilterlist() {
    $dept_list.val(null).trigger("change");
            $sla_list.val(null).trigger("change");
            $priority_list.val(null).trigger("change");
            $source_list.val(null).trigger("change");
            $owner_list.val(null).trigger("change");
            $status_list.val(null).trigger("change");
            $assignee_list.val(null).trigger("change");
            $labels_list.val(null).trigger("change");
            $tags_list.val(null).trigger("change");
            $type_list.val(null).trigger("change");
            $number_list.val(null).trigger("change");
            $help_topic_list.val(null).trigger("change");
    }

    function valueSelected($obj) {
    $obj.on("select2:select", function (e) { clearlist = 0; });
    }

    $('#filter-form').on('submit', function(e){
    if (clearlist > 0) {
    $('#departments-filter, #sla-filter, #priority-filter, #source-filter, #owner-filter, #status-filter, #assigned-filter, #assigned-to-filter, #labels-filter, #tags-filter, #type-filter, #due-on-filter, #created, #modified, #ticket-number, #help-topic-filter').remove();
            $(this).children();
    }
    });
</script>
