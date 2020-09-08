$(document).ready(function () {
    getCategories();
    $("#categories").select2({
        placeholder: "احتار التصنيفات",
        width: "auto"


    });

    changeServiceIcon();
    var categoryDataTable = fillDataTable();
    var table = $('#categoriesTable').DataTable();

    //  categoryDataTable.search().draw();
    prepareDatatable();
    $('#addNewServiceButton').click(function () {
        resetSelect2($('#editedCategories'));
        getCategories(); // fill select2 of add service with categories
    });
    
    var $radios = $('input:radio[id=statusYes]');
    if ($radios.is(':checked') === false) {
        $radios.parent('span').addClass('checked');
        $radios.filter('[value=نعم]').prop('checked', true);
        

    }
    var $radios = $('input:radio[id=emergencyYes]');
    if ($radios.is(':checked') === false) {
        $radios.parent('span').addClass('checked');
        $radios.filter('[value=نعم]').prop('checked', true);
        

    }
    $("#submit").click(function () {
        if ($("#addNewService").valid() == false) {
            return;
        }

        if ($('input[name="serviceImage"]')[0].files && $('input[name="serviceImage"]')[0].files[0]) {
            var reader = new FileReader();
            var data = [{
                'serviceName_ar': $('#serviceName_ar').val(),
                'serviceName_en': $('#serviceName_en').val(),
                'description_ar': $('#description_ar').val(),
                'description_en': $('#description_en').val(),
                'categories': $('#categories').val(),
                'status': $('.status').val(),
                'emergency': $('.emergency').val(),
                'serviceIcon': $('.serviceIcon').val(),
                'serviceImage': $('input[name="serviceImage"]')[0].files[0].result
            }];
            saveService(data, categoryDataTable);
            categoryDataTable.ajax.reload();
            resetSelect2($("#categories")); //reset multi-selection for addService Modal

            $('#basic').modal('hide');
            resetAddServiceModal(); //reset AddService Modal
          
            $('#basic').modal('hide');
            $('#serviceName_ar').val(null);
            $('#serviceName_en').val(null);
            $('#description_ar').val(null);
            $('#description_en').val(null);
            $('#categories').val(null);
        }

    });


    addCategoryButtonAction(categoryDataTable);
    showServices(service); //show category service after clicking


    editCategoryButtonAction(categoryDataTable);
    $('body').on('click', '.deleteCategory', function () {
        //  deleteCategoryName();
        categoryId = $(this).parents().siblings('#categoryId').val();
        var categoryName = $(this).parents('tr').children('.sorting_1').next().html();
        swal({
                title: warningMessage,
                text: "" + categoryName,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: yes,
                showLoaderOnConfirm: true,
                cancelButtonText: no,
                closeOnConfirm: false,
                closeOnCancel: true

            },
            function () {
                deleteCategory(categoryId, categoryDataTable);

                setTimeout(function () {
                    swal(deletionMessage);
                }, 2000);
            });


    });

});


$("#addNewService").validate({
    ignore: '',
    rules: {
        serviceName_ar: {
            required: true
        },
        serviceName_en: {
            required: true
        },
        description_ar: {
            required: true
        },
        description_en: {
            required: true
        },
        "categories[]": {
            required: true
        },
        emergency: {
            required: true
        },
        status: {
            required: true
        }
    },
    messages: {
        serviceName_ar: {
            required: "يجب ادخال اسم الخدمة (عربي)"

        },
        serviceName_en: {
            required: "يجب ادخال اسم الخدمة (انجليزي)"

        },
        "categories[]": {
            required: "يجب اختيار تصنيف واحد على الأقل"
        },
        emergency: {
            required: "يجب ادخال حالة الخدمة"
        },
        description_ar: {
            required: "يجب ادخال وصف للخدمة (عربي)"
        },
        description_en: {
            required: "يجب ادخال وصف للخدمة (انجليزي)"
        }

    },
    submitHandler: function (form) {
        alert('work');
        alert($('#categories').val());
        form.submit();

    }
});

function deleteCategoryName() {
    $('#deleteCategoryModal').find('span.CName').remove();
    $('#CName').remove();

}

