var UIFormSubmit = (function () {
    var handleForms = function () {
        $(document).on("submit", ".send-ajax , .ajax-send", function (event) {
            event.preventDefault();
            var form = $(this),
                action = form.attr("action"),
                method = form.attr("method"),
                formData = form.serialize(),
                fadeOut = typeof form.data("fade") !== "undefined" && form.data("fade") !== "" ? form.data("fade") : 0,
                func_after_done = typeof form.data("after-done") !== "undefined" && form.data("after-done") !== "" ? form.data("after-done") : "",
                with_file = typeof form.data("with-file") !== "undefined" && form.data("with-file") !== "" ? form.data("with-file") : "",
                form_reset = form.data("reset"),
                loader = "animated infinite fadeOut disabled",
                d_param = 0;
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.addClass(loader);
            if (with_file === "yes") {
                formData = new FormData($(this)[0]);
                $.ajaxSetup({ contentType: !1, cache: !1, processData: !1 });
            }
            $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") } });
            $.ajax({
                url: action,
                type: method,
                data: formData,
                dataType: "json",
                success: function (r) {
                    if (r.result || r.result === "1") {
                        swal({ text: r.msg, icon: "success" });
                        if (form_reset === "yes") {
                            form.find("input[type=text], textarea , input[type=password] , input[type=email]").val("");
                            form[0].reset();
                        }
                        if (r.param) {
                            d_param = r.param;
                        }
                        if (func_after_done !== "" && typeof window[func_after_done] === "function") {
                            if (d_param !== 0) window[func_after_done](d_param);
                            else window[func_after_done]();
                        }
                    } else {
                        swal({ text: r.msg, icon: "warning" });
                    }
                    submitBtn.removeClass(loader);
                    if (fadeOut > 0) {
                    }
                },
                error: function (e) {
                    var json = e.responseJSON;
                    $text = "";
                    $.each(json.errors, function (key, value) {
                        $.each(value, function (inKey, inValue) {
                            $text = inValue;
                        });
                    });
                    $text === "" ? swal({ title: "بروز خطا", text: "خطای شبکه رخ داده ، لطفا دوباره تلاش کنید", icon: "error" }) : swal({ title: "بروز خطا", text: $text, icon: "error" });
                    submitBtn.removeClass(loader);
                },
            });
        });
    };
    return {
        init: function () {
            handleForms();
        },
    };
})();
jQuery(document).ready(function () {
    UIFormSubmit.init();
});
