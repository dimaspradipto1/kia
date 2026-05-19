<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>KIA - Monitoring System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    {{--  datatables CSS  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    @include('layouts.dashboard.header')
    @include('layouts.dashboard.sidebar')

    @include('sweetalert::alert')

    <main id="main" class="main">
        @yield('content')
    </main><!-- End #main -->

    @include('layouts.dashboard.footer')


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- datatables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    {{-- Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Select2 dengan search
            $('.select2').select2({
                theme: 'default',
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: 0,
                language: {
                    noResults: function() { return "Tidak ada hasil"; },
                    searching: function() { return "Mencari..."; }
                }
            });

            // Select2 tanpa search (untuk pilihan sedikit)
            $('.select2-nosearch').select2({
                theme: 'default',
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                language: {
                    noResults: function() { return "Tidak ada hasil"; }
                }
            });
        });
    </script>

    @auth
    <script>
        $(document).ready(function () {
            // Real-time Chat Notification Service
            function checkChatNotifications() {
                $.ajax({
                    url: "{{ route('konsultasi-online.check-updates') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.updates) {
                            var unreadCount = 0;
                            var currentUserId = response.user_id;
                            
                            // Check if user is currently inside a chat window
                            var activeChatWrapper = $('#chat-window-wrapper');
                            var activeChatId = activeChatWrapper.length ? activeChatWrapper.data('chat-id') : null;

                            response.updates.forEach(function (upd) {
                                var key = 'chat_last_seen_' + upd.session_id;
                                var lastSeenId = localStorage.getItem(key);

                                // If no record yet, seed it with the current latest to prevent spam on first load
                                if (!lastSeenId) {
                                    localStorage.setItem(key, upd.last_message_id);
                                    lastSeenId = upd.last_message_id;
                                }

                                lastSeenId = parseInt(lastSeenId);
                                var latestId = parseInt(upd.last_message_id);

                                // If the message is new, and not sent by the logged-in user
                                if (latestId > lastSeenId && parseInt(upd.sender_id) !== parseInt(currentUserId)) {
                                    unreadCount++;

                                    // If we are NOT currently viewing this specific chat, trigger Toast
                                    if (parseInt(activeChatId) !== parseInt(upd.session_id)) {
                                        localStorage.setItem(key, latestId); // Update seen id so toast doesn't trigger repeatedly
                                        
                                        // Play visual SweetAlert2 toast notification
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'info',
                                            title: 'Pesan Baru',
                                            html: '<b>' + upd.partner_name + '</b>: ' + upd.message,
                                            showConfirmButton: true,
                                            confirmButtonText: 'Buka Chat',
                                            confirmButtonColor: '#10B981',
                                            showCancelButton: true,
                                            cancelButtonText: 'Tutup',
                                            timer: 10000,
                                            timerProgressBar: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "{{ route('konsultasi-online.index') }}?chat_id=" + upd.session_id;
                                            }
                                        });
                                    } else {
                                        // If we are currently in this chat room, automatically update seen ID
                                        localStorage.setItem(key, latestId);
                                        // Seamless dynamic reload of ONLY the message bubbles container
                                        if ($('#chat-messages-container').length) {
                                            $('#chat-messages-container').load(window.location.href + ' #chat-messages-container > *', function () {
                                                // Smooth scroll to bottom
                                                var container = document.getElementById('chat-messages-container');
                                                if (container) {
                                                    container.scrollTop = container.scrollHeight;
                                                }
                                            });
                                        }
                                    }
                                }
                            });

                            // Update Sidebar & Header Bell Badges
                            var $sidebarBadge = $('#konsultasi-unread-badge');
                            var $headerBadge = $('#header-notification-badge');
                            var $headerText = $('#header-notification-text');
                            
                            var headerListHtml = '';

                            response.updates.forEach(function (upd) {
                                var key = 'chat_last_seen_' + upd.session_id;
                                var lastSeenId = parseInt(localStorage.getItem(key) || 0);
                                var latestId = parseInt(upd.last_message_id);

                                if (latestId > lastSeenId && parseInt(upd.sender_id) !== parseInt(currentUserId)) {
                                    headerListHtml += `
                                        <li class="notification-item" style="cursor: pointer; padding: 12px 15px; transition: background 0.15s;" 
                                            onclick="window.location.href='${"{{ route('konsultasi-online.index') }}?chat_id=" + upd.session_id}'"
                                            onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                          <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-chat-dots-fill text-success fs-5"></i>
                                            <div class="flex-grow-1" style="min-width: 0;">
                                              <h4 class="mb-0 text-dark fw-bold" style="font-size: 12.5px; margin: 0;">${upd.partner_name}</h4>
                                              <p class="mb-0 text-muted" style="font-size: 11.5px; margin: 2px 0 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${upd.message}</p>
                                              <p class="mb-0 text-secondary" style="font-size: 9px; margin-top: 2px;">${upd.time}</p>
                                            </div>
                                          </div>
                                        </li>
                                        <li>
                                          <hr class="dropdown-divider">
                                        </li>
                                    `;
                                }
                            });

                            if (unreadCount > 0) {
                                $sidebarBadge.text(unreadCount).removeClass('d-none');
                                $headerBadge.text(unreadCount).removeClass('d-none');
                                $headerText.text('Anda memiliki ' + unreadCount + ' notifikasi baru');
                                $('#header-notifications-list').html(headerListHtml);
                            } else {
                                $sidebarBadge.addClass('d-none');
                                $headerBadge.addClass('d-none');
                                $headerText.text('Anda tidak memiliki notifikasi baru');
                                $('#header-notifications-list').html('<li class="text-center py-4 text-muted small"><i class="bi bi-bell-slash me-1"></i> Tidak ada notifikasi baru</li>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error polling notifications:', err);
                    }
                });
            }

            // Run check on load, and then every 8 seconds
            checkChatNotifications();
            setInterval(checkChatNotifications, 8000);
        });
    </script>
    @endauth

    @stack('scripts')
    @stack('styles')

</body>

</html>
