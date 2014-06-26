
NetCommonsApp.controller('Announcements.edit', function($scope , $http) {
    var pluginsUrl = '/announcements/announcements/';
    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.dataId = 0;
    $scope.geturl =  pluginsUrl + "get_edit_form/";
    $scope.posturl = pluginsUrl + "edit/";
    $scope.debug = null;
    $scope.tinymceModel = null;

    $scope.alertMss = null;
    $scope.statusList = {
        'Publish' : 1,
        'PublishRequest' : 2,
        'Draft' : 3,
        'Reject' : 4
    };
    $scope.isPreview = 0;

    //DOM
    var viewerTag = '';
    var editerOpenBtnTag = '';
    var previewTag = '';
    var editerTag = '';
    var previewBtnTag = '';
    var htmlEditerTag = '';
    var statusLabelTag = '';
    var editerOpenBtnTag = '';
    var draftTag = '';
    var previewCloseBtnTag = '';
    var messageTag = '';

    //フォームを閉じる
    $scope.closeForm = function(frameId){
        //set
        $scope.setId(frameId);
        //プレビューも閉じる
        $scope.closePreview();
        $(viewerTag).removeClass('hidden');
        $(editerTag).addClass('hidden');
        $(editerOpenBtnTag).removeClass('hidden');
        $(editerOpenBtnTag).removeClass('hidden');
        //メッセージ非表示
        $scope.postAlertClose();
    }

    //フォームを開く
    $scope.getEditer = function(frameId , blockId, dataId){
        $scope.setId(frameId , blockId, dataId);
        $(editerTag).removeClass('hidden');
        $(viewerTag).addClass('hidden');
        $(editerOpenBtnTag).addClass('hidden');
        //表示内容をエディターに反映 公開とは別に最新のドラフトが会った場合そちらが表示される。
        $scope.tinymceModel = $(draftTag).html();
        //メッセージ非表示
        $scope.postAlertClose();
    }

    //メッセージ（実行結果）を表示
    $scope.postAlert = function(alertType , text){
        $(messageTag).css("display","none");
        if(alertType == "error") {
            $(messageTag).addClass("alert-danger");
            $(messageTag).removeClass("alert-success");
            //$(messageTag).removeClass("hidden");
            $(messageTag + " .message").html(text);
            $(messageTag).fadeIn(500);//エラーの場合は消さない
        } else if(alertType == "success") {
            $(messageTag).addClass("alert-success");
            $(messageTag).removeClass("alert-danger");
            $(messageTag).removeClass("hidden");
            $(messageTag + " .message").html(text);
            $(messageTag).fadeIn(500).fadeTo(1000, 1).fadeOut(500)
            ;
        }
    }

    //アラートメッセージを非表示にする
    $scope.postAlertClose = function(frameId){
        $scope.setId(frameId);
        $(messageTag).addClass("hidden");
        $(messageTag + " .message").html("");
    }

    //idのセット
    $scope.setId = function(frameId , blockId, dataId){
        $scope.frameId = frameId;
        if(blockId){
            $scope.blockId = blockId;
        }
        if(dataId){
            $scope.dataId = dataId;
        }
        //dom set
        viewerTag = '#announcement-content-view-' + $scope.frameId;
        draftTag = '#announcement-content-draft-' + $scope.frameId;
        editerTag = '#announcements-form-'  + $scope.frameId;
        previewTag = '#announcement-content-preview-' + $scope.frameId;
        previewBtnTag = '#announcements-btn-preview-'+ $scope.frameId;
        htmlEditerTag = '#announcements-form-' + $scope.frameId + ' .html-editer';
        statusLabelTag = '#announcement-status-label-' + $scope.frameId;
        editerOpenBtnTag = '#announcement-content-edit-btn-' + $scope.frameId;
        previewCloseBtnTag = '#announcement-editer-button-'+ $scope.frameId + ' .announcement-editer-button-preview-close';
        messageTag = '#announcements-mss-' + $scope.frameId;
    }

    //プレビューの表示
    $scope.showPreview = function(){
        //本記事を隠す
        $(viewerTag).addClass('hidden');
        $(previewTag).html($scope.tinymceModel);
        $(previewTag).removeClass('hidden');
        //プレビュー終了ボタンを消す
        $(previewCloseBtnTag).removeClass('hidden');
        //プレビューボタンを表示する
        $(previewBtnTag).addClass('hidden');
        //プレビュー中のラベル。
        $(statusLabelTag + " .announcement-preview").removeClass('hidden');
        $(htmlEditerTag).addClass('hidden');
    }

    //プレビューを終了する
    $scope.closePreview = function(){
        //本記事を表示する
        $(viewerTag).removeClass('hidden');
        //プレビューをクリア。非表示
        $(previewTag).html('');
        $(previewTag).addClass('hidden');
        //プレビュー中のラベルを下げる。
        $(statusLabelTag + " .announcement-preview").addClass('hidden');
        //プレビューを終了するボタンを非表示にする。
        $(previewCloseBtnTag).addClass('hidden');
        //プレビューボタンを表示する。
        $(previewBtnTag ).removeClass('hidden');
        //htmlエディタ非表示する
        $(htmlEditerTag).removeClass('hidden');

    }

    //エディターの切り替え

    //post //todo:非同期通信中のボタン無効化
    $scope.post = function(type , frameId , blockId, dataId){
        //idセット
        $scope.setId(frameId , blockId ,dataId);

        if(type == "Cancel"){
            $scope.closeForm(frameId);
            return ;
        }
        //プレビュー
        if(type == 'Preview'){
            $scope.showPreview();
            return  ;
        }
        //プレビューの終了
        if(type == "PreviewClose"){
            $scope.closePreview();
            return ;
        }
        if(type == 'Publish'
            && $(draftTag).html()
            && ! $scope.tinymceModel
        ) {
            $scope.tinymceModel = $(draftTag).html();
        }

        //form
        $http({method: 'GET', url: $scope.geturl+$scope.frameId})
            .success(function(data, status, headers, config) {
                //set
                $("#announcements-post-"+ $scope.frameId).html(data);
                var post_data_form = "#announcements-data-"+ $scope.frameId;
                var post_params = {
                    'data[_Token][fields]' : $(post_data_form + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(post_data_form + " input[name='data[_Token][key]']").val(),
                    '_method' : $(post_data_form + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(post_data_form + " input[name='data[_Token][unlocked]']").val(),
                    'data[AnnouncementDatum][content]' : encodeURIComponent($scope.tinymceModel),
                    'data[AnnouncementDatum][frameId]' : $scope.frameId,
                    'data[AnnouncementDatum][blockId]' : $scope.blockId,
                    'data[AnnouncementDatum][type]'    : type,
                    'data[AnnouncementDatum][langId]'  : $(post_data_form + " input[name='data[AnnouncementDatum][langId]']").val(),
                    'data[AnnouncementDatum][id]'      : $scope.dataId
                };
                //post
                $.ajax({
                    method:'POST' ,
                    url: $scope.posturl
                        + $scope.frameId
                        + '/'
                        + Math.random(),
                    data: post_params,
                    success:function(json, status, headers, config){
                        $scope.setIndex(json);
                    },
                    error:function(){
                        $scope.postAlert("error" , 'ERROR!');
                    }
                });
            })
            .error(function(data, status, headers, config) {
                //keyの取得に失敗
                if(! data) { data = "ERROR!"; }
                $scope.postAlert("error" , data);
                $scope.debug = data;
            });


    }
    //最新の情報にいれかえる
    $scope.setIndex = function(json){

       //最新
        var statusLabelClassTag = statusLabelTag + ' .announcement-status-';
        var content = decodeURIComponent(json.data.AnnouncementDatum.content);
        var statusId = json.data.AnnouncementDatum.status_id;
        var textareaTag = "#announcements-text-editer-" + $scope.frameId;
        var btnRejectTag = "#announcement-editer-button-" + $scope.frameId + " .announcement-editer-button-reject";
        var btnDraftTag =  "#announcement-editer-button-" + $scope.frameId + " .announcement-editer-button-draft";
        var btnTopPublishTag = '#announcement-content-edit-btn-'+ $scope.frameId + ' .announcement-btn-publish';
        //ラベルのクリア
        $(statusLabelClassTag + $scope.statusList.Draft).addClass("hidden");
        $(statusLabelClassTag + $scope.statusList.PublishRequest).addClass("hidden");
        $(statusLabelClassTag + $scope.statusList.Reject).addClass("hidden");
        //入れ替え : 初期値
        $(textareaTag).val(content);
        $(viewerTag).html(content);
        $(draftTag).html(content);
        $(btnRejectTag).addClass('hidden');
        $(btnDraftTag).removeClass('hidden');
        $(btnTopPublishTag).addClass('hidden');
        if(statusId == $scope.statusList.Draft) {
            //下書き
            $(statusLabelClassTag + $scope.statusList.Draft).removeClass("hidden");
        }else if(statusId == $scope.statusList.Publish){
            //公開中
            //ラベル変更
            $(statusLabelClassTag + $scope.statusList.Publish).removeClass("hidden");
        }else if(statusId == $scope.statusList.PublishRequest){
            //申請中
            //ラベルの変更
            $(statusLabelClassTag + $scope.statusList.PublishRequest).removeClass("hidden");
            //ボタン切り替え
            $(btnRejectTag).removeClass('hidden');
            $(btnDraftTag).addClass('hidden');
            $(btnTopPublishTag).removeClass('hidden');
        }
        else if(statusId == $scope.statusList.Reject){
            //差し戻し
            //Tラベルの変更(表示）
            $(statusLabelClassTag + $scope.statusList.Reject).removeClass("hidden");
        }
        $(statusLabelClassTag + statusId).removeClass("hidden");
        $(editerOpenBtnTag).attr('ng-click' , 'etEditer(' + $scope.frameId + ',' +  json.data.AnnouncementDatum.block_id + ')');
        $scope.postAlert("success" , json.message);
        $scope.closeForm($scope.frameId);
    }

    //全ての編集画面一旦非表示
    $(".text-editer").css('display:none;');
    $(".announcements-editer").addClass('hidden');

    //TEXTエディタ
    $scope.openTextEditer = function(frameId) {
        $scope.setId(frameId);
        var modalTag = "#announcements-text-editer-modal-" + frameId;
        var textareaTag = "#announcements-text-editer-" + frameId;
        var htmlEditerTag = "#announcements-html-editer-" + frameId;
        $(textareaTag).val($(htmlEditerTag).val());
        //モーダル Open
        $(modalTag).modal('show');
    }
    //TEXTエディタ close データの受け渡しのみ
    $scope.closeTextEditer = function(frameId) {
        $scope.setId(frameId);
        var modalTag = "#announcements-text-editer-modal-" + frameId;
        var textEditerTag = "#announcements-text-editer-"+ frameId;
        var htmlEditerTag = "#announcements-html-editer-" + frameId;
        var d = $(textEditerTag).val();
        $scope.tinymceModel = d;
        $(htmlEditerTag).val(d);
        $(textEditerTag).val($(htmlEditerTag).val());
        $(modalTag).modal('hide');
    }
    $scope.openBlockSetting = function(frameId){
        $scope.setId(frameId);
        alert("TODO : ブロック設定を開く");
    }

    $('.announcements-editer').addClass('hidden');

});

NetCommonsApp.controller('Announcements.setting', function($scope , $http) {

    $scope.getPluginName = function(n){

    }
});