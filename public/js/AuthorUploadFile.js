$(document).ready(function() {
    $('#getSlugImag').change(function(){
        var file_data = $('#getSlugImag').prop('files')[0];   
        var form_data = new FormData();  
        form_data.append('file', file_data);
        $.ajax({
            url: "/authoruploadimage",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                $('#preview img').attr('src',data);
                $('.image').attr("value",data);
            },
            error: function(xhr, ajaxOptions, thrownError) 
            {
                alert(xhr.statusText);
            }
        });
    });
});