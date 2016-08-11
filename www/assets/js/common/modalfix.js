$(function() {
    var modalBody = $(".yulong .modal-body[mf=modalfix]");
    modalBody.height($(window).height() - 240);
    $(window).resize(function() {
        modalBody.height($(window).height() - 240)
    })
});
