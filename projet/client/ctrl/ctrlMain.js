
////////////////////////////
// affichage des voitures //
////////////////////////////

$(document).ready(function () {
  if (window.location.pathname.includes("main.html")) {
    getUserInfos(window.sessionStorage.getItem(StorageItems.pk_user), getUserInfosSuccessCallBack, getUserInfosErrorCallBack);
    getCar(getCarSuccessCallback, getCarCtrlErrorCallback);
  }
});

function getUserInfosSuccessCallBack(data) {
  window.sessionStorage.setItem(StorageItems.money, data.money)
  document.getElementById('username').innerText = window.sessionStorage.getItem(StorageItems.username);
  document.getElementById('money').innerText = (window.sessionStorage.getItem(StorageItems.money) + ' CHF');
}

function getUserInfosErrorCallBack(data) {
  alert(data.responseJSON.message);
}

function getCarCtrl() {
  getCar(getCarSuccessCallback, getCarCtrlErrorCallback);
}

function getCarSuccessCallback(data) {
  const vehicleGrid = document.getElementById("vehicleGrid");
  if (data.success && data.cars) {
    data.cars.forEach(car => {
      const carItem = document.createElement("div");
      carItem.classList.add("vehicle-item");
      carItem.innerHTML = `
          <p><strong>Marque : </strong>${car.brand}</p>
          <p><strong>Modèle : </strong>${car.model}</p>
          <p><strong>Prix : </strong>${car.price}</p>
          <button class="buy_button" id="carBtn${car.pk_car}" onclick="buyCarCtrl(${car.pk_car}, ${car.price})">BUY</button>
        `;
      vehicleGrid.appendChild(carItem);
    });
  } else {
    alert(data.message);
  }
}

function getCarCtrlErrorCallback(data) {
  alert(data.message);
}

////////////////////////
// achat des voitures //
////////////////////////

function buyCarCtrl(carId, price) {
  buyCar(window.sessionStorage.getItem(StorageItems.pk_user), carId, buyCarSuccessCallback, buyCarErrorCallback);
}

function buyCarSuccessCallback(data) {
  alert(data.message);
}

function buyCarErrorCallback(data) {
  alert(data.responseJSON.message);
  console.log(data);
}

/////////////////////////////////////
// bouton pour ajouter une voiture //
/////////////////////////////////////

function newCar() {
  window.location.href = 'newCar.html'
  getBrandCtrl();
}

///////////////////////////////////
// bouton pour accéder au garage //
///////////////////////////////////

function garage() {
  window.location.href = 'garage.html'
  getCarFromUserCtrl();
}

//////////////////////
// bouton de logout //
//////////////////////

function logoutCtrl() {
  window.sessionStorage.clear();
  window.location.href = 'index.html';
  logout(logoutSuccessCallback, logoutErrorCallback);
}

function logoutSuccessCallback(data) {
  console.log(data.message)
}

function logoutErrorCallback(data) {
  console.log(data.message)
}