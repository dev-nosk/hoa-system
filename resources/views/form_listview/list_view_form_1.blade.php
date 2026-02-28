<div id="content-display">
    <table id="recordsTable" class="table table-hover table-striped table-bordered nowrap">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Requested By</th>
                <th>Request Date</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>
                        <a href="#" onclick="viewRecord({{ $record->id }})">
                            ID#{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>{{ $record->created_user->name ?? '-' }}</td>
                    <td>
                        @if($record->service_request_at)
                            {{ \Carbon\Carbon::parse($record->service_request_at)->format('M d, Y h:i A') }}
                        @endif
                    </td>
                    <td>{{ $record->category->category_name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No content for form</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#recordsTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 20],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records..."
        }
    });
});
</script>