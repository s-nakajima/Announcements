/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */
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
    var blockSettingTag = '';
    var sendRock = false;

    $scope.nekoget = null;
    $scope.setNekoget = function(text) {
        alert(text);
        $scope.nekoget = text;
    }

    //フォームを閉じる
    $scope.closeForm = function(frameId){
        //set
        $scope.setId(frameId);
        //プレビューも閉じる
        $scope.closePreview(frameId);
        $(viewerTag).removeClass('hidden');
        $(editerTag).addClass('hidden');
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
            $(messageTag).fadeIn(500).fadeTo(1000, 1).fadeOut(500);
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
        blockSettingTag = '#announcements-block-setting-' + $scope.frameId;
    }

    //プレビューの表示
    $scope.showPreview = function(frameId){
        //本記事を隠す
        $scope.setId(frameId);
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
    $scope.closePreview = function(frameId){
        $scope.setId(frameId);
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
        $(viewerTag).addClass('hidden');

    }

    //エディターの切り替え

    //post //todo:非同期通信中のボタン無効化
    $scope.post = function(type , frameId , blockId, dataId){
        //送信中のため、処理せず
        if(sendRock) {
            return false;
        }
        //送信をロックする。
        sendRock = true;
        //idセット
        $scope.setId(frameId , blockId ,dataId);
        if(type == 'Publish'
            && $(draftTag).html()
            && ! $scope.tinymceModel
        ) {
            $scope.tinymceModel = $(draftTag).html();
        }

        //form
        $http({method: 'GET', url: $scope.geturl+$scope.frameId + '/' + Math.random()})
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
        //送信ロックを解除する
        sendRock = false;
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

/**
 * TEXTエディタ close データの受け渡しのみ
 * これも、tinymceのcodeでレスポンシブ対応が出来次第消去の予定
 *
 * @param {int} frameId
 */
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

/**
 * ブロック設定のモーダルを表示させる。
 *
 * @param {int} frameId
 */
    $scope.openBlockSetting = function(frameId){
        $scope.setId(frameId);
        $("#block-setting-"+ $scope.frameId).modal("show");
    }

    //エディタ非表示
    //$('.announcements-editer').addClass('hidden');
});

/**
 * block setting用controller
 */
