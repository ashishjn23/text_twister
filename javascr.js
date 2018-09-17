function gettwistword(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            sessionStorage.setItem("rack",myObj.rack);
            document.getElementById('ansrack').innerHTML = sessionStorage.getItem("rack");
            document.getElementById('ans').innerHTML = myObj.ans;
            sessionStorage.setItem("ctr3",myObj.counts[0]);
            document.getElementById('r3').innerHTML = sessionStorage.getItem("ctr3");
            sessionStorage.setItem("ctr4",myObj.counts[1]);
            document.getElementById('r4').innerHTML = sessionStorage.getItem("ctr4");
            sessionStorage.setItem("ctr5",myObj.counts[2]);
            document.getElementById('r5').innerHTML = sessionStorage.getItem("ctr5");
            sessionStorage.setItem("ctr6",myObj.counts[3]);
            document.getElementById('r6').innerHTML = sessionStorage.getItem("ctr6");
            sessionStorage.setItem("ctr7",myObj.counts[4]);
            document.getElementById('r7').innerHTML = sessionStorage.getItem("ctr7");
        }else if(this.readyState == 0 || this.readyState == 1 || this.readyState == 2 || this.readyState == 3){
            document.getElementById('ansrack').innerHTML = "Loading...";
        }
    };
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php?q=start", true);
    xhr.send();
};

function validate(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById('result').innerHTML = myObj;
            if( myObj == "Correct"){
            //var ctr = document.getElementById('r' + userinput.length).value;
            sessionStorage.setItem("ctr" + userinput.length, Number(sessionStorage.getItem("ctr" + userinput.length)) - 1);
            document.getElementById('r' + userinput.length).innerHTML = sessionStorage.getItem("ctr" + userinput.length);
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
    //code to check if game over
};


document.getElementById('reset').addEventListener('click', gettwistword);

document.getElementById('check').addEventListener('click', validate);