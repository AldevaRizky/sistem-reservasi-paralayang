<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/icon/custom-icon.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/component.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>


<div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]">
</div>


<script>
    layout_change('false');
</script>


<script>
    layout_theme_sidebar_change('dark');
</script>


<script>
    change_box_container('false');
</script>

<script>
    layout_caption_change('true');
</script>

<script>
    layout_rtl_change('false');
</script>

<script>
    preset_change('preset-1');
</script>

<script>
    main_layout_change('vertical');
</script>

<script>
    function setThemeMode(mode) {
        localStorage.setItem('theme-mode', mode);
        layout_change(mode);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mode = localStorage.getItem('theme-mode') || 'default';
        layout_change(mode);
    });
</script>
