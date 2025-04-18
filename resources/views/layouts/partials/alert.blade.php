@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ __('dashboard.success') }}",
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            theme: getCurrentTheme(),
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: "{{ __('dashboard.error') }}",
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false,
            theme: getCurrentTheme(),
        });
    </script>
@endif