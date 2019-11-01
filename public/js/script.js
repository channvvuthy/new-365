$(document).on('click', '.myModalRegister', function () {
    $("#myModalRegister").modal('show');
});
$(document).on('click', '.myModalLogin', function () {
    $("#myModalLogin").modal('show');
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
});

$('#grid').click(function (e) {
    e.preventDefault();
    $('#products .item').removeClass('list-group-item');
    $(".item.col-lg-4").css({"height": "300px"})
    $("#list").removeClass('active');
    $(".list-thum").addClass('hidden');
});

$(document).on('click', '.pro-thumbnail', function () {
    var data = $(this).attr('data');
    $(".bigImg").attr('src', data);
})