<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

@if (isset($alert))
    <script>
        var mensaje = {!! json_encode($alert) !!};

        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: 'error',
                title: mensaje
            })
        });
    </script>
@endif

@if (isset($ok_alert))
    <script>
        var mensaje = {!! json_encode($ok_alert) !!};

        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: 'success',
                title: mensaje
            })
        });
    </script>
@endif