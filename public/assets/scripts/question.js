$(document).ready(function () {
    $('#collapseHid').collapse({
        toggle: true
    });
    var questionDataTable = fillDataTable(); //fill question datatable
    addNewQuestion(questionDataTable); // for adding new Question
    deleteQuestion(questionDataTable);// for deleting the existed Question
    editQuestion(questionDataTable);// for editing the existed Question
    detectingRadioChages(); //tracking radio buttons for page
    initiatingRadioButton();
    addQuestionValidation();
    addQuestionFields();
});

function fillDataTable() {

    $id = window.location.href.split('?')[1].split('=');
    var questionDatatable = $('#questions').DataTable({
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
            "ajax": fillQuestionsInDataTable + '?id=' + $id[1],
            "columns": [
                {
                    mRender: function (data, type, row, full) {
                        return full['row'] + 1;

                    }
                },
                {"data": "s_question_ar"},
                {"data": "s_question_en"},
                {
                    "data": "i_question_type",
                    render: function (data, type, full, meta) {
                        var type = 'غير معروف';
                        switch (data) {
                            case 1:
                                type = 'عام';
                                break;
                            case 2:
                                type = 'لتصنيف'
                                break;
                            case 3:
                                type = 'للاستعلام'
                                break;
                        }
                        return type;
                    }
                },
                {
                    "data": "i_answer_type",
                    render: function (data, type, full, meta) {
                        var type = 'خيارات متعددة';
                        switch (data) {
                            case 2:
                                type = 'خيار أحادي';
                                break;
                            case 3:
                                type = 'قائمة';
                                break;
                            case 4:
                                type = 'نص';
                                break;
                        }
                        return type;
                    }
                },
                {
                    "data": "b_enabled", render: function (data, type, full, meta) {
                    var status = active;
                    if (data != 1) {
                        status = inActive;
                    }

                    return "<span>" + status + "</span>";
                }
                },
                {
                    mRender: function (data, type, row, full) {
                        return "<div class='dropdown'> " +
                            "<button class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>" +
                            "" + options + "" +
                            "<span class='caret'></span>" +
                            "</button>" +
                            "<ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>" +
                            "<input type='hidden' id='questionId' value='" + row['pk_i_id'] + "'/>" +
                            "<li><a id='deleteQuestion' value='remove' class='deleteQuestion'>"+delete_question+"</a></li>" +
                            "<li><a id='editQuestion' name='editQuestion'  value='edit' class='editQuestion' >"+edit_question+"</a></li>" +
                            "<li><a id='addAnswers' name='addAnswers'  style='" + (row['i_answer_type'] == "4" ? "display:none" : "" ) + "' value='edit' class='addAnswers'>"+add_answer+"</a></li>" +
                            "" +
                            "</ul>" +
                            "</div>";

                    }
                }


            ],

            "initComplete": function (settings, json) {
                $rows = questionDatatable.rows().every(function () {
                    this.invalidate();
                });
            }
    //         if(lang == "ar"){
    //     $('.prev').children().children().removeClass('fa fa-angle-left');
    //     $('.prev').children().children().addClass('fa fa-angle-right');
    //     $('.next').children().children().removeClass('fa fa-angle-right');
    //     $('.next').children().children().addClass('fa fa-angle-left');
    // }else{
    //
    // }

});
    return questionDatatable;
}

function deleteQuestion(questionDataTable) {
    $('#questions tbody').on('click', '.deleteQuestion', function () {
        var this1 = $(this);
        var id = $(this).parents().siblings('#questionId').val();
        var questionContent = $(this).parents('tr').children('.sorting_1').next().html();

        swal({
                title: sure,
                text: "" + questionContent,
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
                ajaxDeletingQuestion(id, questionDataTable);

                setTimeout(function () {
                    swal(deletionMessage);
                }, 2000);
            });
    });

}

