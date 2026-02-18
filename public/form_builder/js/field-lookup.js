$(document).ready(function() {
    let targetFieldId = '';
    let userTable = null;

    // On lookup button click
    $(document).on('click', '#lookup-btn', function() {
        targetFieldId = $(this).data('targetid');
        $('#lookupModal').modal('show');

        // Initialize DataTable if not yet initialized
        if ($.fn.DataTable.isDataTable('#userTable')) {
            userTable.ajax.reload(); // reload AJAX if already initialized
        } else {
            userTable = $('#userTable').DataTable({
                ajax: {
                    url: '/get-users',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' }
                ],
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                responsive: true,
                destroy: true, // allow reinitialization just in case

                createdRow: function (row, data, dataIndex) {
                    $(row).addClass('user-row');

                    if (data.name.toLowerCase() === 'admin') {
                        $(row).addClass('table-danger');
                    }

                    $(row).attr('data-id', data.id);
                    $(row).attr('data-name', "(" + data.id + ") " + data.name + ' | ' + data.email);
                    $(row).attr('data-targetid', targetFieldId);
                }
            });
        }
    });

    // Handle selecting a user
    $(document).on('click', '.user-row', function() {
        const userId = $(this).data('id');
        const userName = $(this).data('name');
        const target_id = $(this).data('targetid');

        $('#lookup_display_' + target_id).val(userName);
        $('#input_' + target_id).val(userId);

        $('#lookupModal').modal('hide');
    });
});
