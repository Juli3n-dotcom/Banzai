$(document).ready(function () {

    //modal d'ajout team member
    $('#add_team_member').on('click', function () {
        $('#addmodal').modal('show');
    });

    
    //modal edit team member
    $('.editbtn').on('click', function () {
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        let data = $tr.children('td').map(function () {
            return $(this).text()
        }).get();

        $('#update_id').val(data[0]);
        $('#update_civilite').val(data[1]);
        $('#update_name_member').val(data[2]);
        $('#update_prenom_member').val(data[3]);
        $('#update_email_member').val(data[5]);
        $('#update_statut').val(data[6]);
        $('#update_confirmation').val(data[8]);

    });

    //modal delete team member
    $('.delete_team_member').on('click', function () {
        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        let data = $tr.children('td').map(function () {
            return $(this).text()
        }).get();

        $('#delete_id').val(data[0]);

    });

    //confirmation de la validation
    $('#confirmedelete').on('click', function () {
        if ($(this).is(':checked')) {
            $('#deletemember').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');
        } else {
            $('#deletemember').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');
        }
    })
    
});