function ajaxDeletingQuestion(id, questionDataTable) {
    alert(id);
    $.ajax(
        {
            url: deleteQuestionUrl,
            method: "POST",
            data: {body: id, postId: '', _token: token}
        }).success(function (response) {
        questionDataTable.ajax.reload();
    });

}
function editQuestion(questionDataTable) {

    $('#questions tbody').on('click', '.editQuestion', function () {
        $('#editQuestionModal').modal('show');
        var id = $(this).parents().siblings('#questionId').val();
        var question_ar = $('#editedQuestion_ar');
        var question_en = $('#editedQuestion_en');
        var questionType = $('#editedQuestionType');
        var answerType = $('#editedAnswerType');
        var questionStatus = $('#editedQuestionStatus');
        getQuestionDetails(id, question_ar, question_en, questionType, answerType, questionStatus);
        updateQuestions(id, questionDataTable);
    });
}

function getQuestionDetails(id, question_ar, question_en, questionType, answerType, questionStatus) {
    $.ajax(
        {
            url: getQuestionUrl,
            method: "POST",
            data: {body: id, postId: '', _token: token}
        }).success(function (response) {
        var question = response['message'];
        question_ar.val(question.s_question_ar);
        question_en.val(question.s_question_en);
        questionType.val(question.i_question_type);
        answerType.val(question.i_answer_type);
        if (question.b_enabled == 1) {
            $('input[name="editedQuestionStatus"]:radio[value="1"]').prop('checked', true);
            $('input[name="editedQuestionStatus"]:radio[value="0"]').prop('checked', false);
            $('input[name="editedQuestionStatus"]:radio[value="1"]').parent('span').addClass('checked');
            $('input[name="editedQuestionStatus"]:radio[value="0"]').parent('span').removeAttr('class');
        } else {
            $('input[name="editedQuestionStatus"]:radio[value="1"]').parent('span').removeAttr('class');
            $('input[name="editedQuestionStatus"]:radio[value="1"]').prop('checked', false);
            $('input[name="editedQuestionStatus"]:radio[value="0"]').prop('checked', true);
            $('input[name="editedQuestionStatus"]:radio[value="0"]').parent('span').addClass('checked');
        }
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

    $("#editQuestionsForm").validate({
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
function saveQuestion(id, questionDataTable) {
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
                title: sure,
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
            function (isConfirm) {
                if (isConfirm) {
                    ajaxSaveQuestion(data, questionDataTable); //  make saving operation on server side
                    swal(added);
                    resetQuestionModel(); //reset question Model

                } else {

                    resetQuestionModel(); //reset question Model


                }

            });


    });
}

function ajaxSaveQuestion(data, questionDataTable) {
    $.ajax(
        {
            url: saveQuestionUrl,
            method: "POST",
            data: {body: JSON.stringify(data), postId: '', _token: token}
        }).success(function (response) {
        questionDataTable.ajax.reload();
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
function resetEditingQuestionModel() {
    $('#editedQuestion_ar').val(null);
    $('#editedQuestion_en').val(null);
    $('#editedQuestionType').val('0');
    $('#editedAnswerType').val('1');
    $('input[name="editedQuestionStatus"]:checked').val('1');
    $('#editQuestionModal').modal('hide');
}
function updateQuestions(id, questionDataTable) {
    $('#editedSubmitForQuestion').click(function () {
        var data = [{
            'question_ar': $('#editedQuestion_ar').val(),
            'question_en': $('#editedQuestion_en').val(),
            'questionType': $('#editedQuestionType').val(),
            'answerType': $('#editedAnswerType').val(),
            'questionStatus': $('input[name="editedQuestionStatus"]:checked').val(),
            'questionId': id
        }];

        swal({
                title: sure,
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
            function (isConfirm) {
                if (isConfirm) {
                    ajaxUpdateQuestion(data, questionDataTable);
                    resetEditingQuestionModel(); //reset question Model
                } else {
                    resetEditingQuestionModel(); //reset question Model

                }
            });


    });
}
function ajaxUpdateQuestion(data, questionDataTable) {

    $.ajax(
        {
            url: updateQuestion,
            method: "POST",
            data: {body: JSON.stringify(data), postId: '', _token: token}
        }).success(function (response) {
        questionDataTable.ajax.reload();
    });


}
function detectingRadioChages() {
    $('input[name="questionStatus"]:radio').change(function () {
        if ($(this).val() == '0') {
            $('input[name="questionStatus"]:radio[value="0"]').attr('checked', true);
            $('input[name="questionStatus"]:radio[value="1"]').attr('checked', false);

        } else if ($(this).val() == '1') {
            $('input[name="questionStatus"]:radio[value="1"]').attr('checked', true);
            $('input[name="questionStatus"]:radio[value="0"]').attr('checked', false);
        }
    });

    $('input[name="editedQuestionStatus"]:radio').change(function () {


        if ($(this).val() == '0') {
            $('input[name="editedQuestionStatus"]:radio[value="0"]').attr('checked', true);
            $('input[name="editedQuestionStatus"]:radio[value="1"]').attr('checked', false);


        } else if ($(this).val() == '1') {
            $('input[name="editedQuestionStatus"]:radio[value="1"]').attr('checked', true);
            $('input[name="editedQuestionStatus"]:radio[value="0"]').attr('checked', false);
        }
    });
}
function initiatingRadioButton() {
    if ($('input[name="questionStatus"]').is(':checked') == false) {
        $('input[name="questionStatus"]:radio[value="1"]').prop('checked', true);
        $('input[name="questionStatus"]:radio[value="1"]').parent('span').addClass('checked');
    }
    if ($('input[name="editedQuestionStatus"]').is(':checked') == false) {
        $('input[name="editedQuestionStatus"]:radio[value="1"]').prop('checked', true);
        $('input[name="editedQuestionStatus"]:radio[value="1"]').parent('span').addClass('checked');
    }
    if ($('input[name="answerStatus"]').is(':checked') == false) {
        $('input[name="answerStatus"]:radio[value="1"]').prop('checked', true);
        $('input[name="answerStatus"]:radio[value="1"]').parent('span').addClass('checked');
    }
}

function addNewQuestion(questionDataTable) {
    $('#addNewQuestionButton').click(function () {
        var id = window.location.href.split('?')[1].split('=')[1];
        $('#addQuestionModal').modal('show');
        saveQuestion(id, questionDataTable);

    })
}
function addQuestionFields() {
    $('#questions tbody').on('click', '.addAnswers', function () {
        $('#addAnswersModel').modal('show');
        var id = $(this).parents().siblings('#questionId').val();
        addAnswerToQuestion(id);
    });
}

function addAnswerToQuestion(id) {
    $('#addAnswerSubmitButton').click(function () {
        var data = [{
            'option_ar': $('#option_ar').val(),
            'option_en': $('#option_ar').val(),
            'answerDescription_ar': $('#answerDescription_ar').val(),
            'answerDescription_en': $('#answerDescription_en').val(),
            'answerStatus': $('input[name="answerStatus"]:checked').val(),
            'questionId': id
        }];
        ajaxAddAnswer(data);
    });
}

function ajaxAddAnswer(data) {
    alert('ds');
    $('#addAnswerSubmitButton').attr('disabled', 'disabled');
    $.ajax(
        {
            url: addOption,
            method: "POST",
            data: {body: JSON.stringify(data), postId: '', _token: token}
        }).success(function (response) {
        resetAddOptionModal();

    });


}
function resetAddOptionModal() {
    $('#option_ar').val(null);
    $('#option_ar').val(null);
    $('#answerDescription_ar').val('0');
    $('#answerDescription_en').val('1');
    $('input[name="answerStatus"]:checked').val('1');
    $('#addAnswersModel').modal('hide');
    $('#addAnswerSubmitButton').removeAttr('disabled');
}

