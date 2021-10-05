function handler(action, id = 0) {
    let idAddition = "";

    if (action === "delete") {
        idAddition = "_"+id;
    }
    let number = document.getElementById(action+"_input"+idAddition).value;
    let form = document.getElementById(action+"_form"+idAddition);
    let messageBox = document.getElementById("message")
    messageBox.innerText = "";
    let parameter = "number";

    if (action === "delete") {
        parameter = "id";
    }
    const request = new XMLHttpRequest();
    const url = "/";
    const params = "action=" + action + "&" + parameter + "=" + number;

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200) {
            let rely = isJson(request.responseText);
            messageBox.innerText = rely.message;
            if (rely.message === undefined) {
                messageBox.innerText  = "Server error";
            }

            if (rely.success === true) {
                messageBox.setAttribute("class", "bg-success bg-gradient text-white p-2 rounded mb-2");

                if (action === "add") {
                    setTimeout(window.location.reload.bind(window.location), 1500);
                }
                else if (action === "delete") {
                    form.parentElement.previousElementSibling.innerText = 1;
                    form.remove();
                }
            }
            else {
                messageBox.setAttribute("class", "bg-danger bg-gradient text-white p-2 rounded mb-2");
            }
        }
        else {
            messageBox.setAttribute("class", "bg-danger bg-gradient text-white p-2 rounded mb-2");
            messageBox.innerText  = "Server error";
        }
    });

    request.send(params);
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return JSON.stringify({"success" : false, "message" : "Server error"});
    }
    return JSON.parse(str);
}