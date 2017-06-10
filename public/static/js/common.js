/**
 * Created by fangxingguang on 2016/2/29.
 */

function ajax_from(form_id,check_fun,call_back_fun){
    var options = {
        beforeSubmit: check_fun,
        dataType: 'json',
        success: function (data) {
            call_back_fun(data);
        }
    };
    $("#"+form_id).ajaxForm(options);
}

function comm_ajax(url,data,call_back_fun){
    $.ajax({
        url:url,
        type:'POST',
        dataType:'json',
        data:data,
        success:function(data){
            call_back_fun(data);
        }
    })
}

$(function(){

    var options = {
        dataType: 'json',
        success: function (data) {
            if(data.code == 400){ //失败
                alert(data.msg);
            }else if(data.code == 200){ //成功
                location.reload();
            }
        }
    };
    if($(".ajax").length > 0){
        $(".ajax").ajaxForm(options);
    }

})


