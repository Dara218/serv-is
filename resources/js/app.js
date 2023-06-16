import axios from 'axios'
import './bootstrap'

$(document).ready(function(){

    const userId = $('#current-user-id').val()
    checkUserType()

    const options = {
        bottom: '10px',
        right: 'unset',
        left: '10px',
        time: '0s',
        mixColor: '#fff',
        backgroundColor: '#fff',
        buttonColorDark: '#100f2c',
        buttonColorLight: '#fff',
        saveInCookies: true,
        label: '🌓',
        autoMatchOsTheme: true,
    }

    const darkmode = new Darkmode(options);
    darkmode.showWidget()

    darkmode.isActivated() ? document.documentElement.classList.add('dark-mode') : document.documentElement.classList.remove('dark-mode')

    // new SimpleBar($('.simplebar')[0]);

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

    let isAppended = false

    $('.btn-chat-open').on('click', function(){
        $('.chat-badge').hide()

        axios.get('/get-unread-messages').then(function(response)
        {
            $('.receiver-el').each(function(index, eachChat){
                const chatId = eachChat.getAttribute('data-chat-id')

                const checkChat = response.data.some((chat) => chat == chatId)

                if(checkChat && !isAppended)
                {
                    $(eachChat).append(`<span class="chat-badge-message bg-red-400 rounded-full p-1 text-xs text-white">new</span>`)
                    isAppended = true
                }
            })
        })
        .catch((err) => console.error(err))

        $('.chat-modal').slideDown()
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
                    .then(function(response)
                    {
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
            url: '/api/get-categories',
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
        url: '/api/get-agent-service',
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
                data.forEach(function(eachData)
                {
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
                .then(function(response)
                {
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
            url: '/get-search-services',
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

    const username = $('#username-hidden')
    const message = $('#message')
    const receiver = $('#receiver-hidden')

    // Click the chat head
    $('.receiver-el').on('click', function(e)
    {
        const username = $(this).data('username')
        receiver.val(username)
        const chatRoomId = $(this).data('chat-id')
        var receiverId = $(this).data('receiver')
        var senderId = $(this).data('sender')

        axios.put(`/update-message-read/${chatRoomId}`, {
            receiverId: receiverId,
            senderId: senderId
        })
        .then(function(response)
        {
            $(this).find('.chat-badge-message').hide();
            $('.current-chat-name').show()
            $('.input-message').show()
            $('.user-id-hidden').val(receiverId)
            $('#receiver-chat-head').val(username)

            if(response.data.remainingTime != 0)
            {
                const date = response.data.remainingTime
                let days = date.days
                let daysText = `${days} day(s)`

                if(days == 0){
                    daysText = ''
                }

                $('.current-chat-name').html(`${username} <small class="ml-1">${daysText} ${date.h} hr(s) ${date.i} min(s) left</small>`)
                $('.form-chat-head').submit() //check minutes always 0
            }
            else{
                $('.current-chat-name').text(username)
                $('.form-chat-head').submit()
            }
        })
        .catch((err) => console.error(err))
    })

    $('.receiver-chat-head-click').on('click', function(e)
    {
        const username = $(this).data('username')
        receiver.val($(e.target).data('username'))

        $('.current-chat-name').show()
        $('.input-message').show()

        $('.current-chat-name').text(username)  // Username of current chat
        $('#receiver-chat-head').val(username)

        var receiverId = $(this).data('receiver')
        $('.user-id-hidden').val(receiverId)

        $('.form-chat-head').submit()
    })

    // Sends message
    $('.form-chat').on('submit', function(e) {
        e.preventDefault()

        if (message.val() === '') {
            return
        }

        axios.post('handle-message', {
            message: message.val(),
            username: username.val(),
            receiver_hidden: receiver.val(),
            chatId: $('.chat-id').val()
        })
        .catch(err => console.error(err))

        message.val('')
    })

    // Sends info to server, displays chats
    // Define a variable to keep track of the active chat room
    let activeChatRoom = null

    $('.form-chat-head').on('submit', function(e) {
        e.preventDefault()

        axios.post('/get-user-chat', {
            receiver: $('#receiver-chat-head').val(),
            sender: username.val()
        })
        .then(response => {
            const responseData = response.data
            $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight)
            $('.message-container').empty()
            $('.chat-id').val(responseData.chatRoom.id)
            let messageToShow = 10
            const inputMessage = $('.input-message')

            subscribeToChat()

            // Load messages when chat room is clicked
            if(responseData.checkIfChatHasAdmin)
            {
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Admin chat.
                    </p>
                `)
                inputMessage.prop('disabled', false)
            }
            else if(responseData.userChat.length == 0 && ! responseData.checkIfUserHasAvailed && (! responseData.confirmNotAgent || responseData.confirmNotAgent) && ! responseData.isAccepted){
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Good day! Please wait for the agent to accept your booking. You'll get notified later on.
                    </p>
                `)
                inputMessage.prop('disabled', true)
            }
            if(responseData.userChat.length == 0 && ! responseData.checkIfUserHasAvailed && ! responseData.confirmNotAgent && responseData.isAccepted)
            {
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Good day, to avail my service, payment is a must to be able to  connect with me. You can booked my service by clicking this <a href="/pricing-plan/${$('.user-id-hidden').val()}" class="font-semibold text-blue-600">Avail service</a> to be directed at the payment method field.
                    </p>
                `)
                inputMessage.prop('disabled', true)
            }
            if(responseData.userChat.length == 0 && ! responseData.checkIfUserHasAvailed && responseData.confirmNotAgent && responseData.isAccepted)
            {
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Good day, to avail my service, payment is a must to be able to  connect with me. You can booked my service by clicking this <a href="pricing-plan/${$('.user-id-hidden').val()}" class="font-semibold text-blue-600">Avail service</a> to be directed at the payment method field.
                    </p>
                `)
                inputMessage.prop('disabled', true)
            }
            if(responseData.userChat.length == 0 && responseData.checkIfUserHasAvailed && responseData.confirmNotAgent && responseData.isAccepted)
            {
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Welcome to Serv-is ${responseData.authenticatedUser}! Thank you for availing my service.
                    </p>
                `)
                inputMessage.prop('disabled', false)
            }
            if(responseData.userChat.length == 0 && responseData.checkIfUserHasAvailed && ! responseData.confirmNotAgent && responseData.isAccepted)
            {
                $('.message-container').html(`
                    <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                        Welcome to Serv-is ${responseData.authenticatedUser}! Thank you for availing my service.
                    </p>
                `)
                inputMessage.prop('disabled', false)
            }
            if(responseData.checkIfUserHasAvailed && (! responseData.confirmNotAgent || responseData.confirmNotAgent) && responseData.isAccepted && responseData.isExpired)
            {
                const messageContainer = $('.message-container')

                let message = `Good day! Your subscription for this plan has been expired. If you want to continue, <a href="/pricing-plan/${$('.user-id-hidden').val()}" class="text-slate-800 font-semibold">subscribe another plan.</a>`

                if(! responseData.confirmNotAgent){
                    message = `Good day! The subscription has been expired.`
                }

                messageContainer.append(`
                        <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">${message}</p>
                    `)

                inputMessage.prop('disabled', true)
            }
            else{
                loadMoreMessage(responseData.userChat.reverse().slice(0, messageToShow))
            }

            // Remove previous scroll event listener if exists
            if (activeChatRoom !== null) {
                $(activeChatRoom).off('scroll')
            }

            // Add new scroll event listener
            activeChatRoom = $('.chat-container')
            activeChatRoom.on('scroll', function() {
            const scrollTop = $(this).scrollTop()

                if (scrollTop == 0) {
                    $('.load-more').css('cursor', 'pointer')
                    $('.load-more').show()

                    let currentMessageCount = messageToShow
                    messageToShow += 5
                    const messages = responseData.userChat.slice(currentMessageCount, messageToShow)

                    if(messages.length == 0){
                        $('.load-more').text('Nothing to load.').css('cursor', 'default')
                    }
                    else{
                        $('.load-more').html(`
                            <span>Load More</span>
                            <span class="material-symbols-outlined">
                                arrow_upward
                            </span>`)
                    }

                    loadMoreMessage(messages)

                    $('.load-more').on('click', function(e) {
                        e.stopPropagation()

                        $('.load-more').css('cursor', 'pointer')
                        let currentMessageCount = messageToShow
                        messageToShow += 5
                        const messages = responseData.userChat.slice(currentMessageCount, messageToShow)

                        if(messages.length == 0){
                            $('.load-more').text('Nothing to load.').css('cursor', 'default')
                        }
                        else{
                            $('.load-more').html(`
                                <span>Load More</span>
                                <span class="material-symbols-outlined">
                                    arrow_upward
                                </span>`)
                        }

                        loadMoreMessage(messages)
                    })
                } else {
                    $('.load-more').hide()
                }
            })
        })
        .catch(err => console.error(err))
    });

    function loadMoreMessage(moreMessage){
        moreMessage.forEach(function(eachResponse) {
            const formattedDate = moment(eachResponse.created_at).fromNow()
            $('.message-container').prepend(`
                <small class="font-semibold text-slate-400 mt-2">${eachResponse.sender.fullname}</small>
                <span class="w-auto col-span-4 message-el bg-slate-300 rounded-full py-2 px-3">${eachResponse.message}</span>
                <small class="font-semibold text-slate-400">${formattedDate}</small>
            `)
        })
    }

    function subscribeToChat() {
        const chatId = $('.chat-id').val()

        Echo.leave(`chat.${chatId}`)

        Echo.join(`chat.${chatId}`)
        .listen('.message', (e) => {
            $('.message-container').append(`
                <small class="font-semibold text-slate-400 mt-2">${e.username}</small>
                <span class="w-auto col-span-4 message-el bg-slate-300 rounded-full py-2 px-3">${e.message}</span>
                <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small>
            `)

            $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight)
        })
    }

    Echo.private(`notifications.${userId}`)
    .listen('.user.notif', (e) =>
    {
        let count = parseInt($('.notif-count-hidden').text())
        $('.notif-count-hidden').text(count + 1)

        $('.notif-count-hidden').show()

        if(e.notificationType == 1 || e.notificationType == 3)
        {
            $('.notification-parent').prepend(`
                <li class="flex flex-col py-4 px-2 bg-slate-200">
                    <div class="flex gap-2">
                        <div class="flex flex-col gap-1 justify-center w-full">
                            <span class="font-bold">${e.username}</span>
                            <span>${e.notificationMessage}</span>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center">
                        <a href="#" data-id="${e.notificationId}" data-username="${e.username}" data-message="${e.notificationMessage}" data-from-user-id="${e.fromUserId}" data-to-user-id="${e.userIdToReceive}" data-type="${e.notificationType}" class="material-symbols-outlined cursor-pointer bnt-accept-notif">
                            check_circle
                        </a>
                        <a href="#" data-id="${e.notificationId}" data-username="${e.username}" data-message="${e.notificationMessage}" data-from-user-id="${e.fromUserId}" data-to-user-id="${e.userIdToReceive}" data-type="${e.notificationType}" class="material-symbols-outlined cursor-pointer bnt-reject-notif">
                            cancel
                        </a>
                    </div>
                </li>
            `)
        }
        else if(e.notificationType == 4)
        {
            $('.notification-parent').prepend(`
                <li class="flex flex-col py-4 px-2 bg-slate-200">
                    <a href="{{ route('showConfirmAgent') }}" class="text-slate-500 absolute top-2 right-3">See details</a>
                    <div class="flex gap-2">
                        <div class="flex flex-col gap-1 justify-center w-full">
                            <span class="font-bold">${e.username}</span>
                            <span>${e.notificationMessage}</span>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center">
                        <a href="#" data-id="${e.notificationId}" data-username="${e.username}" data-message="${e.notificationMessage}" data-from-user-id="${e.fromUserId}" data-to-user-id="${e.userIdToReceive}" data-type="${e.notificationType}" class="material-symbols-outlined cursor-pointer bnt-accept-notif">
                            check_circle
                        </a>
                        <a href="#" data-id="${e.notificationId}" data-username="${e.username}" data-message="${e.notificationMessage}" data-from-user-id="${e.fromUserId}" data-to-user-id="${e.userIdToReceive}" data-type="${e.notificationType}" class="material-symbols-outlined cursor-pointer bnt-reject-notif">
                            cancel
                        </a>
                    </div>
                </li>
            `)
        }
        else if(e.notificationType == 2)
        {
            $('.notification-parent').prepend(`
                <li class="flex flex-col py-4 px-2 bg-slate-200">
                    <div class="flex gap-2">
                        <div class="flex flex-col gap-1 justify-center w-full">
                            <span class="font-bold">${e.username}</span>
                            <span>${e.notificationMessage}</span>
                        </div>
                    </div>
                </li>
            `)
        }
        $('.toast-notification-message').text(e.notificationMessage)
        $('.toast-notification').show()
    })

    $('.notification-bell').on('click', function(){

        $('.notif-count-hidden').hide()

        axios.put(`/update-notification-count/${userId}`)
        .catch((err) => console.error(err))
    })

    $('.notification-parent').on('click', '.bnt-accept-notif', function(e)
    {
        const notificationId = $(this).data('id')
        const notificationItem = $(this).closest('li')
        const username = $(this).data('username')
        const message = $(this).data('message')
        const fromUserId = $(this).data('from-user-id')
        const toUserId = $(this).data('to-user-id')
        const notificationType = $(this).data('type')
        let is_Accepted = true
        let status = 1

        if(notificationType == 4){
            $(e.target.closest('.accepted-rejected-btn')).text('Accepted').show()
            const confirmRejectParentEl = $(e.target).parent()
            buttonChangeAfterRejectOrAccept(confirmRejectParentEl, is_Accepted)
        }

        axios.put(`/update-notification-accept/${notificationId}`, {
            fromUserId: fromUserId
        })
        .then(function(response) {
            acceptedRejectedProcess(notificationType, notificationId, notificationItem, username, message, status, fromUserId, is_Accepted, toUserId)
        })
        .catch(err => console.error(err))
    })

    $('.notification-parent').on('click', '.btn-reject-notif', function(e)
    {
        const notificationId = $(this).data('id');
        const notificationItem = $(this).closest('li');
        const username = $(this).data('username')
        const message = $(this).data('message')
        const fromUserId = $(this).data('from-user-id')
        const toUserId = $(this).data('to-user-id')
        let is_Accepted = false
        const notificationType = $(this).data('type')
        let status = 2

        if(notificationType == 4)
        {
            $(e.target.closest('.accepted-rejected-btn')).text('Rejected').show()
            const confirmRejectParentEl = $(e.target).parent()
            buttonChangeAfterRejectOrAccept(confirmRejectParentEl, is_Accepted)
        }

        axios.put(`/update-notification-reject/${notificationId}`, {
            fromUserId: fromUserId
        })
        .then(function(response){
            acceptedRejectedProcess(notificationType, notificationId, notificationItem, username, message, status, fromUserId, is_Accepted, toUserId)
        })
        .catch(err => console.error(err))
    })


    function acceptedRejectedProcess(notificationType, notificationId, notificationItem, username, message, status, fromUserId, is_Accepted, toUserId){
        if(notificationType == 1 || notificationType == 3)
            {
                storeNotificationToCustomer(notificationId, notificationItem, username, message, status, fromUserId, is_Accepted);

                if(notificationType == 3)
                {
                    axios.post('store-chat-after-negotiate', {
                        notificationId: notificationId,
                        fromUserId: fromUserId,
                        toUserId: toUserId,
                        username: username,
                        currentUserId: userId,
                        notificationType: notificationType
                    })
                }
                if (notificationType == 1)
                {
                    axios.post('store-chat-after-negotiate', {
                        notificationId: notificationId,
                        fromUserId: toUserId,
                        toUserId: fromUserId,
                        username: username,
                        currentUserId: fromUserId,
                        notificationType: notificationType
                    })
                }
            }
            if (notificationType == 4)
            {
                axios.put(`/store-agent-updated-details/${notificationId}`, {
                    notificationId: notificationId,
                    fromUserId: fromUserId,
                    toUserId: toUserId,
                    username: username,
                    currentUserId: fromUserId,
                    notificationType: notificationType,
                    is_Accepted: is_Accepted
                })
                .then(function(response){
                    updateNotificationItem(notificationItem, username, message, status)
                })
                .catch((err) => console.error(err))
            }
    }

    function buttonChangeAfterRejectOrAccept(confirmRejectParentEl, is_Accepted){
        confirmRejectParentEl.hide()

        if(! is_Accepted)
        {
            confirmRejectParentEl.parent().children().eq(0).text('Rejected').show()
        }
        else{
            confirmRejectParentEl.parent().children().eq(0).text('Accepted').show()
        }
    }

    function storeNotificationToCustomer(notificationId, notificationItem, username, message, status, fromUserId, is_Accepted)
        {
            if(! is_Accepted)
            {
                is_Accepted = false
            }

            axios.put(`update-availed-user-accepted/${notificationId}`, {
                is_Accepted: is_Accepted
            })
            .then(function(response){
                axios.post(`store-notification-to-customer`, {
                    fromUserId: fromUserId,
                    is_Accepted: is_Accepted
                })
                .then(function(response){
                    updateNotificationItem(notificationItem, username, message, status)
                })
                .catch((err) => console.error(err))
            })
            .catch((err) => console.error(err))
        }

    function updateNotificationItem(notificationItem, username, message, status){
        let color = undefined
        if(status == 1)
        {
            color = 'text-green-500'
            status = 'Accepted'
        }
        else if(status == 2)
        {
            color = 'text-red-400'
            status = 'Rejected'
        }
        notificationItem.html(`
            <li class="notif-item flex justify-between py-4 px-2 {{ $notification->is_unread == true ? 'bg-slate-100' : 'bg-slate-200' }}">
                <div class="flex gap-2">
                    <div class="flex flex-col gap-1 justify-center w-full">
                        <span class="font-semibold ${color}">${status}</span>
                        <span class="font-bold">${username}</span>
                        <span>${message}</span>
                    </div>
                </div>
            </li>
        `)
    }

    $('.btn-negotiate-agenda').on('click', function(e){
        const userId = $(e.target).data('userid')
        const username = $(e.target).data('username')
        const type = 1 // negotiate

        Swal.fire({
            title: 'Make Agenda Offer',
            icon: 'info',
            input: 'number',
            inputLabel: 'Price Offer',
            inputPlaceholder: 'Enter your counter offer price',
            showConfirmButton: true,
            showCancelButton: true,
            inputValidator: (value) => {
                if (! value){
                    return 'You need to enter a price.'
                }
            }
        })
        .then(function(result){
            if(result.isConfirmed){
                const counterPrice = result.value
                axios.post('store-notification-negotiate-agenda', {
                    userId: userId,
                    username: username,
                    counterPrice: counterPrice,
                    type: type
                })
                .then(function(response){
                    Swal.fire({
                        title: 'Successfully made an offer',
                        icon: 'success',
                        showConfirmButton: true,
                    })
                    $(e.target).prop('disabled', true)
                })
                .catch((err) => console.error(err))
            }
        })
    })

    $('.btn-task-me-agenda').on('click', function(e){
        const userId = $(e.target).data('userid')
        const username = $(e.target).data('username')
        const type = 2 // task me
        Swal.fire({
            title: 'Do you really wish to take this task?',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true,
        })
        .then(function(result){
            if(result.isConfirmed){
                const counterPrice = result.value
                axios.post('store-notification-negotiate-agenda', {
                    userId: userId,
                    username: username,
                    counterPrice: counterPrice,
                    type: type
                })
                .then(function(response){
                    Swal.fire({
                        title: 'Successfully made an offer',
                        icon: 'success',
                        showConfirmButton: true,
                    })
                    $(e.target).prop('disabled', true)
                })
                .catch((err) => console.error(err))
            }
        })
    })

    Echo.private(`message-badge.${userId}`).listen('.message.badge', (e) =>
    {
        console.log(response);
        $('.btn-chat-open').append(`<span class="chat-badge bg-red-400 rounded-full p-1 text-xs text-white">new</span>`)

        const chatRoomId = e.chatRoomId
        const chatHeadEl = $('.receiver-el').filter(function(){
            return $(this).data('chat-id') == chatRoomId
        })

        chatHeadEl.append(`<span class="chat-badge-message bg-red-400 rounded-full p-1 text-xs text-white">new</span>`)
    })


    Echo.private(`reviews.${userId}`).listen('.rating', (e) => {
        let userPhoto = undefined
        let starsChecked = ''
        let starsUnchecked = ''
        const formattedDate = moment(e.review.created_at).format('D MMM');

        for(let i = 0; i < e.starRating; i++){
            starsChecked += `<svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>`
        }

        for(let i = e.starRating; i < 5; i++){
            starsUnchecked += `<svg aria-hidden="true" class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>`
        }

        if(! e.user.user_photo){
            userPhoto = `<img src="{{ asset('images/servis_logo.png') }}" alt="" class="h-[50px]">`
        }
        else{
            userPhoto = `<img src="${e.user.user_photo.profile_picture}" alt="${e.user.user_photo.profile_picture}" class="h-[50px] rounded-full">`
        }

        const reviewEl =
        `<div class="flex justify-between px-4">
            <div class="flex gap-2">
                ${userPhoto}
                <div class="flex flex-col gap-2 mx-2">
                    <div class="flex flex-col gap-1">
                        <span>${e.user.username}</span>
                        <div class="flex">
                           ${starsChecked}
                           ${starsUnchecked}
                        </div>
                    </div>
                    <p>${e.message}</p>
                </div>
            </div>
            <span>${formattedDate}</span>
        </div>`

        $('.user-review-el').prepend(reviewEl)
    })
})
