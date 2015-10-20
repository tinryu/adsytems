
app.controller("questionController", function($scope,questiontService){
    $scope.init_List = function(){
        $scope.questions = data
    };
    $scope.del_Item = function(id){
        if(confirm('Xóa question ?')){
            questiontService.deleteItem(id, function(data){
                if(data != "" && data != undefined){
                    $("#question_"+data).remove();
                }
            });
        }
    };
});
app.service('questiontService', function($http){
    this.addItem = function(product){
        $http({
            url    :url_server + 'product/product/add',
            data   :$.param({
                saveProduct:'yes',
                data       :product
            }),
            method :'POST',
            headers:formHeader
        }).success(function(data){
            if(data == true){
                alert(successful_add);
                window.close();
            }else{
                alert(data);
            }
        })
    };
    this.deleteItem = function(id,callback){
        $http({
            url:url_server+'question/delete',
            data:$.param({
                id:id
            }),
            method:'POST',
            headers:formHeader
        }).success(function(data){
            callback(data);
        });
    };
    this.searchItem = function(searchoption, paging, callback){
        $http({
            url    :url_server + 'product/product/loadProduct',
            data   :$.param({
                searchquery:searchoption,
                paging     :paging
            }),
            method :'POST',
            headers:formHeader
        }).success(function(data){
            callback(data);
        });
    };
    this.updateState = function(field, current, id){
        $http({
            url    :url_server + 'product/product/updateState',
            data   :$.param({
                'field'  :field,
                'id'     :id,
                'current':current
            }),
            method :'POST',
            headers:formHeader
        });
    };
    this.paging = function(paging, callback){
        $http({
            url    :url_server + 'product/product/loadProduct',
            data   :$.param({
                paging:paging
            }),
            method :'POST',
            headers:formHeader
        }).success(function(data){
            callback(data);
        })
    };
});
