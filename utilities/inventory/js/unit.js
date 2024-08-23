$(document).ready(function () {
    $('#form-modal').on('hide.bs.modal', function () {
        const form = $('#form-modal form')[0];
        $('#form-modal .modal-title').text('Add Measurement')
        $('#form-modal [name="id"]').val('')
        form.reset()
    });
})

function editItem(id, name) {
    $('#form-modal .modal-title').text('Edit Measurement')
    $('#form-modal [name="measurement"]').val(name)
    $('#form-modal [name="id"]').val(id)
    $('#form-modal').modal('show')
}

function save(event) {
    event.preventDefault();

    const form = $('#form-modal form')[0];
    const formData = new FormData(form);

    $.ajax({
        type: "POST",
        url: 'process/save-measurement.php',
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            const id = formData.get('id')
            if (id) {
                $(`#item-measurement-table #${id} td:nth-child(1)`).text(formData.get('measurement'))
            } else {
                window.location.reload();
            }
            $('#form-modal').modal('hide')
        }
    })
}

function deleteItem(id) {
    $.ajax({
        type: "POST",
        url: 'process/delete-measurement.php',
        data: {
            id
        },
        success: function (response) {
            $(`#item-measurement-table #${id}`).remove()
            $('#form-modal').modal('hide')
        }
    })
}