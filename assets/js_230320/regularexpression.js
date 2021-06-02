// (function(){
function Regularexpression(){
}

Regularexpression.prototype.cct = function(value){
  let regex = /^([a-z]{3})([0-9]{4})([a-z]{1})$/i;
  return regex.test(value);
};
