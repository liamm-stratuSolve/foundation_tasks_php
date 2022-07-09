function loadAllPeople() {
    $.ajax({
        url : 'foundation_task_7.php',
        type : 'GET',
        success : function (result) {
            generateTable(result);
        },
        error : function () {
            console.log ('error');
        }
    })

    loadPage("GET");
}

function generateTable(responseData) {

    let dataArray = JSON.parse(responseData);

    for (let i = 0; i < dataArray.length; i++) {
        dataArray[i].forEach(person => {
            let firstNameID = "firstName" + i
            let table = "<tr><td id="+firstNameID+">"+person.FirstName+"</td>"+
                "<td>"+person.Surname+"</td>"+
                "<td>"+person.DateOfBirth+"</td>"+
                "<td>"+person.EmailAddress+"</td>"+
                "<td>"+person.Age+"</td>"+
                "<td><button id='deleteBtn' onclick='deletePerson("+firstNameID+")'>Delete</button>"+
                "<button id='updateBtn' onclick='loadPage(\"PUT\")'>Update</button></td></tr>";
            document.getElementById("personTable").innerHTML += table;
        })
    }

}

function loadPage(formType) {
    let createElements = new Elements();

    switch (formType) {
        case "POST":
            createElements.generateDetailsPopup();
            break;

        case "GET":
            break;

        case "PUT":
            break;

        case "DELETE":
            break;

        default:
            console.log("Nothing done");
            break;
    }
}

function generateDeleteAllAlert() {
    const deletePerson = confirm("Are you sure you want to delete all records?");
    if(deletePerson === true){

    }
}

class Elements {

    constructor() {
    }

    createLabel(labelName, labelFor, labelText) {
        let labelElement = document.createElement("label");
        labelElement.setAttribute("for", labelFor);
        labelElement.innerText = labelText;

        return labelElement;
    }

    createInput(inputType, inputID, inputPH, inputName, inputRequired) {
        let inputElement = document.createElement("input");
        inputElement.setAttribute("type", inputType);
        inputElement.setAttribute("id", inputID);
        inputElement.setAttribute("placeholder", inputPH);
        inputElement.setAttribute("name", inputName);
        inputElement.setAttribute("required", inputRequired);

        return inputElement;
    }

    createButton(buttonType, buttonName, onClick) {
        let buttonElement = document.createElement("button");
        buttonElement.setAttribute("type", buttonType);
        buttonElement.setAttribute("onclick", onClick);
        buttonElement.innerText = buttonName;

        return buttonElement;
    }

    createDiv(divID, divClass) {
        let divElement = document.createElement("div");
        divElement.setAttribute("id", divID);
        divElement.setAttribute("class", divClass);

        return divID;
    }

    createForm(formID, formFields) {
        let formElement = document.createElement("form");
        formElement.setAttribute("id", formID);

        formFields.forEach(field => {
            formElement.appendChild(field)
        });

        return formElement;
    }

    generateDetailsPopup() {

        let divPopup = this.createDiv("popup");
        let divContainer = this.createDiv("popupContainer");
        let formContainer = this.createForm("formContainer");
        let firstNameLbl = this.createLabel("fNameLbl", "FirstName", "First Name: ");
        let firstName = this.createInput("text", "FirstName", "First Name", "FirstName", true);
        let lastNameLbl = this.createLabel("lNameLbl", "Surname", "Last Name: ");
        let lastName = this.createInput("text", "Surname", "Surname", "Surname", true);
        let dobLbl = this.createLabel("dobLbl", "DateOfBirth", "Date of Birth: ");
        let dateOfBirth = this.createInput("date", "DateOfBirth", "Birthdate", "DateOfBirth", true);
        let emailAddLbl = this.createLabel("emailAddLbl", "EmailAddress", "Email Address: ");
        let emailAddress = this.createInput("text", "FirstName", "Email Address", "EmailAddress", true);
        let submitButton = this.createButton("submit", "Submit", );

        formContainer.appendChild(firstNameLbl);
        formContainer.appendChild(firstName);
        formContainer.appendChild(lastNameLbl);
        formContainer.appendChild(lastName);
        formContainer.appendChild(dobLbl);
        formContainer.appendChild(dateOfBirth);
        formContainer.appendChild(emailAddLbl);
        formContainer.appendChild(emailAddress);
        formContainer.appendChild(submitButton);
        divContainer.appendChild(formContainer);
        divPopup.appendChild(divContainer);

        return divPopup;
    }

    displayData
}