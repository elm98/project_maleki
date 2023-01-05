var UIFormSubmit = (function () {
    var handleForms = function () {
        $(document).on("submit", ".send-ajax, .ajax-send", function (event) {
            event.preventDefault();
            var form = $(this),
                action = form.attr("action"),
                method = form.attr("method"),
                formData = form.serialize(),
                func_after_done = typeof form.data("after-done") !== "undefined" && form.data("after-done") !== "" ? form.data("after-done") : "",
                with_file = typeof form.data("with-file") !== "undefined" && form.data("with-file") !== "" ? form.data("with-file") : "",
                form_reset = form.data("reset"),
                loader = "<i class='fa fa-spinner fa-spin bi bi-arrow-counterclockwise spin'></i>",
                d_param = 0;
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.append(loader);
            submitBtn.attr('disabled',true);
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
                        helper().toast({ text: r.msg, type: "success" });
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
                        helper().toast({ text: r.msg, type: "warning" });
                    }
                    submitBtn.find('i.fa-spin').remove();
                    submitBtn.attr('disabled',false);
                },
                error: function (e) {
                    var json = e.responseJSON;
                    $text = "";
                    $.each(json.errors, function (key, value) {
                        $.each(value, function (inKey, inValue) {
                            $text = inValue;
                        });
                    });
                    $text === "" ? helper().toast({ title: "بروز خطا", text: "خطای شبکه رخ داده ، لطفا دوباره تلاش کنید", type: "error" }) : helper().toast({ title: "بروز خطا", text: $text, type: "error",position:'bottomRight' });
                    console.log($text);
                    submitBtn.find('i.fa-spin').remove();
                    submitBtn.attr('disabled',false);
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
