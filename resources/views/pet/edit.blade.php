@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                <form action="{{ route('pet.update', $oldPetInfo['id']) }}" method="POST"
                      onsubmit="return validateAndConfirm();">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="owner_id" value="{{ $oldPetInfo['owner_id'] }}">

                    <label for="basic-url" class="text-primary">Питомец</label>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Кличка</span>
                        <input type="text" class="form-control" placeholder="Введите кличку питомца"
                               aria-label="Кличка" aria-describedby="basic-addon1" name="alias"
                               value={{ $oldPetInfo['alias'] }} required>
                    </div>

                    <span id="typeId-error" class="text-danger"></span>
                    <span id="breedId-error" class="text-danger"></span>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Вид</span>
                        <select class="form-select" aria-label="Default select example" name="type_id" id="typeId">
                            <option value={{ $oldPetInfo['type_id'] }}>{{ $oldPetInfo['type']['title'] }}</option>

                        </select>

                        <span class="input-group-text">Порода</span>
                        <select class="form-select" aria-label="Default select example"
                                id="breedId" name="breed_id">
                            <option value={{ $oldPetInfo['breed_id'] }}>{{ $oldPetInfo['breed']['title'] }}</option>

                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Пол</span>
                        <select class="form-select" aria-label="Default select example" name="sex">
                            <option value="unknown" @selected($oldPetInfo['sex'] == 'unknown')>Не известен</option>
                            <option value="male" @selected($oldPetInfo['sex'] == 'male')>Самец</option>
                            <option value="female" @selected($oldPetInfo['sex'] == 'female')>Самка</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button  type="submit" class="btn btn-primary me-md-2">Сохранить</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    function validateAndConfirm() {
        if(!validateForm()) {
            return false;
        }

        return confirm('Проверьте правильность внесенных данных питомца');
    }

    function validateForm() {
        let selectedTypeId = document.getElementById("typeId").value;
        let typeIdError = document.getElementById('typeId-error');
        let selectedBreedId = document.getElementById("breedId").value;
        let breedIdError = document.getElementById('breedId-error');

        if (selectedTypeId === 'Выберите вид...' || selectedTypeId === '') {
            typeIdError.textContent = 'Пожалуйста, выберите вид питомца';
            return false;
        }

        if (!selectedBreedId) {
            breedIdError.textContent = 'Пожалуйста, выберите породу питомца';
            return false;
        }

        return true;
    }

    async function petTypesForSelectOption() {
        try {
            const responsePetTypes = await fetch(
                "http://localhost:83/client/{{$oldPetInfo['id']}}/petType", {
                });

            if (!responsePetTypes.ok) {
                throw new Error('Network response was not ok ' + responsePetTypes.statusText);
            }

            const decodedPetTypes = await responsePetTypes.json();
            decodedPetTypes.data.petType.forEach((type)=>{
                insertIntoSelectOptionType(type)
            });
        } catch (error) {
            console.error('Problem with your fetch operation:', error);
        }
    }

    function insertIntoSelectOptionType(type) {
        let row =`<option value="${type.id}">${type.title}</option>`
        document.getElementById("typeId").innerHTML += row;
    }

    async function breedByTypeForSelectOption() {
        clearSelectOptionsBreedByType('breedId');
        const selectedTypeId = document.getElementById("typeId").value;

        if (!selectedTypeId) return;

        try {
            const responseBreedByType = await fetch(
                `http://localhost:83/client/{{$oldPetInfo['id']}}/breedByType/${selectedTypeId}`, {
                });
            if (!responseBreedByType.ok) {
                throw new Error('Network response was not ok ' + responseBreedByType.statusText);
            }

            const decodedBreedByType = await responseBreedByType.json();
            decodedBreedByType.data.breed.forEach((breed)=>{
                insertIntoSelectOptionBreedByType(breed)
            });
        } catch (error) {
            console.error('Problem with your fetch operation:', error);
        }
    }

    function insertIntoSelectOptionType(type) {
        let row =`<option value="${type.id}">${type.title}</option>`
        document.getElementById("typeId").innerHTML += row;
    }
    function clearSelectOptionsBreedByType(selectElementId) {
        let selectElement = document.getElementById(selectElementId);
        selectElement.innerHTML = '';
    }

    function insertIntoSelectOptionBreedByType(breed) {
        let row =`<option value="${breed.id}">${breed.title}</option>`
        document.getElementById("breedId").innerHTML += row;
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("typeId").addEventListener("change", breedByTypeForSelectOption);
        petTypesForSelectOption();
        breedByTypeForSelectOption();

    });

</script>
