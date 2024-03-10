
///////////////////////////
// affichage de voitures //
///////////////////////////

$(document).ready(function () {
    if (window.location.pathname.includes("index.html")) {
        getCar(getCarSuccessCallback, getCarCtrlErrorCallback);
    }
});

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
          `;
            vehicleGrid.appendChild(carItem);
        });
    }else{
        alert(data.message);
    }
}

function getCarCtrlErrorCallback(data) {
    alert(data.responseJSON.message);
}