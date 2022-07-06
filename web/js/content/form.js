$(document).ready(function() {
    $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
        $("#inputNationshidden").val(suggestion.id)
    });


    if (globalContent != null) {
        var obj = JSON.parse(globalContent);
        
        $("#metaTitle").val(obj['meta']['title'])
        $("#metaKeyword").val(obj['meta']['keyword'])
        $("#metaDescription").val(obj['meta']['description'])
        $("#metaH1").val(obj['meta']['h1'])
        $("#metaH2").val(obj['meta']['h2'])

        if (obj['tax']) {
            if (obj['tax']['amount']) {
                $("#inputTaxAmount").val(obj['tax']['amount'])
            }
            if (obj['tax']['currency']) {
                $("#selectTaxCurrency").val(obj['tax']['currency'])
            }
            if (obj['tax']['description']) {
                $("#inputTaxDescription").val(obj['tax']['description'])
            }
        }
        
        if (obj['restriction']) {
            if (obj['restriction']['content']) {
                $("#inputRestrictionContent").val(obj['restriction']['content'])
            }
        }
    }
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

/* SCRIPT TAB GENERAL */
    var nations = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: global_base_url+'content/get-nations?q=%QUERY',
            wildcard: '%QUERY'
        }
    });

    $('#inputNations').typeahead(null, {
        name: 'nations',
        display: 'value',
        source: nations
    });

    $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
        checkData()
    });

    $("#inputServices").change(function() {
        checkData()
        
        if (this.value == 1) {
            $("#basic-addon-url").text("jasa-ekspor-barang/");
        } else if (this.value == 2) {
            $("#basic-addon-url").text("jasa-impor-barang/");
        } else {
            $("#basic-addon-url").text("");
        }
    })

    function checkData() {
        if ($('#inputServices').find(":selected").text() != 'Please Select' && $("#inputNationshidden").val() !== "") {
            $.ajax({
                url:  global_base_url+'/content/check-data',
                type: "POST",
                dataType: "json",
                data: {
                    idService: $('#inputServices').val(),
                    idNations: $("#inputNationshidden").val()
                },
                success: function(data) {
                    if (data.success) {
                        alert('Data sudah pernah di input');
                        $("#form-contens input, textarea, button").prop("disabled", true);
                    } else {
                        $("#form-contens input, textarea, button").prop("disabled", false);
                    }
                }
            })
        } else {
            $("#form-contens input, textarea, button").prop("disabled", false);
        }
    }

/* END SCRIPT TAB GENERAL */