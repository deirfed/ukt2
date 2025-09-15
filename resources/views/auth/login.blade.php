<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | UKT2.ORG Kep. Seribu</title>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>
    <link rel="stylesheet" href="{{ asset('assets/css/csslogin/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('assets/img/ukt2logo.png') }}">

</head>

<body>
    <div class="container">
        <div class="screen">
            <div class="img-back">
                <div class="text-head">
                    <h1 class="text-center">SIMOJA</h1>
                </div>
                <div class="screen__content">
                    <div class="title">
                        <img src="{{ asset('assets/img/ukt2logo.png') }}" alt="" class="login-logo">
                    </div>
                    <form class="login" action="{{ route('login') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" name="email" class="login__input" placeholder="Masukkan Email"
                                required autofocus>
                        </div>
                        @error('email')
                            <span class="badge bg-danger p-2 mb-3 text-start fs-6 w-100 text-wrap" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" name="password" class="login__input" placeholder="Masukkan Password"
                                required>
                        </div>
                        @error('password')
                            <span class="badge bg-danger p-2 mb-3 text-start fs-6 w-100 text-wrap" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button class="button login__submit">
                            <span class="button__text">Masuk</span>
                            <i class="button__icon fas fa-chevron-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <p>&copy; <span id="currentYear"></span> SIMOJA. All Rights Reserved.</p>
    </footer>
</body>

<script>
    var currentYear = new Date().getFullYear();

    document.getElementById("currentYear").textContent = currentYear;
</script>

</html>
