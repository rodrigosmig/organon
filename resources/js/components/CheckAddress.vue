<template>
    <div>
        <div class="form-group row">
            <label for="client-postal_code" class="col-sm-2 col-form-label">CEP</label>
            <div class="input-group col-sm-10">						
                <input type="text" id="client-postal_code" v-model="postal_code" class="form-control" name="postal_code" :readonly="readonly == 'true' ? true : false">
                <div class="input-group-append">
                    <button v-if="!readonly" class="btn btn-outline-secondary" type="button" id="button-addon2">Consultar</button>
                </div>
            </div>					
        </div>

        <div class="form-group row">
            <label for="client-address" class="col-sm-2 col-form-label">Endereço</label>
            <div class="col-sm-10">
                <input type="text" id="client-address" v-model="address" class="form-control" name="address" :readonly="readonly == 'true' ? true : false">
            </div>
        </div>

        <div class="form-group row">
            <label for="client-city" class="col-sm-2 col-form-label">Cidade</label>
            <div class="col-sm-10">
                <input type="text" id="client-city" v-model="city" class="form-control " name="city" :readonly="readonly == 'true' ? true : false">
            </div>
        </div>

        <div class="form-group row">
            <label for="client-state" class="col-sm-2 col-form-label">UF</label>
            <div class="col-sm-10">
                <input type="text" id="client-state" v-model="state" class="form-control" name="state" :readonly="readonly == 'true' ? true : false">
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
       name: 'check-address',
       props: ['postal_code', 'address', 'city', 'state', 'readonly'],
       data() {
            return {
                readOnly: this.readonly == 'true' ? 'readonly' : ""
            }
        },
        mounted() {
            console.log(this.readonly)
        }
    }
</script>
