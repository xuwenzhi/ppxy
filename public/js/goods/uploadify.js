var img_id_upload = new Array();//初始化数组，存储已经上传的图片名
var i=0;//初始化数组下标
$(function() {
    $('#file_upload').uploadify({
        'auto'     : false,//关闭自动上传
        'removeTimeout' : 1,//文件队列上传完成1秒后删除
        'swf'      : PUBLIC+'lib/swf_uploadify/uploadify.swf',
        'uploader' : APP+'/goods/upload',
        'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
        'buttonText' : '添加图片',//设置按钮文本
        'displayData' : 'speed',
        'multi'    : true,//允许同时上传多张图片
        'uploadLimit' : 6,//一次最多只允许上传6张图片
        'fileTypeDesc' : 'Image Files',//只允许上传图像
        'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg',//限制允许上传的图片后缀
        'sizeLimit' : '700',//限制上传的图片不得超过200KB 
        'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
            img_id_upload[i] = data;
            i++;
            console.log(data);
            console.log(data.status);
            var imgDOM = "<div id='add_photo_list'><div id='add_photo_img_list'><img src="+data.data['img_path']+" /></div><div><input type='text' placeholder='相片描述' style='width:115px;height:30px' ></div><span><a href='#' class='"+arr[0]+"' onclick='edit_pic_content(this)'>提交</a></span></div>";
            var img_path = '<div class="col-sm-6 col-md-3">';
            img_path += '<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia"><img src="'+arr[1]+'"  alt="..." class="img-responsive img-rounded" alt="Responsive image"></a>';
            img_path += '<div class="modal fade" id="goodsPhotoDia"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">';
            img_path += '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><img src="" width="80%" class="img-responsive center-block" alt="Responsive image"/></div></div></div></div></div>';
            $("#upload_photo_block").append(img_path);
        },'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数
            if(img_id_upload.length>0){
                $("#file_upload").hide();
                $("#doUploadPhoto").hide();
                $("#doAgainUploadPhoto").show();
            }
        },
        'onComplete':function(evt, queueID, fileObj, response, data){
            //alert('ff');
        }
    });

    $("#doAgainUploadPhoto").click(function(){
        $("#file_upload").show();
        $("#doUploadPhoto").show();
        $(this).hide();
        $("#img").html('');
    });
});
