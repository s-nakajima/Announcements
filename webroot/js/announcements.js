
NetCommonsApp.controller('Announcements.edit', function($scope , $http) {
    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.type = null;
    $scope.geturl = "announcements/announcements/get_edit_form/";
    $scope.posturl = "announcements/announcements/post/";
    $scope.debug = null;
    $scope.tinymceModel = null;
    $scope.post = function(type , frameId , blockId){

        $scope.frameId = frameId;
        $scope.blockId = blockId;
        $scope.type    = type;

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
                    'data[AnnouncementDatum][blockId]' : $scope.blockId
                };



                $.ajax({
                    method:'POST' ,
                    url: $scope.posturl + $scope.frameId,
                    data: post_params,
                    success:function(data, status, headers, config){
                        $scope.debug = data;
                    },
                    error:function(){
                        $scope.debug = "error";
                    }
                });












            })
            .error(function(data, status, headers, config) {
                $scope.debug = "error1";
                alert("NG");
            });
    }



    $scope.getForm = function($scope , $http){

    }
});