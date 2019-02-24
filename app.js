const app = angular.module('MyApp', []);
app.controller('PeopleController', ['$http', function($http){
    this.index = function(){
        $http({
            url:'/people',
            method:'GET'
        }).then((response)=>{
            this.people = response.data;
        });
    }
    this.create = function(){
        $http({
            url:'/people',
            method:'POST',
            data: {
                name:this.newPersonName,
                age:this.newPersonAge
            }
        }).then((response)=>{
            this.index();
        });
    }
    this.edit = function(id){
        $http({
            url:'/people/'+id,
            method:'PUT',
            data: {
                name:this.editedPersonName,
                age:this.editedPersonAge
            }
        }).then((response)=>{
            this.index();
        });
    }
    this.delete = function(id){
        $http({
            url:'/people/'+id,
            method:'DELETE'
        }).then((response)=>{
            this.index();
        });

    }
    this.index();
}])
