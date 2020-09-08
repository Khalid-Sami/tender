$(document).ready(function () {

    $("#categories").select2({
        placeholder: "احتار التصنيفات",
        width: "auto"
    });
    getCategories(); // fill select2 of add service with categories
    var serviceDatatable = fillDataTable(); // fill dataTable with services by using AJAX
    actionOfEdit(serviceDatatable); //prepare editing actions which located in Service DataTable
    actionOfDelete(serviceDatatable); //prepare delete actions which located in Service DataTable
    addQuestion(serviceDatatable);
    prepareDatatable(); // change the tips of Service dataTable
    initiatingRadioButtonForAddService(); //its name descrips itself
    showQuestions();
    showServiceInfo();
    changeServiceIcon(); //detecting the change of icons of service


    $('#addNewServiceButton').click(function () {
        resetSelect2($('#editedCategories'));
        getCategories(); // fill select2 of add service with categories
    });
    $("#submit").click(function (event) {
        event.preventDefault();
        // alert('a');
        var formData = new FormData();
        var image = $('input[name="serviceImage"]')[0].files[0];
        formData.append('serviceImage', image);

        var imageTest = $('input[name="serviceImage"]')[0].files[0];
        if (imageTest == 'undefined') {
            return;
        }
        $('#submit').css('disabled', '');
        if ($('input[name="serviceImage"]')[0].files && $('input[name="serviceImage"]')[0].files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if ($("#addNewService").valid() == true) {
                    $('#submit').removeAttr('style');
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

                        }]
                        ;

                    saveService(data, serviceDatatable);
                    //    serviceDatatable.ajax.reload()
                    resetSelect2($("#categories")); //reset multi-selection for addService Modal

                    $('#basic').modal('hide');
                    resetAddServiceModal(); //reset AddService Modal
                }
            },

                reader.readAsDataURL($('input[name="serviceImage"]')[0].files[0]);
        }
     


    });

    detectingRadioChages(); //detecting all changes of radio buttons in this page

    $('.close').click(function () {
        //reset select2
        resetSelect2($('#editedCategories'));
    });
    $('.closeButton').click(function () {
        //reset select2
        resetSelect2($('#editedCategories'));
    });
    addCategoryButtonAction(serviceDatatable);
    showServices(service); //show category service after clicking

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
        status: {
            required: "يجب اختيار حالة الخدمة"
        },
        description_ar: {
            required: "يجب ادخال وصف للخدمة (عربي)"
        },
        description_en: {
            required: "يجب ادخال وصف للخدمة (انجليزي)"
        }

    },
    submitHandler: function (form) {
        form.submit();

    }
});

function deleteCategoryName() {
    $('#deleteCategoryModal').find('span.CName').remove();
    $('#CName').remove();

}

function deleteCategory(categoryId, serviceDatatable) {
    
    $.ajax(
        {
            url: deleteService,
            method: "GET",
            data: {body: categoryId, postId: '', _token: token}
        }).success(function (response) {
        deleteCategoryName();
        serviceDatatable.ajax.reload(); //update datatable
        $('#deleteCategoryModal').modal('hide');

    });

    //});

}
function getCategories() {
    $('#categories').append('<option id=""> اختر من القائمة </option>');
    $.ajax(
        {
            url: getCategory,
            method: "GET",
            data: {body: '', postId: '', _token: token}
        }).success(function (response) {


        $.each(response['data'], function (key, value) {
            $('#categories').append('<option id="' + value.id + '">' + value.category_name_ar + '</option>');

        });

    });
}

function getCategoriesForUpdate(serviceCategories) {
    
    var data = [];
    $.ajax(
        {
            url: getCategory,
            method: "GET",
            data: {body: '', postId: '', _token: token}
        }).success(function (response) {


        $.each(response['data'], function (key, value) {
          
            $('#categories').append('<option id="' + value.id + '">' + value.category_name_ar + '</option>');
            var flag = false;
            $.each(serviceCategories, function (key, categoryValue) {
            
                if (categoryValue.s_category_name_ar == value.category_name_ar) {
                    data.push(categoryValue.s_category_name_ar);
                    $("#editedCategories").append('<option id="' + value.id + '" value="' + value.category_name_ar + ' " selected="selected">' + value.category_name_ar + '</option>');
                    flag = true;
                }
            });
            if (flag == false) {
                $("#editedCategories").append('<option id="' + value.id + '" value="' + value.category_name_ar + '">' + value.category_name_ar + '</option>');
            }

        });
        $("#editedCategories").select2({
            placeholder: "احتار التصنيفات",
            width: "auto",
            tags: true

        });

    });
}
function saveService(content, serviceDatatable) {
    $.ajax(
        {
            url: saveServiceURL,
            method: "POST",
            data: {body: JSON.stringify(content), postId: '', _token: token}
        }).success(function (response) {
        serviceDatatable.ajax.reload(); //update datatable
    });

}

