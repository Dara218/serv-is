import './bootstrap'

const username = $('#username-hidden')
const message = $('#message')
const receiver = $('#receiver-hidden')

// Click the chat head
$('.receiver-el').on('click', function(e) {
    console.log($(e.target).text());
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
    console.log($(e.target).data('username'));
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

        console.log(response)
        subscribeToChat()

        // Load messages when chat room is clicked
        loadMoreMessage(response.data[0].reverse().slice(0, messageToShow))

        // Load more messages on back read
        $('.chat-container').on('scroll', function(){
            const scrollTop = $(this).scrollTop()

            if(scrollTop == 0)
            {
                $('.load-more').show()

                let currentMessageCount = messageToShow

                messageToShow += 5
                const messages = response.data[0].slice(currentMessageCount, messageToShow)

                loadMoreMessage(messages)

                $('.load-more').on('click', function(){
                    let currentMessageCount = messageToShow
                    messageToShow += 5
                    const messages = response.data[0].slice(currentMessageCount, messageToShow)

                    loadMoreMessage(messages)
                })
            }
            else
            {
                $('.load-more').hide()
            }
        })
    })
    .catch(err => console.error(err))

})

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
