$(document).ready(function(){

    checkUserType()

    $('.user_type-options').on('change', function(){
        checkUserType()
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

    $('.dots').on('click', function() {
        var index = $(this).index('.dots') // Get the index of the clicked element
        $('.view-profile').eq(index).toggle() // Show the element with the corresponding index

    });

    $('.btn-chat-open').on('click', function(){
        $('.chat-modal').slideToggle()
    })

    $(document).click(function(e) {
        if(! $(e.target).closest('.view-profile, .dots').length) {
            $('.view-profile').hide();
        }

        if(! $(e.target).closest('.contact-us-modal, .btn-contact-us' ).length){
            $('.contact-us-modal').hide()
        }

        if(! $(e.target).closest('.chat-modal, .btn-chat-open').length){
            $('.chat-modal').slideUp()
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

    // Preview profile photo edit
    $('.profile_picture').on('change', function(e){
        const file = e.target.files[0]

        if(file){
            const reader = new FileReader()

            reader.onload = function(e){
                $('.user-profile-el').attr('src', e.target.result)
            }
            reader.readAsDataURL(file)
        }
    })

    var initialInputValues = {}

    $('input:not([type="password"])').each(function(){
        var input = $(this)
        initialInputValues[input.attr('id')] = input.val()
    })

    $('input:not([type="password"])').on('input', function(){
        var input = $(this)
        var inputId = input.attr('id')

        if(input.val() !== initialInputValues[inputId]){
            $('.unsaved-changes-el').fadeIn()
        }
        else{
            $('.unsaved-changes-el').fadeOut()
        }
    })

    $('.form-pricing').on('submit', function(e){

        const basicEl = $('#basic')
        const advanceEl = $('#advance')
        const errorEl = $('.error-pricing-plan')

        if(!basicEl.is(':checked') && !advanceEl.is(':checked')){
            $('.label-pricing').css('border', '1px solid red')
            errorEl.show()
            e.preventDefault()
        }
        else{
            errorEl.hide()
        }
    })

    $('#checkbox-primary').on('click', function() {
        $('.form-primary-address-checkbox').submit()

        var userId = $('#logged-user').val();
        var isChecked = $('#checkbox-primary').is(':checked');

        axios.put(`address-changed-update/${userId}`,{
            address: isChecked
        })
        .then(function(response){
            location.reload()
        })
        .catch(err => console.error(err))
    })

    $('.checkbox-secondary').on('click', function(e) {
        $('.form-secondary-address-checkbox').submit()

        var userId = $('#logged-user').val();
        var isChecked = $('.checkbox-secondary').is(':checked');
        var secondaryAddressId = $(e.target).data('id')
        // console.log(secondaryAddressId);

        axios.put(`address-changed-secondary-update/${userId}`,{
            secondaryAddressId: secondaryAddressId,
            address: isChecked
        })
        .then(function(response){
            // console.log(response);
            location.reload()
        })
        .catch(err => console.error(err))
    })

    $('.edit-primary-address').on('click', function(){
        const primaryAddressId = $('.primary-address').data('id')

        Swal.fire({
            title: "Edit your primary address",
            input: "text",
            inputValue: $(".primary-address").text(),
            inputPlaceholder: "Enter your primary address",
            inputValidator: (value) => {
                if (!value) {
                    return "You need to write something."
                }
            },
        }).then((result) => {
            const primaryAddress = result.value
            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true,
                confirmButtonText: "Save",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .put(`address-primary-update/${primaryAddressId}`, {
                            primaryAddressId: primaryAddressId,
                            primaryAddress: primaryAddress,
                        })
                        .then(function (response) {
                            // console.log(response)
                        })
                        .catch((err) => console.error(err))

                    Swal.fire({
                        title: "Primary address has been saved",
                        icon: "success",
                        confirmButtonText: "Okay",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        }
                    })
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info")
                }
            })
        })
    })

    $('.edit-secondary-address').on('click', function(e){
        const secondaryAddressId = $(e.target).data('id')

        Swal.fire({
            title: 'Edit your secondary address',
            input: 'text',
            inputValue: $(e.target).data('address'),
            inputPlaceholder: 'Enter your secondary address',
            inputValidator: (value) => {
                if (! value){
                    return 'You need to write something.'
                }
            }
        })
        .then((result) => {

        const secondaryAddress = result.value

            Swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: 'Save',
            })
            .then((result) => {
                if (result.isConfirmed)
                {
                    axios.put(`address-secondary-update/${secondaryAddressId}`,{
                        secondaryAddressId: secondaryAddressId,
                        secondaryAddress: secondaryAddress
                    })
                    .then(function(response){
                        // console.log(response)
                    })
                    .catch(err => console.error(err))

                    Swal.fire({
                        title: 'Secondary address has been saved',
                        icon: 'success',
                        confirmButtonText: 'Okay',
                        allowOutsideClick: false
                    })
                    .then((result) => {
                        if(result.isConfirmed){
                            location.reload()
                        }
                    })
                }
                else if (result.isDenied)
                {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })
    })

    // Delete primary or secondary address
    $('.delete-address').on('click', function(e){

        const addressId = $(e.target).data('id')
        const addressType = $(e.target).data('type')

        Swal.fire({
            title: `Delete ${addressType} address?`,
            icon: 'warning',
            inputLabel: 'Are you sure you want to delete this address?',
            showConfirmButton: true,
            showCancelButton: true
        })
        .then((result) => {
            if(result.isConfirmed)
            {
                axios.delete(`address-destroy/${addressId}`)
                .then(function(response){

                    axios.put(`address-to-${addressType}-update/${addressId}`,{
                        secondaryAddressId: addressId,
                    })
                    .then(function(response){

                        const ucAddressType = addressType.charAt(0).toUpperCase() + addressType.slice(1).toLowerCase()

                        Swal.fire({
                            title: `${ucAddressType} address has been deleted`,
                            icon: 'success',
                            confirmButtonText: 'Okay',
                            allowOutsideClick: false
                        })
                        .then((result) => {
                            if(result.isConfirmed)
                            {
                                location.reload()
                            }
                        })
                    })
                    .catch(err => console.error(err))

                })
                .catch(err => console.error(err))
            }
        })
    })

    // Update agenda
    $('.btn-edit-agenda').on('click', function(e){
        const idData = $(e.target).data('id')
        const messageData = $(e.target).data('message')
        const serviceData = $(e.target).data('service')
        const budgetData = $(e.target).data('budget')
        const deadlineData = $(e.target).data('deadline')

        $('.edit-agenda-message').text(messageData)
        $('.edit-agenda-service-option').val(serviceData)
        $('.edit-agenda-budget').val(budgetData)
        $('.edit-agenda-deadline').val(deadlineData) 

        $(`#edit-agenda-modal-${idData}`).slideDown()

        $('.btn-close-agenda').on('click', function(){
            $(`#edit-agenda-modal-${idData}`).slideUp()
        })
    })
    
    $('.btn-add-agenda').on('click', function(){
        $('.form-agenda-modal').slideToggle()
    })

    $('.btn-close-agenda').on('click', function(){
        $('.form-agenda-modal').slideToggle()
    })

})
