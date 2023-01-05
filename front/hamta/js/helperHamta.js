/****** Front Front *******/
$(document).ready(function () {

});

function helper() {
	return{
		dropAreaId:'' ,
		old_file_list:[],
	    file_list:[],
		toast:function(obj){
			let	$type = typeof obj.type != "undefined"?obj.type:'show',
				$position = typeof obj.position != "undefined"?obj.position:'bottomRight';
				$title = typeof obj.title != "undefined"?obj.title:'';
				$message = typeof obj.text != "undefined"?obj.text:'';

			swal.fire({
				title: $title,
				text: $message,
				icon: $type,
			});
		},
		post:function (action,data) {
			return $.ajax({
				url: action,
				type: 'post',
				data: data,
				headers: {
					//Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),  //for object property name, use quoted notation shown in second
				},
				dataType: 'json',
				success: function (r) {
					return r;
				},
				error:function(e){
					let txt='';
					if(e.responseJSON.hasOwnProperty('errors')){
						for(let row in e.responseJSON.errors){
							e.responseJSON.errors[row].forEach(function(v) {
								txt = v;
							});
						}
						helper().toast({
							text:txt,
							type:'error'
						});
					}else{
						if(data.hasOwnProperty('showError') && (data.showError === 'no' || !data.showError)){
							return 0;
						}
						helper().toast({
							text:'هنگام بازیابی اطلاعات از سرور خطایی رخ داده دوباره تلاش کنید',
							type:'error'
						});
						return 0;
					}
				}
			});
			/*$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});
			data.token = '';
			return $.post(action,data).done(function (r) {
				return r;
			})
			.fail(function (e) {
				let txt='هنگام بازیابی اطلاعات از سرور خطایی رخ داده دوباره تلاش کنید';
				if(e.responseJSON.hasOwnProperty('errors')){
					for(let row in e.responseJSON.errors){
						e.responseJSON.errors[row].forEach(function (v) {
							txt = v;
						});
					}
				}
				helper().toast({
					text:txt,
					type:'error'
				});
				return 0;
			});*/
		},
		get:function (action) {
			return $.get(action).done(function (r) {
				return r;
			}).fail(function (e) {
				let txt='هنگام بازیابی اطلاعات از سرور خطایی رخ داده دوباره تلاش کنید';
				if(e.responseJSON.hasOwnProperty('errors')){
					for(let row in e.responseJSON.errors){
						e.responseJSON.errors[row].forEach(function (v) {
							txt = v;
						});
					}
					helper().toast({
						text:txt,
						type:'error'
					});
				}else{
					if(data.hasOwnProperty('showError') && (data.showError === 'no' || !data.showError)){
						return 0;
					}
					helper().toast({
						text:'هنگام بازیابی اطلاعات از سرور خطایی رخ داده دوباره تلاش کنید',
						type:'error'
					});
					return 0;
				}
			});
		},
		select_2:function(){
			$("._select2").each(function () {
				let $this=$(this);
				let parent=typeof $this.data('parent')!=='undefined'?$("#"+$this.data('parent')):'';
				$(this).select2({
					dropdownParent:parent,
					dropdownAutoWidth: true,
					width: '100%',
					placeholder: "انتخاب گزینه",
					dir: "rtl",
					"language": {
						"noResults": function(){
							return "چیزی پیدا نشد";
						}
					},
				});
			});
		},
		selectAjax:function(){
			$("._select2_ajax").each(function(){
				let $this =$(this);
				let placeholder=typeof $this.data('placeholder')?$this.data('placeholder'):'برای جستجو چیزی تایپ کنید';
				let url=typeof $this.data('url')?$this.data('url'):'action_not_set';
				let parent=typeof $this.data('parent')!=='undefined'?$("#"+$this.data('parent')):'';
				$this.select2({
					dropdownParent:parent,
					dropdownAutoWidth: !0,
					width: "100%",
					placeholder: placeholder,
					dir : "rtl",
					allowClear:!0,
					language: {
						noResults: function(){return "چیزی یافت نشد";},
						inputTooShort: function () { return 'یک یا چند کاراکتر تایپ کنید';},
						searching: function () { return 'درحال  جستجو...';},
					},
					escapeMarkup: function (e) {
						return e;
					},
					ajax: {
						url: $baseurl+'/management/'+url,
						//url: "https://api.github.com/search/repositories",
						dataType: "json",
						delay: 250,
						language: 'fa',
						data: function (e) {
							return { q: e.term, page: e.page };
						},
						processResults: function (e, t) {
							return (t.page = t.page || 1), { results: e.items, pagination: { more: 30 * t.page < e.total_count } };
						},
						cache: !0,
					},
					minimumInputLength: 1,
					templateResult: function (e) {
						if (e.loading) return e.text;
						var t ="";
						if(e.hasOwnProperty('img')){
							t +="<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'>" +
								"<img  src='" +e.img + "' />" +
								"</div>" ;
						}
						t += "<div class='select2-result-repository__meta'>";
						t += "<div class='select2-result-repository__description'></div>";
						t +="<div class='select2-result-repository__statistics'>";
						t += e.text?"<div class='select2-result-repository__forks'>" +	e.text +"</div>" :"";
						t +=e.text2?"<div class='select2-result-repository__stargazers'>" +	e.text2 +"</div>" :"";
						t +=e.text3?"<div class='select2-result-repository__watchers'>" +	e.text3 +"</div></div>" :"";
						t +="</div></div>";
						return t;
					},
					templateSelection: function (e) {
						return e.text || e.id;
					}
				});

			});
		},
		select2_tag:function(){
			$("._select2_tag").select2({
				dropdownAutoWidth: true,
				width: '100%',
				placeholder: "انتخاب گزینه",
				tags:true,
				dir: "rtl",
				"language": {
					"noResults": function(){
						return "چیزی پیدا نشد";
					}
				},
			});
		},
		scrollTo:function (id,top) {
			top = typeof top == 'undefined'?70:top;
			$('html, body').animate({
				scrollTop: $("#"+id).offset().top - top
			}, 1000);
		},
		number_format:function (number) {
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
			var n = !isFinite(+number) ? 0 : +number;
			var prec = !isFinite(+0) ? 0 : Math.abs(0);
			var sep = (typeof  ',' === 'undefined') ? ',' :  ',';
			var dec = (typeof '.' === 'undefined') ? '.' : '.';
			var s = '';
			var toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k)
					.toFixed(prec);
			};
			// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
			}
			if ((s[1] || '').length < prec) {
				s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1).join('0')
			}
			return s.join(dec);
		},
		imagePreview:function (input,id,size,func) {
			size = typeof size === 'undefined' ?200000:size;
			var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
			if(input.files && input.files[0]){
				if (!filterType.test(input.files[0].type)) {
					helper().toast({
						text:'شما باید یک فایل تصویر را انتخاب کنید',
						type:'warning'
					});
					return 0;
				}
				if(this.checkFileSize(input,size)){
					this.readUrl(input,id,func);
				}else{
					let $u='byte';
					if(size > 1024){
						$u = 'Kb';
						size = size / 1024;
					}
					if(size > 1024){
						$u = 'Mb';
						size = size / 1024;
					}
					if(size > 1024){
						$u = 'Gb';
						size = size / 1024;
					}
					helper().toast({
						text:'حداکثر حجم تصویر نباید بیشتر از ' + this.number_format(size) +  $u + '  باشد',
						type:'warning'
					});
					return 0;
				}
			}
		},
		readUrl:function (input,id,func) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#'+id).attr('src', e.target.result);
					func(e.target.result);
				};
				reader.readAsDataURL(input.files[0]); // convert to base64 string
			}
		},
		checkFileSize:function(input,size){
			/*چک کردن بر اساس بایت*/
			size = typeof size === 'undefined' ?200000:size;
			if(input.files[0].size > size) {
				input.value = null;
				//alert("حجم فایل انتخابی نباید بیشتر از 200 کیلو بایت باشد");
				return 0;
			}else
				return  1;
		},
		full_height:function(){
			var $list=$("*[class*=full-height]"),
				$el=[],
				$max=10;
			for(let i=0;i<=$max;i++){$el[i]=[0]}
			for(let i=0;i<=$max;i++){
				$list.each(function () {
					let $class=i===0?'full-height':'full-height-'+i;
					if($(this).hasClass($class)){
						$el[i].push($(this).height());
					}
				});
			}
			for(let i=0;i<=$max;i++){
				$list.each(function () {
					let $class=i===0?'full-height':'full-height-'+i;
					if($(this).hasClass($class)){
						$(this).css('min-height',Math.max(...$el[i])+'px');
					}
				});
			}
		},
		logout:function () {
			swal({
				title: "آیا میخواهید خارج شوید ؟",
				text: "در صورت اطمینان روی دکمه تایید کلیک کنید",
				icon: 'warning',
				dangerMode: true,
				buttons: {
					cancel: 'نه منصرف شدم',
					delete: 'بله ، مطمنم'
				}
			}).then(function (e) {
				if(e){
					window.location.href = $baseUrl+'/log-out';
				}
			});
		},
		formValid:function () {
			$(".form-valid").validate({
				errorElement: "span",
				invalidHandler:function(e, r) {
					//$(r.submitButton).addClass('animated fadeOut-');
				}
			}),
			$(".form-valid1").validate({
				errorElement: "span",
			}),
			$(".form-valid2").validate({
				errorElement: "span",
			}),
			$(".form-valid3").validate({
				errorElement: "span",
			}),
			$(".form-valid4").validate({
				errorElement: "span",
			}),
			$(".form-valid5").validate({
				errorElement: "span",
			}),

			jQuery.extend(jQuery.validator.messages, {
				required: "فیلد ضروری را پر کنید.",
				remote: "لطفا یک گزینه انتخاب کنید.",
				email: "لطفا یک ادرس ایمیل معتبر وارد کنید.",
				url: "لطفا یک لینک معتبر وارد کنید .",
				date: "لطفا یک تاریخ معتبر وارد کنید.",
				dateISO: "لطفا یک تاریخ معتبر (ISO) وارد کنید.",
				number: "لطفا یک مقدار عددی وارد کنید.",
				digits: "لطفا یک مقدار دیجیتال وارد کنید.",
				creditcard: "Please enter a valid credit card number.",
				equalTo: "Please enter the same value again.",
				accept: "Please enter a value with a valid extension.",
				maxlength: jQuery.validator.format("طول کاراکتر ها نباید بیشتر از {0} شود ."),
				minlength: jQuery.validator.format("طول کاراکتر ها نباید کمتر از {0} شود ."),
				rangelength: jQuery.validator.format("طول کاراکتر ها مابین {0} باشد {1} و."),
				range: jQuery.validator.format("مقدار باید مابین {0} و {1} باشد."),
				max: jQuery.validator.format("مقدار ورودی باید کمتر از {0} باشد."),
				min: jQuery.validator.format("مقدار ورودی باید بیشتر از {0} باشد.")
			});
		},
		setCitySelectBox:function (parent_id,target_id) {
			helper().get($baseurl+'/get-city?parent_id='+parent_id).done(function (r) {
				if(r.hasOwnProperty('result') && r.result){
					$("#"+target_id).html(r.data.html);
				}
				else{
					helper().toast({
						text:r.msg,
						type:'warning'
					});
				}
			});
		},
		getCity:function(parent_id,func){
			helper().get($baseurl+'/get-city?parent_id='+parent_id).done(function (r) {
				if (r.hasOwnProperty('result') && r.result) {
					func(r.data.html);
				} else {
					helper().toast({
						text: r.msg,
						type: 'warning'
					});
				}
			});
		},
		pDate:function () {
			$("#pdate1").is(function () {
				new AMIB.persianCalendar( 'pdate1' )
			}),
			$("#pdate2").is(function () {
				new AMIB.persianCalendar( 'pdate2' )
			}),
			$("#pdate3").is(function () {
				new AMIB.persianCalendar( 'pdate3' )
			}),
			$("#pdate4").is(function () {
				new AMIB.persianCalendar( 'pdate4' )
			}),
			$("#pdate5").is(function () {
				new AMIB.persianCalendar( 'pdate5' )
			});
		},
		dtParam:function (d,cls) {
			d._token=$csrf_token;
			$('.'+cls).each(function(){
				var name= $(this).attr('name');
				d[name] = $(this).val();
			});
			return d;
		},
		getCat:function ($type,$parent_id) {
			return helper().get($baseurl+'/get-cat?type='+$type+'&parent_id='+$parent_id)
				.done(function (r) {
					return r
				})
		},
		getCatHtml:function ($type,$parent_id) {
			return helper().get($baseurl+'/get-cat-html?type='+$type+'&parent_id='+$parent_id)
				.done(function (r) {
					return r;
				});
		},
		catList:function ($parenId,$type,func) {
			if($parenId < 1){return 0;}
			helper().get($baseUrl+'/get-cat-api/'+$parenId+'/'+$type)
				.done(function (r) {
					let $html='';
					r.length?$html='<option>آیتمی را انتخاب کنید</option>':
						$html='<option>چیزی پیدا نشد</option>';
					r.forEach(function (row,key) {
						$html+='<option value="'+row.id+'">'+row.title+'</option>';
					});
					func($html);
			});
		},
		excerpt:function(str,num,more){
			more = more ===undefined?'':more;
			if(str.length > num)
				return str.substring(0,num) + more;
			else
				return str;
		},
		persianNumber(number){
			return Num2persian(number);
		},
		empty:function(val){
			if(typeof val == "undefined" || typeof val == undefined)
				return 0;
			if(typeof val == "string" && !val.length)
				return 0;
			if(Array.isArray(val) && val.length == 0)
				return 0;
			if(val == null || val == "null")
				return 0;
			if(typeof val == null)
				return 0;
			if(typeof val == "object" && Object.keys(val).length === 0)
				return 0;

			return 1;
		}
	};
}
