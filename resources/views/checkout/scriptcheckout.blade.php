<script src="{{ asset('acheck/js/main.js') }}"></script>
<script src="{{ asset('acheck/js/common_scripts.min.js') }}"></script>
<script>
    // Other address Panel
    $('#other_addr input').on("change", function (){
        if(this.checked)
            $('#other_addr_c').fadeIn('fast');
        else
            $('#other_addr_c').fadeOut('fast');
    });
</script>

