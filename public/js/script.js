$(document).on('click', '.myModalRegister', function () {
    $("#myModalRegister").modal('show');
});
$(document).on('click', '.myModalLogin', function () {
    $("#myModalLogin").modal('show');
});

$(document).on("click", ".loginInstead", function (e) {
    e.preventDefault();
    $("#myModalRegister").modal("hide");
    $("#myModalLogin").modal('show');
});
$(document).on("click", ".registerInstead", function (e) {
    e.preventDefault();
    $("#myModalRegister").modal("show");
    $("#myModalLogin").modal('hide');
});
$(document).on("click", ".forgotInsead", function (e) {
    e.preventDefault();
    $("#myForgot").modal("show");
    $("#myModalLogin").modal('hide');
});

$(document).on('click', '.first a', function (e) {
    e.preventDefault();
    $(".toggle").toggleClass('hidden');
});

$('#list').click(function (e) {
    e.preventDefault();
    $('#products .item').addClass('list-group-item');
    $(".item.col-lg-4").css({"height": "auto"});
    $("#grid").removeClass('active');
    $(".list-thum").removeClass('hidden');
    $(".grid").addClass('marginRight');
});

$('#grid').click(function (e) {
    e.preventDefault();
    $('#products .item').removeClass('list-group-item');
    $(".item.col-lg-4").css({"height": "300px"})
    $("#list").removeClass('active');
    $(".list-thum").addClass('hidden');
    $(".grid").removeClass('marginRight');
});

$(document).on('click', '.pro-thumbnail', function () {
    var data = $(this).attr('data');
    $(".bigImg").attr('src', data);
})

$(document).on('change', '#category', function () {
    var id = $('option:selected', this).attr('data-id');
    jQuery.ajax({
        type: "GET",
        url: $("#homeUrl").val() + '/api/category?id=' + id,
        dataType: "json",
        success: function (data) {
            var sub = data.sub_category;
            var option = "";
            for (var i = 0; i < sub.length; i++) {
                option += "<option value='" + sub[i].name + "'>" + sub[i].name + "</option>";
            }
            $("#sub").html(option);
        }
    })
});


$(function () {
    // Multiple images preview in browser
    var imagesPreview = function (input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function (event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function () {
        imagesPreview(this, 'div.gallery');
    });
});

$(document).on("click", ".img-post", function () {
    $('#gallery-photo-add').click();
});

//delete image ads
$(document).on("click", ".x", function () {
    var data = {};
    data.url = $(this).attr('data-url');
    data.key = $(this).attr('data-key');
    data.pid = $(this).attr('data-id');
    jQuery.ajax({
        type: "GET",
        url: $("#homeUrl").val() + '/delete/product/image/',
        dataType: "json",
        data: data,
        success: function (data) {

        }
    });
    $(this).parent().remove();

})

$(document).on('click', '.img-responsive', function () {
    $("#image").click();
})

$(document).on("change", "#sort", function () {
    $("#formSort").submit();
})