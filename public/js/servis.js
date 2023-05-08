$(document).ready(function(){

    // $('.id-imgs').hide()
    checkUserType()
    // checkUserLogin()

    $('.user_type-options').on('change', function(){
        checkUserType()
    })

    // $('.user_type-options-client').on('change', function(){
    //     checkUserLogin()
    // })

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

    $('.dots').on('click', function() {
        var index = $(this).index('.dots') // Get the index of the clicked element
        $('.view-profile').eq(index).toggle() // Show the element with the corresponding index

    });

    $(document).click(function(e) {
        if(! $(e.target).closest('.view-profile, .dots').length) {
            $('.view-profile').hide();
        }

        if(! $(e.target).closest('.contact-us-modal, .btn-contact-us' ).length){
            $('.contact-us-modal').hide()
        }
    });

    $('.add-address').on('click', function(){
        $('.address-modal').fadeIn()
    })

    $('.close-address-modal').on('click', function(){
        $('.add-address-form').fadeOut()
    })

    $('.btn-contact-us').on('click', function(){
        $('.contact-us-modal').show()
    })

    $('.close-contact-us-modal').on('click', function(){
        $('.contact-us-modal').hide()
    })

    // function checkUserLogin(){
    //     if($('.user_type-options').val() === 'Customer'){
    //         $('.form-login').attr('action', `/session/login-store`)
    //     }
    //     if($('.user_type-options').val() === 'Client'){
    //         $('.form-login').attr('action', `/session/login-store-client`)
    //     }
    // }
})