NetCommonsApp.controller('Announcements.setting', function($scope , $http) {
    $scope.setId = function (frameId, BlockId) {
        $scope.frameId = frameId;
        $scope.blockId = blockId;
        blockSettingGetFormTag = 'announcements_setting_get_edit_form_'; + $scope.frameId;
    }
/**
 * ヒエラルキーによるチェック状態の制御
 * 共通処理にするべき : 後でがっつり修正する
 * input[name='part_id_']にhitさせるようにしたい。
 *
 * @param {string} type
 * @param {int} flameId
 * @param {int} partId
 */
    $scope.partChange = function(type, flameId, partId) {
        var con = 0;
        var idTag = '#announcements_'+ type +'_frame_'+ flameId + '_part_';
        var baseH = $scope.getHierarchy(partId).hierarchy;
        var checkedFlg = $(idTag + partId+":checked").val();
        while(con < $scope.roomParts.length) {
            var changeTag = idTag + $scope.roomParts[con].id;
            if(checkedFlg){
                //チェックボックスON
                //ヒエラルキーの大きいものはすべてONにする
                if($scope.roomParts[con].hierarchy >= baseH) {
                    $(changeTag).prop('checked', true);
                } else {
                    $(changeTag).prop('checked', false);
                }
            }
            else{
                //チェックボックスOFF
                //ヒエラルキーが小さいものはすべてOFFにする。
                if($scope.roomParts[con].hierarchy <= baseH) {
                    $(changeTag).prop('checked', false);
                }
            }
            con ++;
        }
    }


    //設定の更新 post処理分岐
    $scope.partSend = function(type, frameId, blockId, langId) {
        //すべてのボタンを無効に。 //ちょっと乱暴すぎるのであとで範囲指定。
        $('input').attr("disabled", "disabled");
        $("button").fadeTo(1000, 0.3);
        //$scope.setId(frameId, blockId);
        if (type == "editParts") {
            $scope.postSendToEditPart(frameId, blockId);
        } else if (type == "publishParts") {
            $scope.postToPublishPart(frameId, blockId);
        } else if (type == "publishMessage") {
            $scope.postSendToPublishMessage(frameId, blockId, langId);
        } else if (type == "updateMessage") {
            $scope.postSendToUpdateMessage(frameId, blockId, langId);
        }
        //すべてのボタンを有効に。//ちょっと乱暴すぎるのであとで範囲指定。
        $('input').removeAttr("disabled");

    }
    //更新処理 :公開権限の編集
    $scope.postToPublishPart = function(frameId, blockId) {
        var setFormTag = '#announcements-block-setting-get-edit-form-' + frameId;
        var getFormUrl = '/announcements/announcements_block_setting/get_edit_form/publishParts/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();
        var postFormUrl = '/announcements/announcements_block_setting/edit/publishParts/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();

        //formの取得
        $http({method: 'GET', url: getFormUrl})
            .success(function(data, status, headers, config) {
                var partIdList = "";;
                for(i=0; i < $scope.roomParts.length; i++) {
                   var t = '#announcements_publish_frame_'
                       + frameId
                       + '_part_'
                       + i
                       + ':checked'
                    ;
                    if($(t).val()) {
                        partIdList = partIdList + $(t).val() + ",";
                    }
                }

                $(setFormTag).html(data);
                var post_params = {
                    'data[_Token][fields]' : $(setFormTag + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(setFormTag + " input[name='data[_Token][key]']").val(),
                    '_method' : $(setFormTag + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(setFormTag + " input[name='data[_Token][unlocked]']").val(),
                    'data[frame_id]' : frameId,
                    'data[block_id]' : blockId,
                    'data[part_id]' : partIdList
                 };

                $.ajax({
                    method: 'POST',
                    url: postFormUrl,
                    data: post_params,
                    success: function (json, status, headers, config) {
                        //$(setFormTag).html(json);
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    },
                    error: function (json, status, headers, config) {
                        alert(JSON.stringify(json));
                        $("button").fadeTo(100, 1);
                    }
                });


            })
            .error(
            function(data, status, headers, config) {
                alert(data);
                $("button").fadeTo(100, 1);
            });

            //完了動作

    }
    //更新処理 :編集権限の編集
    $scope.postSendToEditPart = function(frameId, blockId) {

        var setFormTag = '#announcements-block-setting-get-edit-form-' + frameId;
        var getFormUrl = '/announcements/announcements_block_setting/get_edit_form/editParts/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();
        var postFormUrl = '/announcements/announcements_block_setting/edit/editParts/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();

        //formの取得
        $http({method: 'GET', url: getFormUrl})
            .success(function(data, status, headers, config) {
                //part_idを取得
                var partIdList = '';
                for(i=0; i < $scope.roomParts.length; i++) {
                    var t = '#announcements_edit_frame_'
                            + frameId
                            + '_part_'
                            + i
                            + ':checked'
                        ;
                    if($(t).val()) {
                        partIdList = partIdList + $(t).val() + ",";
                    }
                }

                $(setFormTag).html(data);
                var post_params = {
                    'data[_Token][fields]' : $(setFormTag + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(setFormTag + " input[name='data[_Token][key]']").val(),
                    '_method' : $(setFormTag + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(setFormTag + " input[name='data[_Token][unlocked]']").val(),
                    'data[frame_id]' : frameId,
                    'data[block_id]' : blockId,
                    'data[part_id]' : partIdList
                };

                $.ajax({
                    method: 'POST',
                    url: postFormUrl,
                    data: post_params,
                    success: function (json, status, headers, config) {
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    },
                    error: function (json, status, headers, config) {
                        alert(JSON.stringify(json));
                        $("button").fadeTo(100, 1);
                    }
                });
            })
            .error(
            function(data, status, headers, config) {
                alert(data);
                $("button").fadeTo(100, 1);
            });

    }
    //更新処理 :公開申請通知の編集
    $scope.postSendToPublishMessage = function(frameId, blockId, langId) {
        var viewFormTag = '#announcements-block-setting-request-' + frameId;
        var setFormTag = '#announcements-block-setting-get-edit-form-' + frameId;
        var getFormUrl = '/announcements/announcements_block_setting/get_edit_form/publishMessage/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();
        var postFormUrl = '/announcements/announcements_block_setting/edit/publishMessage/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();


        //formの取得
        $http({method: 'GET', url: getFormUrl})
            .success(function(data, status, headers, config) {

                $(setFormTag).html(data);
                var post_params = {
                    'data[_Token][fields]' : $(setFormTag + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(setFormTag + " input[name='data[_Token][key]']").val(),
                    '_method' : $(setFormTag + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(setFormTag + " input[name='data[_Token][unlocked]']").val(),
                    'data[frame_id]' : frameId,
                    'data[block_id]' : blockId,
                    'data[is_send]' :  $(viewFormTag + " input[name='is_send']:checked").val(),
                    'data[language_id]' : langId,
                    'data[subject]' : encodeURIComponent($(viewFormTag + " input[name='subject']").val()),
                    'data[body]' : encodeURIComponent($(viewFormTag + " textarea[name='body']").val())
                };
                $.ajax({
                    method: 'POST',
                    url: postFormUrl,
                    data: post_params,
                    success: function (json, status, headers, config) {
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    },
                    error: function (json, status, headers, config) {
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    }
                });
            })
            .error(
            function(data, status, headers, config) {
                alert(data);
                $("button").fadeTo(100, 1);
            });
    }
    //更新処理 : 記事変更通知の編集
    $scope.postSendToUpdateMessage = function(frameId, blockId, langId) {
        var viewFormTag = '#announcements-block-setting-update-' + frameId;
        var setFormTag = '#announcements-block-setting-get-edit-form-' + frameId;
        var getFormUrl = '/announcements/announcements_block_setting/get_edit_form/updateMessage/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();
        var postFormUrl = '/announcements/announcements_block_setting/edit/updateMessage/'
            + frameId
            + '/'
            + blockId
            + '/'
            + Math.random();
        //formの取得
        $http({method: 'GET', url: getFormUrl})
            .success(function(data, status, headers, config) {
                //partIdを取得 //後で切り出し
                var partIdList = '';
                for(i=0; i < $scope.roomParts.length; i++) {
                    var t = viewFormTag
                            + " input[name='part_id_"+ $scope.roomParts[i].id +"']"
                            + ':checked'
                        ;
                    if($(t).val()) {
                        partIdList = partIdList + $scope.roomParts[i].id + ",";
                    }
                }
                //フォーム仮設置
                $(setFormTag).html(data);
                var post_params = {
                    'data[_Token][fields]' : $(setFormTag + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(setFormTag + " input[name='data[_Token][key]']").val(),
                    '_method' : $(setFormTag + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(setFormTag + " input[name='data[_Token][unlocked]']").val(),
                    'data[frame_id]' : frameId,
                    'data[block_id]' : blockId,
                    'data[is_send]' :  $(viewFormTag + " input[name='is_send']:checked").val(),
                    'data[language_id]' : langId,
                    'data[part_id]' : partIdList,
                    'data[subject]' : encodeURIComponent($(viewFormTag + " input[name='subject']").val()),
                    'data[body]' : encodeURIComponent($(viewFormTag + " textarea[name='body']").val())
                };
                $.ajax({
                    method: 'POST',
                    url: postFormUrl,
                    data: post_params,
                    success: function (json, status, headers, config) {
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    },
                    error: function (json, status, headers, config) {
                        alert(json.message);
                        $("button").fadeTo(100, 1);
                    }
                });
            })
            .error(
            function(data, status, headers, config) {
                alert(data);
                $("button").fadeTo(100, 1);
            });
    }
});