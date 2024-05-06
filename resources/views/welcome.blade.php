
    @extends('layouts.app')

     @section('content')
    <div aria-live="polite" aria-atomic="true" id="modelBox"
        class="d-flex justify-content-center align-items-center w-100">
        <div id="liveToast" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    &nbsp;
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <section class="noteText">
        <div class="container">
            <div class="row">
                <div class="col-12 m-auto">

                    <div class="card customCard">
                        <div class="card-header customHeader" style="background-color:#87CEEB"> Note: </div>
                        <div class="card-body">
                     
                        {!! $content->content !!}
                       
                            <div class="regBtn" ><a href="/register" style="background-color:#87CEEB;color:black">Register Now</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @endsection
    @push('scripts')
    
@endpush
    