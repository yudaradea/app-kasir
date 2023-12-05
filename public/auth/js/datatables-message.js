$(document).ready(function () {
    var table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.section.messages') }}",
        columns: [
            {
                data: "id",
                name: "id",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "phone",
                name: "phone",
            },
            {
                data: "message",
                name: "message",
            },
            {
                data: "checkbox",
                name: "checkbox",
                orderable: false,
                searchable: false,
            },
        ],
    });
});
