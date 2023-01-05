let uploadTimer ;
let $myOpt;
let $fileup;
function _constructor($opt) {
    $myOpt = $opt;
    $fileup = myFileUp($opt);
    getFile(); // فراخوانی
}

// Create Fileup  -- ایجاد متغیر فایل کنترل جی کوئری
function myFileUp($opt) {
    return  $.fileup({
        url: $baseurl+'/management/galleryUpload',
        method: 'post',
        inputID: $opt.inputID, //this.fileup.options; options.inputID
        dropzoneID: $opt.dropzoneID,
        queueID: $opt.queueID,
        wrap:$opt.wrap,
        fieldName: $opt.fieldName,
        extraFields: {
            id: $opt.id,
            _token:$opt.token,
            path:$opt.path,
        },
        sizeLimit:$opt.sizeLimit, // 1Mb = 1000000
        filesLimit:$opt.filesLimit, // max file count select
        autostart:$opt.autostart,
        files:[], // uploaded file preview
        onSelect: function(file) {
            let $options = this.fileup.options;
            $('#'+$options.wrap+' .control-button').show();
        },
        onStart:function(file_number, file){
            clearTimeout(uploadTimer);
        },
        onRemove: function(file, total,file_number) {
            let $wrap = this.fileup.options.wrap;
            if (file === '*' || total === 1) {
                $('#'+$wrap+' .control-button').hide();
            }
        },
        onSuccess: function(response, file_number, file) {
            let r = JSON.parse(response);
            if(r.result){
                $.growl.notice({ title: "آپلود موفق", message: "بارگذاری انجام شد : " + file.name });
                $.fileup($opt.inputID, 'remove', file_number);
                uploadTimer = setTimeout(function () {
                    getFile();
                },2000);
            }else{
                $.growl.warning({ title: "هشدار : ", message: r.msg});
            }
        },
        onSuccessSystem: function(response, file_number, file) {
            let r = JSON.parse(response);
            let options = this.fileup.options;
            let $file   = $('#fileup-' + options.inputID + '-' + file_number);
            $file.find('.fileup-abort').hide();
            $file.find('.fileup-upload').hide();
            let $result = $file.find('.fileup-result');
            if(r.result){
                $result
                    .removeClass('fileup-error')
                    .addClass('fileup-success')
                    .text('بارگذاری شد');
            }else{
                $file.find('.fileup-upload').show();
                $result
                    .addClass('fileup-error')
                    .removeClass('fileup-success')
                    .text('خطا در بارگذاری ، دوباره تلاش کنید');
            }
        },
        onError: function(event, file, file_number) {
            $.growl.error({ title:'بروز خطا : ',message: "بارگذاری انجام نشد : " + file.name });
        },
    });
}

// Get File List - دریافت لیست فایلها
function getFile() {
    helper().get($baseurl+'/management/galleryList?id='+$opt.id+'&path='+$myOpt.path)
        .done(function (r) {
            if(r.result){
                let $html = '';
                r.list.forEach(function (v,key) {
                    $html+='<div class="list-file-uploaded" id="fileUploaded-'+v.id+'">';
                    $html+='<div class="file-thumb" style="margin-right: 15px;"> ';
                    $html+='<img src="'+v.previewUrl+'" style="max-width: 80px;max-height: 80px" />';
                    $html+='</div><!--end thumb-->';
                    $html+='<div class="file-info">';
                    $html+='<p>'+v.name+'</p>';
                    $html+='<p>'+v.size+'</p>';
                    $html+='<p>شماره : '+parseInt(key + 1)+'</p>';
                    $html+='</div><!--end info-->';
                    $html+='<span class="file-remove" onclick="deleteFile(\''+v.name+'\',this)">×</span>';
                    $html+='</div>';
                });
                $("#"+$myOpt.id_list_upload).html($html);
                helper().scrollTo($myOpt.id_list_upload,100);
            }
        });
}

// Delete File - حذف فایلهای آپلود شده
function deleteFile(name,t) {
    if(confirm('این فایل برای همیشه پاک شود ؟')){
        helper().post($baseurl+'/management/galleryDelete',
            {
                path:$myOpt.path,
                name:name,
            }).done(function (r) {
            if(r.result){
                $(t).closest('.list-file-uploaded').remove();
            }else{
                swal({
                    text:r.msg,
                    icon:'warning'
                });
            }
        });
    }
}