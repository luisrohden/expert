document.addEventListener('DOMContentLoaded', function () {
	document.querySelector('#addItem').addEventListener('click',function(event){
		itemsControl.add();		
	},false);
	document.querySelector('#removeItem').addEventListener('click',function(event){
		itemsControl.remove();		
		
	},false);
	document.querySelector('.addToCart .qtd').addEventListener('change',function(){
		itemsControl.update();		
	},false);
}, false);

const itemsControl = {
	add : function(){

		var actual = document.querySelector(".addToCart .qtd").value;
		actual = parseInt(actual) + 1;
		console.log('clic+' +  actual);
		document.querySelector(".addToCart .qtd").value = actual;
		this.update();
	},
	remove : function (){
		var actual = document.querySelector(".addToCart .qtd").value;
		actual = parseInt(actual) - 1;
		if(actual < 1) actual = 1;
		document.querySelector(".addToCart input").value = actual;
		this.update();

	},
	update : function(){
		var actual = parseInt(document.querySelector(".addToCart .qtd").value);
		var itemprice = parseFloat(document.querySelector(".addToCart .total").dataset.itemprice);
		total = actual * itemprice;
		document.querySelector(".addToCart .total strong").innerHTML = total.toFixed(2);
		

	}

}
