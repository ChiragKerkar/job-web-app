$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $("#registerBtn").click(function() {
        // Serialize form data
        var email = $("#email").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            // If email format is invalid, show alert and return
            $("#registrationAlert").removeClass("d-none").addClass("alert-danger").html("Invalid email format");
            return;
        }
        var siteurl = $("#url").val();
        var formData = $("#registrationForm").serialize();
        // Send Ajax request
        $.ajax({
            url: siteurl + '/register',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                // Handle success response
                $('#registrationAlert').removeClass('d-none');
                $('#registrationAlert').addClass(responseData.class);
                $('#registrationAlert').html(response.message);

                setTimeout(function() {
                    $('#registrationAlert').addClass('d-none');
                    if(responseData.status == 'success') {
                        window.location.href = siteurl + 'login-view';
                    }}, 3000);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error
                $('#registrationAlert').removeClass('d-none');
                $('#registrationAlert').addClass('alert-danger');
                $('#registrationAlert').html('Error: ' + errorThrown);

                setTimeout(function() {
                    $('#registrationAlert').addClass('d-none');
                    if(responseData.status == 'success') {
                        window.location.href = siteurl + 'login-view';
                    }}, 3000);
                }
        });
    });


    $("#loginBtn").click(function() {
        // Serialize form data
        var siteurl = $("#url").val();
        var formData = $("#loginForm").serialize();
        sessionStorage.setItem("siteurl", siteurl);
        // Send Ajax request
        $.ajax({
            url: siteurl + '/login_user',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            success: function(response) {
                // Handle success response
                    // getJobs(siteurl,response.token, csrfToken);
                    sessionStorage.setItem("userId", response.user.id);
                    sessionStorage.setItem("siteurl", siteurl);
                    $('#loginAlert').removeClass('d-none');
                    $('#loginAlert').addClass('alert-success');
                    $('#loginAlert').html(response.message);

                    setTimeout(function() {
                        $('#loginAlert').addClass('d-none'); // Hide the alert
                        // Redirect to the login page after timeout
                        window.location.href = siteurl + '/dashboard';
                    }, 3000);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error
                var response = xhr.responseJSON;
            if (response.errors) {
                var errorMessage = '';
                        for (var key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                errorMessage += response.errors[key][0] + '<br>';
                            }
                            }
                            $('#loginAlert').removeClass('d-none');
                            $('#loginAlert').addClass('alert-danger');
                            $('#loginAlert').html(errorMessage);
                        } else {
                            $('#loginAlert').removeClass('d-none');
                            $('#loginAlert').addClass('alert-danger');
                            $('#loginAlert').html('Error: ' + errorThrown);
                        }
                        setTimeout(function() {
                            $('#loginAlert').addClass('d-none'); // Hide the alert
                            // Redirect to the login page after timeout
                            window.location.href = siteurl + '/login-view';
                        }, 3000);
                    }
            });
    });

    $('.editLink').on('click', function(e) {
        e.preventDefault(); // Prevent the default link behavior
        var Id = $(this).data('id');
        var siteurl = $("#url").val();
        $.ajax({
            url: siteurl + '/getJobData/' + Id,
            type: "GET",
            success: function(response) {
                // Handle success response
                if(response) {
                    $('#editCity').val(response.data.job_title);
                    $('#editState').val(response.data.description);
                    $('#editZipCode').val(response.data.requirements);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error
                console.error('Error:', errorThrown);
            }
        });
        $('#editModal').modal('show');
        // $("#user_id").val(userId);
    });

    $('.addJob').on('click', function(e) {
        e.preventDefault(); // Prevent the default link behavior
        var siteurl = $("#url").val();

        $('#addModal').modal('show');
        // $("#user_id").val(userId);
    });

    $(".addVacancy").click(function() {
        // Serialize form data
        var siteurl = $("#url").val();
        var formData = $("#AddForm").serialize();
        var userId = $("#user_id").val();
        // Send Ajax request
        $.ajax({
            url: siteurl + '/save-job',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            success: function(response) {
                // Handle success response
                $('#saveAlert').removeClass('d-none');
                $('#saveAlert').addClass('alert-success');
                $('#saveAlert').html(response.message);

                setTimeout(function() {
                    $('#saveAlert').addClass('d-none'); // Hide the alert
                    // Redirect to the login page after timeout
                    window.location.href = siteurl + '/dashboard';
                }, 5000);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error
                console.error('Error:', errorThrown);
            }
        });
    });

    var path = window.location.pathname;

    // Split the path into segments using '/'
    var segments = path.split('/');

    // Get the last segment (excluding any trailing '/')
    var lastSegment = segments[segments.length - 1];

    if (lastSegment == 'dashboard') {
        $(document).ready(function() {
            var table = $('#dealerTable').DataTable({
                // Add your DataTable configurations here
            });

            // Add a single search input for all columns
             $('#dealerTable_filter').append('<input type="search" id="globalSearch" class="form-control form-control-sm" placeholder="Search all columns" style="display:none" aria-controls="dealerTable">');

            // Apply the global search
            $('#globalSearch').on('keyup change', function() {
                table.search(this.value).draw();
            });
        });
    }

    $(".applyLink").click(function(e) {
        e.preventDefault();
        var userId = sessionStorage.getItem("userId");
        var siteurl = sessionStorage.getItem("siteurl");
        var Id = $(this).data('id');

        var csrfToken = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            url: siteurl + '/apply-job',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
            },
            data: {user_id: userId,job_id: Id},
            success: function(response) {
                // Handle success response
                // var responseData = JSON.parse(response);
                $('#saveAlert').removeClass('d-none');
                $('#saveAlert').addClass('alert-success');
                $('#saveAlert').html(response.message);

                setTimeout(function() {
                    $('#saveAlert').addClass('d-none'); // Hide the alert
                    // Redirect to the login page after timeout
                }, 5000);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error
                console.error('Error:', errorThrown);
            }
        });
    });


        $(".logout-btn").click(function() {
            var siteurl = window.location.href;
            var segments = siteurl.split('/');
            segments.pop(); // Remove the last segment
            segments.push('login-view'); // Add 'login-view' as the new last segment
            var newUrl = segments.join('/'); // Reconstruct the URL
            window.location.href = newUrl;
            sessionStorage.clear();
            sessionStorage.removeItem("userId");
        });
});