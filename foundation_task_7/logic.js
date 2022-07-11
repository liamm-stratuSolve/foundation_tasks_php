function createPerson() {
    openForm("create");
}

function searchPerson() {
    openForm("search", "", "");
}

function searchAllPeople() {
    let requestData = {"ActionType": "all"};
    getPerson(requestData);
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

function generateRequestData(actionType){

    let inputForm = document.getElementById("inputForm");
    let personDetails = [];

    if (actionType === "search") {
        personDetails = {
            "ActionType" : actionType,
            "FirstName" : inputForm.elements["inputFirstName"].value,
            "Surname" : inputForm.elements["inputSurname"].value
        };
    } else {
        let personAge = calculateAge(inputForm.elements["inputDateOfBirth"].value);
        personDetails = {
            "FirstName" : inputForm.elements["inputFirstName"].value,
            "Surname" : inputForm.elements["inputSurname"].value,
            "DateOfBirth" : inputForm.elements["inputDateOfBirth"].value,
            "EmailAddress" : inputForm.elements["inputEmailAddress"].value,
            "Age" : personAge
        };
    }

    return personDetails;
}

function calculateAge(birthDate) {
    let today = new Date();
    return new Date(today - new Date(birthDate)).getFullYear() - 1970;
}

function generateTable(responseData, actionType) {

    let personTable = document.getElementById("personTable");

    let table =
        "<tr>" +
            "<th>First Name</th>" +
            "<th>Surname</th>" +
            "<th>Date of Birth</th>" +
            "<th>Email Address</th>" +
            "<th>Age</th>"+
            "<th> </th>"+
        "</tr>";

    switch (actionType) {
        case "all":
            let dataArray = JSON.parse(responseData);
            for(let i = 0; i<dataArray.length; i++){
                let person = dataArray[i];
                table += buildTable("details", person.FirstName, person.Surname, person.DateOfBirth,
                    person.EmailAddress, person.Age);
            }
            break;

        case "single":
            for(let i = 0; i<responseData.length; i++){
                let person = responseData[i];
                table += buildTable("details", person.FirstName, person.Surname, person.DateOfBirth,
                    person.EmailAddress, person.Age);
            }
            break;

        case "error-404":
            table += buildTable(actionType);
    }
    personTable.innerHTML += table;
}

function buildTable(tableType, firstName, surname, dateOfBirth, emailAddress, age) {
    if (tableType === "error-404") {
        let table =
            "<tr>"+
                "<td colspan='6'>No data found...</td>"+
            "</tr>";

        return table;
    } else {
        let table =
            "<tr>" +
                "<td>" + firstName + "</td>" +
                "<td>" + surname + "</td>" +
                "<td>" + dateOfBirth + "</td>" +
                "<td>" + emailAddress + "</td>" +
                "<td>" + age + "</td>" +
                "<td><button class='editBtn' onclick='updatePerson(\"" + firstName + "\", \"" + surname + "\")'>Edit</button>" +
                "<button class='deleteBtn' onclick='deletePerson(\"" + firstName + "\", \"" + surname + "\")'>Delete</button>" +
                "</td>" +
            "</tr>";

        return table;
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

    createHeading(headingClass, headingID) {
        let headingElement = document.createElement("h2");
        headingElement.id = headingID

        return headingElement;
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
        let formHeading = this.createHeading("inputHeading", "inputHeading");

        submitButton.className = "submitBtn";

        if (actionType === "update") {
            formHeading.innerText = "Edit Person Details";
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generateRequestData(actionType);
                    putPerson(personFirstName, personSurname, personDetails);
                    closeForm();
                }
            );
        } else if (actionType === "create") {
            formHeading.innerText = "Enter New Person Details";
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generateRequestData(actionType);
                    postPerson(personDetails, actionType);
                    closeForm();
                }
            );
        } else {
            formHeading.innerText = "Enter Search Person's Names";
            submitButton.addEventListener(
                'click', () => {
                    let personDetails = generateRequestData(actionType);
                    getPerson(personDetails);
                    closeForm();
                }
            );
        }

        cancelButton.className = "cancelBtn";
        cancelButton.addEventListener(
            'click', () => {
                closeForm();
            }
        );

        switch (actionType) {
            case "search":
                formContainer.appendChild(formHeading);
                formContainer.appendChild(firstNameLbl);
                formContainer.appendChild(firstName);
                formContainer.appendChild(lastNameLbl);
                formContainer.appendChild(lastName);
                popupContainer.appendChild(formContainer);
                popupContainer.appendChild(submitButton);
                popupContainer.appendChild(cancelButton);
                break;

            default:
                formContainer.appendChild(formHeading);
                formContainer.appendChild(firstNameLbl);
                formContainer.appendChild(firstName);
                formContainer.appendChild(lastNameLbl);
                formContainer.appendChild(lastName);
                formContainer.appendChild(dobLbl);
                formContainer.appendChild(dateOfBirth);
                formContainer.appendChild(emailAddLbl);
                formContainer.appendChild(emailAddress);
                popupContainer.appendChild(formContainer);
                popupContainer.appendChild(submitButton);
                popupContainer.appendChild(cancelButton);
                break;


        }
        document.getElementById("root").appendChild(popupContainer);
    }
}