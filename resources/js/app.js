import './bootstrap';

    const username = $('#username')
    const message = $('#message')
    const receiver = $('#receiver-hidden')

    $('.receiver-el').on('click', function(e){
        receiver.val($(e.target).text())
        $('.current-chat-name').text($(e.target).text())
        $('#receiver-chat-head').val($(e.target).text())

        // console.log($('#receiver-chat-head').val());

        $('.form-chat-head').submit()
    })

    $('.form-chat-head').on('submit', function(e){
        e.preventDefault()

        axios.post('get-user-chat', {
            receiver: $('#receiver-chat-head').val()
        })
        .then(response => {
            // console.log(response);
            $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight);

            $('.message-container').empty()

            response.data.forEach(function(eachResponse){
                const formattedDate = moment(eachResponse.created_at).fromNow()

                $('.message-container').append(`
                    <small class="font-semibold text-slate-400 mt-2">${eachResponse.sender.fullname}</small>
                    <span class="w-auto col-span-4 message-el">${eachResponse.message}</span>
                    <small class="font-semibold text-slate-400">${formattedDate}</small>
                `)
            })
        })
        .catch(err => console.error(err))
    })

    $('.form-chat').on('submit', function(e){

        e.preventDefault()

        console.log(receiver.val());

        if(message.val() === ''){
            return
        }

        axios.post('handle-message', {
            // data: {
                message: message.val(),
                receiver_hidden: receiver.val()
            // }
        })
        .then(response => {
            console.log(response);
        })
        .catch(err => console.error(err))

        message.val('')
    })

    window.Echo.channel('chat')
        .listen('.message', (e) => {
            console.log(e);
        $('.message-container').append(`
            <small class="font-semibold text-slate-400 mt-2">${e.username}</small>
            <span class="w-auto col-span-4 message-el">${e.message}</span>
            <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small>
        `)
    })
