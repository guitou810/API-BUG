(function() {
    var httpRequest;

    let els = document.getElementsByClassName("trigger");

    Array.from(els).forEach((el) => {        

        el.addEventListener('click', makeRequest)
    });

    function makeRequest(event) {

        let el = event.target
        let li = getClosestLi(el)
        let html_id = li.id
        let id = html_id.replace('bug_', '')

        httpRequest = new XMLHttpRequest();

        if (!httpRequest) {
            alert('Abandon :( Impossible de créer une instance de XMLHTTP');
            return false;
        }
        httpRequest.onreadystatechange = updateBugState;

        var url = 'update/'+id

        httpRequest.open('POST', url);

        httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        httpRequest.setRequestHeader("XMLHttpRequest", true)

        var params = "closed=1"

        httpRequest.send(params);
    }

    function updateBugState() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {

                let json = JSON.parse(httpRequest.responseText);

                console.log(json);

                if(json.success){
                    let id = json.id
                    let html_id = "bug_"+id
                    let bug = document.getElementById(html_id)
                    let p = bug.querySelector("div p.closed")
                    p.innerHTML = 'resolu'
                }

            } else {
                alert('Il y a eu un problème avec la requête.');
            }
        }
    }

    function getClosestLi (elem) {
        while (elem && elem !== document && elem.nodeName != 'LI'){            
            elem = elem.parentNode
        } return elem;
    };



    // Filtre sur les bugs ///////////////////////////////////////


    let filter=document.querySelector(".filters input[type=checkbox]");

    filter.addEventListener('change',requestBugs);

    function requestBugs(e){        

        httpRequest = new XMLHttpRequest();

        httpRequest.onreadystatechange = displayBug;

        let url = (this.checked) ? 'list?closed=false' : 'list';

        httpRequest.open('GET', url);

        httpRequest.setRequestHeader("XMLHttpRequest", true)

        httpRequest.send();

    }

    function displayBug() {

        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            
            if (httpRequest.status === 200) {

                let json = JSON.parse(httpRequest.responseText);

                console.log(json);

                if(json.success){

                    let ul = document.getElementById('bugList');
                    ul.innerHTML = '';

                    json.bugs.forEach((bug)=>{

                        let li = document.createElement('li');

                        li.innerHTML = 
                            `<a href='/bug/show/`+bug.id+`'>`
                                +bug.title+
                            `</a>
                            <p>`+bug.createdAt+`</p>
                            <p class="closed">
                                <a class="trigger" href="#">Non-résolu</a>
                            </p>`
 
                        ul.appendChild(li);

                    })
 
                }

            } else {
                alert('Il y a eu un problème avec la requête.');
            }
        }
    }





    
})();