<script>
    $(".gender").change(function() {
        var suffix = $(this).val();
        $(".avatar").attr("src", "/img/avatar_" + suffix + ".png"); 
    });
</script>
