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
});
$('#grid').click(function (e) {
    e.preventDefault();
    $('#products .item').removeClass('list-group-item');
});