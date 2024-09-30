$(document).ready(function() {
    // Show the main popup when the 'Add Daily Work' button is clicked
    $('#addreport').on('click', function() {
        $('#addreportpopup').fadeIn("slow");
    });

    // Hide the main popup when the 'Cancel' button is clicked
    $('#cancel').on('click', function() {
        $('#addreportpopup').fadeOut();
    });
        // Function to convert Y-m-d to d-m-Y
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
    
        // Handle form submission for adding a new daily work report
        $('#dailyWorkForm').on('submit', function(event) {
            event.preventDefault();
            jQuery.ajax({
                url: "/report/store",
                type: 'POST',
                data: jQuery('#dailyWorkForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('#message').css('display', 'block');
                    jQuery('#message').html(result.message);
        
                    // Reset form and close popup
                    jQuery('#dailyWorkForm')[0].reset();
                    $('#addreportpopup').fadeOut();
    
                    // Convert the date from Y-m-d to d-m-Y
                    const formattedDate = formatDate(result.date);
    
                    // Check if the row with the same date exists
                    let existingRow = $('table tbody').find(`tr[data-date="${formattedDate}"]`);
    
                    // If row exists, replace its content, otherwise append a new row
                    var newReportRow = `
                        <tr data-date="${formattedDate}">
                            <td>${formattedDate}</td>
                            <td>${result.checkIn}</td>
                            <td>${result.checkOut}</td>
                            <td>${result.project}</td>
                            <td>${result.taskDetails}</td>
                            <td>${result.remarks ? result.remarks : 'N/A'}</td>
                            <td>
                                <button type="button" class="edit btn" data-id="${result.id}">Edit</button>
                                <form action="/report/delete/${result.id}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `;
    
                    if (existingRow.length > 0) {
                        // Replace existing row content
                        existingRow.replaceWith(newReportRow);
                    } else {
                        // Append new row to the table
                        $('table tbody').append(newReportRow);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Error handling
                }
            });
        });

    // Show the edit popup when the 'Edit Daily Work' button is clicked
    $(document).on('click', '.edit.btn', function() {
        var reportId = $(this).data('id'); // Get the report ID from data attribute
        if (reportId) {
            $('#editreportpopup-' + reportId).fadeIn("slow");
        }
    });

    // Hide the edit popup when the 'Cancel' button is clicked
    $(document).on('click', '.cancel-edit', function() {
        var reportId = $(this).data('id');
        $('#editreportpopup-' + reportId).fadeOut();
    });

    // Show the add empty report popup
    $(document).on('click', '.add-empty-report', function() {
        var date = $(this).data('date');
        $('#addemptyreportpopup-' + date).fadeIn("slow");
    });

    // Hide the add empty report popup when the 'Cancel' button is clicked
    $(document).on('click', '.cancel-add', function() {
        var date = $(this).data('date');
        $('#addemptyreportpopup-' + date).fadeOut();
    });
});
