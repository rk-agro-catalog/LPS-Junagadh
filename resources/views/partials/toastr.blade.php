<!-- LPS Junagadh - Toastr & Multi-Validation Floating Notifications -->
<script src="{{ asset('js/lps-toast.js') }}?v={{ file_exists(public_path('js/lps-toast.js')) ? filemtime(public_path('js/lps-toast.js')) : '1.0' }}"></script>

<script>
    (function () {
        function triggerServerNotifications() {
            if (typeof window.toastr === 'undefined') return;

            @if(session('success'))
                window.toastr.success(@json(session('success'), JSON_UNESCAPED_UNICODE));
            @endif

            @if(session('error'))
                window.toastr.error(@json(session('error'), JSON_UNESCAPED_UNICODE));
            @endif

            @if(session('warning'))
                window.toastr.warning(@json(session('warning'), JSON_UNESCAPED_UNICODE));
            @endif

            @if(session('info'))
                window.toastr.info(@json(session('info'), JSON_UNESCAPED_UNICODE));
            @endif

            @if(session('status'))
                window.toastr.info(@json(session('status'), JSON_UNESCAPED_UNICODE));
            @endif

            @if($errors->any())
                window.toastr.validation(@json($errors->all(), JSON_UNESCAPED_UNICODE), 'કૃપા કરીને નીચેની વિગતો સુધારો:');
            @endif
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', triggerServerNotifications);
        } else {
            triggerServerNotifications();
        }
    })();
</script>
