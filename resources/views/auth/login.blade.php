<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login SIMTEK</title>
        <link rel="icon" href="{{ asset('favicon_io/favicon.ico') }}" type="image/x-icon">
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-white">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h4 class="text-center font-weight-light my-4">Halaman Login</h4></div>
                                    <div class="card-body">
                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                        <form action="{{ route('login.action') }}" method="POST" class="user">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" placeholder="name@example.com" value="{{ old('email') }}" />
                                                <label for="email">Email</label>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="Password" value="{{ old('password') }}" />
                                                <label for="password">Kata Sandi</label>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <div class="d-flex">
                                                    <span class="small">Belum punya akun?</span>
                                                    <a class="small ms-1" href="{{ route('register') }}">Daftar Sekarang</a>
                                                    <span class="small">.</span>
                                                </div>
                                                <button class="btn btn-primary">Masuk</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Modal Success Notification -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Login Berhasil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        <p class="mt-3">Anda berhasil masuk!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('dashboard') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script>
            @if(session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                successModal.show();
            @endif
        </script>
    </body>
</html>
