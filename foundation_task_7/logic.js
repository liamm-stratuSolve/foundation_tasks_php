function createPerson() {
    openForm("create");
}

function searchPerson() {
    openForm("search");
}

function deletePerson(personFirstName, personSurname){
    let deleteConfirmation = confirm("Are you sure you want to delete " + personFirstName + " " + personSurname + "?");
    if (deleteConfirmation === true) {
        deletePeople("single", personFirstName, personSurname);
    }
}

function deleteAllPeople(){
    let deleteConfirmation = confirm("Are you sure you want to delete all records?");
    if (deleteConfirmation === true) {
        deletePeople("all");
    }
}

function updatePerson(personFirstName, personSurname) {
    openForm("update", personFirstName, personSurname);
}

function openForm(actionType, personFirstName, personSurname) {
    let createElements = new Elements();
    createElements.generateDetailsForm(actionType, personFirstName, personSurname);
}

function closeForm() {
    let closeElement = document.getElementById("popupContainer");
    closeElement.remove();
}

function generatePersonDetails(){

    const inputForm = document.getElementById("inputForm");
    let personAge = calculateAge(inputForm.elements["inputDateOfBirth"].value);

    return {
        "FirstName" : inputForm.elements["inputFirstName"].value,
        "Surname" : inputForm.elements["inputSurname"].value,
        "DateOfBirth" : inputForm.elements["inputDateOfBirth"].value,
        "EmailAddress" : inputForm.elements["inputEmailAddress"].value,
        "Age" : personAge
    };
}

function calculateAge(birthDate) {
    let today = new Date();
    return new Date(today - new Date(birthDate)).getFullYear() - 1970;
}

function generateTable(responseData) {

    let dataArray = JSON.parse(responseData);

    let personTable = document.getElementById("personTable");

    for (let i = 0; i < dataArray.length; i++) {
        dataArray[i].forEach(person => {
            let table =
                "<tr>"+
                    "<td>"+person.FirstName+"</td>"+
                    "<td>"+person.Surname+"</td>"+
                    "<td>"+person.DateOfBirth+"</td>"+
                    "<td>"+person.EmailAddress+"</td>"+
                    "<td>"+person.Age+"</td>"+
                    "<td><button class='editBtn' onclick='updatePerson(\""+person.FirstName+"\", \""+person.Surname+"\")'>Edit</button>"+
                    "<button class='deleteBtn' onclick='deletePerson(\""+person.FirstName+"\", \""+person.Surname+"\")'>Delete</button>"+
                    "</td>"+
                "</tr>";
            personTable.innerHTML += table;
        })
    }

}

function clearTable(){
    let tableData = document.getElementById("personTable");
    while(tableData.firstChild){
        tableData.removeChild(tableData.firstChild);
    }
}

class Elements {

    constructor() {
    }

    createLabel(labelName, labelFor, labelText) {
        let labelElement = document.createElement("label");
        labelElement.for = labelFor;
        labelElement.innerText = labelText;

        return labelElement;
    }

    createInput(inputType, inputID, inputPH, inputName) {
        let inputElement = document.createElement("input");
        inputElement.type = inputType;
        inputElement.id = inputID;
        inputElement.placeholder = inputPH;
        inputElement.name = inputName;

        return inputElement;
    }

    createButton(buttonType, buttonName, onClick) {
        let buttonElement = document.createElement("button");
        buttonElement.type = buttonType;
        buttonElement.onclick = onClick;
        buttonElement.innerText = buttonName;

        return buttonElement;
    }

    createDiv(divID, divClass) {
        let divElement = document.createElement("div");
        divElement.id = divID;
        divElement.className = divClass;

        return divElement;
    }

    createForm(formID, formClass) {
        let formElement = document.createElement("form");
        formElement.id = formID;
        formElement.className = formClass;

        return formElement;
    }

    generateDetailsForm(actionType, personFirstName, personSurname) {

        let popupContainer = this.createDiv("popupContainer", "popupContainer");
        let divContainer = this.createDiv("formContainer", "formPopup");
        let formContainer = this.createForm("inputForm", "formContainer");
        let firstNameLbl = this.createLabel("fNameLbl", "FirstName", "First Name: ");
        let firstName = this.createInput("text", "inputFirstName", "First Name", "FirstName");
        let lastNameLbl = this.createLabel("lNameLbl", "inputSurname", "Last Name: ");
        let lastName = this.createInput("text", "inputSurname", "Surname", "Surname");
        let dobLbl = this.createLabel("dobLbl", "DateOfBirth", "Date of Birth: ");
        let dateOfBirth = this.createInput("date", "inputDateOfBirth", "Birthdate", "DateOfBirth");
        let emailAddLbl = this.createLabel("emailAddLbl", "EmailAddress", "Email Address: ");
        let emailAddress = this.createInput("text", "inputEmailAddress", "Email Address", "EmailAddress");
        let submitButton = this.createButton("button", "Submit");
        let cancelButton = this.createButton("button", "Cancel");

        if (actionType === "update") {
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generatePersonDetails(actionType);
                    putPerson(personFirstName, personSurname, personDetails);
                    closeForm();
                }
            );
        } else if (actionType === "create") {
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generatePersonDetails(actionType);
                    postPerson(personDetails);
                    closeForm();
                }
            );
        } else {
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generatePersonDetails(actionType);
                    getPerson(personDetails);
                    closeForm();
                }
            )
        }

        cancelButton.addEventListener(
            'click', () => {
                closeForm();
            }
        );


        formContainer.appendChild(firstNameLbl);
        formContainer.appendChild(firstName);
        formContainer.appendChild(lastNameLbl);
        formContainer.appendChild(lastName);

        if (actionType !== "search") {
            formContainer.appendChild(dobLbl);
            formContainer.appendChild(dateOfBirth);
            formContainer.appendChild(emailAddLbl);
            formContainer.appendChild(emailAddress);
            divContainer.appendChild(formContainer);
        }

        divContainer.appendChild(submitButton);
        divContainer.appendChild(cancelButton);
        popupContainer.appendChild(divContainer);

        document.getElementById("root").appendChild(popupContainer);
    }
}