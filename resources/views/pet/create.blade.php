@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pet.store', $ownerId) }}" method="POST"
                              onsubmit="return confirm('Проверьте правильность внесенных данных питомца');">
                            @csrf
                            <input type="hidden" name="owner_id" value="{{ $ownerId }}">

                            <label for="basic-url" class="text-primary">Питомец</label>
                            <div id="pet-fields-container">
                                <div class="pet-fields">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Кличка</span>
                                        <input type="text" class="form-control" placeholder="Введите кличку"
                                               aria-label="Кличка" aria-describedby="basic-addon1" name="alias" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Вид</span>
                                        <select class="form-select" aria-label="Default select example" name="type_id" id="typeId">
                                            <option selected>Выберите вид...</option>

                                        </select>

                                        <span class="input-group-text">Порода</span>
                                        <select class="form-select" aria-label="Default select example"
                                                id="breedId" name="breed_id"
                                                disabled="disabled">

                                        </select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Пол</span>
                                        <select class="form-select" aria-label="Default select example" name="sex">
                                            <option value="unknown">Не известен</option>
                                            <option value="male">Самец</option>
                                            <option value="female">Самка</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
   async function getPetTypesForSelectOption() {
    try {
        const responsePetTypes = await fetch(
            "http://localhost:83/client/{{$ownerId}}/getPetType", {
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

   async function getBreedByTypeForSelectOption() {
       clearSelectOptionsBreedByType('breedId');
       const selectedTypeId = document.getElementById("typeId").value;

       if (!selectedTypeId) return;

       try {
           const responseBreedByType = await fetch(
               `http://localhost:83/client/{{$ownerId}}/getBreedByType/${selectedTypeId}`, {
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
       document.getElementById('breedId').removeAttribute('disabled')
       let row =`<option value="${breed.id}">${breed.title}</option>`
       document.getElementById("breedId").innerHTML += row;
   }

   document.addEventListener("DOMContentLoaded", function() {
       document.getElementById("typeId").addEventListener("change", getBreedByTypeForSelectOption);
       getPetTypesForSelectOption();
   });

</script>