function deleteCategory(categoryId, datatable) {
    $.ajax(
        {
            url: removeCategory,
            method: "POST",
            data: {body: categoryId, postId: '', _token: token}
        }).success(function (response) {
        datatable.ajax.reload(); //update datatable

    });
    $('#doCategoryDeletion').click(function () {


    });

}
function getCategories() {
    $('#categories').append('<option id=""> اختر من القائمة </option>');
    $.ajax(
        {
            url: url,
            method: "GET",
            data: {body: '', postId: '', _token: token}
        }).success(function (response) {
        
        $.each(response['data'], function (key, value) {
            $('#categories').append('<option id="' + value.id + '">' + value.category_name_ar + '</option>');
        });
    });
}
function saveService(content, datatable) {
    $.ajax(
        {
            url: saveServiceURL,
            method: "POST",
            data: {body: JSON.stringify(content), postId: '', _token: token}
        }).success(function (response) {
        datatable.ajax.reload(); //update datatable
    });

}

function fillDataTable() {
    var categoryDataTable = $('#categoriesTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: '',
                className: 'hidden'
            }],
        "oLanguage": {
            "sSearch": "" + search,
            "processing": "Processing...",
            "sLengthMenu": "_MENU_ " + numberOfRows,
            sInfo: "عرض _START_ الى _END_ من _TOTAL_ العناصر"

        },

        "ajax": url,
        "columns": [
            {
                mRender: function (data, type, row, full) {
                    return full['row'] + 1;

                }
            },
            {"data": "category_name_ar"},
            {"data": "category_name_en"},
            {
                "data": "enabled", render: function (data, type, full, meta) {
                
                var status = active;
                if (data != 'فعال') {
                    status = inActive;
                }

                return "<span>" + status + "</span>";
            }
            },
            {"data": "serviceNumber"},
            {
                "data": "buttons",
                render: function (row, type, full, meta) {
                    return "<div class='dropdown'> " +
                        "<button class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown' aria-haspopup=''true' aria-expanded='true'>" +
                        "" + options + "" +
                        "<span class='caret'></span>" +
                        "</button>" +
                        "<ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>" +
                        "<input type='hidden' id='categoryId' value='" + full['id'] + "'/><li><a id='deleteCategory' value='remove' class='deleteCategory'>" + removeCategoryLang + "</a></li>" +
                        "<li><a id='editCategoryButton' name='editCategoryButton'  value='edit' class='editCategoryButton' >" + editCategoryLang + "</a></li>" +
                        "<li><a id='showService' name='showService'  value='edit' class='showService' >" + showService + "</a></li>" +
                        "</ul>" +
                        "</div>";
                }
            }


        ],

        "initComplete": function (settings, json) {
            $rows = categoryDataTable.rows().every(function () {
                this.invalidate();
            });
        }


    });

    if (lang == 'ar') {
        $('.prev').children().children().removeClass('fa fa-angle-left');
    $('.prev').children().children().addClass('fa fa-angle-right');
    $('.next').children().children().removeClass('fa fa-angle-right');
    $('.next').children().children().addClass('fa fa-angle-left');
    }


    return categoryDataTable;
}
function editCategoryButtonAction(categoryDataTable) {

    $('#categoriesTable tbody ').on('click', '#editCategoryButton', function () {
        var categoryId = $(this).parent().siblings('#categoryId').val();
        $.ajax(
            {
                url: getSingleCategory,
                method: "POST",
                data: {body: categoryId, postId: '', _token: token}
            }).success(function (response) {
            //     $result = jQuery.parseJSON(response);
            $('#editedCategoryName_ar').val(response['category'].s_category_name_ar);
            $('#editedCategoryName_en').val(response['category'].s_category_name_en);
            if (response['category'].b_enabled == 1) {
                $('#editedCategoryStatus').val('فعال');
            } else {
                $('#editedCategoryStatus').val('غير فعال');
            }

        });
        $('#editCategoryDiv').modal('show');
        editedCategoryButtonAction(categoryId, categoryDataTable);
    });
}


