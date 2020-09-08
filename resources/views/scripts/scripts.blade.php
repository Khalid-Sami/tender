<script>
$('#SubscribePlanForm').validate({
    rules: {
        subscription_package_en: "required",
        subscription_package_ar: "required",
        users_count: {
            required: true,
            digits: true
        },
        services_count: {
            required: true,
            digits: true
        },
        request_count: {
            required: true,
            digits: true
        },
        sms_notification: {
            required: true,
            digits: true
        },
        email_notification: {
            required: true,
            digits: true
        }, percentage: {
            required: true,
            digits: true
        }, price: {
            required: true,
            digits: true
        }, duration: {
            required: true,
            digits: true
        }, listed: {
            required: true
        }, status: {
            required: true
        }
    },
    errorPlacement: function (error, element) {
        var name = $(element).attr("name");
        error.appendTo($("#" + name + "_validate"));
    },
    messages: {
@if(app()->getLocale() =='ar')
    subscription_package_en: "خطة الاشتراك (English)",
        subscription_package_ar: "خطة الاشتراك",
    users_count: {
    required: "عدد المستخدمين حقل مطلوب",
        digits: "عدد المستخدمين يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
services_count: {
    required: "عدد الخدمات حقل مطلوب",
        digits: "عدد الخدمات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
request_count: {
    required: "عدد الطلبات حقل مطلوب",
        digits: "عدد الطلبات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, sms_notification: {
    required: "عدد الرسائل حقل مطلوب",
        digits: "عدد الرسائل يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, email_notification: {
    required: "عدد الايميلات حقل مطلوب",
        digits: "عدد الايميلات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
percentage: {
    required: "النسبة المئوية للعقد حقل مطلوب",
        digits: "النسبة المئوية للعقد يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, price: {
    required: "السعر  حقل مطلوب",
        digits: "السعر يجب ان يحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, duration: {
    required: "المدة حقل مطلوب",
        digits: "المدة يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, status:{
    required: "الحالة حقل مطلوب"
}, listed: {
    required: "عرض في الصفحات حقل مطلوب"
},
@else
subscription_package_en: "subscription package  field is required",
    subscription_package_ar: "subscription package (Arabic) field is required",
    users_count: {
    required: "users count  field is required",
        digits: "users count must contains number only and must greater or equal than 0"
},
services_count: {
    required: "services count field is required",
        digits: "services count must contains number only and must greater or equal than 0"
}, request_count: {
    required: "request count field is required",
        digits: "request count must contains number only and must greater or equal than 0"
}, sms_notification: {
    required: "sms_notification field is required",
        digits: "sms notification  must contains number only and must greater  or equal than 0"
}, email_notification: {
    required: "email notification field is required",
        digits: "email notification must contains number only and must greater or equal than 0"
},
percentage: {
    required: "percentage field is required",
        digits: " percentage must contains number only and must greater than or equal 0"
}, price: {
    required: "price field is required",
        digits: "price  must contains number only and must greater than or equal 0"
}, duration: {
    required: "duration field is required",
        digits: "duration must contains number only and must greater than or equal 0"
}, status: {
    required: "status field is required"
}, listed: {
    required: "listed field is required"
},
@endif
}, submitHandler: function (form) {
    form.submit();
}
});
$('#editSubscribePlanForm').validate({
    rules: {
        subscription_package_en: "required",
        subscription_package_ar: "required",
        users_count: {
            required: true,
            digits: true
        },
        services_count: {
            required: true,
            digits: true
        },
        request_count: {
            required: true,
            digits: true
        },
        sms_notification: {
            required: true,
            digits: true
        },
        email_notification: {
            required: true,
            digits: true
        }, percentage: {
            required: true,
            digits: true
        }, price: {
            required: true,
            digits: true
        }, duration: {
            required: true,
            digits: true
        }, listed: {
            required: true
        }, status: {
            required: true
        }
    },
    errorPlacement: function (error, element) {
        var name = $(element).attr("name");
        error.appendTo($("#" + name + "_validate"));
    },
    messages: {
@if(app()->getLocale() =='ar')
    subscription_package_en: "خطة الاشتراك (English)",
        subscription_package_ar: "خطة الاشتراك",
    users_count: {
    required: "عدد المستخدمين حقل مطلوب",
        digits: "عدد المستخدمين يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
services_count: {
    required: "عدد الخدمات حقل مطلوب",
        digits: "عدد الخدمات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
request_count: {
    required: "عدد الطلبات حقل مطلوب",
        digits: "عدد الطلبات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, sms_notification: {
    required: "عدد الرسائل حقل مطلوب",
        digits: "عدد الرسائل يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, email_notification: {
    required: "عدد الايميلات حقل مطلوب",
        digits: "عدد الايميلات يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
},
percentage: {
    required: "النسبة المئوية للعقد حقل مطلوب",
        digits: "النسبة المئوية للعقد يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, price: {
    required: "السعر  حقل مطلوب",
        digits: "السعر يجب ان يحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, duration: {
    required: "المدة حقل مطلوب",
        digits: "المدة يجب ان تحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي صفر"
}, status:{
    required: "الحالة حقل مطلوب"
}, listed: {
    required: "عرض في الصفحات حقل مطلوب"
},
@else
subscription_package_en: "subscription package  field is required",
    subscription_package_ar: "subscription package (Arabic) field is required",
    users_count: {
    required: "users count  field is required",
        digits: "users count must contains number only and must greater or equal than 0"
},
services_count: {
    required: "services count field is required",
        digits: "services count must contains number only and must greater or equal than 0"
}, request_count: {
    required: "request count field is required",
        digits: "request count must contains number only and must greater or equal than 0"
}, sms_notification: {
    required: "sms_notification field is required",
        digits: "sms notification  must contains number only and must greater  or equal than 0"
}, email_notification: {
    required: "email notification field is required",
        digits: "email notification must contains number only and must greater or equal than 0"
},
percentage: {
    required: "percentage field is required",
        digits: " percentage must contains number only and must greater than or equal 0"
}, price: {
    required: "price field is required",
        digits: "price  must contains number only and must greater than or equal 0"
}, duration: {
    required: "duration field is required",
        digits: "duration must contains number only and must greater than or equal 0"
}, status: {
    required: "status field is required"
}, listed: {
    required: "listed field is required"
},
@endif
}, submitHandler: function (form) {
    form.submit();
}
});
</script>
