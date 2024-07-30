console.log(111111111111)
document.getElementById('add-pet-button').addEventListener('click', function () {
    const container = document.getElementById('pet-fields-container');
    const petFieldsCount = container.querySelectorAll('.pet-fields').length;

    const newPetFields = document.createElement('div');
    newPetFields.classList.add('pet-fields');

    newPetFields.innerHTML = `
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Кличка</span>
                <input type="text" class="form-control" placeholder="Введите кличку питомца" aria-label="Кличка" aria-describedby="basic-addon1" name="pets[${petFieldsCount}][name]">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">Вид</span>
                <input type="text" class="form-control" placeholder="Введите вид питомца" aria-label="Вид" name="pets[${petFieldsCount}][type]">
                <span class="input-group-text">Порода</span>
                <input type="text" class="form-control" placeholder="Введите породу питомца" aria-label="Порода" name="pets[${petFieldsCount}][breed]">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">Пол</span>
                <input type="text" class="form-control" placeholder="Введите пол питомца" aria-label="Пол" name="pets[${petFieldsCount}][sex]">
            </div>
        `;

    container.appendChild(newPetFields);
});
