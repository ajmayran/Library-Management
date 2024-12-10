<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/bootstrap-datatables/datatables.js"></script>
    <script src="./assets/bootstrap-datatables/datatables.min.css"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                "pageLength": 20,
                "lengthMenu": [
                    [20, 40, 60, 80 - 1],
                    [20, 40, 60, 80, "All"]
                ],
                "searching": true,
                "ordering": false,
                "paging": true,
                "language": {
                    "emptyTable": "No data available in table",
                    "lengthMenu": "Show _MENU_ Books per page",
                    "search": "Search Books: ",
                    "paginate": {
                        "next": "🡆",
                        "previous": "🡄"
                    }
                }
            });
        }); 
    </script>