<script>

function openImageModal() {
    setTimeout(function() {
        $('#imageModal').modal('show');
    }, 230);
}

function fadeImageModal() {
    setTimeout(function() {
        $('#imageModal').modal({'show':false});
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
}

$(document).ready(function() {

    $(".gender").change(function() {
        var suffix = $(this).val();
        $(".avatar").attr("src", "/img/avatar_" + suffix + ".png");
    });

    $('.error').removeClass('alert alert-danger').html('');

    $('.btn-file :file').on('change', function() {
        var f = $(this).val().replace(/^.*\\/, '');
        $('#image_file').val(f);
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#image_preview");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "avatar img-thumbnail"
                }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });

    $('#image_sumbit').on('submit', function() {
        fadeImageModal();
    });
});
</script>
