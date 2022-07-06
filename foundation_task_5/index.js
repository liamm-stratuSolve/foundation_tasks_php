function postMethod() {
    const inputNumber = document.getElementById("inputValue").value;

    let options = {
        method: "POST",
        header: {"Content-Type": "application/json"},
        body: JSON.stringify({"input": inputNumber})
    };

    console.log(options.body);

    fetch("./fibonacci_sequence.php", options)
        .then(response => buildOutput(response.json))
        .then(response => console.log(response.json))
        .then(json => console.log(json))
        .catch(error => console.log("Error: " + error));
}

function buildOutput(dataJson){
    let outputString = JSON.stringify(dataJson);
    let root = document.getElementById("root");

    let resultOutput = document.createElement("p");
    resultOutput.id = "root-output";
    resultOutput.innerText = dataJson;

    root.appendChild(resultOutput);
}