$(document).ready(function () {
    loadlistcountry('export');
    loadlistcountry('import');
});

function loadlistcountry(type){
    $('#datatable-'+type).DataTable({
        processing: false,
        serverSide: false,
        ajax: '../list-country-zone?id='+global_id+'&type='+type,
        pageLength: 50,
        columns: [
            { 
                "data": function(row, type, set, meta){
                    return row.name;
                }
            },
            { 
                "data": function(row){
                    return `<button class="btn btn-sm btn-danger btn-remove-country-zone" type="button" data-type="`+type+`" data-idcontent="`+row.id+`">X</button>`;
                },
                "className": "text-center"
            }
        ],
    });
}

$('#countryModal').on('show.bs.modal', function(event){
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var type = button.getAttribute('data-bs-type')
    var category = button.getAttribute('data-bs-idcategory')
    $('#save-modal-country').attr("data-type", type);
    // call ajax
    $.ajax({
        type:'GET',
        dataType:'JSON',
        url: '../list-country-none-zone?type='+type+'&idcategory='+category, 
        success: function(res){
            if(res.success){
                var str = '';
                $.each(res.data, function(i, v){
                    str += `<div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-country" type="checkbox" value="`+v.id+`" id="check`+v.id+`" data-name="`+v.name+`">
                                <label class="form-check-label" for="check`+v.id+`">
                                    `+v.name+`
                                </label>
                            </div>`
                })
                $("#modal-list-country").html(str);
            }else{
                alert('error')
            }
        }
    });
})

$('#save-modal-country').click(function(){
    var type=$(this).attr('data-type');
    var checkedValues = $('input.checkbox-country:checkbox:checked').map(function() {
        return this.value + '-' + $(this).data('name');
    }).get();
    var id=$(this).data('publishpricezone');

    if(!checkedValues){
        alert ('no selected country');
        return false;
    }

    $.ajax({
        type:'POST',
        dataType:'JSON',
        data : {type, checkedValues, id},
        url: '../save-country-zone', 
        success: function(res){
            if(res.success){
                $('#datatable-'+type).DataTable().clear().destroy();
                loadlistcountry(type)
                alert('success add country to zone')
            }else{
                alert('error')
            }
        },
        complete: function(jqXHR, textStatus){
            $("#countryModal").modal('hide')
        }
    })
})

$('body').on('click', '.btn-remove-country-zone', function(){
    var idcountry = $(this).data('idcontent');
    var type = $(this).data('type');
    var id = global_id;

    $.ajax({
        type:'POST',
        dataType:'JSON',
        data : {id, idcountry, type},
        url: '../remove-country-zone', 
        success: function(res){
            if(res.success){
                $('#datatable-'+type).DataTable().clear().destroy();
                loadlistcountry(type)
                alert('success remove country to zone')
            }else{
                alert('error')
            }
        },
        complete: function(jqXHR, textStatus){
            
        }
    })
})