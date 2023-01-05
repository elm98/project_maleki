var UIDeleteRows = function () {
    var handleDelete = function () {
        $(document).on("click", ".rows-delete",function () {
			var $btn = $(this),
                action = $btn.data('action');
            $btn.addClass('m-loader');
			var $dataDeleteList = [];
			var $listDeleteItem=$('input[type=checkbox].dt-row-checkbox:checked');
			if($listDeleteItem.length < 1){
				swal({
					title:'شما هیچ گزینه ای انتخاب نکردید',
					text:'حد اقل یک گزینه برای حذف انتخاب کنید',
					icon:'warning'
				});
				return 0;
			}
			$listDeleteItem.each(function(){
				if($(this).prop('checked'))
				{
					$dataDeleteList.push($(this).val());
				}
			}),
			swal({
                title: "آیا مطمن هستید ؟",
				text: "این عملیات غیر قابل بازگشت است",
				icon: 'warning',
				dangerMode: true,
				buttons: {
				  cancel: 'نه منصرف شدم',
				  delete: 'بله ، مطمنم'
				}
            }).then(function(e) {
                if(e){
					delete_rows_datatable()
				}
			});
			function delete_rows_datatable(foo){
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $csrf_token}
				});
				$.ajax({
					url: action,
					type: 'POST',
					data: {foo:foo},
					dataType: "json",
					success: function(r) {
						if(r.result){
							$list.closest('tr').remove();
							swal({
								text:r.msg,
								icon:'success'
							});
						}
						else{
							swal({
								title:r.msg,
								icon:'warning'
							});
						}
					},
					error: function (e){
						swal({
								title:'خطای شبکه ',
								text:'لطفا دوباره تلاش کنید',
								icon:'error'
							});
					/*$('html, body').animate({
						scrollTop: $("#alertBox").offset().top
					}, 1000);*/
					   
					}
				});
			}
		});
	};
    return {
        //main function to initiate the module
        init: function () {
            handleDelete();
        }
    };
}();
jQuery(document).ready(function() {
    UIDeleteRows.init();
});
