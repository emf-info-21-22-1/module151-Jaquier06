
////////////////////////////////////
// validation de l'enregistrement //
////////////////////////////////////

function registerCtrl(user, pass, confpass) {
  if (user.length > 0 && pass.length > 0 && confpass.length > 0) {
    if (pass == confpass) {
      createUser(user, pass, successCallback, errorCallback);
    } else {
      alert('ERROR : Les mots de passe ne correspondent pas !')
    }
  } else {
    alert('ERROR : Les champs ne peuvent pas être vide !');
  }
}

function successCallback(data) {
  if (data.success) {
    window.sessionStorage.setItem(StorageItems.pk_user, data.pk)
    window.sessionStorage.setItem(StorageItems.money, data.money)
    window.sessionStorage.setItem(StorageItems.username, data.username)
    alert('Bienvenue ' + data.username + ' !');
    window.location.href = 'main.html'
    getCarCtrl();
  } else {
    errorCallback(data);
  }
}

function errorCallback(data) {
  alert(data.responseJSON.message)
}