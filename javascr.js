function gettwistword(){
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('answords').innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "https://text-twister-ashishjn23.c9users.io/get_anagrams.php");
    xhr.send();
    //document.write("ashish");
};

document.getElementById('ajax').addEventListener('click', gettwistword);