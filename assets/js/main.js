let current_cell;

let strValue = document.querySelectorAll('.str__value a');

for (let i = 0; i < strValue.length; i++) {
    strValue[i].addEventListener('click', function() {
        current_cell = this;
        let table = this.dataset.table;
        let column = this.dataset.column;
        document.querySelector('[name="table"]').value = table;
        document.querySelector('[name="column"]').value = column;
    });
}

let formChange = document.querySelector('#change-value form');

formChange.addEventListener('submit', function (e) {
    e.preventDefault();
    let data = new FormData(this);
    fetch('assets/doing.php', {
        method: 'POST',
        body: data,
        headers: {"content-type": "application/x-www-form-urlencoded"}
    }).then( (response) => {
        if (response.status !== 200) {
            return Promise.reject();
        }
        return response.text();
    }).then( i => console.log(i)).catch(() => console.log('error'));
});





$(document).on('submit', '#change-value form', function() {
    let that =  $(this);
    let data = that.serialize();
    $.ajax({
        url: 'assets/action.php',
        data: data,
        type: 'post',
        success: function(html){
            that.get(0).reset();
            $.fancybox.close();
            current_cell.innerHTML = html;
        }
    });
    return false;
});
