$(document).ready(function(){

    const userId = $('#current-user-id').val()

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
                $('.upload-profile-text').hide()
                $('.user-profile-el').show()
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
        $('.form-agenda-modal').slideUp()
    })

    // Delete agenda
    $('.btn-delete-agenda').on('click', function(e){
        const idData = $(e.target).data('id')

        Swal.fire({
            title: 'Delete Agenda',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true,
        })
        .then((result) => {
            if(result.isConfirmed)
            {
                axios.delete(`agenda-destroy/${idData}`)
                .then(function(response){
                    Swal.fire({
                        title: 'Agenda successfully deleted',
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonText: 'Okay'
                    })
                    .then((result) => {
                        if(result.isConfirmed)
                        {
                            location.reload()
                        }
                    })
                })
                .catch((err) => console.error(err))
            }
        })
        .catch((err) => console.error(err))
    })

    getCategories()

    let allCategories = 6
    async function getCategories(){
        $.ajax({
            url: 'get-categories',
            method: 'get',
            success: function(data){
                $('.categories-container').empty()
                data.slice(0, allCategories).forEach(function(eachData){
                    $('.categories-container').append(
                        `
                        <div class="h-full w-full grid-cols-span-1 border border-slate-300 rounded-xl text-center">

                            <div class="bg-slate-200 flex justify-center">
                                <img src="${eachData.category_photo}" alt="${eachData.type}" class="h-auto w-6/12 py-6">
                            </div>

                            <div class="p-4">
                                <span class="font-semibold">${eachData.type.charAt(0).toUpperCase() + eachData.type.slice(1).toLowerCase()}</span>
                            </div>
                        </div>
                    `)
                })
            },
            error: function(error){
                console.error(error)
            }
        })
    }

    $('.view-all-categories').on('click', function(){
        getCategories(allCategories = 9)
    })

    $('.skeleton-loading').show()

    $.ajax({
        url: 'get-agent-service',
        method: 'get',
        success: function(data){
            $('.skeleton-loading').hide()
            loadServices(data)
        },
        error: function(err){
            console.error(err)
        }
    })

    $('.view-all-services').on('click', function(){
        $('.services-container').hide()
        $('.skeleton-loading').show()
        $.ajax({
            url: 'get-all-agent-service',
            method: 'get',
            success: function(data){
                $('.skeleton-loading').hide()
                loadServices(data)
            },
            error: function(err){
                console.error(err)
            }
        })
    })

    function loadServices(data){
        $('.services-container').show()
        $('.services-container').empty()
                data.forEach(function(eachData){
                    // console.log(eachData)
                    $('.services-container').append(
                        `
                        <div class="p-4 flex flex-col gap-3 border border-slate-300 rounded-xl">
                            <span>***** star rating here</span>
                            <div class="flex flex-col">
                                <span class="font-semibold">${eachData.title}</span>
                                <small class="text-slate-500">${eachData.service.type.charAt(0).toUpperCase() + eachData.service.type.slice(1).toLowerCase()}</small>
                            </div>
                            <div class="flex gap-2 items-center">
                                <img src="${eachData.user.user_photo.profile_picture}" alt="" class="h-[50px] rounded-full">
                                <span class="text-slate-500">${eachData.user.fullname.charAt(0).toUpperCase() + eachData.user.fullname.slice(1).toLowerCase()}</span>
                            </div>
                        </div>
                    `)
                })
    }

    $('.btn-add-service-title').on('click', function()
    {
        const agentServiceId = $('#current-user-id').data('user-service')

        Swal.fire({
            title: 'Add service title',
            icon: 'info',
            input: 'text',
            inputLabel: 'Enter your service title here',
            showConfirmButton: true,
            showCancelButton: true,
            inputValidator: function(value){
                if(! value)
                {
                    return 'You need to enter a title.'
                }
            }
        })
        .then(function(result){
            const serviceTitle = result.value
            if(result.isConfirmed)
            {
                axios.put(`update-agent-services/${agentServiceId}`, {
                    title: serviceTitle
                })
                .then(function(response){
                    // console.log(response)

                    Swal.fire({
                        title: 'Title successfully added',
                        icon: 'success',
                        showConfirmButton: true,
                    })
                    .then(function(result){
                        if(result.isConfirmed)
                        {
                            location.reload()
                        }
                    })

                })
                .catch((err) => console.error(err))
            }
        })
        .catch((err) => console.error(err))
    })

    $('.btn-update-service').on('click', function(){

    })

    Fancybox.bind('[data-fancybox="valid-photos-gallery"]', {
        // custom options
    });

    $('.service-type-dropdown-item').on('click', function(){
        var serviceCategoryData = $(this).data('service-type')
        $('#dropdown-services').text(serviceCategoryData)

        $.ajax({
            url: 'get-search-services',
            method: 'get',
            data: {
                category: serviceCategoryData
            },
            success: ((response) => {
                let results = ''
                showSearchResults(response,  results)
            }),
            error: ((err) => console.error(err))
        })
    })

    $('#search-services').on('input', function()
    {
        $('.skeleton-loading').show()

        let searchValue = $(this).val()
        let dropdownText = $('#dropdown-services').text() 

        if(searchValue.length > 0)
        {
            $('.skeleton-loading').hide()
            $.ajax({
                url: 'get-search-agent-services',
                method: 'get',
                data: {
                    searchValue: searchValue,
                    dropdownText: dropdownText
                },
                success: function(response){
                    let results = ''  
                    showSearchResults(response,  results)
                },
                error: ((err) => console.error(err))
            })
        }
        else{
            $('.skeleton-loading').show()
            $.ajax({
                url: 'get-all-agent-service',
                method: 'get',
                success: function(data){
                    $('.skeleton-loading').hide()
                    loadServices(data)
                },
                error: function(err){
                    console.error(err)
                }
            })
        }
    })

    function showSearchResults(response,  results){
        if(response.agentService.length > 0)
        {
            response.agentService.forEach(function(eachAgentService)
            {
                results += `
                    <div class="p-4 flex flex-col gap-3 border border-slate-300 rounded-xl">
                        <span>***** star rating here</span>
                        <div class="flex flex-col">
                            <span class="font-semibold">${eachAgentService.title}</span>
                            <small class="text-slate-500">${eachAgentService.service.type}</small>
                        </div>
                        <div class="flex gap-2 items-center">
                                <img src="${eachAgentService.user.user_photo.profile_picture}" alt="" class="h-[50px] rounded-full">
                                <span class="text-slate-500">${eachAgentService.user.fullname.charAt(0).toUpperCase() + eachAgentService.user.fullname.slice(1).toLowerCase()}</span>
                        </div>
                    </div>
                `
            })
        }
        else{
            $('.skeleton-loading').hide()
            results = '<span class="font-semibold text-slate-500">No results found.</span>'
        }
        $('.services-container').html(results)
    }

    // todo: reload chat modal to reload it instead of whole page.
})
