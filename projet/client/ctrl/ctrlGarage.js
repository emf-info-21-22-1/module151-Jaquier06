
////////////////////////////
// affichage des voitures //
////////////////////////////

$(document).ready(function () {
  if (window.location.pathname.includes("garage.html")) {
    getUserInfos(window.sessionStorage.getItem(StorageItems.pk_user), getUserInfosSuccessCallBack, getUserInfosErrorCallBack);
    getCarFromUserCtrl();
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

function getCarFromUserCtrl() {
  getCarFromUser(window.sessionStorage.getItem(StorageItems.pk_user), getCarSuccessCallBack, getCarErrorCallBack);
}

function getCarSuccessCallBack(data) {
  const vehicleGrid = document.getElementById("vehicleGrid");
  if (data.success && data.cars) {
    data.cars.forEach(car => {
      const carItem = document.createElement("div");
      carItem.classList.add("vehicle-item");
      carItem.innerHTML = `
          <p><strong>Marque : </strong>${car.brand}</p>
          <p><strong>Modèle : </strong>${car.model}</p>
          <p><strong>Prix : </strong>${car.price}</p>
          <button class="sell_button" id="carBtn${car.pk_car}" onclick="sellCarCtrl(${car.pk_car})">Sell</button>`;
      vehicleGrid.appendChild(carItem);
    });
  } else {
    alert(data.message);
  }

}

function getCarErrorCallBack(data) {
  alert(data.responseJSON.message);
  console.log(data);
}

////////////////////////
// vente des voitures //
////////////////////////

function sellCarCtrl(carId) {
  sellCar(window.sessionStorage.getItem(StorageItems.pk_user), carId, sellCarSuccessCallback, sellCarErrorCallback);
}

function sellCarSuccessCallback(data) {
  alert(data.message);
}

function sellCarErrorCallback(data) {
  alert(data.responseJSON.message);
}