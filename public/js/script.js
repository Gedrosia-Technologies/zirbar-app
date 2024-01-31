let balance = document.getElementsByClassName('balance');

for(let i=0; i<balance.length; i++){
    let balancevalue = parseInt(balance[i].innerHTML);
    if(balancevalue > 0){
        balance[i].classList.remove("text-danger");
        balance[i].classList.remove("text-muted");
        balance[i].classList.add("text-success");
       
    }
    else if(balancevalue ==0){
        balance[i].classList.remove("text-danger");
        balance[i].classList.remove("text-success");
        balance[i].classList.add("text-muted");
    }
    else{
        balance[i].classList.remove("text-success");
        balance[i].classList.remove("text-muted");
        balance[i].classList.add("text-danger");
    }
}

let amountfield = document.getElementsByClassName("amount-field");


for (let i = 0; i < amountfield.length; i++) {
    amountfield[i].addEventListener('keyup', function(){
    amountfield[i].nextElementSibling.innerHTML = numberWithCommas(amountfield[i].value);

    });
}


function check(value){
    alert('Are you Sure you want to '+value+' this record?' );
}


$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var action = button.data('action')
    var resourseid = button.data('resourseid')

    var modal = $(this)
    modal.find('.modal-body #deleteid').val(id)
    modal.find('.modal-body #resourseid').val(resourseid)
    modal.find('.modal-body #deleteform').attr('action', action);
})

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}