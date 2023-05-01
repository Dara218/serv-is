$(document).ready(function(){

    // $('.id-imgs').hide()
    checkUserType()
    checkUserLogin()

    $('.user_type-options').on('change', function(){
        checkUserType()
    })

    $('.user_type-options-client').on('change', function(){
        checkUserLogin()
    })

    axios.get('https://ph-locations-api.buonzz.com/v1/regions')
    .then(function(res){

        const rest = res.data.data

        rest.forEach(function(eachRes){
            $('.loading').remove();
            $('.region-options').append(
                `
                    <option value="${eachRes.name}" {{ old('region') === '${eachRes.name}' ? 'selected' : '' }}>${eachRes.name}</option>
                `
            )
        })
    })
    .catch(err => console.error(err))

    function checkUserType(){
        if($('.user_type-options').val() === 'Customer'){
            $('.id-imgs').hide()
            $('.register').attr('action', `/register/register-store`)
        }
        if($('.user_type-options').val() === 'Client'){
            $('.id-imgs').show()
            $('.register').attr('action', `/register/register-storeAgent`)
        }
    }

    function checkUserLogin(){
        if($('.user_type-options').val() === 'Customer'){
            $('.form-login').attr('action', `/session/login-store`)
        }
        if($('.user_type-options').val() === 'Client'){
            $('.form-login').attr('action', `/session/login-store-client`)
        }
    }
})
