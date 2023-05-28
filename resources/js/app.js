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

        // Load messages when chat room is clicked
        // console.log(response.data);

        if(response.data[0].length == 0 && response.data[2] == false && response.data[4] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Good morning, to avail my service, payment is a must to be able to  connect with me. You can booked my service by clicking this <a href="/home/pricing-plan/${$('.user-id-hidden').val()}" class="font-semibold text-blue-600">Avail service</a> to be directed at the payment method field.
                </p>
            `)
            $('.input-message').prop('disabled', true)
        }
        else if(response.data[0].length == 0 && response.data[2] == true && response.data[4] == true)
        {
            $('.message-container').html(`
                <p class="w-auto col-span-4 message-el bg-slate-300 rounded-md py-2 px-3">
                    Welcome to Serv-is ${response.data[3]}! Thank you for availing my service.
                </p>
            `)
            $('.input-message').prop('disabled', false)
        }
        else if(response.data[0].length == 0 && (response.data[4] == false))
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
