$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadmore() {
    const page = $('#page').val()
    $.ajax({
        type: 'post',
        dataType: 'JSON',
        data: {page},
        url: '/services/load-product',

        success: function(result) {
            if(result.html != '') {
                $('#loadProduct').append(result.html)
                $('#page').val(page + 1)
            }
            else {
                alert('Đã load hết sản phẩm.')
                $('#btn-loadmore').css('display', 'none')
            }
        }
    })
}
