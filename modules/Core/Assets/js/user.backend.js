/**
 * Created by ngocnh on 8/5/15.
 */
$(function () {
    $('#user-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: $('#user-table').attr('route'),
        columns: [
            {data: 'email', name: 'email'},
            {data: 'fullname', name: 'fullname'},
            {data: 'role', name: 'role'},
            {data: 'action', name: 'action'}
        ]
    });
});