$("#addNewCategory").validate({
    rules: {
        categoryName_ar: {
            required: true
        },
        categoryName_en: {
            required: true
        },
        categoryStatus: {
            required: true
        }
    },
    messages: {
        categoryName_ar: {
            required: "يجب ادخال اسم التصنيف (عربي)"

        },
        categoryName_en: {
            required: "يجب ادخال اسم التصنيف (انجليزي)"

        },
        categoryStatus: {
            required: "يجب ادخال حالة الخدمة"
        }

    },
    submitHandler: function (form) {
        form.submit();
        $('#submitButtonForCategory').attr('disable', 'disable');
    }
});
editCategoryValidation();
function addCategoryButtonAction(categoryDataTable) {
    $('#submitButtonForCategory').click(function () {
//            alert('Amr');
        if ($("#addNewCategory").valid() == true) {
            var data = [{
                'categoryName_ar': $('#categoryName_ar').val(),
                'categoryName_en': $('#categoryName_en').val(),
                'status': $('#categoryStatus').val()

            }

            ];
            saveCategory(data, addCategoryUrl);
            categoryDataTable.ajax.reload();
        }
    });
}

function editCategory(categoryId) {
    $('#editedCategoryButton').click(function () {
        $.ajax(
            {
                url: url,
                method: "POST",
                data: {body: content, postId: '', _token: token}
            }).success(function (response) {
        });
    });

}
function saveCategory(content, url) {
    $.ajax(
        {
            url: url,
            method: "POST",
            data: {body: content, postId: '', _token: token}
        }).success(function (response) {

        if (response.status != 200) {
            $("#addNewCategory").valid();
        }

        $('#addCategory').modal('hide');


    });
}
function editedCategoryButtonAction(categoryId, categoryDataTable) {
    $('#editedCategoryButton').click(function () {
        if ($('#editCategory').valid() == false)
            return 's';
        notification = $('#editedCategoryName_ar').val() + "تم تحديث المعلومات الخاصة بالتصنيف ";
        var content = [{
            'id': categoryId,
            'categoryName_ar': $('#editedCategoryName_ar').val(),
            'categoryName_en': $('#editedCategoryName_en').val(),
            'enabled': $('#editedCategoryStatus').val()
        }
        ];
        $.ajax(
            {
                url: editCategoryURL,
                method: "POST",
                data: {body: content, postId: '', _token: token}
            }).success(function (response) {
            $('#editCategoryDiv').modal('hide');
            initializeAlertContent(updated);
            $("#alert").fadeIn(1000).delay(5000).fadeOut(1000);

            categoryDataTable.ajax.reload(); //update datatable

        });
    });

}

function editCategoryValidation() {

    $("#editCategory").validate({
        rules: {
            editedCategoryName_ar: {
                required: true
            },
            editedCategoryName_en: {
                required: true
            },
            editedCategoryStatus: {
                required: true
            }
        },
        messages: {
            editedCategoryName_ar: {
                required: "يجب ادخال اسم التصنيف (عربي)"

            },
            editedCategoryName_en: {
                required: "يجب ادخال اسم التصنيف (انجليزي)"

            },
            editedCategoryStatus: {
                required: "يجب ادخال حالة الخدمة"
            }

        },
        submitHandler: function (form) {
            //  form.submit();
            $('#editedCategoryButton').attr('disable', 'disable');
        }
    });
}
function moveToServices(link) {
    window.location.href = link;
}
function showServices(link) {

    $('#categoriesTable tbody').on('click', '.showService', function () {
        $categoryId = $(this).parents().siblings('#categoryId').val();
        moveToServices(link + "?id=" + $categoryId);
    });

}

function initializeAlertContent(message) {

    $('#alert').children('strong').html('اشعار !');
    $('#alert').children('#alertContent').html(message);
}

function prepareDatatable() {
    $('#categoriesTable_length').attr('dir', 'ltr');
    $('#categoriesTable_wrapper').first('.row').css('font-size', '17px');
}
function resetSelect2(select) {
    select.empty();
    select.select2({
        data: select.data.slots
    });
}

function resetAddServiceModal() {
    $('#serviceName_ar').val(null);
    $('#serviceName_en').val(null);
    $('#description_ar').val(null);
    $('#description_en').val(null);
    $('#categories').val(null);
}

function changeServiceIcon() {
    $('body').on('change', '.serviceIcon', function () {
        $('.showServiceIcon').children('i').attr('class', '');
        $('.showServiceIcon').children('i').addClass($(this).val());
    })

}