$(document).on('click', '.create-record', function (e) {
    e.preventDefault();

    var form_id = $(this).data('formid');
    var system_name = $(this).data('formname')

    // Example AJAX sending all params
    $.ajax({
        url: '/form-builder',
        method: 'POST',
        data: {
            form_id: form_id,
        },
        beforeSend: function () {
            $('#content-display').html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary"></div>
                <div>Loading form...</div>
            </div>
        `);
        },
        success: function (data) {
            $('#system_display').text(system_name + ' request')
            $('#content-display').html(data.html);
        }
    });



    $.ajax({
        url: '/get-category',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (index, item) {
                var newOption = new Option(item.category_name, item.id, false, false);
                $('.select-category').append(newOption);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error loading categories:', error);
        }
    });


    $(document).off('submit', '#form_submit').on('submit', '#form_submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');

        $.ajax({
            url: '/save-record',
            method: 'POST',
            data: form.serialize(), // IMPORTANT: send all form data
            beforeSend: function () {
                submitBtn.prop('disabled', true);
                submitBtn.html(`
                <span class="spinner-border spinner-border-sm"></span>
                Saving...
            `);
                $('#page-overlay').show();
            },

            success: function (data) {
                if (data) {
                    var record = data.record;
                    $('#page-overlay').hide();
                    Toastify({
                        text: `Record #${record.id} Successfully saved`,
                        duration: 1500,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#34db5e",
                        callback: function () {
                            $('#content-display').html(`
                                <div class="text-center p-4">
                                    <div class="spinner-border text-primary"></div>
                                    <div>Redirect to record</div>
                                </div>
                            `);

                            viewRecord(record.id);
                            // Your code here, e.g., enable button or trigger next action
                        }
                    }).showToast();

                   
                } else {
                    $('#system_display').text(system_name + ' request');
                    $('#content-display').html(data.html);
                }
            },
            error: function (xhr) {
                 $('#page-overlay').hide();
                alert('Something went wrong.');
            },
            complete: function () {
                submitBtn.prop('disabled', false);
                submitBtn.html('Save');
            }
        });
    });



});