function gettwistword(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById('ansrack').innerHTML = myObj.rack;
            document.getElementById('r3').innerHTML = myObj.counts[0];
            document.getElementById('r4').innerHTML = myObj.counts[1];
            document.getElementById('r5').innerHTML = myObj.counts[2];
            document.getElementById('r6').innerHTML = myObj.counts[3];
            document.getElementById('r7').innerHTML = myObj.counts[4];
        }
    };
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php", true);
    xhr.send();
};

function validate(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById('ansrack').innerHTML = myObj.rack;
            
        }
    };
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php", true);
    xhr.send();
    
    //code to check if game over
};


document.getElementById('reset').addEventListener('click', gettwistword);

//document.getElementById('check').addEventListener('click', validate);