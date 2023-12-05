<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/modernizr.js') }}"></script>
<script src="{{ asset('js/css-scrollbars.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/SmoothScroll.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
@yield('script')
<script src="{{ asset('js/pcoded.min.js') }}"></script>
<script src="{{ asset('js/vertical-layout.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".delete").click(function() {
            if (!confirm("Do you want to delete?")) {
                return false;
            }
        });
        $('.select2').select2();
    });

    window.onload = function() {
        const activeMenuItem = document.querySelector('.active');

        if (activeMenuItem) {
            activeMenuItem.scrollIntoView({
                behavior: 'smooth'
            });
        }

    };
</script>

<style>
    .sidebar {
        overflow: hidden;
    }
</style>