function fillDataTable() {

    $id = window.location.href.split('?')[1].split('=');
    var serviceTable = $('#services').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: '',
                className: 'hidden'
            }

        ],
        "oLanguage": {
            "sSearch": "" + search,
            "processing": "Processing...",
            "sEmptyTable": "" + noService,
            "sLengthMenu": "_MENU_ " + numberOfRows

        },
        "ajax": url + '?id=' + $id[1],
        "columns": [
            {
                mRender: function (data, type, row, full) {
                    return full['row'] + 1;

                }
            },
            {"data": "service_name_ar"},
            {"data": "service_name_en"},
            {
                "data": "enabled", render: function (data, type, full, meta) {
                
                var status = active;
                if (data != 1) {
                    status = inActive;
                }

                return "<span >" + status + "</span>";
            }
            },

            {
                "data": "is_instant", render: function (data, type, full, meta) {
                
                var status = urgent;
                if (data != 1) {
                    status = nonUrgent;
                }

                return "<span>" + status + "</span>";
            }
            },

            {
                "data": "buttons",
                render: function (data, type, full, meta) {

                    return "<div class='dropdown'> " +
                        "<button class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown' aria-haspopup=''true' aria-expanded='true'>" +
                        "" + options + "" +
                        "<span class='caret'></span>" +
                        "</button>" +
                        "<ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>" +
                        "<input type='hidden' id='serviceId' value='" + full['id'] + "'/><li><a id='deleteCategory' value='remove' class='deleteCategory'>" + removeService + "</a></li>" +
                        "<li><a id='editCategoryButton' name='editCategoryButton'  value='edit' class='editCategoryButton' >" + editService + "</a></li>" +
                        "<li><a id='showQuestions' name='showQuestions'  value='edit' class='showQuestions' >" + showQuestion_lang + "</a></li>" +
                        "<li><a id='showServiceInfo' name='showServiceInfo'  value='edit' class='showServiceInfo' >" + showServiceInfo_lang + "</a></li>" +
                        "" +
                        "</ul>" +
                        "</div>";
                }
            }


        ],

        "initComplete": function (settings, json) {
            $rows = serviceTable.rows().every(function () {
                this.invalidate();
            });
        }


    });
    $('#services')
        .on('error.dt', function (e, settings, techNote, message) {
        })
        .DataTable();
    return serviceTable;
}
function editCategoryButtonAction(serviceTable, serviceId) {


    $.ajax(
        {
            url: getSingleService,
            method: "GET",
            data: {body: serviceId, postId: '', _token: token}
        }).success(function (response) {
        $('#editedServiceName_ar').val(response['service'].s_service_name_ar);
        $('#editedServiceName_en').val(response['service'].s_service_name_en);
        $('#editedDescription_ar').val(response['service'].s_description_ar);
        $('#editedDescription_en').val(response['service'].s_description_en);
        $('.editedStatus').val(response['service'].b_enabled);
        $('.editedStatus').select2();
        $('.editedEmergency').val(response['service'].b_is_instant);
        $('.editedEmergency').select2();
        $('.editedServiceIcon').val(response['service'].s_icon);
        $('.editedServiceIcon').select2();
        // add the given image

        if( response['service'].s_pic == null){
            $('.editedServiceImage').attr('src', 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image');
        }else{
            $('.editedServiceImage').attr('src', response['service'].s_pic);
            $('.toBeRemoved').removeClass('fileinput-new').addClass('fileinput-exists');
        }


        getCategoriesForUpdate(response['serviceCategories']);
    });

    $('#editService').modal('show');

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
addQuestionValidation();
function addCategoryButtonAction(categoryDataTable) {
    $('#submitButtonForCategory').click(function () {

        if ($("#addNewCategory").valid() == true) {
            var data = [{
                'categoryName_ar': $('#categoryName_ar').val(),
                'categoryName_en': $('#categoryName_en').val(),
                'status': $('#categoryStatus').val()

            }

            ];
            saveCategory(data, addCategoryUrl);
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
function editedCategoryButtonAction(categoryId, serviceTable) {
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
            initializeAlertContent('تم تحديث بيانات الصنف ' + $('#editedCategoryName_ar').val() + ' بنجاح ');
            $("#alert").fadeIn(1000).delay(5000).fadeOut(1000);

            serviceTable.ajax.reload(); //update datatable

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
            $('#editedCategoryButton').attr('disable', 'disable');
        }
    });
}
function moveToServices(link) {
    window.location.href = link;
}
function showServices(link) {

    $('#services tbody').on('click', '.showService', function () {
        $categoryId = $(this).parents('tr').children('.sorting_1').html();
        moveToServices(link + "?id=" + $categoryId);
    });

}

function updateServiceInfo(id, serviceTable, select2) {
    $('#editedSubmit').click(function () {

        var data = [{
            'id': id,
            'serviceName_ar': $('#editedServiceName_ar').val(),
            'serviceName_en': $('#editedServiceName_en').val(),
            'description_ar': $('#editedDescription_ar').val(),
            'description_en': $('#editedDescription_en').val(),
            'categories': $('#editedCategories').val(),
            'status': $('.editedStatus').val(),
            'emergency': $('.editedEmergency').val(),
            'serviceIcon': $('.editedServiceIcon').val(),
            'serviceImage': $('input[name="editedServiceImage"]')[0].files[0] == undefined ? 'null' : $('input[name="editedServiceImage"]')[0].files[0].result
        }];
        $.ajax(
            {
                url: updateService,
                method: "POST",
                data: {body: JSON.stringify(data), postId: '', _token: token}
            }).success(function (response) {
            if (response['status'] != 200)
                return 'Error';
            $('#editService').modal('hide');

            initializeAlertContent('  تم تحديث بيانات الخدمة  ' + $('#editedServiceName_ar').val() + ' بنجاح ');
            $("#alert").fadeIn(1000).delay(5000).fadeOut(1000);
            resetSelect2(select2);
            serviceTable.ajax.reload(); //update datatable

        });
    });

}
function initializeAlertContent(message) {

    $('#alert').children('strong').html('اشعار !');
    $('#alert').children('#alertContent').html(message);
}

function prepareDatatable() {
    $('#services_length').attr('dir', 'ltr');
    $('#services_wrapper').first('.row').css('font-size', '17px');
}

function resetSelect2(select) {
    select.empty();
    select.select2({
        data: select.data.slots
    });
}

function actionOfDelete(serviceDatatable) {
    $('body').on('click', '.deleteCategory', function () {
        var categoryId = $(this).parents().siblings('#serviceId').val();

        var categoryName = $(this).parents('tr').children('.sorting_1').next().html();

        swal({
                title: deletionMessageForService,
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
                deleteCategory(categoryId, serviceDatatable);
                setTimeout(function () {
                    swal(deletionMessage);
                }, 2000);
            });
    });
}

function actionOfEdit(serviceDatatable) {
    $('#services tbody').on('click', '.editCategoryButton', function () {
        var this1 = $(this);
        $id = $(this).parents().siblings('#serviceId').val();
        var tr = $(this).parents('tr');
        editCategoryButtonAction(serviceDatatable, $id);
        updateServiceInfo($id, serviceDatatable, $("#editedCategories"));
    });
}

function initiatingRadioButtonForAddService() {
    if ($('input[name="status"]').is(':checked') == false) {

        $('input[name="status"]:radio[value="yes"]').prop('checked', true);
        $('input[name="status"]:radio[value="yes"]').parent('span').addClass('checked');
    }
    if ($('input[name="emergency"]').is(':checked') == false) {
        $('input[name="emergency"]:radio[value="yes"]').prop('checked', true);
        $('input[name="emergency"]:radio[value="yes"]').parent('span').addClass('checked');
    }
    if ($('input[name="questionStatus"]').is(':checked') == false) {
        $('input[name="questionStatus"]:radio[value="1"]').prop('checked', true);
        $('input[name="questionStatus"]:radio[value="1"]').parent('span').addClass('checked');
    }
}

function resetAddServiceModal() {
    $('#serviceName_ar').val(null);
    $('#serviceName_en').val(null);
    $('#description_ar').val(null);
    $('#description_en').val(null);
    $('#categories').val(null);
}

function detectingRadioChages() {
    $('input[name="editedEmergency"]:radio').change(function () {

        if ($(this).val() == 'no') {
            $('input[name="editedEmergency"]:radio[value="no"]').attr('checked', true);
            $('input[name="editedEmergency"]:radio[value="yes"]').attr('checked', false);


        } else if ($(this).val() == 'yes') {
            $('input[name="editedEmergency"]:radio[value="yes"]').attr('checked', true);
            $('input[name="editedEmergency"]:radio[value="no"]').attr('checked', false);
        }
    });
    $('input[name="editedStatus"]:radio').change(function () {

        if ($(this).val() == 'no') {
            $('input[name="editedStatus"]:radio[value="no"]').attr('checked', true);
            $('input[name="editedStatus"]:radio[value="yes"]').attr('checked', false);


        } else if ($(this).val() == 'yes') {
            $('input[name="editedStatus"]:radio[value="yes"]').attr('checked', true);
            $('input[name="editedStatus"]:radio[value="no"]').attr('checked', false);
        }
    });
    $('input[name="status"]:radio').change(function () {

        if ($(this).val() == 'no') {
            $('input[name="status"]:radio[value="no"]').attr('checked', true);
            $('input[name="status"]:radio[value="yes"]').attr('checked', false);


        } else if ($(this).val() == 'yes') {
            $('input[name="status"]:radio[value="yes"]').attr('checked', true);
            $('input[name="status"]:radio[value="no"]').attr('checked', false);
        }
    });
    $('input[name="emergency"]:radio').change(function () {

        if ($(this).val() == 'no') {
            $('input[name="emergency"]:radio[value="no"]').attr('checked', true);
            $('input[name="emergency"]:radio[value="yes"]').attr('checked', false);


        } else if ($(this).val() == 'yes') {
            $('input[name="emergency"]:radio[value="yes"]').attr('checked', true);
            $('input[name="emergency"]:radio[value="no"]').attr('checked', false);
        }
    });
    $('input[name="questionStatus"]:radio').change(function () {

        if ($(this).val() == '0') {
            $('input[name="questionStatus"]:radio[value="0"]').attr('checked', true);
            $('input[name="questionStatus"]:radio[value="1"]').attr('checked', false);


        } else if ($(this).val() == '1') {
            $('input[name="questionStatus"]:radio[value="1"]').attr('checked', true);
            $('input[name="questionStatus"]:radio[value="0"]').attr('checked', false);
        }

    });
}
function addQuestion(serviceDatatable) {
    $('#services tbody').on('click', '.addQuestion', function () {
        var this1 = $(this);
        var id = $(this).parents().siblings('#serviceId').val();
        moveToServices(questions + '?id=' + id);

    });
}

function addQuestionValidation() {

    $("#addQuestionsForm").validate({
        rules: {
            question_ar: {
                required: true
            },
            question_en: {
                required: true
            },
            questionType: {
                required: true
            },
            answerType: {
                required: true
            },
            questionStatus: {
                required: true

            }
        },
        messages: {
            question_ar: {
                required: "يجب ادخال نص السؤال"

            },
            question_en: {
                required: "يجب ادخال نص السؤال (انجليزي)"

            },
            questionType: {
                required: "يجب ادخال نوع السؤال"
            },
            answerType: {
                required: "يجب ادخال نوع الاجابة"
            },
            questionStatus: {
                required: "يجب ادخال حالة السؤال"
            }

        },
        submitHandler: function (form) {
            $('#submitForQuestion').attr('disable', 'disable');
        }
    });
}
function saveQuestion(id) {
    $('#submitForQuestion').click(function () {
        if ($("#addQuestionsForm").valid() == false)
            return 'Validation is incomplete';
        var data = [{
            'question_ar': $('#question_ar').val(),
            'question_en': $('#question_en').val(),
            'questionType': $('#questionType').val(),
            'answerType': $('#answerType').val(),
            'questionStatus': $('input[name="questionStatus"]:checked').val(),
            'serviceId': id
        }];

        swal({
                title:sure,
                text: "",
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
                ajaxSaveQuestion(data); //  make saving operation on server side
                setTimeout(function () {
                    swal(added);
                    resetQuestionModel(); //reset question Model
                }, 2000);
            });


    });
}

function ajaxSaveQuestion(data) {
    $.ajax(
        {
            url: saveQuestionUrl,
            method: "POST",
            data: {body: JSON.stringify(data), postId: '', _token: token}
        }).success(function (response) {
    });
}
function resetQuestionModel() {
    $('#question_ar').val(null);
    $('#question_en').val(null);
    $('#questionType').val('0');
    $('#answerType').val('1');
    $('input[name="questionStatus"]:checked').val('1');
    $('#addQuestionModal').modal('hide');
}

function showQuestions() {
    $('#services tbody').on('click', '.showQuestions', function () {
        var this1 = $(this);
        var id = $(this).parents().siblings('#serviceId').val();
        moveToServices(questions+'?qId=' + id+'&cId='+categoryId);
    });
}

function showServiceInfo() {
    $('#services tbody').on('click', '.showServiceInfo', function () {
        var id = $(this).parents().siblings('#serviceId').val();
        moveToServices(serviceInfo + "?id=" + id+'&cId='+categoryId);
    });
}

function changeServiceIcon() {
    $('body').on('change', '.serviceIcon', function () {
        $('.showServiceIcon').children('i').attr('class', '');
        $('.showServiceIcon').children('i').addClass($(this).val());
    });
    $('body').on('change', '.editedServiceIcon', function () {
        $('.showServiceIcon').children('i').attr('class', '');
        $('.showServiceIcon').children('i').addClass($(this).val());
    });

}