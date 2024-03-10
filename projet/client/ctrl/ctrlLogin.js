
///////////////////////////////////
// bouton de validation de login //
///////////////////////////////////

function loginCtrl(user, pass) {
    if (user.length > 0 && pass.length > 0) {
        checkUser(user, pass, successCallback, errorCallback)
    } else {
        alert('Les champs ne peuvent pas être vides !');
    }
}

function successCallback(data) {
    console.log('Success');
    console.log(data);
    window.sessionStorage.setItem(StorageItems.pk_user, data.pk)
    window.sessionStorage.setItem(StorageItems.money, data.money)
    window.sessionStorage.setItem(StorageItems.username, data.username)
    getCarCtrl();
    window.location.href = 'main.html'
}

function errorCallback(data) {
    alert(data.responseJSON.message);
}