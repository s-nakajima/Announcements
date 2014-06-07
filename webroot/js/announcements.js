angular.module('NetCommonsApp',
    [
        'ui.bootstrap',
        'ui.tinymce'
    ]
).controller('Announcements.edit', function($scope , $http) {
    $scope.pluginsUrl = '/announcements/announcements/';
    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.dataId = 0;
    $scope.geturl =  $scope.pluginsUrl + "get_edit_form/";
    $scope.posturl = $scope.pluginsUrl + "post/";
    $scope.debug = null;
    $scope.tinymceModel = null;
    errorViewTag = "#announcements_mss_";
    $scope.alertMss = null;

    //フォームを閉じる
    $scope.closeForm = function(frameId){
        var editerTag = '#announcements_form_' + frameId;
        var viewerTag = '#announcement_content_view_' + frameId;
        var editerOpenBtnTag = '#announcement_content_edit_btn_' +frameId;
        $(viewerTag).removeClass('hidden');
        $(editerTag).addClass('hidden');
        $(editerOpenBtnTag).removeClass('hidden');
        $scope.postAlertClose();
    }

    //フォームを開く
    $scope.getEditer = function(frameId , blockId){
        $scope.setId(frameId , blockId);
        var editerTag = '#announcements_form_' + frameId;
        var viewerTag = '#announcement_content_view_' + frameId;
        var editerOpenBtnTag = '#announcement_content_edit_btn_' +frameId;
        var draftTag = '#announcement_content_draft_'+ frameId;;
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
    $scope.setId = function(frameId , blockId){
        $scope.frameId = frameId;
        $scope.blockId = blockId;
    }



    //post //todo:非同期通信中のボタン無効化
    $scope.post = function(type , frameId , blockId){
        //idセット
        $scope.setId(frameId , blockId);

        if(type == "Cancel"){
            $scope.closeForm(frameId);
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
                    url: $scope.posturl + $scope.frameId,
                    data: post_params,
                    success:function(data, status, headers, config){
                        if(! data) { data = "success"; }
                        $scope.postAlert("success" , data);
                    },
                    error:function(){
                        if(! data) { data = "ERROR!"; }
                        $scope.postAlert("error" , data);
                    }
                });
            })
            .error(function(data, status, headers, config) {
                //keyの取得に失敗
                if(! data) { data = "ERROR!"; }
                $scope.postAlert("error" , data);
            });


    }

    //公開確認
    $scope.PublishComfirm = function(){
        alert("公開処理前の確認");
    }
    //全ての編集画面一旦非表示
    $(".announcements_editer").addClass('hidden');

});