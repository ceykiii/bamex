@include('admin.partials.head',['title' => "Kulannıcı Yönetimi"])

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

@include('admin.partials.sidebar',['pageName' => "Dashboard"])

<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        @include('admin.partials.topbar')
        <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-1 text-gray-800">Kullanıcı Yönetimi</h1>

                <!-- Content Row -->
                <div class="row">

                    <div class="col-lg-12">

                        <!-- Dropdown No Arrow -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Yeni Bir Kullanıcı Belirle</h6>
                            </div>
                            <div class="card-body">
                                <table id="table_id" class="display" id = "user_table" class = "table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Düzenle</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        @include('admin.partials.footer')

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

@include("admin.partials.script")
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_id').DataTable({
            proccesing : true,
            serverSide: true,
            ajax : {
                url : "{{route("admin.user.data")}}"
            },
            columns : [
                {
                    data : 'name',
                    name : 'name'
                },
                {
                    data : 'email',
                    name : 'email'
                },
                {
                    data : 'action',
                    name : 'actiom',
                    orderable : false
                }
            ]

        })
    });
</script>
</body>

</html>
