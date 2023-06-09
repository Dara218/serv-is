import './bootstrap'

const username = $('#username-hidden')
const message = $('#message')
const receiver = $('#receiver-hidden')

// Click the chat head
$('.receiver-el').on('click', function(e) {
    // console.log($(e.target).text());
    receiver.val($(e.target).text())

    $('.current-chat-name').show()
    $('.input-message').show()
    $('.current-chat-name').text($(e.target).text()) // Username of current chat
    $('#receiver-chat-head').val($(e.target).text())

    var receiverId = $(this).data('id')
    $('.user-id-hidden').val(receiverId)

    $('.form-chat-head').submit()
})

$('.receiver-chat-head-click').on('click', function(e){
    // console.log($(e.target).data('username'));
    receiver.val($(e.target).data('username'))

    $('.current-chat-name').show()
    $('.input-message').show()
    $('.current-chat-name').text($(e.target).data('username')) // Username of current chat
    $('#receiver-chat-head').val($(e.target).data('username'))

    var receiverId = $(e.target).data('id')
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
    .then(response => {
        // console.log(response)
    })
    .catch(err => console.error(err))

    message.val('')
})

// Sends info to server, displays chats
// Define a variable to keep track of the active chat room
let activeChatRoom = null

$('.form-chat-head').on('submit', function(e) {
    e.preventDefault()

    axios.post('get-user-chat', {
        receiver: $('#receiver-chat-head').val(),
        sender: username.val()
    })
    .then(response => {
        $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight)
        $('.message-container').empty()
        $('.chat-id').val(response.data[1].id)
        let messageToShow = 10

        subscribeToChat()
        // console.log(response);

        // Load messages when chat room is clicked

        if(response.data[0].length == 0 && response.data[2] == false && (response.data[4] == false || response.data[4] == true) && response.data[5] == false){
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Good day! Please wait for the agent to accept your booking. You'll get notified later on.
                </p>
            `)
            $('.input-message').prop('disabled', true)
        }
        else if(response.data[0].length == 0 && response.data[2] == false && response.data[4] == false && response.data[5] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Good day, to avail my service, payment is a must to be able to  connect with me. You can booked my service by clicking this <a href="/home/pricing-plan/${$('.user-id-hidden').val()}" class="font-semibold text-blue-600">Avail service</a> to be directed at the payment method field.
                </p>
            `)
            $('.input-message').prop('disabled', true)
        }
        else if(response.data[0].length == 0 && response.data[2] == false && response.data[4] == true && response.data[5] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Good day, to avail my service, payment is a must to be able to  connect with me. You can booked my service by clicking this <a href="/home/pricing-plan/${$('.user-id-hidden').val()}" class="font-semibold text-blue-600">Avail service</a> to be directed at the payment method field.
                </p>
            `)
            $('.input-message').prop('disabled', true)
        }
        else if(response.data[0].length == 0 && response.data[2] == true && response.data[4] == true && response.data[5] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Welcome to Serv-is ${response.data[3]}! Thank you for availing my service.
                </p>
            `)
            $('.input-message').prop('disabled', false)
        }
        else if(response.data[0].length == 0 && response.data[2] == true && response.data[4] == false && response.data[5] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Welcome to Serv-is ${response.data[3]}! Thank you for availing my service.
                </p>
            `)
            $('.input-message').prop('disabled', false)
        }
        else{
            loadMoreMessage(response.data[0].reverse().slice(0, messageToShow))
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
                const messages = response.data[0].slice(currentMessageCount, messageToShow)

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
                    const messages = response.data[0].slice(currentMessageCount, messageToShow)

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

    Echo.leave(`chat.${chatId}`) // Leave the previous channel (if any)

    Echo.join(`chat.${chatId}`)
    .listen('.message', (e) => {
        // console.log(e)

        $('.message-container').append(`
            <small class="font-semibold text-slate-400 mt-2">${e.username}</small>
            <span class="w-auto col-span-4 message-el bg-slate-300 rounded-full py-2 px-3">${e.message}</span>
            <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small>
        `)

        $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight)
    })
}

const userId = $('#current-user-id').val()

// changed notif, add accept or reject

Echo.private(`notifications.${userId}`)
.listen('.user.notif', (e) =>
{
    let count = parseInt($('.notif-count-hidden').text())
    $('.notif-count-hidden').text(count + 1)

    $('.notif-count-hidden').show()

    if(e.notificationType == 1 || e.notificationType == 3 || e.notificationType == 4)
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
    else if(e.notificationType == 4) // TODO FIX NOTIF APPENDING NEW.
    {
        $('.notification-parent').prepend(`
            <li class="flex flex-col py-4 px-2 bg-slate-200">
                <a href="{{ route('home.showConfirmAgent') }}" class="text-slate-500 absolute top-2 right-3">See details</a>
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

    axios.put(`update-notification-count/${userId}`)
    .then(function(response){
        // console.log(response)
    })
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

    const confirmRejectParentEl = $(e.target).parent()
    buttonChangeAfterRejectOrAccept(confirmRejectParentEl, is_Accepted)

    $(e.target.closest('.accepted-rejected-btn')).text('Accepted').show()

    axios.put(`update-notification-accept/${notificationId}`, {
        fromUserId: fromUserId
    })
    .then(function(response) {
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
            axios.put(`store-agent-updated-details/${notificationId}`, {
                notificationId: notificationId,
                fromUserId: fromUserId,
                toUserId: toUserId,
                username: username,
                currentUserId: fromUserId,
                notificationType: notificationType
            })
            .then(function(response){
                updateNotificationItem(notificationItem, username, message, status)
            })
            .catch((err) => console.error(err))
        }
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
    let is_Accepted = false
    let status = 2

    const confirmRejectParentEl = $(e.target).parent()
    buttonChangeAfterRejectOrAccept(confirmRejectParentEl, is_Accepted)

    axios.put(`update-notification-reject/${notificationId}`, {
        fromUserId: fromUserId
    })
    .then(function(response){
        storeNotificationToCustomer(notificationId, notificationItem, username, message, status, fromUserId, is_Accepted)
    })
    .catch(err => console.error(err))
})

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
