var app = angular.module('scheduler', []);
app.controller("SimpleController", function($scope, $http, $timeout){
	$scope.values = [];
	$scope.alreadyAddedClasses = [];
	$scope.selection = [];
	$scope.majors = [];
	$scope.names = [];
	
	$http.post('getMajors.php')
	.success(function(response) {$scope.majors = response; var object = ["nothing"]; $scope.majors.push(object);});
	$( "#add-button" ).click(function() {
		var selectedClasses = $('#class-select-list').val();
		for(var x in selectedClasses){
			if(!$scope.checkArray(selectedClasses[x], $scope.values)) {
				$scope.values.push(selectedClasses[x]);
				$scope.values.sort();
			}
			else {
				$scope.classAlreadyAdded(selectedClasses[x]);
			}
		}
		$scope.$apply();
	});
	$( "#schedule-button" ).click(function() {
		var classesForSchedule = JSON.stringify($scope.selection);
		$scope.postNewWindow("../../queries/test.php", classesForSchedule);
		/*$.ajax({
		type: "POST",
		url: "project2.php",
		data: {tableData:classesForSchedule},
		success: function(result){}
		});*/
	});
	$scope.postNewWindow = function(path, params) {
		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", path);
		form.setAttribute("target", "_blank");
		var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "tableData");
		hiddenField.setAttribute("value", params);
		form.appendChild(hiddenField);
		document.body.appendChild(form);
    form.submit();
	};
	$scope.getClassesByMajor = function (major) {
		$.ajax({
		type: "POST",
		url: "getClassesByMajor.php",
		data: {major:major},
		success: function(result){$scope.names = JSON.parse(result); $scope.$apply();}
		});
	};
	$scope.toggleSelection = function toggleSelection(className) {
    var idx = $scope.selection.indexOf(className);
    if (idx > -1) {
      $scope.selection.splice(idx, 1);
    }
    else {
      $scope.selection.push(className);
    }
  };
	$scope.deleteClasses = function() {
		var noWSClassToDelete = "";
		var compareString = "";
		for(var i in $scope.selection) {
			noWSClassToDelete = $scope.selection[i].replace(/\s/g, '');
			for (j in $scope.values) {
				compareString = $scope.values[j].replace(/\s/g, '');
				if(compareString==noWSClassToDelete) {
					$scope.values.splice(j, 1);
				}
			}	
		}
		$scope.selection = [];
	};
	$scope.classAlreadyAdded = function(className) {
		var found = false;
		if(!$scope.checkArray(className, $scope.alreadyAddedClasses)) {
			$scope.alreadyAddedClasses.push(className);
			$timeout(function(){$scope.alreadyAddedClasses = []}, 3000);
		}
	};
	$scope.selectAll = function() {
		for(var i in $scope.values) {
			if(!$scope.checkArray($scope.values[i], $scope.selection)) {
				$scope.selection.push($scope.values[i]);
				
			}
		}
	};
	$scope.checkArray = function(value, array) {
		var found = false;
		for(var i in array){
			if(array[i].replace(/\s/g, '') == value.replace(/\s/g, '')) {
				
				found = true;
			}
		}
		return found;
	};
});