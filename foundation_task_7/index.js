$(document).ready(() => {
    searchAllPeople()
});

function postPerson(personDetails, actionType){

    let requestData = {"ActionType": actionType, "PersonDetails": personDetails};

    $.ajax({
        url : 'foundation_task_7.php',
        type : 'POST',
        contentType: "application/json",
        dataType : 'json',
        data : JSON.stringify(requestData),
        success : function () {
            clearTable();
            closeForm();
            console.clear();
            searchAllPeople({"ActionType": "all"});
        },
        error: function(error) {
            console.log("Error: " + error.status);
            if(error.status === 404) {
                generateTable(error, "error-404");
            } else {
                console.warn("Error: \n" + error.status+ ": " + error.statusText);
            }
        }
    })
}

function getPerson(personDetails){
    let actionType = personDetails["ActionType"];

    switch (actionType) {
        case "all":
            $.ajax({
                url : 'foundation_task_7.php',
                type : 'GET',
                success : function (result) {
                    clearTable();
                    generateTable(result, actionType);
                },
                error: function(error) {
                    if(error.status === 404) {
                        generateTable(error, "error-404");
                    } else {
                        console.warn("Error: \n" + error.status+ ": " + error.statusText);
                    }
                }

            });
            break;

        case "search":
            $.ajax({
                url : 'foundation_task_7.php',
                type : 'POST',
                contentType: "application/json",
                dataType : 'json',
                data : JSON.stringify(personDetails),
                success : function (result) {
                    clearTable();
                    generateTable(result, "single");
                },
                error: function(error) {
                    if(error.status === 404) {
                        clearTable();
                        generateTable(error, "error-404");
                    } else {
                        console.warn("Error: \n" + error.status+ ": " + error.statusText);
                    }
                }
            })
            break;
    }
}

function putPerson(firstName, surname, personDetails){

    let originalData = {"OriginalFirstName": firstName, "OriginalSurname": surname};
    let data = {"OriginalData": originalData, "NewData": personDetails};

    $.ajax({
        url : 'foundation_task_7.php',
        type : 'PUT',
        contentType: "application/json",
        dataType : 'json',
        data : JSON.stringify(data),
        success : function () {
            clearTable();
            searchAllPeople({"ActionType": "all"});
        },
        error: function(error) {
            console.warn("Error: \n" + error.status+ ": " + error.statusText);
        }
    })
}

function deletePeople(deleteType, personFirstName, personSurname){
    let personDetails = {"ActionType": deleteType,"FirstName": personFirstName, "Surname": personSurname};

    $.ajax({
        url : 'foundation_task_7.php',
        type : 'DELETE',
        contentType: "application/json",
        dataType : 'json',
        data : JSON.stringify(personDetails),
        success : function () {
            switch (deleteType) {
                case "single":
                    alert(personFirstName + " " + personSurname + " deleted!");
                    break;

                case "all":
                    alert("All records deleted!")
                    break;
            }
            clearTable();
            searchAllPeople({"ActionType": "all"});
        },
        error: function(error) {
            console.warn("Error: \n" + error.status+ ": " + error.statusText);
        }
    });
}