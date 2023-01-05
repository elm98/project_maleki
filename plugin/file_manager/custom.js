//var $iframeSrc = document.currentScript.getAttribute('iframeSrc');
var $iframeSrc = window.location.href.split('/management')[0]+'/plugin/file_manager/index.html';
var fm_is_opened = 0;
document.addEventListener("DOMContentLoaded", function(event) {
    let divIframe = document.createElement('div');
    divIframe.setAttribute("id", "fm_modal_file_manager");
    document.body.appendChild(divIframe);
    //fm_modal('all');

    var fm_target_id='';
    var fm_after_done='';
    var fm_filter='';
});

function fm_modal(filter) {
    var $html='<div class="fm_modal_shadow" id="fm_modal_shadow">';
    $html+='<div class="fm_modal_body">';
    $html+='<div class="fm_modal_header"><h6>فایل منیجر</h6><span class="fm_modal_close" onclick="fm_modal_close()">+</span></div>';
    $html+='<div class="fm_modal_content">';
    $html+='<iframe src="'+$iframeSrc+'?filter='+filter+'" style="width:100%;height: 100%;border-style: none">';
    $html+='</iframe>';
    $html+='</div>';
    $html+='</div>';
    $html+='</div>';
    $html+='</div>';
    document.getElementById('fm_modal_file_manager').innerHTML = $html;
}

function selectItem(str) {
    //str = str.substring(1);
    fm_modal_close();
    var target=document.getElementById(fm_target_id);
    if(target){
        target.value = str;
    }
    if(fmModalAfterDone!=='' && (typeof window[fmModalAfterDone] === "function")){
        window[fmModalAfterDone]({id:fm_target_id,file:str});
    }
}

function fm_modal_open(th) {
    if(!fm_is_opened){
        fm_modal('all');
        fm_is_opened =1;
    }
    let $this=$(th);
    fm_target_id=$this.data('target-id');
    fm_filter=[null,'null','undefined','*',''].includes(typeof $this.data('filter')) ? 'all':  $this.data('filter');
    //fm_modal($fm_modal_src,fm_filter);
    fmModalAfterDone = (typeof $this.data('after-done') !== 'undefined' && $this.data('after-done')!=="" ) ?  $this.data('after-done') : '';
    document.getElementById("fm_modal_shadow").style.display='block';
    document.body.style.overflowY = 'hidden';
}

function fm_modal_close() {
    document.getElementById("fm_modal_shadow").style.display='none';
    document.body.style.overflowY = 'auto';
}
