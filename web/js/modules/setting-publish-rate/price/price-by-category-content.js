$(document).ready(function(){

})
var ExcelToJSON = function() {
    this.parseExcel = function(file, type) {
        $("body").busyLoad("show", {spinner: "cube",text: "loading"})

        var reader = new FileReader();
        var ext = file.name.split('.').pop().toLowerCase()

        reader.onload = function(e) {
            var data = e.target.result
            var object_itemList = null, object_shipping = null, object_dimension = null
            var formData = new FormData()

            if(ext == "xlsx" || ext == "xls"){
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });

                var sheet_0 = workbook.SheetNames[0]

                var obj = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet_0])
                var data = JSON.parse(JSON.stringify(obj))
                console.log(data)
                console.log(type)
                createTable(data, type)
            }else{
                alert("Upload list item hanya menerima file dengan extension .xlsx, .xsl")
            }
        }

        reader.onerror = function(ex) {
            console.log(ex)
        }

        reader.readAsBinaryString(file)
        $("body").busyLoad('hide')
    }
}

$('.upload-file-xls').change(function(e){
    console.log('a')
    var type = $(this).data('type')
    handleFileSelect(e.target.files[0], type)
})

function handleFileSelect(files, type) {
    var xl2json = new ExcelToJSON()
    xl2json.parseExcel(files, type)
}

function createTable(data, type){
    var table = $(`<table class="table"></table>`);
    var thead = $(`<thead>
                        <tr>
                            <th>Tier</th>
                            <th>Harga</th>
                        </tr>
                    </thead>`);
    var tbody = $(`<tbody></tbody>`);

    $.each(data, function(i, v){
        var tr = $(`<tr></tr>`);
        tr.append(`
            <td><input type="text" value="`+v.Tier+`" class="form-control inp-price" name="PublishPrice[rate][`+i+`][tier]"></td>
            <td><input type="text" value="`+v.Harga+`" class="form-control inp-price" name="PublishPrice[rate][`+i+`][price]"></td>
        `);
        tbody.append(tr)
    })
    table.append(thead).append(tbody)
    $('#table-publish-price-'+type).append(table)

}

$('.btn-submit-publish-price').click(function(){
    var type = $(this).data('type')
    if( $('.inp-price').length ) {
        $("body").busyLoad("show", {spinner: "cube",text: "loading"})
        var form_data = new FormData($('#form-publish-price-'+type)[0]);
        $.ajax({
            type:'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            data : form_data,
            async: false,
            url: '../price/submit-publish-price-by-content', 
            success: function(res){
                if(res.success){
                    alert("success update price for publish")
                    location.reload()
                }else{
                    alert('error')
                }
            },
            complete: function(jqXHR, textStatus){
                $("body").busyLoad("hide")
            }
        })
    }else{
        alert('Data Not Available To Submit')
        return false;
    }
})

$('#countryModal').on('show.bs.modal', function(event){
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var category = button.getAttribute('data-bs-idcategory')
    var category_name = button.getAttribute('data-bs-categoryname')
    var active_id_content = button.getAttribute('data-bs-idcontent')
    $('#save-modal-country').attr("data-category", category_name);
    var str = '';
    $.each(global_list_content[category], function(idcontent, country) {
        if(active_id_content != idcontent){
            str += `<div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox-country" type="checkbox" value="`+idcontent+`" id="check`+idcontent+`" data-name="`+country+`">
                                    <label class="form-check-label" for="check`+idcontent+`">
                                        `+country+`
                                    </label>
                                </div>`;
        }
    })
    $("#modal-list-country").html(str);
})

$('#save-modal-country').click(function(){
    var category_name= $(this).attr('data-category');
    var id_content = $(this).attr('data-idcontent');

    var checkedValues = $('input.checkbox-country:checkbox:checked').map(function() {
        return this.value + '-' + $(this).data('name');
    }).get();

    if(checkedValues.length == 0){
        alert ('no selected country');
        return false;
    }

    $.ajax({
        type:'POST',
        dataType:'JSON',
        data : {category_name, id_content, checkedValues},
        url: '../price/submit-price-with-same-zone', 
        success: function(res){
            if(res.success){
                alert('success submit publish price to selected country')
                location.reload()
            }else{
                alert('error')
            }
        },
        complete: function(jqXHR, textStatus){
            $("#countryModal").modal('hide')
        }
    })
})