<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>KIA - Monitoring System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    @if(auth()->check() && auth()->user()->role && strtolower(auth()->user()->role->nama_role) === 'ibu hamil')
    <style>
        /* Hide all Add/Create, Edit, and Delete action buttons, links, and forms for Ibu Hamil role on the 13 restricted menus */
        .role-ibu-hamil a[href*="/buku-kia/create"],
        .role-ibu-hamil a[href*="/buku-kia/"][href*="/edit"],
        .role-ibu-hamil form[action*="/buku-kia/"],
        
        .role-ibu-hamil a[href*="/kunjungan-anc/create"],
        .role-ibu-hamil a[href*="/kunjungan-anc/"][href*="/edit"],
        .role-ibu-hamil form[action*="/kunjungan-anc/"],
        
        .role-ibu-hamil a[href*="/profil-ibu/create"],
        .role-ibu-hamil a[href*="/profil-ibu/"][href*="/edit"],
        .role-ibu-hamil form[action*="/profil-ibu/"],
        
        .role-ibu-hamil a[href*="/profil-suami/create"],
        .role-ibu-hamil a[href*="/profil-suami/"][href*="/edit"],
        .role-ibu-hamil form[action*="/profil-suami/"],
        
        .role-ibu-hamil a[href*="/profil-anak/create"],
        .role-ibu-hamil a[href*="/profil-anak/"][href*="/edit"],
        .role-ibu-hamil form[action*="/profil-anak/"],
        
        .role-ibu-hamil a[href*="/bayi-baru-lahir/create"],
        .role-ibu-hamil a[href*="/bayi-baru-lahir/"][href*="/edit"],
        .role-ibu-hamil form[action*="/bayi-baru-lahir/"],
        
        .role-ibu-hamil a[href*="/imunisasi-anak/create"],
        .role-ibu-hamil a[href*="/imunisasi-anak/"][href*="/edit"],
        .role-ibu-hamil form[action*="/imunisasi-anak/"],
        
        .role-ibu-hamil a[href*="/tumbuh-kembang/create"],
        .role-ibu-hamil a[href*="/tumbuh-kembang/"][href*="/edit"],
        .role-ibu-hamil form[action*="/tumbuh-kembang/"],
        
        .role-ibu-hamil a[href*="/perkembangan-sidtk/create"],
        .role-ibu-hamil a[href*="/perkembangan-sidtk/"][href*="/edit"],
        .role-ibu-hamil form[action*="/perkembangan-sidtk/"],
        
        .role-ibu-hamil a[href*="/mpasi/create"],
        .role-ibu-hamil a[href*="/mpasi/"][href*="/edit"],
        .role-ibu-hamil form[action*="/mpasi/"],
        
        .role-ibu-hamil a[href*="/pembiayaan/create"],
        .role-ibu-hamil a[href*="/pembiayaan/"][href*="/edit"],
        .role-ibu-hamil form[action*="/pembiayaan/"],
        
        .role-ibu-hamil a[href*="/pemantauan-nifas/create"],
        .role-ibu-hamil a[href*="/pemantauan-nifas/"][href*="/edit"],
        .role-ibu-hamil form[action*="/pemantauan-nifas/"],
        
        .role-ibu-hamil a[href*="/kb-pasca-salin/create"],
        .role-ibu-hamil a[href*="/kb-pasca-salin/"][href*="/edit"],
        .role-ibu-hamil form[action*="/kb-pasca-salin/"],
        
        .role-ibu-hamil a[href*="/hasil-lab-ibu/create"],
        .role-ibu-hamil a[href*="/hasil-lab-ibu/"][href*="/edit"],
        .role-ibu-hamil form[action*="/hasil-lab-ibu/"],
        
        .role-ibu-hamil a[href*="/fasilitas-kesehatan/create"],
        .role-ibu-hamil a[href*="/fasilitas-kesehatan/"][href*="/edit"],
        .role-ibu-hamil form[action*="/fasilitas-kesehatan/"],
        
        .role-ibu-hamil .btn-delete,
        .role-ibu-hamil .btn-delete-child {
            display: none !important;
        }
    </style>
    @endif

    <style>
        /* Global CSS: Reposition DataTable horizontal scrollbar above pagination/info footer */
        .table-responsive {
            overflow-x: visible !important;
        }
        
        .dt-container .row:has(table),
        .dataTables_wrapper .row:has(table),
        .dt-container .col-12:has(table),
        .dataTables_wrapper .col-12:has(table),
        .dt-container .col-sm-12:has(table),
        .dataTables_wrapper .col-sm-12:has(table) {
            overflow-x: auto !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-bottom: 5px;
        }
        
        /* Ensure table takes full width and lays out nicely */
        .dt-container table,
        .dataTables_wrapper table {
            width: 100% !important;
            margin-bottom: 0 !important;
        }
    </style>

