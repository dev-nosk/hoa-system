function viewRecord(record_id){
        $.ajax({
        url: '/view-record',
        method: 'POST',
        data: {
            record_id: record_id,
           
        },
        beforeSend: function () {
            $('#content-display').html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary"></div>
                <div>Loading record...</div>
            </div>
        `);
        },
        success: function (data) {
            console.log(data.html);
             $('#content-display').html(data.html);
        }
    });
}