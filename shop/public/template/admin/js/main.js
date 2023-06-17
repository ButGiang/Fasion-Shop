// xử lý @csrf token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


// xóa 1 dòng trg database sử dụng ajax
function RemoveRow(id, url) {
    if(confirm('Xóa danh mục này? hành động này không thể hoàn tác!')) {
        $.ajax({
            type: 'delete',
            datatype: 'JSON',
            data: {id},
            url: url,

            success: function(result) {
                if(!result.error) {
                    alert(result.message)
                    location.reload()
                }
                else {
                    alert('Có lỗi xảy ra! Vui lòng thử lại')
                }
            }
        })
    }
}


// upload file
$('#upload').change(function() {
    const form = new FormData()
    form.append('file', $(this)[0].files[0])

    $.ajax({
        processData: false,
        contentType: false,
        type: 'post',
        datatype: 'JSON',
        data: form,
        url: '/admin/upload/services',

        success: function(result) {
            if(!result.error) {
                $('#image_show').html(
                    '<a href="' + result.url + '" target="_blank">' +
                        '<img src="' + result.url + '" width="100px"> </img></a>')

                $('#file').val(result.url);
            }
            else {
                alert('Upload file thất bại!')
            }
        }

    })


})
