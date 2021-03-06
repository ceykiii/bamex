<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bamex Ticaret</title>
    <link href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"  rel="stylesheet">
    <link href="{{ asset("css/sb-admin-2.min.css") }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-lg-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-lg-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bamex Ticaret</h1>
                                </div>
                                <form class="user" action="{{route('login.attempt')}}" method="post">
                                    @if($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            {{$errors->first()}}
                                        </div>
                                    @endif
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name = "email" class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Mail Adresini Giriniz" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="??ifrenizi Kullan??n" required>
                                    </div>
                                    <input type="submit" value="Giri?? Yap??n" class="btn btn-primary btn-user btn-block">
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset("vendor/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("vendor/jquery-easing/jquery.easing.min.js") }}"></script>
<script src="{{ asset("js/sb-admin-2.min.js") }}"></script>
</body>

</html>
