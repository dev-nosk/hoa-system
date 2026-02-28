



$(document).on('click', '.list-view', function (e) {
    e.preventDefault();
    var form_id = $(this).data('formid');
    var system_name = $(this).data('formname');
    $('#change-status-div').hide();

    $('#system_display').text(system_name + ' list view');
    $('#content-display').html(`
        <div class="text-center p-4">
            <div class="spinner-border text-primary"></div>
            <div>Loading records...</div>
        </div>
    `);

   $.ajax({
    url: '/get-list',
    method: 'POST',
    data: { form_id: form_id },
    success: function (data) {
        if (data.success) {
             $('#content-display').html(data.html);
        } else {
            $('#content-display').html('<div class="alert alert-danger">'+data.message+'</div>');
        }
    }
});
});

$(document).on('click', '#create-model-link', function (e) {
    e.preventDefault();
    
   
    $('#content-display').html(`
        <div class="text-center p-4">
            <div class="spinner-border text-primary"></div>
            <div>Creating model...</div>
        </div>
    `);

    var model = $(this).data('model-name');
    var formId = $(this).data('form-id');
    $.ajax({
        url: '/model-generator/create',
        method: 'POST',
        data: {
            model_name: model,
            form_id: formId
        },
        success: function (data) {
            if (data.success) {
                $('#content-display').html('<div class="alert alert-success">' + data.message + '</div>');
            } else {
                $('#content-display').html('<div class="alert alert-danger">' + data.message + '</div>');
            }
        },
        error: function (xhr, status, error) {
            $('#content-display').html('<div class="alert alert-danger">Error: ' + error + '</div>');
        }
    });
});

