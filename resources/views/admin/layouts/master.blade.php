<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard &mdash; Truckzap</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">
    <link rel="stylesheet" href="{{asset('css/chat-status.css')}}">
    <link rel="stylesheet" href="{{ asset('css/chat-files.css') }}">
    {{-- <style>
        :root {
            --primary-color: {
                    {
                    config('settings.site_default_color')
                }
            }

            ;

        }

        /* Add more overrides as needed */
    </style> --}}

    @stack('styles')
{{-- 
    <script>
        var PUSHER_APP_KEY = "{{ config('settings.pusher_app_key') }}";
        var PUSHER_APP_CLUSTER = "{{ config('settings.pusher_cluster') }}";
        var USER = {
            id: "{{ auth()->user()?->id }}",
            name: "{{ auth()->user()?->name }}",
            avatar: "{{ asset(Auth::user()?->avatar) }}"
        }
    </script>
    @vite(['resources/js/app.js', 'resources/js/admin.js']) --}}

</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            @include('admin.layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">

                @yield('contents')

            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{date('Y')}}
                    <div class="bullet"></div> Design By <a href="">Truck Zap LLC</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{asset('admin/assets/modules/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/modules/popper.js')}}"></script>
    <script src="{{asset('admin/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/stisla.js')}}"></script>

    <!-- JS Libraies -->

    <script src="{{asset('admin/assets/modules/summernote/summernote-bs4.js')}}"></script>
    <script src="{{ asset('admin/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script
        src="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        // Ensure CSRF token is included globally

        $(document).on('click', '.delete-item', function (e) {
            e.preventDefault();  // Prevent default link behavior

            var url = $(this).data('url');  // Get the URL from data-url attribute
            var $this = $(this);  // Store the clicked element for later use
            // Confirm deletion using SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send the delete request via AJAX
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Include the CSRF token
                        },
                        success: function (response) {
                            // Success response handling
                            Swal.fire(
                                'Deleted!',
                                'The item has been deleted.',
                                'success'
                            );

                            // Reload the closest DataTable
                            const $table = $this.closest('table');
                            if ($.fn.DataTable.isDataTable($table)) {
                                $table.DataTable().ajax.reload();
                            } else {
                                $this.closest('tr').fadeOut(300, function () {
                                    $(this).remove();
                                });
                            }







                        },
                        error: function (xhr, status, error) {
                            // Error response handling
                            Swal.fire(
                                'Error!',
                                'Something went wrong while deleting the item.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


    </script>
    {{--
    <script>
        $(document).ready(function () {
            // Small delay to ensure Echo is fully initialized
            setTimeout(function () {
                console.log('=== Initializing Echo Listeners ===');
                console.log('Echo available:', typeof window.Echo !== 'undefined');
                console.log('USER:', USER);

                if (typeof window.Echo === 'undefined') {
                    console.error('❌ Echo not loaded!');
                    return;
                }

                // Subscribe to private message channel
                console.log('Subscribing to: message.' + USER.id);

                window.Echo.private('message.' + USER.id)
                    .subscribed(() => {
                        console.log('✅ Successfully subscribed to message.' + USER.id);
                    })
                    .error((error) => {
                        console.error('❌ Channel error:', error);
                    });

                // Subscribe to online presence channel
                window.Echo.join('online')
                    .here((users) => {
                        console.log('✅ Online users:', users);
                        $.each(users, function (index, user) {
                            $('.profile_card').each(function () {
                                let profileUserId = $(this).data('receiver-id');
                                if (profileUserId == user.id) {
                                    $(this).find('.user-status').addClass('user-active');
                                }
                            });
                        });
                    })
                    .joining((user) => {
                        console.log('✅ User joined:', user);
                        $(`.profile_card[data-receiver-id="${user.id}"]`).find('.user-status').addClass('user-active');
                    })
                    .leaving((user) => {
                        console.log('User left:', user);
                        $(`.profile_card[data-receiver-id="${user.id}"]`).find('.user-status').removeClass('user-active');
                    })
                    .error((error) => {
                        console.error('Presence channel error:', error);
                    });

                console.log('=== Echo Listeners Initialized ===');
            }, 500); // 500ms delay to ensure everything is ready
        });
    </script> --}}
    @stack('scripts')
</body>

</html>