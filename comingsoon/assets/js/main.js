function selectOnlyThis(id) {
    for (var i = 1;i <= 4; i++){
        if ("Check" + i === id && document.getElementById("Check" + i).checked === true){
            document.getElementById("Check" + i).checked = true;
            } else {
              document.getElementById("Check" + i).checked = false;
            }
    }  
}