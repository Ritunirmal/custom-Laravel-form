@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/3.3.1/jsencrypt.min.js"></script>


<script>
// Event listener for the form submission
document.getElementById('myForm').addEventListener('submit', function(event) {
    // event.preventDefault(); // Prevent default form submission behavior (page refresh)
    const publicKey = `-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjfknEXET0JhkUDQ5f5Fa
uvTfkM1uyz179ys5deRhsnAIpz6vZdZAFAmw3ffX+bDEEhgg6qCTyYMITCoTLWDL
FNOjErR3B5ZQV9XChjtc9E20pd+ku8tx3k7xwvqb/p9t/RtYfr4BWLLqye3acc3q
cSItvB8tLMXy51Zm0Gpp5FAoSbodJJGvbF8pZgxDiqbPtwb5ynV3c8IUgsokRfwM
/VLzz/R/JGeUxkCX7Geep4ittAGo9gucoK8eqlbO5FG0781jb59m5ZZ6Qtvc/j7c
1Ost7pbU9HqKWHFq9R38CBq1Bf+xBA9RcOqqqCXluWM5npN3XU9AcGPxgJUNouRI
xwIDAQAB
-----END PUBLIC KEY-----`;
const encrypt = new JSEncrypt();
    encrypt.setPublicKey(publicKey);
    const passwordInput = document.getElementById('password');
    const password = passwordInput.value;
   
    const encryptedPassword = encrypt.encrypt(password);
    document.getElementById('password').value = encryptedPassword;
    console.log('Encrypted Password:', encryptedPassword);

    // You can send the encrypted data to your backend here
});



</script>

@endsection