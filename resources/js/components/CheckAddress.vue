<template>
    <div>
        <div class="form-group row">
            <label for="client-postal_code" class="col-sm-2 col-form-label">CEP</label>
            <div class="input-group col-sm-10">						
                <input type="text" id="client-postal_code" v-model="postal_code" class="form-control" name="postal_code" :readonly="readonly == 'true' ? true : false">
                <div class="input-group-append">
                    <button v-if="readonly == 'false'" @click="getPostalCode" class="btn btn-primary" type="button" id="button-addon2" :disabled="isDisabled || disabled">
                        Consultar
                        <span v-if="loading" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
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
       props: ['ca_code', 'ca_address', 'ca_city', 'ca_state', 'readonly'],
       data() {
            return {
                postal_code: this.ca_code,
                address: this.ca_address,
                city: this.ca_city,
                state: this.ca_state,
                readOnly: this.readonly == 'true' ? 'readonly' : "",
                loading: false,
                disabled: false
            }
        },
        methods: {
            getPostalCode() {
                if(!this.validatePostalCode()) {
                    this.alert('Invalid postal code', 'warning')
                    return
                }

                this.loading = true
                this.disabled = true

                axios.get("https://viacep.com.br/ws/" + this.postal_code + "/json/")
                    .then(response => {
                        let data = response.data

                        if(data.erro) {
                            this.alert('Invalid postal code', 'warning')
                        } else {
                            this.setFields(data)
                        }
                        
                        this.loading = false
                        this.disabled = false
                    })
            },
            setFields(data) {
                this.postal_code = data.cep
                this.address = data.logradouro
                this.city = data.localidade
                this.state = data.uf
            },
            validatePostalCode() {
                let code = this.postal_code.replace(/\D/g, '');
                let validator = /^[0-9]{8}$/;

                return validator.test(code)
            },
            alert: function(title, icon) {
                swal.fire({
                    title: title,
                    icon: icon,
                })
            },
        },
        computed: {
            isDisabled() {
                if (!this.postal_code) {
                    return true
                }
                
                if(this.postal_code.length > 7) {
                    return false
                }
                
                return true
            }
        }
    }
</script>
