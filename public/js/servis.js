$(document).ready(function(){

    axios.get('https://ph-locations-api.buonzz.com/v1/regions')
    .then(function(res){

        const rest = res.data.data

        rest.forEach(function(eachRes){
            $('.loading').remove();
            $('.region-options').append(
                `
                    <option value="${eachRes.name}">${eachRes.name}</option>
                `
            )
        })
    })
    .catch(err => console.error(err))

})
