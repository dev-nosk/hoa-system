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
    data: { form_id: form_id },
    success: function (data) {
        if (data.success) {
            // Build table HTML dynamically
            var tableHtml = `
                <table id="recordsTable" class="table table-hover table-striped table-bordered nowrap">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Requested By</th>
                            <th>Request Date</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                            var formattedId = 'ID#' + String(data).padStart(5, '0');
                            return `<a href="#" onclick="viewRecord(${data})">${formattedId}</a>`;
                        }
                    },
                    { data: 'created_user.name' },
                    {
                        data: 'service_request_at',
                        render: function (data) {
                            if (!data) return '';
                            const date = new Date(data);
                            const options = {
                                year: 'numeric',
                                month: 'short',
                                day: '2-digit',
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            };
                            return date.toLocaleString('en-US', options); // e.g., Jan 01, 2026 9:49 AM
                        }
                    },
                    { data: 'category.category_name' },
                ],
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records..."
                }
            });

        } else {
            $('#content-display').html('<div class="alert alert-danger">'+data.message+'</div>');
        }
    }
});
});
