// const { data } = require("alpinejs");


function viewRecord(record_id){
        $.ajax({
        url: '/view-record',
        method: 'POST',
        data: {
            record_id: record_id,
           
        },
        dataType: 'json',
        beforeSend: function () {
            $('#content-display').html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary"></div>
                <div>Loading record...</div>
            </div>
        `);
        },
        success: function (data) {
            $('#change-status-div').show(); // Show the change status dropdown
             $('#content-display').html(data.html);
             var status_list = '';
            console.log(data);
            $('#system_display').text(
                'Record# | ' + String(record_id).padStart(5, '0') + ' | ' + data.status.current.rep_status.status_name
            );
            if (data.status.current) {
                var color = data.status.current.rep_status.status_tag == 'CLOSED' ? 'danger' : 'primary';
                status_list += `<li class="dropdown-item fw-bold text-${color}">
                                 ${data.status.current.rep_status.status_name}
                                </li> `;
             }
             if(data.status.next){

                $(data.status.next).each(function(index, status){
                    var statusColor = status.rep_status.status_tag == 'CLOSED' ? 'danger' : 'primary';
                    status_list += `<hr><li class="dropdown-item text-${statusColor}" data-statusid="${status.status_id}" data-recordid="${record_id}" onclick="changeStatus(this)">
                                     ${status.rep_status.status_name}
                                    </li>`;
                });
             }
             $('#status-change-list').html(status_list);
        }
    });
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
function changeStatus(element){
    var status_id = $(element).data('statusid');
    var record_id = $(element).data('recordid');

    // Ask for confirmation first
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to change the status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if(result.isConfirmed){
            // Make AJAX request to update status
            $.ajax({
                url: '/change-status', // Your route to handle status update
                type: 'POST',
                data: {
                    status_id: status_id,
                    record_id: record_id
                },
                success: function(response){
                    Swal.fire({
                        icon: response.success ? 'success' : 'error',
                        title: response.success ? 'Success!' : 'Oops!',
                        html: response.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    });

                    // Optionally, refresh the table or update UI
                    if(response.success){
                        // Example: change the status text/button dynamically
                        $(element).closest('tr').find('.status-text').text(response.new_status);
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: 'Something went wrong. Please try again.'
                    });
                }
            });
        } else {
            // User canceled
            Swal.fire('Cancelled', 'Status not changed.', 'info');
        }
    });
}

$(document).ready(function(){

$(document).on('click','#edit-btn',function(){
    $(this).addClass('d-none');
    $('#change-status-div').addClass('d-none');
    $('#save-btn').removeClass('d-none');
    $('#cancel-btn').removeClass('d-none');
    $('.show-record').addClass('d-none');
    $('.edit-record').removeClass('d-none');
})

$(document).on('click','#cancel-btn',function(){
    $(this).addClass('d-none');
    $('#change-status-div').removeClass('d-none');
    $('#save-btn').addClass('d-none');
    $('#edit-btn').removeClass('d-none');
    $('.show-record').removeClass('d-none');
    $('.edit-record').addClass('d-none');
})

})
