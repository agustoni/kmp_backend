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
            url: '../../price/submit-publish-price-by-zone', 
            success: function(res){
                if(res.success){
                    var len = res.list_country.length;
                    var index = 1;
                    var str = '';
                    $.each(res.list_country, function(i, v){
                        if(index == len){
                            str += v
                        }else{
                            str += v+', '
                        }
                        index++;
                    })
                    alert("success update price for publish to "+str)
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