</head>

<body class="{{ auth()->check() && auth()->user()->role && strtolower(auth()->user()->role->nama_role) === 'ibu hamil' ? 'role-ibu-hamil' : '' }}">

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

                                    // Mark sidebar thread with a WhatsApp-style new message indicator
                                    var chatItem = $('#chat-list-container [data-chat-id="' + upd.session_id + '"]');
                                    if (chatItem.length) {
                                        chatItem.find('.chat-item-preview').text(upd.message);
                                        chatItem.find('.chat-item-time').text(upd.time);
                                        if (parseInt(activeChatId) !== parseInt(upd.session_id)) {
                                            chatItem.find('.chat-unread-indicator').removeClass('d-none');
                                        } else {
                                            chatItem.find('.chat-unread-indicator').addClass('d-none');
                                        }
                                    }

                                    // If we are NOT currently viewing this specific chat, trigger Toast
                                    if (parseInt(activeChatId) !== parseInt(upd.session_id)) {
                                        localStorage.setItem(key, latestId); // Update seen id so toast doesn't trigger repeatedly
                                        
                                        // WA-like visual SweetAlert2 toast notification
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: '<strong>' + upd.partner_name + '</strong>',
                                            html: '<div style="font-size: 13px; color: #111;">' + upd.message + '</div>',
                                            showConfirmButton: true,
                                            confirmButtonText: 'Buka Chat',
                                            confirmButtonColor: '#10B981',
                                            showCancelButton: true,
                                            cancelButtonText: 'Tutup',
                                            background: '#f5fffb',
                                            customClass: {
                                                popup: 'shadow-sm border border-success-subtle rounded-4'
                                            },
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
                                        if (typeof window.refreshActiveChatMessages === 'function') {
                                            window.refreshActiveChatMessages(upd.session_id, latestId);
                                        } else if ($('#chat-messages-container').length) {
                                            // Fallback partial reload if page-specific live chat is not available
                                            $('#chat-messages-container').load(window.location.href + ' #chat-messages-container > *', function () {
                                                var container = document.getElementById('chat-messages-container');
                                                if (container) {
                                                    container.scrollTop = container.scrollHeight;
                                                }
                                            });
                                        }
                                    }
                                }
                            });

                            var $sidebarBadge = $('#konsultasi-unread-badge');
                            var headerListHtml = '';

                            response.updates.forEach(function (upd) {
                                var key = 'chat_last_seen_' + upd.session_id;
                                var lastSeenId = parseInt(localStorage.getItem(key) || 0);
                                var latestId = parseInt(upd.last_message_id);

                                if (latestId > lastSeenId && parseInt(upd.sender_id) !== parseInt(currentUserId)) {
                                    headerListHtml += `
                                        <div class="notification-item dropdown-item p-2 rounded-3 mb-2" style="cursor: pointer; transition: background 0.15s;" 
                                            onclick="window.location.href='${"{{ route('konsultasi-online.index') }}?chat_id=" + upd.session_id}'"
                                            onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                          <div class="d-flex align-items-start gap-2">
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                              <i class="bi bi-chat-dots-fill fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1" style="min-width: 0;">
                                              <h4 class="mb-0 text-dark fw-bold" style="font-size: 12.5px; margin: 0;">${upd.partner_name}</h4>
                                              <p class="mb-0 text-muted" style="font-size: 11.5px; margin: 2px 0 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${upd.message}</p>
                                              <p class="mb-0 text-secondary" style="font-size: 9px; margin-top: 2px;">${upd.time}</p>
                                            </div>
                                          </div>
                                        </div>
                                        <hr class="dropdown-divider">
                                    `;
                                }
                            });

                            // (chat badge updates are merged into KIA notif badge below)
                            window._chatUnreadCount = unreadCount;
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

            // ── KIA Notifikasi Bell ──────────────────────────────────────
            var tipeIcon = {
                ttd_harian:'bi-capsule', anc_reminder:'bi-hospital',
                imunisasi_reminder:'bi-shield-plus', stunting_alert:'bi-graph-down-arrow',
                pasien_belum_anc:'bi-exclamation-triangle', posyandu_bulanan:'bi-calendar-heart',
                rekap_anc:'bi-clipboard-data', tanda_bahaya:'bi-exclamation-octagon',
                kelas_ibu:'bi-people', rujukan:'bi-arrow-right-circle'
            };
            var tipeColor = {
                ttd_harian:'#8b5cf6', anc_reminder:'#2563eb',
                imunisasi_reminder:'#059669', stunting_alert:'#dc2626',
                pasien_belum_anc:'#d97706', posyandu_bulanan:'#16a34a',
                rekap_anc:'#0891b2', tanda_bahaya:'#dc2626',
                kelas_ibu:'#be185d', rujukan:'#7c3aed'
            };

            function checkKiaNotifikasi() {
                $.get("{{ route('notifikasi.unread-count') }}", function (res) {
                    var total = (res.count || 0) + (window._chatUnreadCount || 0);
                    var $badge = $('#header-notif-badge');
                    var $title = $('#header-notif-title');

                    var $sidebarNotifBadge = $('#sidebar-notif-badge');
                    if (res.count > 0) {
                        $badge.text(res.count).show();
                        $sidebarNotifBadge.text(res.count).removeClass('d-none');
                        $title.text(res.count + ' notifikasi baru');
                    } else {
                        $badge.hide();
                        $sidebarNotifBadge.addClass('d-none');
                        $title.text('Notifikasi');
                    }

                    var $list = $('#header-notif-list');
                    if (res.items && res.items.length > 0) {
                        var html = '';
                        res.items.forEach(function (n) {
                            var ic = tipeIcon[n.tipe] || 'bi-bell';
                            var cl = tipeColor[n.tipe] || '#64748b';
                            html += '<a class="dropdown-item d-flex align-items-start py-2 px-3 notif-dropdown-item" href="' + (n.link || '#') + '" data-id="' + n.id + '" style="gap:10px;">' +
                                '<div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center" style="width:34px;height:34px;background:' + cl + '20;color:' + cl + ';">' +
                                '<i class="bi ' + ic + '"></i></div>' +
                                '<div class="flex-grow-1" style="overflow:hidden;">' +
                                '<div class="fw-semibold text-dark" style="font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + n.judul + '</div>' +
                                '<div class="text-muted" style="font-size:0.72rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + n.pesan + '</div>' +
                                '<div class="text-muted" style="font-size:0.68rem;">' + n.waktu + '</div>' +
                                '</div></a><hr class="dropdown-divider m-0">';
                        });
                        $list.html(html);

                        // Mark as read on click
                        $('.notif-dropdown-item').on('click', function (e) {
                            var id = $(this).data('id');
                            if (id) {
                                $.ajax({ url: '/notifikasi/' + id + '/read', method: 'PATCH',
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                            }
                        });
                    } else {
                        $list.html('<div class="text-center py-4 text-muted small" id="header-notif-empty"><i class="bi bi-bell-slash me-1"></i> Tidak ada notifikasi baru</div>');
                    }
                });
            }

            checkKiaNotifikasi();
            setInterval(checkKiaNotifikasi, 30000);
        });
    </script>
    @endauth

    @stack('scripts')
    @stack('styles')

</body>

</html>
