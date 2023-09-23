
function top5(){
    alert("hi");
    let xhr = new XMLHttpRequest();
    xhr.addEventListener("load", sent);
    xhr.responseType = "json";
    let name = "name=" + encodeURIComponent("top5");
    xhr.open("GET", "SQLRUN.php?" + name);
    xhr.send();
  }
  
  function movied(){
    let xhr = new XMLHttpRequest();
    xhr.addEventListener("load", sent);
    xhr.responseType = "json";
    let name = "name=" + encodeURIComponent("md");
    xhr.open("GET", "SQLRUN.php?" + name);
    xhr.send();
  }
  
  function actors(){
    let xhr = new XMLHttpRequest();
    xhr.addEventListener("load", sent);
    xhr.responseType = "json";
    let name = "name=" + encodeURIComponent("act");
    xhr.open("GET", "SQLRUN.php?" + name);
    xhr.send();
  }
  
  function actord(){
  let xhr = new XMLHttpRequest();
  xhr.addEventListener("load", sent);
  xhr.responseType = "json";
  let name = "name=" + encodeURIComponent("actd");
  xhr.open("GET", "SQLRUN.php?" + name);
  xhr.send();
  }
  
  function sent(){
  if (this.status === 200) {
    let response = this.response;
    if(response[0]){   
    document.getElementById("results").value = response[1];
  }else{
  document.getElementById("results").value = response[1];
  }
  } else {
    document.getElementById("results").value = "Error reaching server";
  }
  }
  
  var button4 =document.getElementById("5movies");
  button4.addEventListener("click", top5);
  
  var button5 =document.getElementById("moviedetails");
  button5.addEventListener("click", movied);
  
  var button6 =document.getElementById("actors");
  button6.addEventListener("click", actors);
  
  var button7 =document.getElementById("actordetails");
  button7.addEventListener("click", actord);
