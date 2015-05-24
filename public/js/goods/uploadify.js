var img_id_upload = new Array();//初始化数组，存储已经上传的图片名
var i=0;//初始化数组下标
$(function() {
    $('#file_upload').uploadify({
        'auto'     : false,//关闭自动上传
        'removeTimeout' : 1,//文件队列上传完成1秒后删除
        'swf'      : PUBLIC+'lib/swf_uploadify/uploadify.swf',
        'uploader' : APP+'/goods/upload',
        'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
        'buttonText' : '选择图片',//设置按钮文本
        'displayData' : 'speed',
        'multi'    : true,//允许同时上传多张图片
        'uploadLimit' : 6,//一次最多只允许上传6张图片
        'fileTypeDesc' : 'Image Files',//只允许上传图像
        'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg',//限制允许上传的图片后缀
        'sizeLimit' : '700',//限制上传的图片不得超过200KB 
        'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
            if(response){
                var res = data.split('*');
                console.log(res);
                if(res[0] == 'success'){
                    var img_path = '<div class="col-sm-6 col-md-3">';
                    img_path += '<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia'+res[2]+'"><img src="'+PUBLIC+res[1]+'"  alt="..." class="img-responsive img-rounded" alt="Responsive image"></a>';
                    img_path += '<div class="modal fade" id="goodsPhotoDia'+res[2]+'"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">';
                    img_path += '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><img src="'+PUBLIC+res[3]+'" width="80%" class="img-responsive center-block" alt="Responsive image"/></div></div></div></div></div>';
                    $("#upload_photo_block").append(img_path);
                }else{
                    alert(res[1]);
                }
            }
        },'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数

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
