
$(document).ready(function () {
    // Show the main popup when the 'Add Daily Work' button is clicked
  
     $('#taskDate').on('click focus', function() {
        $(this).attr('type', 'date'); // Ensures the type is set to date for compatibility
        this.showPicker(); // Show the date picker on focus/click
    });

    $('#checkIn').on('click focus', function() {
        $(this).attr('type', 'time'); // Ensures the type is set to date for compatibility
        this.showPicker(); // Show the date picker on focus/click
    });

    $('#checkOut').on('click focus', function(){
        $(this).attr('type', 'time');
        this.showPicker();
    });

    

    $("#addreport").on("click", function () {
        $("#addreportpopup").fadeIn("slow");
    });

    // Hide the main popup when the 'Cancel' button is clicked
    $("#cancel").on("click", function () {
        $("#addreportpopup").fadeOut();
    });
    // Function to convert Y-m-d to d-m-Y
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are 0-based
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    // Handle form submission for adding a new daily work report
    $("#dailyWorkForm").on("submit", function (event) {
        event.preventDefault();
        var formdata = $(this).serialize();
        let _token = $("input[name=_token]").val();
    
        $.ajax({
            type: "POST",
            url: "/report/store", 
            dataType: "json",
            data: formdata,
            _token: _token,
    
            success: function(response) {
                $('#addreportpopup').fadeOut();
                $('#saveWork')[0].reset();
    
                // Reset and hide error message if the form is successful
                $('#formError').hide().html('');
    
                // Show success message on the main page (if needed)
                $('#message').removeClass('alert-danger').addClass('alert-success').html('<strong>Success:</strong> ' + response.message).fadeIn();
    
                setTimeout(function() {
                    $('#message').fadeOut(); 
                }, 5000);
            },
    
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.errors;
                    var errorMessages = '';
    
                    // Loop through the validation errors and append them to the errorMessages variable
                    $.each(errors, function(key, value) {
                        errorMessages += '<p>' + value[0] + '</p>';
                    });
    
                    // Display the error messages inside the popup
                    $('#formError').html(errorMessages).fadeIn();
                } else {
                    alert("An error occurred. Please try again.");
                }
            }
        });
    });
    
    

    // Show the edit popup when the 'Edit Daily Work' button is clicked
    $(document).on("click", ".edit.btn", function () {
        var reportId = $(this).data("id"); // Get the report ID from data attribute
        if (reportId) {
            $("#editreportpopup-" + reportId).fadeIn("slow");
        }
    });

    // Hide the edit popup when the 'Cancel' button is clicked
    $(document).on("click", ".cancel-edit", function () {
        var reportId = $(this).data("id");
        $("#editreportpopup-" + reportId).fadeOut();
    });

    // Show the add empty report popup
    $(document).on("click", ".add-empty-report", function () {
        var date = $(this).data("date");
        $("#addemptyreportpopup-" + date).fadeIn("slow");
    });

    // Hide the add empty report popup when the 'Cancel' button is clicked
    $(document).on("click", ".cancel-add", function () {
        var date = $(this).data("date");
        $("#addemptyreportpopup-" + date).fadeOut();
    });
});
