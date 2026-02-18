$(document).on('click', '.list-view', function (e) {
    e.preventDefault();
    var form_id = $(this).data('formid');
    var system_name = $(this).data('formname');

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
        data: {
            form_id: form_id
        },
        success: function (data) {
            if (data.success) {
                // Build table HTML dynamically
                var tableHtml = `
                    <table id="recordsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Requested By</th>
                                <th>Request Date</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                `;
                $('#content-display').html(tableHtml);

                // Initialize DataTable
                $('#recordsTable').DataTable({
                    data: data.records,
                    columns: [
                        {
                            data: 'id',
                            render: function (data, type, row) {
                                // Format ID with leading zeros (5 digits)
                                var formattedId = 'ID#' + String(data).padStart(5, '0');
                                // Make it clickable to call viewRecord(id)
                                return `<a href="#" onclick="viewRecord(${data})">${formattedId}</a>`;
                            }
                        },
                        { data: 'service_request_by' },
                        { data: 'service_request_at' },
                        { data: 'service_category_id' },
                     
                    ],
                    pageLength: 5,
                    lengthMenu: [5, 10, 20], 
                    responsive: true
                });


            } else {
                $('#content-display').html('<div class="alert alert-danger">'+data.message+'</div>');
            }
        }
    });
});
