function validateMap() {
    var imageInput = document.getElementById('mapInput');

    // Check if a file is selected
    if (imageInput.files.length === 0) {
        alert('Please select an image.');
        return false;
    }

    // Check if the selected file is an image
    var allowedExtensions = /\.(jpg|jpeg|png|gif)$/i;
    if (!allowedExtensions.test(imageInput.value)) {
        alert('Invalid file type. Please select a valid image (jpg, jpeg, png, gif).');
        imageInput.value = "";
        return false;
    }
    return true;
}

//upload

$(document).ready(function () {
    $(".form-image-upload").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);


        formData.append('caption', $('#txt_map').val());
        formData.append('uploadFile', $('#mapInput')[0].files[0]);

        swal({
            title: "Confirm?",
            text: "Are you sure you want to add a new observatory image?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then(() => {
                $.ajax({
                    type: "POST",
                    url: "imageUpload.php", // Replace with the actual URL to handle form submission
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json", // Expect JSON response
                    success: function (response) {
                        // Handle the success response here
                        if (response.status === "Success") {
                            swal({
                                title: "Success!",
                                text: "Image Successfully Uploaded",
                                icon: "success"
                            }).then(okay => {
                                if (okay) {
                                    window.location.href = "Observatory.php";
                                    // You don't need the 'exit' statement here
                                }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: " + error.message);;
                        console.error("AJAX Error:", error);
                        console.error(xhr.responseText);
                    },
                });
            });




    });

    //delete
    $(".delete-map").submit(function (e) {

        e.preventDefault();
        var formData = new FormData(this);


        formData.append('folder_image', $(this).find('#map-id').data('id'));

        formData.append('del_id', $(this).find("#map-id").val());

        console.log($(this).find('#map-id').data('id'));
        console.log($(this).find("#map-id").val())
        swal({
            title: "Are you sure you want to delete?",
            text: "Once deleted, you will not be able to recover the image",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: "imageDelete.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json", // Expect JSON response
                        success: function (response) {
                            // Handle the success response here
                            if (response.status === "Success") {
                                swal({
                                    title: "Success!",
                                    text: "Image Successfully Deleted",
                                    icon: "success"
                                }).then(okay => {
                                    if (okay) {
                                        window.location.href = "Observatory.php";

                                    }
                                });
                            }
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error: " + error.message);;
                            console.error("AJAX Error:", error);
                            console.error(xhr.responseText);
                        },
                    });

                }

            })




    });
});


//animation
document.addEventListener("DOMContentLoaded", function () {
    const gallery = document.querySelector('.list-group.gallery');
    gallery.classList.add('show');
});