$(document).ready(function() {
    CKEDITOR.replace('Post[content]');

    $('#select-country').each(function () {
        $(this).select2({
            theme: 'bootstrap-5',
            // width: '100%',
            // placeholder: $(this).data('placeholder'),
            // allowClear: Boolean($(this).data('allow-clear')),
        })
    })

    var global_base_url = checklocationurl()

    function checklocationurl(){
        var host = window.location.host;
        if(host == 'localhost'){
            var _url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + "/";
        }else{
            var _url = window.location.protocol + "//" + window.location.host + "/";
        }
        return _url
    }

    $("#select-country").change(function(){
        checkdata()
    })

    $("#select-services").change(function(){
        checkdata()
    })

    function checkdata(){
        console.log($('#select-services').find(":selected").text())
        console.log($('#select-country').find(":selected").text())
        if($('#select-services').find(":selected").text() != 'Please Select' && $('#select-country').find(":selected").text() != 'Please Select'){
        console.log(this)
            $.ajax({
                url:  global_base_url+'/post/check-data',
                type: "POST",
                dataType: "json",
                data: {
                    id_service: $('#select-services').val(),
                    id_country: $("#select-country").val()
                },
                success: function(data) {
                    if (data.success) {
                        alert('Data sudah pernah di input');
                        $('#select-services').prop('selectedIndex',0);
                    }
                }
            })
        }
    }
})