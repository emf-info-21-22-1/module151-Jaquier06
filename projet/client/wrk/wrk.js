// LOCAL :
//var BASE_URL = "http://localhost:8082/server/index.php";

// ONLINE :
var BASE_URL = "https://jaquierl.emf-informatique.ch/151/server/index.php";

function checkUser(user, pass, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "checkUser",
            "user": user,
            "pass": pass
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function createUser(user, pass, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "createUser",
            "user": user,
            "pass": pass
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function getCar(successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "getCar"
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function getCarFromUser(user, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "getCarFromUser",
            "user": user
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function getBrand(successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "getBrand"
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function addCar(brand, model, price, user, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "addCar",
            "brand": brand,
            "model": model,
            "price": price,
            "user": user,
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function buyCar(user, car, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "buyCar",
            "user": user,
            "car": car
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function sellCar(user, car, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "sellCar",
            "user": user,
            "car": car
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function logout(successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "logout"
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function getUserInfos(user, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL,
        data: {
            "action": "getUserInfos",
            "user": user
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}
