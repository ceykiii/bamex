@include('admin.partials.head',['title' => "Kulannıcı Yönetimi"])
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
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
                                <form action="{{route("admin.user.add.post")}}" method="post">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success" role="alert">
                                            Başarılı Bir Şekilde Eklendi
                                        </div>
                                    @endif
                                    <div class="dropdown no-arrow mb-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">İsim</label>
                                            <input type="text" name = "name" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="İsim Soyisim" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mail Adresi</label>
                                            <input type="email" name = "email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Mail Adresini Giriniz" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Şifre</label>
                                            <input type="password" name="password" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Şifrenizi Kullanın" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tekrar Şifre</label>
                                            <input type="password" name="password_confirmation" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Şifrenizi Kullanın" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Roller</label>
                                            <select multiple="multiple" id="roles" width = "50%" class="form-control" name="roles[]">
                                                @foreach ($roles as $role)
                                                    <option value='{{$role->id}}'>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Yetkileri Belirle</label>
                                            <select multiple="multiple" id="permissions" width = "50%" class="form-control" name="permission[]">
                                                @foreach ($permissions as $permission)
                                                    <option value='{{$permission->id}}'>{{$permission->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="submit" value="Kullanıcıyı Ekle" class="btn btn-primary">
                                </form>
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
<script src="{{ asset("js/jquery.multi-select.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#roles').multiSelect();
        $('#permissions').multiSelect();
    });
</script>
</body>

</html>
