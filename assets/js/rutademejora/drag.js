$(document).ready(function () {

});


function Drag(){
   _this = this;
}


 Drag.prototype.all_rows = function(idtable){
 	var matriz=new Array();
 	var contador = 0;
   $("#"+idtable+" tbody tr").each(function (index) {
   		var fila=new Array();
        $(this).children("td").each(function (index2) {
            if($(this).text() !== "" || $(this).text() !== " " || $(this).text() !== null){
            	fila.push($(this).text());
            }
        })
        matriz.push(fila);
    })
   return matriz;
 };

 Drag.prototype.remove_empty = function(vector){
 	var eliminar = false;
 	var posicion = 0;
 	for(var i = 0; i < vector.length; i++){
 		for(var j = 0; j < vector[i].length; j++){
 			if(vector[i][j] == "" || vector[i][j] == " " || vector[i][j] == '' || vector[i][j] == ' ' || vector[i][j] == null){
 				eliminar = true;
 				posicion = i;
 			}
 		}
 	}
 }

 Drag.prototype.sort = function(vector, pos){
 	for(var i = 0; i < vector.length; i++){
 		for(var j = 0; j < vector[i].length; j++){
 			if(j === pos){
 				vector[i][j] = i+1;
 			}
 		}
 	}
 }
