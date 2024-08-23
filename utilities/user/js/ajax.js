$(document).ready(function() {
    // DataTable initialization
    $('#datatableid').DataTable({
        "language": {
            "emptyTable": "No records found"
        }
    });

     $('.btnNew').click(function() {

         $('#addModal').modal("show");    
          $('#showAlert').hide();
    }); 

    $("#add-admin-form").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var firstname = $("#txtFName").val();
        var lastname = $("#txtLName").val();
        var uname = $("#txtUName").val();
        var password = $("#txtPass").val();

        if (!isValidName(firstname)) {
            $("#showAlert").text("Invalid name").show();
            return;
        }

        if (!isValidName(lastname)) {
            $("#showAlert").text("Invalid name").show();
            return;
        }

        if (!isValidUsername(uname)) {
            $("#showAlert").text("Invalid Username").show();
            return;
        }

        if (!isValidPassword(password)) {
            $("#showAlert").text("Invalid Password").show();
            return;
        }

        // Use SweetAlert for confirmation
        Swal.fire({
            title: "Do you really want to add user?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: 'btn-success',
                cancelButton: 'btn-danger'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked 'Yes', proceed with form submission

                $.ajax({
                    type: "POST",
                    url: "add_admin.php",
                    data: { 
                        firstname: firstname,
                        lastname: lastname,
                        uname: uname,
                        password: password,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == "success") {
                            $("#add-admin-form")[0].reset();

                            // Show success message
                            Swal.fire({
                                title: "Success!",
                                text: "User Successfully Added",
                                icon: "success",
                                showConfirmButton: true,
                            }).then((okResult) => {
                                if (okResult.isConfirmed) {
                                    // Reload the current page
                                    location.reload();
                                }
                            });
                        } else if(response.status =="Invalid") {
                            $("#showAlert").text(response.message).addClass("alert alert-danger").show();
                        } else {
                            $("#showAlert").text("Something went wrong").addClass("alert alert-danger").show();
                        }
                    },
                    error: function(xhr, status, errorThrown) {
                      $("#showAlert").text("Something went wrong").addClass("alert alert-danger").show();
                    }
                });
            }
        });
    });



    //update passwords  
    $('.btn-password').click(function() {

        $('#setPasswordModal').find('#txtuserPassId').val($(this).data('id'));
        $('#setPasswordModal').modal('show');   
        $('#showUpdateAlert').hide();                      

    });

  $("#update-admin-form").submit(function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Do you really want to update the user's password?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: 'btn-success', // Apply a custom class to the confirm button
                cancelButton: 'btn-danger'   // Apply a custom class to the cancel button
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Yes" in the confirmation dialog

                var updatePassword = $("#updatePassword").val();
                if (!isValidPassword(updatePassword)) {
                    $("#showUpdateAlert").text("Invalid Password").addClass("alert alert-danger").show();
                    return;
                }

                let userID = $("#txtuserPassId").val();

                $.ajax({
                    type: "POST",
                    url: "update_admin_password.php",
                    data: { 
                        updatePassword: updatePassword,
                        userID: userID,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            Swal.fire({
                                title: "Success!",
                                text: "Account Successfully Updated",
                                icon: "success",
                                showConfirmButton: true, // Show the "OK" button
                            }).then((okResult) => {
                                if (okResult.isConfirmed) {
                                    // Reload the current page
                                    location.reload();
                                }
                            });
                        } else {
                            $("#update-admin-form")[0].reset();
                            if (response.status == "Invalid") {
                                $("#showUpdateAlert").text(response.message).addClass("alert alert-danger").show();
                            } else {
                                $("#showUpdateAlert").text("Something went wrong").addClass("alert alert-danger").show();
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#showUpdateAlert").text("Something went wrong").addClass("alert alert-danger").show();
                    }
                });
            }
        });
    });

  //update user status
  $('.btn-update').click(function() {
        var id = $(this).data('id');          
        $('#setActionModal').find('#txtuserId').val(id);
  
        $.ajax({
            type: 'POST',
            url: 'check_admin_status.php',
            data: { admin_id: id },
            dataType: 'json',
            success: function(response) {
                // Parse the JSON response
              
                if (response.status === 'success') {
                    var accStatus = response.acc_status;
                   
                    $('#statusPlaceholder').text('Account Status: ' + accStatus);
                
                    //set radio button
                    if (accStatus === 'Active') {
                        $('#normalAction').prop('checked', true);
                    } else {
                        $('#suspendAction').prop('checked', true);
                    }
                } else {
                    $('#statusPlaceholder').text("Something went wrong");
                }
            },
            // Handle any error that may occur during the AJAX request
            error: function(xhr, status, errorThrown) {
                  
            }
        });

            $('#setActionModal').modal('show');
    });

   $('.btnUpdateAccount').click(function() {
    event.preventDefault()
    let userID = $("#txtuserId").val();

    let accStatus = $("input[name='action']:checked").val();

    console.log(accStatus);
        Swal.fire({
            title: "Do you really want update user account?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: 'btn-success', // Apply a custom class to the confirm button
                cancelButton: 'btn-danger'   // Apply a custom class to the cancel button
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX Request
                $.ajax({
                    url: 'update_admin_status.php',
                    type: 'POST',
                    data: { 
                        userID: userID, 
                        accStatus: accStatus,
                    }, // Send both IDs as data
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "success") {
                            // Show a success SweetAlert notification
                            Swal.fire({
                                title: "Success!",
                                text: "Account Successfully Updated",
                                icon: "success",
                                showConfirmButton: true, // Show the "OK" button
                            }).then((okResult) => {
                                if (okResult.isConfirmed) {
                                    // Reload the current page
                                    location.reload();
                                }
                            });
                        }
                        else
                        {
                            console.log(response.message);
                        }
                    },
                    error: function (xhr,status, errorThrown) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });


    function isValidName(name) {
        var nameRegex = /^[a-zA-Z]+(\s[a-zA-Z]+)?$/;
        return nameRegex.test(name);
    }

    function isValidUsername(uname) {
        if (uname.length < 6 || uname.length > 50) {
            return false;
        }    
        var sqlRegex = /[;'"\\()|*+--]/;
        if (sqlRegex.test(uname)) {
            return false;
        }     
        return true;
    }

   
    function isValidPassword(password) {
        // Password validation logic here (e.g., minimum length)
        var regex = /[;'"\\()|*+--]/;
        return password.length >= 8 && !regex.test(password);
    }

});

