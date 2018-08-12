jQuery(function () {
    $('#display-more').on('click', function () {
        this.style.display = 'none';
        $('tbody.flight:gt(1)').show();
    });
});