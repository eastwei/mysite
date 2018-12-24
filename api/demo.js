        function readyAJAX(){
			try {
				return new XMLHttpRequest();
			}catch(e){
				alert("create xmlhttp fail!");
			}
		}

        window.onload = function doAjax(){
	    
		var requestObj = readyAJAX();
		var url = "http://localhost/phpapi/ajax_server.php?isbn=9780735624498";
		requestObj.open("GET",url,true);
		requestObj.send();
		
		requestObj.onreadystatechange = function() {
			if (requestObj.readyState == 4) {
				if (requestObj.status == 200) {
					alert(requestObj.responseText);
				}else{
					alert(requestObj.statusText);
				}
			}
		}
	}


	