<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card bg-white">
                        <div class="card-body p-5">
                            <form id="registerForm" class="mb-3 mt-md-4">
                                <h2 class="fw-bold mb-2 text-uppercase ">Cukkala</h2>
                                <p class=" mb-5">Please enter your register and password!</p>
                                <div class="mb-3">
                                    <label for="username" class="form-label ">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username">

                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label ">Email address</label>
                                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label ">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="*******">
                                </div>
                                <div class="mb-3">
                                    <label for="passwordConfirm" class="form-label ">Password Confirm</label>
                                    <input type="password" class="form-control" id="passwordConfirm" placeholder="*******">
                                </div>
                                <div id="errorArea">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-outline-dark" type="button" onclick="register()">Register</button>
                                </div>
                            </form>
                            <div>
                                <p class="mb-0  text-center">Don't have an account? <a href="/" class="text-primary fw-bold">Sign
                                        In</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function register() {
            var errorMessage = "";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },

                url: "/registerPost",
                method: 'POST',
                data: {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    passwordConfirm: $('#passwordConfirm').val(),
                },
                dataType: 'JSON',
                success: function(response) {
                    $("#errorArea").html(errorMessage)
                    window.location.href = '/';
                },
                error: function(response) {
                    for (const [key, value] of Object.entries(JSON.parse(response.responseText).message)) {
                        errorMessage += `<p  class="bg-danger text-light">${value}</p>`;

                    }

                    $("#errorArea").html(errorMessage)
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>