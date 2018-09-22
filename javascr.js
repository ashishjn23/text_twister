var correctw = [];

function gettwistword(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            sessionStorage.setItem("rack",myObj.rack);
            document.getElementById("ans").innerHTML = myObj.ans;
            document.getElementById('ansrack').innerHTML = sessionStorage.getItem("rack");
            document.getElementById('r3').innerHTML = myObj.counts[0];
            document.getElementById('r4').innerHTML = myObj.counts[1];
            document.getElementById('r5').innerHTML = myObj.counts[2];
            document.getElementById('r6').innerHTML = myObj.counts[3];
            document.getElementById('r7').innerHTML = myObj.counts[4];
        }else if(this.readyState == 0 || this.readyState == 1 || this.readyState == 2 || this.readyState == 3){
            document.getElementById('ansrack').innerHTML = "Loading...";
        }
    };
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php?q=start", true);
    xhr.send();
    document.getElementById('result').innerHTML = "";
    document.getElementById("check").disabled = false;
    document.getElementById("wordhere").innerHTML = "";
    correctw = [];
};

   
function validate(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById('result').innerHTML = myObj.res;
            if( myObj.res == "Correct"){
                document.getElementById('r3').innerHTML = myObj.ctr3;
                document.getElementById('r4').innerHTML = myObj.ctr4;
                document.getElementById('r5').innerHTML = myObj.ctr5;
                document.getElementById('r6').innerHTML = myObj.ctr6;
                document.getElementById('r7').innerHTML = myObj.ctr7;

                var corword = document.getElementById("input1").value;
    
                correctw.push(corword);
                
                for (var i = 0; i < correctw.length; i++){
                    document.querySelector('#wordhere').innerHTML += `<li>${correctw[i]}</li>`; 
                }
                 
                if( ( myObj.ctr3 + myObj.ctr4 + myObj.ctr5 + myObj.ctr6 + myObj.ctr7 ) == 0){
                    document.getElementById('result').innerHTML = "Game Over! Congratulations you won!"
                    document.getElementById("check").disabled = true;
                }
            
        }
        }else if(this.readyState == 0 || this.readyState == 1 || this.readyState == 2 || this.readyState == 3){
            document.getElementById('result').innerHTML = "Loading...";
        }
    };
    var userinput =  document.getElementById("input1").value;
    var rack = sessionStorage.getItem("rack");
    var str = "https://text-twister-ashishjn23.c9users.io/get_anagrams.php?q=validate&r=" + userinput + "&s=" + rack;
    xhr.open("GET", str , true);
    xhr.send();

  
};

function twist(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById('ansrack').innerHTML = myObj;
        }
    }
    var rack = sessionStorage.getItem("rack");
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php?q=shuffle&s=" + rack, true);
    xhr.send();
};


document.getElementById('reset').addEventListener('click', gettwistword);

document.getElementById('check').addEventListener('click', validate);

document.getElementById('twist').addEventListener('click', twist);