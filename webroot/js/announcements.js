
NetCommonsApp.controller('Announcements.edit', function($scope , $http) {
    var pluginsUrl = '/announcements/announcements/';
    var errorViewTag = "#announcements_mss_";
    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.dataId = 0;
    $scope.geturl =  pluginsUrl + "get_edit_form/";
    $scope.posturl = pluginsUrl + "post/";
    $scope.debug = null;
    $scope.tinymceModel = null;

    $scope.alertMss = null;
    $scope.statusList = {
        'Publish' : 1,
        'PublishRequest' : 2,
        'Draft' : 3
    };
    $scope.isPreview = 0;

    //フォームを閉じる
    $scope.closeForm = function(frameId){
        var editerTag = '#announcements_form_' + frameId;
        var viewerTag = '#announcement_content_view_' + frameId;
        var editerOpenBtnTag = '#announcement_content_edit_btn_' +frameId;
        //プレビューも閉じる
        $scope.closePreview();
        $(viewerTag).removeClass('hidden');
        $(editerTag).addClass('hidden');
        $(editerOpenBtnTag).removeClass('hidden');
        $scope.postAlertClose();
    }

    //フォームを開く
    $scope.getEditer = function(frameId , blockId, dataId){
        $scope.setId(frameId , blockId, dataId);
        var editerTag = '#announcements_form_' + frameId;
        var viewerTag = '#announcement_content_view_' + frameId;
        var editerOpenBtnTag = '#announcement_content_edit_btn_' +frameId;
        var draftTag = '#announcement_content_draft_'+ frameId;
        $(editerTag).removeClass('hidden');
        $(viewerTag).addClass('hidden');
        $(editerOpenBtnTag).addClass('hidden');
        //表示内容をエディターに反映 公開とは別に最新のドラフトが会った場合そちらが表示される。
        $scope.tinymceModel = $(draftTag).html();
    }

    //メッセージ（エラー成功両方）を表示するタグを取得
    $scope.getErrorViewTag = function()
    {
        return  errorViewTag + $scope.frameId + " .alert";
    }

    //メッセージ（実行結果）を表示
    $scope.postAlert = function(alertType , text){
        if(alertType == "error") {
            $($scope.getErrorViewTag()).addClass("alert-danger");
            $($scope.getErrorViewTag()).removeClass("alert-success");
            $($scope.getErrorViewTag()).removeClass("hidden");
            $($scope.getErrorViewTag() + " .errorMss").html(text);
        } else if(alertType == "success") {
            $($scope.getErrorViewTag()).addClass("alert-success");
            $($scope.getErrorViewTag()).removeClass("alert-danger");
            $($scope.getErrorViewTag()).removeClass("hidden");
            $($scope.getErrorViewTag() + " .errorMss").html(text);
        }
    }

    //アラートメッセージを非表示にする
    $scope.postAlertClose = function(){
        $scope.alertMss = null;
        $($scope.getErrorViewTag()).addClass("hidden");
        $($scope.getErrorViewTag() + ".errorMss").html("");
    }

    //idのセット
    $scope.setId = function(frameId , blockId, dataId){
        $scope.frameId = frameId;
        if(! blockId){
            blockId = 0;
        }
        if(! dataId){
            dataId = 0;
        }
        $scope.blockId = blockId;
        $scope.dataId = dataId;
    }

    //プレビューの表示
    $scope.showPreview = function(){
        var previewTag = '#announcement_content_preview_' + $scope.frameId;
        var previewCloseBtnTag = '#announcements_btn_preview_close_'+ $scope.frameId;;
        var previewBtnTag = '#announcements_btn_preview_'+ $scope.frameId;
        var statusLavelTag = '#announcement_status_label_' + $scope.frameId + " .announcement-preview";
        var viewerTag = '#announcement_content_view_' + $scope.frameId;
        //本記事を隠す
        $(viewerTag).addClass('hidden');
        $(previewTag).html($scope.tinymceModel);
        $(previewTag).removeClass('hidden');
        //プレビュー終了ボタンを消す
        $(previewCloseBtnTag).removeClass('hidden');
        //プレビューボタンを表示する
        $(previewBtnTag).addClass('hidden');
        //プレビュー中のラベル。
        $(statusLavelTag).removeClass('hidden');
    }

    //プレビューを終了する
    $scope.closePreview = function(){
        var previewTag = '#announcement_content_preview_' + $scope.frameId;
        var previewCloseBtnTag = '#announcements_btn_preview_close_'+ $scope.frameId;
        var previewBtnTag = '#announcements_btn_preview_'+ $scope.frameId;
        var statusLavelTag = '#announcement_status_label_' + $scope.frameId + " .announcement-preview";
        var viewerTag = '#announcement_content_view_' + $scope.frameId;
        //本記事を表示する
        $(viewerTag).removeClass('hidden');
        $(previewTag).html('');
        $(previewTag).addClass('hidden');
        //プレビュー中のラベルを下げる。
        $(statusLavelTag).addClass('hidden');
        //プレビューを終了するボタンを非表示にする。
        $(previewCloseBtnTag).addClass('hidden');
        //プレビューボタンを表示する。
        $(previewBtnTag ).removeClass('hidden');

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
        //form
        $http({method: 'GET', url: $scope.geturl+$scope.frameId})
            .success(function(data, status, headers, config) {
                //set
                $("#announcements_post_"+ $scope.frameId).html(data);
                var post_data_form = "#announcements_data_"+ $scope.frameId;
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
                        + type
                        + '/'
                        + $scope.frameId
                        + '/'
                        + $scope.blockId
                        + '/'
                        + $scope.dataId
                        + '/'
                        + Math.random(),
                    data: post_params,
                    success:function(json, status, headers, config){
                        $scope.setIndex(json);
                    },
                    error:function(){
                        $scope.postAlert("error" , 'NG');
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
        //フォームを閉じる
        $scope.closeForm($scope.frameId);
       //最新
        var editerTag = '#announcements_form_' + $scope.frameId;
        var viewerTag = '#announcement_content_view_' + $scope.frameId;
        var editerOpenBtnTag = '#announcement_content_edit_btn_' + $scope.frameId;
        var draftTag = '#announcement_content_draft_' + $scope.frameId;
        var statusLavelTag = '#announcement_status_label_' + $scope.frameId;
        var statusLavelClassTag = statusLavelTag + ' .announcement-status-';
        var content = json.data.AnnouncementDatum.content;
        var statusId = json.data.AnnouncementDatum.status_id;
        $(statusLavelClassTag + $scope.statusList.Draft).addClass("hidden");
        //$(statusLavelClassTag + $scope.statusList.Publish).addClass("hidden");
        $(statusLavelClassTag + $scope.statusList.PublishRequest).addClass("hidden");
        if(statusId == $scope.statusList.Draft)
        {
            //下書き
            $(draftTag).html(content);
        }else if(statusId == $scope.statusList.Publish){
            //公開中
            $(viewerTag).html(content);
            $(draftTag).html(content);
        }else if(statusId == $scope.statusList.PublishRequest){
            //申請中
            $(draftTag).html(content);
        }

        $(statusLavelClassTag + statusId).removeClass("hidden");
        $(editerOpenBtnTag).attr('ng-click' , 'etEditer(' + $scope.frameId + ',' +  json.data.AnnouncementDatum.block_id + ')');
        $scope.debug = json.data.AnnouncementDatum.block_id;
        $scope.postAlert("success" , json.message);
    }

    //公開確認
    $scope.PublishComfirm = function(){
        alert("公開処理前の確認");
    }


    //全ての編集画面一旦非表示
    $(".text-editer").css('display:none;');

    $(".announcements_editer").addClass('hidden');

    //TEXTエディタ
    $scope.openTextEditer = function(frameId) {
        var modalTag = "#announcements-text-editer-modal-" + frameId;
        var textareaTag = "#announcements-text-editer-" + frameId;
        $(textareaTag).html($scope.tinymceModel);
        //モーダル Open
        $(modalTag).modal('show');
    }
    //TEXTエディタ close データの受け渡しのみ
    $scope.closeTextEditer = function(frameId) {
        var editerTag = "#announcements-html-editer-" + frameId;
        var modalTag = "#announcements-text-editer-modal-" + frameId;
        var textEditerTag = "#announcements-text-editer-"+ frameId;
        var d = $(textEditerTag).val();
        $scope.tinymceModel = d;
        $(modalTag).modal('hide');
    }



    //HTMLエディタの設定
    $scope.tinymceOptions = {
        mode : "exact",
        menubar: " ",
        plugins: "textcolor advlist autolink autoresize charmap code link ",
        toolbar: "undo redo  | forecolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link ",
    };
});

NetCommonsApp.controller('Announcements.setting', function($scope , $http) {

    $scope.getPluginName = function(n){

    }
});