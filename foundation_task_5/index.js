function postMethod() {
    const inputNumber = document.getElementById("inputValue").value;

    let options = {
        method: "POST",
        header: {"Content-Type": "application/json"},
        body: JSON.stringify({"input": inputNumber})
    };

    fetch("./fibonacci_sequence.php", options)
        .then(response => response.json())
        .then(json => buildOutput(json))
        .catch(error => console.log("Error: " + error));
}

function buildOutput(dataJson){
    let root = document.getElementById("root");

    let resultOutput = document.createElement("p");
    resultOutput.id = "root-output";
    resultOutput.innerText = dataJson;

    root.appendChild(resultOutput);
}