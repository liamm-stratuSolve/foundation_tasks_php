function postPerson(personDetails){
    $.ajax({
        url : 'foundation_task_7.php',
        type : 'POST',
        contentType: "application/json",
        dataType : 'json',
        data : JSON.stringify(personDetails),
        success : function () {
            clearTable();
            getPeople();
        },
        error: function(error) {
            alert("Error: \n" + JSON.stringify(error));
        }
    })
}

function getPeople(){

    let data = {"ActionType": "all"};

    $.ajax({
        url : 'foundation_task_7.php',
        type : 'GET',
        data : JSON.stringify(data),
        success : function (result) {
            generateTable(result);
        },
        error : function () {
            alert("Error: \n" + JSON.stringify(error));
        }
    })
}

function getPerson(){

}

function putPerson(firstName, surname, personDetails){

    let originalData = {"OriginalFirstName": firstName, "OriginalSurname": surname};
    let data = {"originalData": originalData, "newData": personDetails};

    $.ajax({
        url : 'foundation_task_7.php',
        type : 'PUT',
        contentType: "application/json",
        dataType : 'json',
        data : JSON.stringify(data),
        success : function () {
            clearTable();
            getPeople();
        },
        error: function(error) {
            alert("Error: \n" + JSON.stringify(error));
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
            getPeople();
        },
        error: function(error) {
            alert("Error: \n" + JSON.stringify(error));
        }
    });
}