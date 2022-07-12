$(document).ready(function(){

})
var ExcelToJSON = function() {
    this.parseExcel = function(file) {
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
                createTable(data)
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

$("#upload-file").change(function(e){
    handleFileSelect(e.target.files[0])
})

function handleFileSelect(files) {
    var xl2json = new ExcelToJSON()
    xl2json.parseExcel(files)
}

function createTable(data){
    var table = $(`<table class="table"></table>`);
    var thead = $(`<thead>
                        <tr>
                            <th>Tier</th>
                            <th>Harga</th>
                        </tr>
                    </thead>`);
    var tbody = $(`<tbody></tbody>`);

    $.each(data, function(i, v){
        
    })

}