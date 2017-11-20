$(function(){
    Dropzone.autoDiscover = false;
	$('div#dropzoneBox').dropzone({
		paramName:'file',
		url:'dropzone.html',
//		acceptedFiles:'text/plain,application/pdf,application/msword,application/x-zip-compressed,image/png,image/jpeg,image/gif,application/msword,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation',
		maxFilesize:20,
		addRemoveLinks:true,
		success:function(_file, _return, _xml){
			var r=_return.trim();
			if(r.length == 32){
				var $hiddenInput = $('<input/>',{type:'hidden',name:'file_key[]',value:r});
				$hiddenInput.appendTo(_file.previewElement);
				_file.previewElement.classList.add("dz-success");
			}else{
				if(r){
				alert(r);
				}else{
				alert('システムエラー');
				}
				(ref = _file.previewElement) != null ? ref.parentNode.removeChild(_file.previewElement) : void 0;
			}
		},
		error:function(_file, _error_msg){
			if(_error_msg){
			alert(_error_msg);
			}else{
			alert('システムエラー');
			}
			var ref;
			(ref = _file.previewElement) != null ? ref.parentNode.removeChild(_file.previewElement) : void 0;
		},
		removedfile:function(_file){
			var ref;
			(ref = _file.previewElement) != null ? ref.parentNode.removeChild(_file.previewElement) : void 0;
		},
		dictRemoveFile:'削除',
		dictCancelUpload:'キャンセル'
	});

});

