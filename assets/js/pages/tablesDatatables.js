/*
 *  Document   : tablesDatatables.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Tables Datatables page
 */

var TablesDatatables = function() {

    return {
        init: function() {
            /* Initialize Bootstrap Datatables Integration */
            App.datatables();

            /* Initialize Datatables */
            $('#example-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });


            $('#datatable-adminrole').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-adminmodule').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-adminuser').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-billingcycle').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-codcycle').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-transitpartner').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            $('#datatable-common').dataTable({
                columnDefs: [ { orderable: false, targets: 0 } ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            /* Add placeholder attribute to the search input */
            $('.dataTables_filter input').attr('placeholder', 'Search');
        }
    };
}();