<script>
    $(".gender").change(function() {
        var suffix = $(this).val();
        $(".avatar").attr("src", "/img/avatar_" + suffix + ".png"); 
    });
    
    function openImageModal() {
        //showUploadForm();
        setTimeout(function() {
            $('#imageModal').modal('show');
        }, 230);
    }
    
    function showUploadForm() {
    $('#loginModal .registerBox').fadeOut('fast', function() {
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast', function() {
            $('.login-footer').fadeIn('fast');
        });
        $('.modal-title').text('Log in to Flocc');
    });
    $('.error').removeClass('alert alert-danger').html('');
}
</script>
