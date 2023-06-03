// Clear all
function clearAll() {
    $("#file_details").html("");
    $("#total-size").html("");
    $("#attachment").val('');
    $("#clear-file").hide();
    $("#replybtn").removeClass('disabled');
}

// Attachments
$('#attachment').change(function() {
    input = document.getElementById('attachment');
    if (!input) {
        alert("Um, couldn't find the fileinput element.");
    } else if (!input.files) {
        alert("This browser doesn't seem to support the `files` property of file inputs.");
    } else if (!input.files[0]) {
    } else {
        $("#file_details").html("");
        var total_size = 0;
        for(i = 0; i < input.files.length; i++) {
            file = input.files[i];
            var supported_size = "{!! $max_size_in_bytes !!}";
            var supported_actual_size = "{!! $max_size_in_actual !!}";
            if(file.size < supported_size) {
                $("#file_details").append("<tr> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
            } else {
                $("#file_details").append("<tr style='color:red;'> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
            }
            total_size += parseInt(file.size);
        }
        if(total_size > supported_size) {
            $("#total-size").append("<span style='color:red'>Your total file upload size is greater than "+ supported_actual_size +"</span>");
            $("#replybtn").addClass('disabled');
            $("#clear-file").show();
        } else {
            $("#total-size").html("");
            $("#replybtn").removeClass('disabled');
            $("#clear-file").show();
        }
    }
});

function formatBytes(bytes,decimals) {
    if(bytes == 0) return '0 Byte';
    var k = 1000;
    var dm = decimals + 1 || 3;
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}