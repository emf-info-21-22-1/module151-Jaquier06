
///////////////////////////////
// récupération des voitures //
///////////////////////////////

$(document).ready(function () {
  if (window.location.pathname.includes("newCar.html")) {
    getBrandCtrl();
  }
});

function getBrandCtrl() {
  getBrand(getBrandSuccessCallback, getBrandErrorCallback);
}

function getBrandSuccessCallback(data) {
  if (data && data.cars) {
    var selectElement = $("#brandList");
    data.cars.forEach(function (brand) {
      selectElement.append("<option value='" + brand.pk_brand + "'>" + brand.name + "</option>");
    });
  } else {
    getBrandErrorCallback();
  }
}

function getBrandErrorCallback(data) {
  alert(data.message);
  console.log(data);
}

////////////////////////////
// création de la voiture //
////////////////////////////

function validate() {
  let brand = $("#brandList").val();
  let model = $("#model").val();
  let price = $("#price").val();
  if (brand != null && model.length > 0 && price.length > 0) {
    newCarCtrl(brand, model, price);
  } else {
    alert('Les champs ne peuvent pas être vides !')
  }
}

function newCarCtrl(brand, model, price) {
  addCar(brand, model, price, window.sessionStorage.getItem(StorageItems.pk_user), newCarSuccessCallback, newCarErrorCallback)
}

function newCarSuccessCallback(data) {
    alert(data.message);
}

function newCarErrorCallback(data) {
  alert(data.responseJSON.message)
}