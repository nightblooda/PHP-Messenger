<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
 
  <title>Messanger</title>
</head>
<body onload= "checkcookie(); update();">
  <div id= 'whitebg'></div>
  <div id= 'loginbox'>
    <h1>Pick a username:</h1>
    <p><input type= 'text' name= 'pickusername' id= 'cusername' placeholder= 'Pick a username' class= 'msginput'></p>
    <p class= 'buttonp'><button onclick= 'chooseusername()'>Choose username</button></p>
  </div>
  <div class= 'msg-container'>
    <div class= 'header'>Messenger</div>
    <div class= 'msg-area' id= 'msg-area'></div>
    <div class= 'bottom'><input type= 'text' name= 'msginput' class= 'msginput' id= 'msginput' onkeydown= "if(event.keyCode== 13) sendmsg()" value= "" placeholder= "Enter your message here ... (Press enter to send message)">
    </div>
  </div>

<script type= 'text/javascript'>
    var msginput= document.getElementById('msginput');
    var msgarea= document.getElementById('msg-area');

    function showLogin(){
      document.getElementById("whitebg").style.display= "inline-block";
      document.getElementById("loginbox").style.display= 'inline-block';
    }

    function hideLogin(){
      document.getElementById("whitebg").style.display= "none";
      document.getElementById("loginbox").style.display= 'none';
    }

    function chooseusername(){
      var user= document.getElementById('cusername').value;
      document.cookie= "messengerUname=" + user;
      checkcookie();
    }

    function checkcookie(){
      if(document.cookie.indexOf("messengerUname")== -1){
        showLogin();
      }else{
        hideLogin();
      }
    }

    function getcookie(cname){
      var name= cname + "=";
      var ca= document.cookie.split(';');
      for(var i= 0; i< ca.length; i++){
        var c= ca[i];
        while(c.charAt(0)== ' ') c= c.substring(1);
        if(c.indexOf(name)== 0){
          return c.substring(name.length, c.length);
        }
      }
      return "not comming";
    }

    function update(){
      var xmlhttp= new XMLHttpRequest();
      var username= getcookie("messengerUname");
      var output= "";
      
      xmlhttp.onreadystatechange= function(){
          if(xmlhttp.readyState== 4 && xmlhttp.status==200){
            var response= xmlhttp.responseText.split("\n");
            var rl= response.length;
            var item= "";
            
            for(var i= 0; i< rl; i++){
              item= response[i].split("\\");
              if(item[1]!= undefined){
                if(item[0]== username){
                  output+="<div style= \"margin-bottom: 30px;background: blue; padding: 10px; width: 500px;\">"+ item[1]+"Sent by "+item[0]+ "</div>";
                }else{
                  output+= "<div style= \"margin-bottom: 30px;background: green; padding: 10px;width: 500px;\">"+ item[1]+"Sent by "+item[0]+ "</div>";
                }
              }
            }

            msgarea.innerHTML= output;
            msgarea.scrollTop= msgarea.scrollHeight;
          }
        }
        xmlhttp.open('GET', "get-messages.php?username="+username, true);
        xmlhttp.send();

    }
    
    function sendmsg(){
      var message= msginput.value;
      if(message!= ""){
        var username= getcookie("messengerUname");
        
        var xmlhttp= new XMLHttpRequest();

        xmlhttp.onreadystatechange= function(){
          if(xmlhttp.readyState== 4 && xmlhttp.status==200){
            msgarea.innerHTML+= "<div class\"msgc\" style= \"margin-bottom: 30px;\"><div class= \"msg msgfrom\">" +message +"</div><div class= \"msgarr msgarrfrom\"></div><div class=\"msgsentby\">Sent by " + username + "</div></div>";

            msginput.value= "";
          }
        }
        xmlhttp.open('GET', "update-messages 2.php?username=" + username + "&message=" + message, true);
        xmlhttp.send();
      }
    }

    setInterval(function(){update();}, 2500);

  </script>

</body>


    
 
</html>
