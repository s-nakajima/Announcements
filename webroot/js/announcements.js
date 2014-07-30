/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */
NetCommonsApp.controller('Announcements.edit', function($scope , $http, $sce) {
    var pluginsUrl = '/announcements/announcements/';
	$scope.show = false;
    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.langId = 2; //デェフォルト日本語
    $scope.dataId = 0;
    $scope.geturl =  pluginsUrl + "get_edit_form/";
    $scope.posturl = pluginsUrl + "edit/";

    /**
     * debug
     * @type {null}
     */
    $scope.debug = null;

    /**
     * HTMLエディタ用データ
     *
     * @type {null}
     */
    $scope.tinymceModel = null;

    /**
     * ステータスコード
     * @type {{Publish: number, PublishRequest: number, Draft: number, Reject: number}}
     */
    $scope.statusList = {
        'Publish' : 1,
        'PublishRequest' : 2,
        'Draft' : 3,
        'Reject' : 4
    };

    /**
     * 表示制御設定
     * @type {{default: boolean, edit: {preview: boolean, html: boolean, text: boolean, body: boolean}}}
     */
    $scope.View = {
        'default' : true,
        'edit' : {
            'preview' : false,
            'html' : false,
            'text' : false,
            'body' : false
        }
    };

    /**
     * プレビューのhtmlデータ
     * $scope.View.previewとまとめるか検討する。
     *
     * @type {{html: null}}
     */
    $scope.Preview = {
        'html' : null
    };

    /**
     * 記事の状態設定
     * ラベルとボタンの表示制御 : お知らせの状態の格納
     *
     * @type {{publish: boolean, draft: boolean, request: boolean, reject: boolean}}
     */
   $scope.label = {
       'publish' : false,
       'draft' : false,
       'request' : false,
       'reject' : false
   };

    /**
     * テキストエディタ用データ
     *
     * @type {string}
     */
    $scope.textEditorModel = '';

    /**
     * 記事最新の格納DOM
     * @type {string}
     */
    var draftTag = '';

    /**
     * 送信完了メッセージ用DOM
     * @type {string}
     */
    var messageTag = '';

    /**
     * ブロック設定用DOM
     *
     * @type {string}
     */
    var blockSettingTag = '';

    /**
     * 送信のロック設定
     *
     * @type {boolean}
     */
    $scope.sendRock =  false;

    //初期値設定 ng-initで指定
    $scope.setInit = function (frameId, blockId, langId) {
      $scope.frameId = frameId;
      $scope.blockId = blockId;
      $scope.langId = langId;
    }

    /**
     * 編集画面を閉じる
     *
     * @param {int} frameId
     */
    $scope.closeForm = function(frameId){
        //set
        $scope.setId(frameId);
        //プレビューも閉じる
        $scope.closePreview(frameId);
        //編集全体 OFF
        $scope.View.edit.body = false;
        //標準表示ON
        $scope.View.default = true;
        //メッセージ非表示
        $scope.postAlertClose();

    }

    /**
     * 編集画面を表示させる
     *
     * @param {int} frameId
     */
    $scope.getEditor = function(frameId){
        $scope.setId(frameId);
        $scope.View.default = false;
        $scope.View.edit.html = true;
        $scope.View.edit.body = true;
        //表示内容をエディターに反映 公開とは別に最新のドラフトが会った場合そちらが表示される。
        $scope.tinymceModel = $(draftTag).html();
        //メッセージ非表示
        //$scope.postAlertClose();
        $scope.PostMessage = {
            'view' : false,
            'message' : '',
            'class' : 'alert alert-success'
        };
    }

    /**
     * メッセージ（実行結果）を表示
     *
     * @param {string} alertType
     * @param {string} text
     */
    $scope.postAlert = function(alertType , text){
        $scope.PostMessage.view = true;
        $scope.PostMessage.message = text;

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

    /**
     * 送信完了メッセージを非表示の状態にする。
     *
     * @param {int} frameId
     */
    $scope.postAlertClose = function(frameId){
        $scope.setId(frameId);
        $(messageTag).addClass("hidden");
        $(messageTag + " .message").html("");
    }

    /**
     * idのセット
     *
     * @param {int} frameId
     */
    $scope.setId = function(frameId){
        $scope.frameId = frameId;
        draftTag = '#nc-announcement-content-draft-' + $scope.frameId;
        messageTag = '#nc-announcements-mss-' + $scope.frameId;
        blockSettingTag = '#nc-announcements-block-setting-' + $scope.frameId;
    }

    /**
     * プレビューの表示
     *
     * @param {int} frameId
     */
    $scope.showPreview = function(frameId){
        //本記事を隠す
        $scope.setId(frameId);
        //previewにコードを格納する
        //scriptタグを除去し、格納
        //textの状態でpostされた場合は、格納しなおす。
        if($scope.View.edit.text){
            $scope.tinymceModel = $scope.textEditorModel;
        }
		$scope.tinymceModel = $scope.tinymceModel.replace(/<script(.*)script>/gi , '');
        $scope.Preview.html = $sce.trustAsHtml($scope.tinymceModel);
        $scope.View.edit.preview = true;
        $scope.View.edit.html = false;
        $scope.View.edit.text = false;
        $scope.View.default = false;
        $scope.$apply();
    }

    /**
     * プレビューを閉じる
     *
     * @param {int} frameId
     */
    $scope.closePreview = function(frameId){
        $scope.setId(frameId);
        $scope.View.edit.preview = false;
        $scope.View.edit.html = true;
        $scope.Preview.html = ''; //プレビューの中身をclear
        $scope.$apply();
    }

    /**
     * お知らせの内容を送信する。
     *
     * @param {string} type
     * @param {int} frameId
     * @returns {boolean}
     */
    $scope.post = function(type , frameId){
        //送信中のため、処理せず
        if($scope.sendRock) {
            return false;
        }
        $("button").fadeTo(100, 0.3);
        $('button').attr("disabled", "disabled");

        //textの状態でpostされた場合は、格納しなおす。
        if($scope.View.edit.text){
            $scope.tinymceModel = $scope.textEditorModel;
        }

        //送信をロックする。
        $scope.sendRock = true;
        //idセット
        $scope.setId(frameId);
        if(type == 'Publish'
            && $(draftTag).html()
            && ! $scope.tinymceModel
        ) {
            $scope.tinymceModel = $(draftTag).html();
			$scope.tinymceModel = $scope.tinymceModel.replace(/<script(.*)script>/gi , '');
        }

        //form
        $http({method: 'GET', url: $scope.geturl + $scope.frameId + '/' + Math.random()})
            .success(function(data, status, headers, config) {
                //set
                $("#nc-announcements-post-"+ $scope.frameId).html(data);
                var post_data_form = "#nc-announcements-data-"+ $scope.frameId;
                var post_params = {
                    'data[_Token][fields]' : $(post_data_form + " input[name='data[_Token][fields]']").val(),
                    'data[_Token][key]' : $(post_data_form + " input[name='data[_Token][key]']").val(),
                    '_method' : $(post_data_form + " input[name='_method']").val(),
                    'data[_Token][unlocked]' : $(post_data_form + " input[name='data[_Token][unlocked]']").val(),
                    'data[AnnouncementDatum][content]' : encodeURIComponent($scope.tinymceModel),
                    'data[AnnouncementDatum][frameId]' : $scope.frameId,
                    'data[AnnouncementDatum][blockId]' : $scope.blockId,
                    'data[AnnouncementDatum][type]'    : type,
                    'data[AnnouncementDatum][langId]'  : $scope.langId,
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
        $scope.sendRock = false;
        //defaultに戻す
		$("button").fadeTo(3000, 1);
		$('button').removeAttr("disabled");
		$scope.setViewdDefault();
    }

    /**
     * Viewの設定を標準値に戻す
     */
    $scope.setViewdDefault = function () {
        $scope.View = {
            'default' : true,
            'edit' : {
                'preview' : false,
                'html' : false,
                'text' : false,
                'body' : false
            }
        };
    }

    /**
     * ラベル(状態）をすべてfalseにする。
     */
    $scope.labelClear = function (){
        $scope.label.publish = false;
        $scope.label.draft = false;
        $scope.label.publish = false;
        $scope.label.draft = false;
        $scope.label.request = false;
        $scope.label.reject = false;
    }

    /**
     * 最新の情報にいれかえる。
     *
     * @param json
     */
    $scope.setIndex = function(json){
       //最新
        var content = '';
        var statusId = 0;
        if(json.data && json.data.AnnouncementDatum.content) {
            content = decodeURIComponent(json.data.AnnouncementDatum.content);
            statusId = json.data.AnnouncementDatum.status_id;
        }
        //ラベル - クリア初期値に戻す
        $scope.labelClear();
        //入れ替え : 初期値
		$scope.textEditorModel = $sce.trustAsHtml(content);
        $('#announcement-content-view-' + $scope.frameId).html(content);
        $(draftTag).html(content);
        if(statusId == $scope.statusList.Draft) {
            //下書き
            $scope.label.draft = true;
        } else if (statusId == $scope.statusList.Publish) {
            //公開中 //ラベル変更
            $scope.label.publish = true;
        }else if(statusId == $scope.statusList.PublishRequest){
            //申請中 //ラベルの変更
            $scope.label.request = true;
        }
        else if(statusId == $scope.statusList.Reject){
            //差し戻し
            $scope.label.reject = true;
        }

        $scope.blockId = json.data.AnnouncementFrame.block_id;
        //完了メッセージを表示
        $scope.postAlert("success" , json.message);
        //編集フォームを閉じる
        $scope.closeForm($scope.frameId);
        //ラベル表示等ng-show, ng-hideへの反映
        $scope.$apply();
    }

    /**
     * TEXT editor open
     *
     * @param {int} frameId
     */
    $scope.openTextEditor = function(frameId) {
        //モーダルのためidで対応中。
        $scope.setId(frameId);
        //変更があったなら、<scriptタグの除去
        if ($scope.textEditorModel != $scope.tinymceModel) {
            $scope.tinymceModel = $sce.trustAsHtml($scope.tinymceModel.replace(/<script(.*)script>/gi , ''));
        }
        $scope.textEditorModel = $scope.tinymceModel;
        $scope.View.edit.html=false;
        $scope.View.edit.text=true;
        $scope.View.edit.preview = false;
        $scope.View.default = false;
        $scope.$apply();
    }

    /**
     * TEXTエディタ close データの受け渡しのみ
     * これも、tinymceのcodeでレスポンシブ対応が出来次第消去の予定
     *
     * @param {int} frameId
     */
    $scope.closeTextEditor = function(frameId) {
        $scope.setId(frameId);
        if ($scope.textEditorModel != $scope.tinymceModel) {
            $scope.textEditorModel = $scope.textEditorModel.replace(/<script(.*)script>/gi , '');
        }
        $scope.tinymceModel = $scope.textEditorModel;
        $scope.View.edit.html=true;
        $scope.View.edit.text=false;
        $scope.$apply();
    }

    /**
     * ブロック設定のモーダルを表示させる。
     *
     * @param {int} frameId
     */
    $scope.openBlockSetting = function(frameId){
        $scope.setId(frameId);
        $("#nc-block-setting-"+ $scope.frameId).modal("show");
    }
});

/**
 * block setting用controller
 */
NetCommonsApp.controller('Announcements.setting', function($scope , $http) {
    $scope.setId = function (frameId) {
        $scope.frameId = frameId;
        blockSettingGetFormTag = 'announcements-setting-get-edit-form-'; + $scope.frameId;
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
        var idTag = '#nc-announcements-'+ type +'-frame-'+ flameId + '-part-';
        var baseH = $scope.getHierarchy(partId).hierarchy;
        var checkedFlg = $(idTag + partId+":checked").val();
        while(con < $scope.roomParts.length) {
            var changeTag = idTag + $scope.roomParts[con].id;
            if(checkedFlg){
                if($scope.roomParts[con].hierarchy >= baseH) {
                    $(changeTag).prop('checked', true);
                } else {
                    $(changeTag).prop('checked', false);
                }
            }
            else{
                //チェックボックスOFF
                if($scope.roomParts[con].hierarchy <= baseH) {
                    $(changeTag).prop('checked', false);
                }
            }
            con ++;
        }
    }

    /**
     * 設定の更新 post処理分岐
     *
     * @param {string} type 送信するタイプ
     * @param {int} frameId frames.id
     * @param {int} blockId blocks.id
     * @param {int} langId languages.id
     */
    $scope.partSend = function(type, frameId, blockId, langId) {
        //すべてのボタンを無効に。 //ちょっと乱暴すぎるのであとで範囲指定。
        $('input').attr("disabled", "disabled");
        $("button").fadeTo(1000, 0.3);
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

    /**
     * 更新処理 :公開権限の編集
     *
     * @param {int} frameId
     * @param {int} blockId
     */
    $scope.postToPublishPart = function(frameId, blockId) {
        var setFormTag = '#nc-announcements-block-setting-get-edit-form-' + frameId;
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
                   var t = '#nc-announcements_publish_frame_'
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

    /**
     * 更新処理 :編集権限の編集
     *
     * @param {int} frameId
     * @param {int} blockId
     */
    $scope.postSendToEditPart = function(frameId, blockId) {

        var setFormTag = '#nc-announcements-block-setting-get-edit-form-' + frameId;
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
                    var t = '#nc-announcements-edit-frame_'
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
                        alert("error");
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

    /**
     * 更新処理 :公開申請通知の編集
     *
     * @param {int} frameId
     * @param {int} blockId
     * @param {int} langId
     */
    $scope.postSendToPublishMessage = function(frameId, blockId, langId) {
        var viewFormTag = '#nc-announcements-block-setting-request-' + frameId;
        var setFormTag = '#nc-announcements-block-setting-get-edit-form-' + frameId;
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
                        alert("保存しました");
                        //alert(json.message);
                        $("button").fadeTo(100, 1);
                    }
                });
            })
            .error(
            function(data, status, headers, config) {
                alert("保存しました");
                //alert(data);
                $("button").fadeTo(100, 1);
            });
    }

    /**
     * 更新処理 : 記事変更通知の編集
     *
     * @param {int} frameId
     * @param {int} blockId
     * @param {int} langId
     */
    $scope.postSendToUpdateMessage = function(frameId, blockId, langId) {
        var viewFormTag = '#nc-announcements-block-setting-update-' + frameId;
        var setFormTag = '#nc-announcements-block-setting-get-edit-form-' + frameId;
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

